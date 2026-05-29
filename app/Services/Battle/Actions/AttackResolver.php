<?php

namespace App\Services\Battle\Actions;

use App\Models\GamePlayer;

use App\Services\Battle\Damage\DamageCalculator;
use App\Services\Battle\Damage\CriticalCalculator;

use App\Services\Battle\Attacks\MageAttackService;
use App\Services\Battle\Attacks\RogueAttackService;
use App\Services\Battle\Attacks\WarriorAttackService;

class AttackResolver
{
    public function __construct(
        protected DamageCalculator $damageCalculator,
        protected CriticalCalculator $criticalCalculator,
        protected MageAttackService $mageAttackService,
        protected WarriorAttackService $warriorAttackService,
        protected RogueAttackService $rogueAttackService,
    ) {
    }

    public function resolve(
        GamePlayer $attacker,
        GamePlayer $defender,
        string $attack
    ): array {
        $attackResult = $this->resolveClassAttack(
            attacker: $attacker,
            defender: $defender,
            attack: $attack
        );

        if (isset($attackResult['error'])) {
            return $attackResult;
        }

        $isCrit = $this->criticalCalculator->calculate(
            critChance: $attacker->gameClass->crit_chance ?? 0,
            critBonus: $attackResult['crit_bonus'] ?? 0
        );

        $finalDamage = $this->damageCalculator->calculate(
            attacker: $attacker,
            defender: $defender,
            baseDamage: $attackResult['damage'],
            isCrit: $isCrit
        );

        $message = $attackResult['message'];

        if ($isCrit) {
            $message .= ' Critical hit!';
        }

        $message .= " ({$finalDamage} damage)";

        $attackResult['damage'] = $finalDamage;
        $attackResult['is_crit'] = $isCrit;
        $attackResult['message'] = $message;

        return $attackResult;
    }

    private function resolveClassAttack(
        GamePlayer $attacker,
        GamePlayer $defender,
        string $attack
    ): array {
        $class = strtolower(
            $attacker->gameClass->name
        );

        return match ($class) {

            'mage' => $this->mageAttackService->use(
                attack: $attack,
                attacker: $attacker,
                defender: $defender
            ),

            'warrior' => $this->warriorAttackService->use(
                attack: $attack,
                attacker: $attacker,
                defender: $defender
            ),

            'rogue' => $this->rogueAttackService->use(
                attack: $attack,
                attacker: $attacker,
                defender: $defender
            ),

            default => [
                'error' => 'Class bestaat niet.',
            ]
        };
    }
}
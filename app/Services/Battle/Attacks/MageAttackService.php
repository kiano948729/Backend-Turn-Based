<?php

namespace App\Services\Battle\Attacks;

use App\Models\GamePlayer;

class MageAttackService
{
    public function use(
        string $attack,
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        return match ($attack) {

            'fireball' => [
                'damage' => rand(20, 35),
                'message' => "{$attacker->user->name} slingert een fireball.",
            ],

            'frost_nova' => [
                'damage' => rand(10, 20),
                'skip_turn' => true,
                'message' => "{$attacker->user->name} gebruikt frost nova.",
            ],

            'arcane_blast' => [
                'damage' => rand(15, 45),
                'message' => "{$attacker->user->name} gebruikt arcane blast.",
            ],

            'you_shall_not_pass' => [
                'damage' => rand(900, 1500),
                'message' => "{$attacker->user->name} roept: YOU SHALL NOT PASS!",
            ],

            default => [
                'error' => 'Attack bestaat niet.',
            ],
        };
    }
}
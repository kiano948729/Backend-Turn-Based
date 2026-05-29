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

            'fireball' => $this->fireball(
                $attacker,
                $defender
            ),

            'frost_nova' => $this->frostNova(
                $attacker,
                $defender
            ),

            'arcane_blast' => $this->arcaneBlast(
                $attacker,
                $defender
            ),
            'you_shall_not_pass' => $this->youShallNotPass(
                $attacker,
                $defender
            ),

            default => [
                'error' => 'Attack bestaat niet.',
            ]
        };
    }

    private function fireball(
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        $damage = rand(20, 35);

        return [
            'damage' => $damage,
            'message' => "{$attacker->user->name} slingert een fireball.",
        ];
    }

    private function frostNova(
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        $damage = rand(10, 20);

        return [
            'damage' => $damage,
            'skip_turn' => true,
            'message' => "{$attacker->user->name} gebruikt frost nova.",
        ];
    }

    private function arcaneBlast(
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        $damage = rand(15, 45);

        return [
            'damage' => $damage,
            'message' => "{$attacker->user->name} gebruikt arcane blast.",
        ];
    }

    private function youShallNotPass(
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        $damage = rand(900, 1500);

        return [
            'damage' => $damage,
            'message' => "{$attacker->user->name} You shall not pass!",
        ];
    }
}
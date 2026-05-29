<?php

namespace App\Services\Battle\Damage;

use App\Models\GamePlayer;

class DamageCalculator
{
    public function calculate(
        GamePlayer $attacker,
        GamePlayer $defender,
        int $baseDamage,
        bool $isCrit = false
    ): int {
        $damage = $baseDamage;

        //critical hit
        if ($isCrit) {
            $damage *= 2;
        }

        //defense
        $defense = $defender->gameClass->base_defense ?? 0;

        //defending bonus
        if ($defender->is_defending) {
            $defense *= 2;
        }

        return max(
            1,
            $damage - $defense
        );
    }
}
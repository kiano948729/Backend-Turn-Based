<?php

namespace App\Services\Battle\Damage;

class CriticalCalculator
{
    public function calculate(
        int $critChance,
        int $critBonus = 0
    ): bool {
        $finalCritChance = min(
            100,
            $critChance + $critBonus
        );

        return rand(1, 100) <= $finalCritChance;
    }
}
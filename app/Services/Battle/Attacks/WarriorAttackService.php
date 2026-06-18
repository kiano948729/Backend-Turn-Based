<?php

namespace App\Services\Battle\Attacks;

use App\Models\GamePlayer;

class WarriorAttackService
{
    public function use(
        string $attack,
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        return match ($attack) {

            'heavy_slash' => [
                'damage' => rand(25, 45),
                'message' => "{$attacker->user->name} gebruikt heavy slash.",
            ],

            'shield_bash' => [
                'damage' => rand(20, 30),
                'self_damage' => 5,
                'message' => "{$attacker->user->name} gebruikt shield bash.",
            ],

            'berserk' => [
                'damage' => rand(35, 50),
                'self_damage' => 10,
                'message' => "{$attacker->user->name} gaat berserk.",
            ],
            default => [
                'error' => 'Attack bestaat niet.',
            ],
        };
    }
}
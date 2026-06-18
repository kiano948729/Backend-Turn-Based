<?php

namespace App\Services\Battle\Attacks;

use App\Models\GamePlayer;

class RogueAttackService
{
    public function use(
        string $attack,
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        return match ($attack) {

            'backstab' => [
                'damage' => rand(20, 45),
                'crit_bonus' => 50,
                'message' => "{$attacker->user->name} gebruikt backstab.",
            ],

            'poison_dagger' => [
                'damage' => rand(10, 20),
                'poison' => true,
                'message' => "{$attacker->user->name} gebruikt poison dagger.",
            ],

            'shadow_strike' => [
                'damage' => rand(15, 25),
                'dodge' => true,
                'message' => "{$attacker->user->name} verdwijnt in de schaduw.",
            ],
            default => [
                'error' => 'Attack bestaat niet.',
            ],
        };
    }
}
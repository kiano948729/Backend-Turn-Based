<?php

namespace App\Services\Battle\Actions;

use App\Models\GamePlayer;

class EffectApplier
{
    public function apply(
        GamePlayer $attacker,
        GamePlayer $defender,
        array $result
    ): void {
        //damage
        if (isset($result['damage'])) {
            $defender->current_hp = max(
                0,
                $defender->current_hp - $result['damage']
            );

            $defender->is_defending = false;
        }

        //self damage
        if (isset($result['self_damage'])) {
            $attacker->current_hp = max(
                0,
                $attacker->current_hp - $result['self_damage']
            );
        }

        //stun
        if (isset($result['skip_turn'])) {
            $defender->is_stunned = true;
        }

        //poison
        if (isset($result['poison'])) {
            $defender->is_poisoned = true;

            $defender->poison_turns = 3;
        }

        //dodge
        if (isset($result['dodge'])) {
            $attacker->dodge_chance = 100;
        }

        $attacker->save();
        $defender->save();
    }
}
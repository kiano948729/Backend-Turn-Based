<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameAction;

class BattleService
{
    public function attack(Game $game, GamePlayer $attacker)
    {
        $defender = $this->getOpponent($game, $attacker);

        $damage = rand(10, 20);

        if ($defender->defending) {
            $damage = floor($damage / 2);
        }

        $defender->current_hp -= $damage;

        $defender->defending = false;

        $defender->save();

        GameAction::create([
            'game_id' => $game->id,
            'user_id' => $attacker->user_id,
            'action_type' => 'attack',
            'damage' => $damage,
            'description' => 'Player attacked for ' . $damage . ' damage'
        ]);

        if ($defender->current_hp <= 0) {

            $defender->current_hp = 0;

            $defender->save();

            $game->winner_id = $attacker->user_id;

            $game->status = 'finished';

            $game->save();

            return;
        }

        $game->current_turn_player_id = $defender->user_id;

        $game->save();
    }

    public function defend(Game $game, GamePlayer $player)
    {
        $player->defending = true;

        $player->save();

        $opponent = $this->getOpponent($game, $player);

        $game->current_turn_player_id = $opponent->user_id;

        $game->save();

        GameAction::create([
            'game_id' => $game->id,
            'user_id' => $player->user_id,
            'action_type' => 'defend',
            'description' => 'Player is defending'
        ]);
    }

    private function getOpponent(Game $game, GamePlayer $player)
    {
        return GamePlayer::where('game_id', $game->id)
            ->where('user_id', '!=', $player->user_id)
            ->first();
    }
}
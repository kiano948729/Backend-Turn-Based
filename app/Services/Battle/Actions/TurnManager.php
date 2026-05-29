<?php

namespace App\Services\Battle\Actions;

use App\Models\Game;
use App\Models\GamePlayer;

class TurnManager
{
    public function isPlayersTurn(
        Game $game,
        GamePlayer $player
    ): bool {
        return $game->current_turn_player_id === $player->user_id;
    }

    public function switch(
        Game $game,
        GamePlayer $nextPlayer
    ): void {
        $game->current_turn_player_id = $nextPlayer->user_id;

        $game->save();
    }

    public function handleNextTurn(
        Game $game,
        GamePlayer $attacker,
        GamePlayer $defender,
        array $result
    ): void {
        //stun
        if (
            isset($result['skip_turn']) &&
            $result['skip_turn']
        ) {
            $this->switch($game, $attacker);

            return;
        }

        $this->switch($game, $defender);
    }
}
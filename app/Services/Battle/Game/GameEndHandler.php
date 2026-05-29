<?php

namespace App\Services\Battle\Game;

use App\Models\Game;
use App\Models\GamePlayer;

use App\Services\Battle\Logs\BattleLogger;

class GameEndHandler
{
    public function __construct(
        protected BattleLogger $battleLogger
    ) {
    }

    public function finish(
        Game $game,
        GamePlayer $winner
    ): array {
        $game->status = 'finished';

        $game->winner_id = $winner->user_id;

        $game->save();

        $message = "{$winner->user->name} wint de strijd!";

        $this->battleLogger->win(
            game: $game,
            player: $winner,
            message: $message
        );

        return [
            'game_over' => true,
            'winner' => $winner->user->name,
            'message' => $message,
        ];
    }
}
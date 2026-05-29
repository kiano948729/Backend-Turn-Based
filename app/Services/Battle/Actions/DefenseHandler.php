<?php

namespace App\Services\Battle\Actions;

use App\Models\Game;
use App\Models\GamePlayer;

use App\Services\Battle\Logs\BattleLogger;

class DefenseHandler
{
    public function __construct(
        protected BattleLogger $battleLogger,
        protected TurnManager $turnManager,
    ) {
    }

    public function handle(
        Game $game,
        GamePlayer $defender
    ): array {
        $defender->is_defending = true;

        $defender->save();

        $message = "{$defender->user->name} verdedigt zichzelf.";

        $this->battleLogger->defend(
            game: $game,
            player: $defender,
            message: $message
        );

        $opponent = GamePlayer::where('game_id', $game->id)
            ->where('user_id', '!=', $defender->user_id)
            ->first();

        $this->turnManager->switch(
            game: $game,
            nextPlayer: $opponent
        );

        return [
            'message' => $message,
        ];
    }
}


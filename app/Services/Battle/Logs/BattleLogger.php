<?php

namespace App\Services\Battle\Logs;

use App\Models\Game;
use App\Models\GameLog;
use App\Models\GamePlayer;

class BattleLogger
{
    public function attack(
        Game $game,
        GamePlayer $attacker,
        string $message
    ): void {
        $this->create(
            game: $game,
            userId: $attacker->user_id,
            action: 'attack',
            message: $message
        );
    }

    public function defend(
        Game $game,
        GamePlayer $player,
        string $message
    ): void {
        $this->create(
            game: $game,
            userId: $player->user_id,
            action: 'defend',
            message: $message
        );
    }

    public function win(
        Game $game,
        GamePlayer $player,
        string $message
    ): void {
        $this->create(
            game: $game,
            userId: $player->user_id,
            action: 'win',
            message: $message
        );
    }

    private function create(
        Game $game,
        int $userId,
        string $action,
        string $message
    ): void {
        GameLog::create([
            'game_id' => $game->id,
            'user_id' => $userId,
            'action' => $action,
            'message' => $message,
        ]);
    }
}
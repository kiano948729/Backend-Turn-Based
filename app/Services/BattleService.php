<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameLog;
use App\Models\GamePlayer;

class BattleService
{
    public function basicAttack(
        Game $game,
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        if (!$this->isPlayersTurn($game, $attacker)) {
            return [
                'error' => 'Het is niet jouw beurt.',
            ];
        }

        $damage = $this->calculateAttackDamage(
            attacker: $attacker,
            defender: $defender
        );

        $this->applyDamage(
            defender: $defender,
            damage: $damage['final_damage']
        );

        $message = $damage['is_crit']
            ? "{$attacker->user->name} landt een critical hit op {$defender->user->name} voor {$damage['final_damage']} schade."
            : "{$attacker->user->name} valt {$defender->user->name} aan voor {$damage['final_damage']} schade.";

        $this->createLog(
            game: $game,
            userId: $attacker->user_id,
            action: 'attack',
            message: $message
        );

        if ($defender->current_hp <= 0) {
            return $this->finishGame($game, $attacker);
        }

        $this->switchTurn($game, $defender);

        return [
            'message' => $message,
            'damage' => $damage['final_damage'],
            'is_crit' => $damage['is_crit'],
        ];
    }

    public function defend(
        Game $game,
        GamePlayer $defender
    ): array {
        if (!$this->isPlayersTurn($game, $defender)) {
            return [
                'error' => 'Het is niet jouw beurt.',
            ];
        }

        $defender->update([
            'is_defending' => true,
        ]);

        $message = "{$defender->user->name} neemt een verdedigende houding aan.";

        $this->createLog(
            game: $game,
            userId: $defender->user_id,
            action: 'defend',
            message: $message
        );

        $opponent = GamePlayer::where('game_id', $game->id)
            ->where('user_id', '!=', $defender->user_id)
            ->first();

        $this->switchTurn($game, $opponent);

        return [
            'message' => $message,
        ];
    }

    private function calculateAttackDamage(
        GamePlayer $attacker,
        GamePlayer $defender
    ): array {
        //base damage
        $baseDamage = $attacker->gameClass->base_strength ?? 10;

        //crit
        $critChance = $attacker->gameClass->crit_chance ?? 10;

        $isCrit = rand(1, 100) <= $critChance;

        if ($isCrit) {
            $baseDamage *= 2;
        }

        //defense
        $defense = $defender->gameClass->base_defense ?? 5;

        if ($defender->is_defending) {
            $defense *= 2;
        }

        $finalDamage = max(
            1,
            $baseDamage - $defense
        );

        return [
            'final_damage' => $finalDamage,
            'is_crit' => $isCrit,
        ];
    }

    private function applyDamage(
        GamePlayer $defender,
        int $damage
    ): void {
        $defender->current_hp = max(
            0,
            $defender->current_hp - $damage
        );

        $defender->is_defending = false;

        $defender->save();
    }

    private function isPlayersTurn(
        Game $game,
        GamePlayer $player
    ): bool {
        return $game->current_turn_player_id === $player->user_id;
    }

    private function switchTurn(
        Game $game,
        GamePlayer $nextPlayer
    ): void {
        $game->update([
            'current_turn_player_id' => $nextPlayer->user_id,
        ]);
    }

    private function finishGame(
        Game $game,
        GamePlayer $winner
    ): array {
        $game->update([
            'status' => 'finished',
            'winner_id' => $winner->user_id,
        ]);

        $message = "{$winner->user->name} wint de strijd!";

        $this->createLog(
            game: $game,
            userId: $winner->user_id,
            action: 'win',
            message: $message
        );

        return [
            'game_over' => true,
            'winner' => $winner->user->name,
            'message' => $message,
        ];
    }

    private function createLog(
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
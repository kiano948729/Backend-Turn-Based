<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameLog;

class BattleService
{
    public function attack(Game $game, GamePlayer $attacker, GamePlayer $defender): array
    {
        if ($game->current_turn_player_id !== $attacker->user_id) {
            return ['error' => 'Het is niet jouw beurt.'];
        }

        $attackerClass = $attacker->gameClass;
        $defenderClass = $defender->gameClass;

        //basis schade berekening
        $baseDamage = $attackerClass->base_strength ?? 10;

        //crit chance
        $critChance = $attackerClass->crit_chance ?? 10;
        $isCrit = rand(1, 100) <= $critChance;
        $damage = $isCrit ? $baseDamage * 2 : $baseDamage;

        //defense vermindering
        $defense = $defenderClass->base_defense ?? 5;

        //als defender aan het verdedigen is, verdubbel de defense
        if ($defender->is_defending) {
            $defense *= 2;
        }

        $finalDamage = max(1, $damage - $defense);

        //HP verlagen
        $defender->current_hp = max(0, $defender->current_hp - $finalDamage);
        $defender->is_defending = false; //defending reset
        $defender->save();

        //battle log opslaan
        $logMessage = $isCrit
            ? "{$attacker->user->name} voert een CRITICAL hit uit op {$defender->user->name} voor {$finalDamage} schade!"
            : "{$attacker->user->name} valt {$defender->user->name} aan voor {$finalDamage} schade.";

        GameLog::create([
            'game_id' => $game->id,
            'user_id' => $attacker->user_id,
            'action' => 'attack',
            'message' => $logMessage,
        ]);

        //controleer winnaar
        if ($defender->current_hp <= 0) {
            return $this->endGame($game, $attacker);
        }

        //beurt wisselen
        $this->nextTurn($game, $defender);

        return [
            'damage' => $finalDamage,
            'is_crit' => $isCrit,
            'message' => $logMessage,
        ];
    }

    public function defend(Game $game, GamePlayer $defender): array
    {
        if ($game->current_turn_player_id !== $defender->user_id) {
            return ['error' => 'Het is niet jouw beurt.'];
        }

        $defender->is_defending = true;
        $defender->save();

        $logMessage = "{$defender->user->name} neemt een verdedigende houding aan.";

        GameLog::create([
            'game_id' => $game->id,
            'user_id' => $defender->user_id,
            'action' => 'defend',
            'message' => $logMessage,
        ]);

        //beurt naar tegenstander
        $opponent = GamePlayer::where('game_id', $game->id)
            ->where('user_id', '!=', $defender->user_id)
            ->first();

        $this->nextTurn($game, $opponent);

        return ['message' => $logMessage];
    }

    private function nextTurn(Game $game, GamePlayer $nextPlayer): void
    {
        $game->current_turn_player_id = $nextPlayer->user_id;
        $game->save();
    }

    private function endGame(Game $game, GamePlayer $winner): array
    {
        $game->status = 'finished';
        $game->winner_id = $winner->user_id;
        $game->save();

        $logMessage = "{$winner->user->name} wint de strijd!";

        GameLog::create([
            'game_id' => $game->id,
            'user_id' => $winner->user_id,
            'action' => 'win',
            'message' => $logMessage,
        ]);

        return [
            'winner' => $winner->user->name,
            'message' => $logMessage,
            'game_over' => true,
        ];      
    }
}
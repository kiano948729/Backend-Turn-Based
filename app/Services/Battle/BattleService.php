<?php

namespace App\Services\Battle;

use App\Models\Game;
use App\Models\GamePlayer;

use App\Services\Battle\Actions\TurnManager;
use App\Services\Battle\Actions\AttackResolver;
use App\Services\Battle\Actions\DefenseHandler;
use App\Services\Battle\Actions\EffectApplier;

use App\Services\Battle\Logs\BattleLogger;
use App\Services\Battle\Game\GameEndHandler;

class BattleService
{
    public function __construct(
        protected TurnManager $turnManager,
        protected AttackResolver $attackResolver,
        protected DefenseHandler $defenseHandler,
        protected EffectApplier $effectApplier,
        protected BattleLogger $battleLogger,
        protected GameEndHandler $gameEndHandler,
    ) {
    }

    public function useAttack(
        Game $game,
        GamePlayer $attacker,
        GamePlayer $defender,
        string $attack
    ): array {
        if (!$this->turnManager->isPlayersTurn($game, $attacker)) {
            return [
                'error' => 'Het is niet jouw beurt.',
            ];
        }

        $result = $this->attackResolver->resolve(
            attacker: $attacker,
            defender: $defender,
            attack: $attack
        );

        if (isset($result['error'])) {
            return $result;
        }

        $this->effectApplier->apply(
            attacker: $attacker,
            defender: $defender,
            result: $result
        );

        $this->battleLogger->attack(
            game: $game,
            attacker: $attacker,
            message: $result['message']
        );

        if ($defender->current_hp <= 0) {
            return $this->gameEndHandler->finish(
                game: $game,
                winner: $attacker
            );
        }

        $this->turnManager->handleNextTurn(
            game: $game,
            attacker: $attacker,
            defender: $defender,
            result: $result
        );

        return $result;
    }

    public function defend(
        Game $game,
        GamePlayer $defender
    ): array {
        if (!$this->turnManager->isPlayersTurn($game, $defender)) {
            return [
                'error' => 'Het is niet jouw beurt.',
            ];
        }

        return $this->defenseHandler->handle(
            game: $game,
            defender: $defender
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Services\BattleService;
use Illuminate\Support\Facades\Auth;

class BattleController extends Controller
{
    public function __construct(
        protected BattleService $battleService
    ) {
    }

    public function attack(Game $game)
    {
        [$attacker, $defender] = $this->getPlayers($game);

        if (!$attacker || !$defender) {
            return back()->with('error', 'Speler niet gevonden.');
        }

        $result = $this->battleService->basicAttack(
            game: $game,
            attacker: $attacker,
            defender: $defender
        );

        return $this->handleBattleResult($game, $result);
    }

    public function defend(Game $game)
    {
        $player = $this->getCurrentPlayer($game);

        if (!$player) {
            return back()->with('error', 'Speler niet gevonden.');
        }

        $result = $this->battleService->defend(
            game: $game,
            defender: $player
        );

        return $this->handleBattleResult($game, $result);
    }

    private function getPlayers(Game $game): array
    {
        $players = GamePlayer::where('game_id', $game->id)->get();

        $currentPlayer = $players
            ->where('user_id', Auth::id())
            ->first();

        $enemyPlayer = $players
            ->where('user_id', '!=', Auth::id())
            ->first();

        return [$currentPlayer, $enemyPlayer];
    }

    private function getCurrentPlayer(Game $game): ?GamePlayer
    {
        return GamePlayer::where('game_id', $game->id)
            ->where('user_id', Auth::id())
            ->first();
    }

    private function handleBattleResult(Game $game, array $result)
    {
        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        if (isset($result['game_over'])) {
            return redirect()
                ->route('games.show', $game)
                ->with('success', $result['message']);
        }

        return back()->with(
            'battle_result',
            $result['message']
        );
    }
}
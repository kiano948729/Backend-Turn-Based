<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Services\BattleService;
use Illuminate\Support\Facades\Auth;

class BattleController extends Controller
{
    protected BattleService $battleService;

    public function __construct(BattleService $battleService)
    {
        $this->battleService = $battleService;
    }

    public function attack(Game $game)
    {
        if ($game->status === 'finished') {
            return back();
        }

        if ($game->current_turn_player_id !== Auth::id()) {
            abort(403);
        }

        $player = GamePlayer::where('game_id', $game->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$player) {
            abort(403);
        }

        $this->battleService->attack($game, $player);

        return back();
    }

    public function defend(Game $game)
    {
        if ($game->status === 'finished') {
            return back();
        }

        if ($game->current_turn_player_id !== Auth::id()) {
            abort(403);
        }

        $player = GamePlayer::where('game_id', $game->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$player) {
            abort(403);
        }

        $this->battleService->defend($game, $player);

        return back();
    }
}
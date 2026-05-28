<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePlayer;
use App\Services\BattleService;
use Illuminate\Support\Facades\Auth;

class BattleController extends Controller
{
    public function __construct(protected BattleService $battleService) {}

    public function attack(Game $game)
    {
        $players = GamePlayer::where('game_id', $game->id)->get();

        $attacker = $players->where('user_id', Auth::id())->first();
        $defender = $players->where('user_id', '!=', Auth::id())->first();

        if (!$attacker || !$defender) {
            return back()->with('error', 'Speler niet gevonden.');
        }

        $result = $this->battleService->attack($game, $attacker, $defender);

        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        if (isset($result['game_over'])) {
            return redirect()->route('games.show', $game)
                ->with('success', $result['message']);
        }

        return back()->with('battle_result', $result['message']);
    }

    public function defend(Game $game)
    {
        $player = GamePlayer::where('game_id', $game->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$player) {
            return back()->with('error', 'Speler niet gevonden.');
        }

        $result = $this->battleService->defend($game, $player);

        if (isset($result['error'])) {
            return back()->with('error', $result['error']);
        }

        return back()->with('battle_result', $result['message']);
    }
}
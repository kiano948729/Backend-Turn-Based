<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\GamePlayer;

use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function store()
    {
        $opponent = User::where('id', '!=', Auth::id())
            ->inRandomOrder()
            ->first();

        if (!$opponent) {
            return back();
        }

        $startingPlayer = collect([
            Auth::id(),
            $opponent->id
        ])->random();

        $game = Game::create([
            'status' => 'active',
            'current_turn_player_id' => $startingPlayer,
        ]);

        GamePlayer::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'game_class_id' => 1,
            'current_hp' => 100,
            'current_mana' => 50,
        ]);

        GamePlayer::create([
            'game_id' => $game->id,
            'user_id' => $opponent->id,
            'game_class_id' => 2,
            'current_hp' => 100,
            'current_mana' => 50,
        ]);

        return redirect()->route('games.show', $game);
    }

    public function show(Game $game)
    {
        $players = GamePlayer::where('game_id', $game->id)
            ->get();

        $currentPlayer = $players
            ->where('user_id', Auth::id())
            ->first();

        $enemyPlayer = $players
            ->where('user_id', '!=', Auth::id())
            ->first();

        return view('games.show', compact(
            'game',
            'currentPlayer',
            'enemyPlayer'
        ));
    }
}
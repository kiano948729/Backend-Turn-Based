<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\GamePlayer;
use App\Models\GameClass;

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

        $selectedClass = GameClass::findOrFail(
            request('game_class_id')
        );

        GamePlayer::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'game_class_id' => $selectedClass->id,
            'current_hp' => $selectedClass->base_hp,
            'current_mana' => $selectedClass->base_mana,
        ]);

        $enemyClass = GameClass::inRandomOrder()->first();

        GamePlayer::create([
            'game_id' => $game->id,
            'user_id' => $opponent->id,
            'game_class_id' => $enemyClass->id,
            'current_hp' => $enemyClass->base_hp,
            'current_mana' => $enemyClass->base_mana,
        ]);

        return redirect()->route('games.show', $game);
    }

    public function show(Game $game)
    {
        $players = GamePlayer::where('game_id', $game->id)
            ->with(['gameClass', 'user'])
            ->get();

        $currentPlayer = $players->where('user_id', Auth::id())->first();
        $enemyPlayer = $players->where('user_id', '!=', Auth::id())->first();

        $isMyTurn = $game->current_turn_player_id === Auth::id();

        return view('games.show', compact(
            'game',
            'currentPlayer',
            'enemyPlayer',
            'isMyTurn',
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\GameClass;
use App\Models\GamePlayer;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function store()
    {
        $opponent = $this->findOpponent();

        if (!$opponent) {
            return back();
        }

        $selectedClass = GameClass::findOrFail(
            request('game_class_id')
        );

        $enemyClass = GameClass::inRandomOrder()->first();

        $game = Game::create([
            'status' => 'active',
            'current_turn_player_id' => collect([
                Auth::id(),
                $opponent->id,
            ])->random(),
        ]);

        $this->createPlayer(
            game: $game,
            userId: Auth::id(),
            gameClass: $selectedClass
        );

        $this->createPlayer(
            game: $game,
            userId: $opponent->id,
            gameClass: $enemyClass
        );

        return redirect()->route('games.show', $game);
    }

    public function show(Game $game)
    {
        $players = GamePlayer::where('game_id', $game->id)
            ->with(['user', 'gameClass'])
            ->get();

        $currentPlayer = $players
            ->where('user_id', Auth::id())
            ->first();

        $enemyPlayer = $players
            ->where('user_id', '!=', Auth::id())
            ->first();

        return view('games.show', [
            'game' => $game,
            'currentPlayer' => $currentPlayer,
            'enemyPlayer' => $enemyPlayer,
            'isMyTurn' => $game->current_turn_player_id === Auth::id(),
        ]);
    }

    private function findOpponent(): ?User
    {
        return User::where('id', '!=', Auth::id())
            ->inRandomOrder()
            ->first();
    }

    private function createPlayer(
        Game $game,
        int $userId,
        GameClass $gameClass
    ): void {
        GamePlayer::create([
            'game_id' => $game->id,
            'user_id' => $userId,
            'game_class_id' => $gameClass->id,
            'current_hp' => $gameClass->base_hp,
            'current_mana' => $gameClass->base_mana,
        ]);
    }
}
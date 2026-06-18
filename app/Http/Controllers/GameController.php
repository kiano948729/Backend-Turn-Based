<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Game;
use App\Models\GameClass;
use App\Models\GamePlayer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function store()
    {
        $selectedClass = GameClass::findOrFail(request('game_class_id'));

        //spel tegen vriend of willekeurig
        $friendId = request('friend_id');

        if ($friendId) {
            $opponent = $this->findFriend($friendId);

            if (!$opponent) {
                return back()->with('error', 'Deze vriend is niet gevonden of is geen vriend van jou.');
            }
        } else {
            $opponent = $this->findRandomOpponent();
        }

        if (!$opponent) {
            return back()->with('error', 'Geen tegenstander gevonden.');
        }

        $enemyClass = GameClass::inRandomOrder()->first();

        $game = Game::create([
            'status' => 'active',
            'current_turn_player_id' => collect([Auth::id(), $opponent->id])->random(),
        ]);

        $this->createPlayer($game, Auth::id(), $selectedClass);
        $this->createPlayer($game, $opponent->id, $enemyClass);

        return redirect()->route('games.show', $game);
    }

    public function show(Game $game)
    {
        $isParticipant = $game->players()->where('user_id', Auth::id())->exists();
        if (!$isParticipant)
            abort(403);
        
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

    private function findFriend(int $friendId): ?User
    {
        $isFriend = Friend::where('status', 'accepted')
            ->where(function ($q) use ($friendId) {
                $q->where('user_id', Auth::id())->where('friend_user_id', $friendId);
            })->orWhere(function ($q) use ($friendId) {
                $q->where('user_id', $friendId)->where('friend_user_id', Auth::id());
            })->exists();

        if (!$isFriend) {
            return null;
        }

        return User::find($friendId);
    }

    private function findRandomOpponent(): ?User
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
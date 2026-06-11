<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\GameClass;
use App\Models\GamePlayer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $classes = GameClass::all();

        $activeGame = GamePlayer::where('user_id', Auth::id())
            ->whereHas('game', fn($q) => $q->where('status', 'active'))
            ->with('game')
            ->latest()
            ->first()
                ?->game;

        //vrienden van de ingelogde gebruiker (geaccepteerd)
        $friendships = Friend::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhere('friend_user_id', Auth::id());
            })
            ->with(['user', 'friendUser'])
            ->get();

        //haal de User objecten op, niet de ingelogde gebruiker zelf
        $friends = $friendships->map(function ($f) {
            return $f->user_id === Auth::id() ? $f->friendUser : $f->user;
        });

        return view('dashboard', compact('classes', 'activeGame', 'friends'));
    }
}

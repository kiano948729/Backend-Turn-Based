<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameClass;
use App\Models\GamePlayer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $classes = GameClass::all();

        //actieve game van de ingelogde speler
        $activeGame = GamePlayer::where('user_id', Auth::id())
            ->whereHas('game', fn($q) => $q->where('status', 'active'))
            ->with('game')
            ->latest()
            ->first()
                ?->game;

        return view('dashboard', compact('classes', 'activeGame'));
    }
}
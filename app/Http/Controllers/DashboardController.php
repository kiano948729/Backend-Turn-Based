<?php

namespace App\Http\Controllers;

use App\Models\GameClass;
use App\Models\GamePlayer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $classes = GameClass::all();

        $activeGame = GamePlayer::where('user_id', Auth::id())
            ->whereHas('game', function ($query) {
                $query->where('status', 'active');
            })
            ->with('game')
            ->latest()
            ->first()
                ?->game;

        return view('dashboard', [
            'classes' => $classes,
            'activeGame' => $activeGame,
        ]);
    }
}
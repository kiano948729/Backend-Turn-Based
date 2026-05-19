<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GamePlayer;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function store()
    {
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }
}
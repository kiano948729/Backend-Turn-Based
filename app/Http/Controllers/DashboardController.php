<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameClass;

class DashboardController extends Controller
{
    public function index()
    {
        $games = Game::latest()->get();

        $classes = GameClass::all();

        return view('dashboard', compact(
            'games',
            'classes'
        ));
    }
}
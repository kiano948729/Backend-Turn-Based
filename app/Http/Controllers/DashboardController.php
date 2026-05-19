<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class DashboardController extends Controller
{
    public function index()
    {
        $games = Game::latest()->get();

        return view('dashboard', compact('games'));
    }
}
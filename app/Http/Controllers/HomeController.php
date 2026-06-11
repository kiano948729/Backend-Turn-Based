<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'dailyLeaders' => $this->getLeaders(Carbon::today()),
            'weeklyLeaders' => $this->getLeaders(Carbon::now()->startOfWeek()),
            'allTimeLeaders' => $this->getLeaders(null),
        ]);
    }

    private function getLeaders(?Carbon $from)
    {
        return User::withCount([
            'wonGames' => function ($query) use ($from) {
                if ($from) {
                    $query->where('updated_at', '>=', $from);
                }
            },
        ])
            ->orderByDesc('won_games_count')
            ->take(5)
            ->get();
    }
}

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/games/create', [GameController::class, 'store'])
        ->name('games.store');

    Route::get('/games/{game}', [GameController::class, 'show'])
        ->name('games.show');

    Route::post('/games/{game}/attack', [BattleController::class, 'attack'])
        ->name('battle.attack');

    Route::post('/games/{game}/defend', [BattleController::class, 'defend'])
        ->name('battle.defend');

    Route::get('/friends', [FriendController::class, 'index'])
        ->name('friends.index');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');


});
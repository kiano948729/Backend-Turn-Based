<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\FriendController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/games/create', [GameController::class, 'store'])
        ->name('games.store');

    Route::get('/games/{game}', [GameController::class, 'show'])
        ->name('games.show');

    Route::post(
        '/battle/{game}/attack/{attack}',
        [BattleController::class, 'attack']
    )->name('battle.attack');

    Route::post('/battle/{game}/defend', [BattleController::class, 'defend'])
        ->name('battle.defend');

    Route::get('/friends', [FriendController::class, 'index'])
        ->name('friends.index');

});

require __DIR__ . '/auth.php';

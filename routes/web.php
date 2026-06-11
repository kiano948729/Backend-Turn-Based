<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\FriendController;

Route::get('/', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    //profiel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //spel
    Route::post('/games/create', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

    //battle acties
    Route::post('/battle/{game}/attack/{attack}', [BattleController::class, 'attack'])->name('battle.attack');
    Route::post('/battle/{game}/defend', [BattleController::class, 'defend'])->name('battle.defend');

    //vrienden
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends', [FriendController::class, 'store'])->name('friends.store');
    Route::patch('/friends/{friend}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::patch('/friends/{friend}/decline', [FriendController::class, 'decline'])->name('friends.decline');

});

require __DIR__ . '/auth.php';

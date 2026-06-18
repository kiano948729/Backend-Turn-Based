<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'game_class_id',
        'current_hp',
        'current_mana',
        'is_defending',
        'is_stunned',
        'is_poisoned',
        'poison_turns',
        'dodge_chance',
    ];  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //in GamePlayer model
    public function gameClass()
    {
        return $this->belongsTo(GameClass::class);
    }
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

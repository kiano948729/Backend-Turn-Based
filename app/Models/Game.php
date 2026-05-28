<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'status',
        'current_turn_player_id',
        'winner_id',
    ];

    public function players()
    {
        return $this->hasMany(GamePlayer::class);
    }

    public function logs()
    {
        return $this->hasMany(GameLog::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
}

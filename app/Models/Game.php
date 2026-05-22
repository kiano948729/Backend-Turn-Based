<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function actions()
    {
        return $this->hasMany(GameAction::class);
    }
}

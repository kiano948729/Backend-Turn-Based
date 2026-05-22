<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameAction extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

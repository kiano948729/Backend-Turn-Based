<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameClass extends Model
{
    protected $fillable = ['name', 'base_hp', 'base_mana', 'base_defense', 'crit_chance'];

    public function spells()
    {
        return $this->belongsToMany(Spell::class, 'class_spell');
    }
}

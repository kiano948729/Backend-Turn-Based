<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GameClass;

class GameClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GameClass::create([
            'name' => 'Warrior',
            'base_hp' => 140,
            'base_mana' => 30,
            'base_strength' => 18,
            'base_defense' => 12,
        ]);

        GameClass::create([
            'name' => 'Mage',
            'base_hp' => 90,
            'base_mana' => 100,
            'base_strength' => 24,
            'base_defense' => 5,
        ]);

        GameClass::create([
            'name' => 'Rogue',
            'base_hp' => 110,
            'base_mana' => 50,
            'base_strength' => 16,
            'base_defense' => 8,
        ]);
    }
}

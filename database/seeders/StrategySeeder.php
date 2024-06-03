<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Strategy;

class StrategySeeder extends Seeder
{
    public function run(): void
    {
        $strategies = ['DESKTOP', 'MOBILE'];
        foreach ($strategies as $strategy) {
            Strategy::create(['name' => $strategy]);
        }
    }
}


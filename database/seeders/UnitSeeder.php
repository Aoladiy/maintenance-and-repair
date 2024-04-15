<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create(['name' => null]);
        Unit::create(['name' => 'миллилитры']);
        Unit::create(['name' => 'литры']);
        Unit::create(['name' => 'штуки']);
        Unit::create(['name' => 'граммы']);
        Unit::create(['name' => 'килограммы']);
        Unit::create(['name' => 'тонны']);
        Unit::create(['name' => 'метры кубические']);
        Unit::create(['name' => 'метры квадратные']);
        Unit::create(['name' => 'метры']);
        Unit::create(['name' => 'сантиметры']);
        Unit::create(['name' => 'миллиметры']);
        Unit::create(['name' => 'кВт*ч']);
        Unit::create(['name' => 'пары']);
    }
}

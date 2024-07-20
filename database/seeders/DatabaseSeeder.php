<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UnitSeeder::class]);
        exec('python3 seeder.py'); // заполнение старой god object таблицы
        exec('python3 seeder_new.py'); // заполнение бд, спроектриованной несолько лучше
        exec('php artisan app:get-current-engine-hours-and-mileage');
//        $this->call([ItemSeeder::class]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

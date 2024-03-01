<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory(10)->create();
        for ($i = 0; $i < 90; $i++) {
            Item::factory()->create([
                'parent_id' => Item::query()->inRandomOrder()->first()
            ]);
        }
    }
}

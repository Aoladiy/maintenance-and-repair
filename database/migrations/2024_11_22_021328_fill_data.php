<?php

use Database\Seeders\UnitSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => 'UnitSeeder']);
        exec('python3 seeder.py'); // заполнение старой god object таблицы
        exec('python3 seeder_new.py'); // заполнение бд, спроектриованной несолько лучше
        exec('php artisan app:get-current-engine-hours-and-mileage');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // irreversible
    }
};

<?php

use App\Models\Component;
use App\Models\Operation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            $equipmentId = DB::table('equipment')
                ->where('name', 'Т11.02 ЯБР-1')
                ->value('id');
            // не нашел ДВС ЯМЗ236НД-2
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // irreversible
    }
};

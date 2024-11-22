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
            $equipmentIds = DB::table('equipment')
                ->where('name', 'like', '%CDM856М%')
                ->pluck('id');
            foreach ($equipmentIds as $equipmentId) {
                $nodeId = DB::table('nodes')
                    ->where('equipment_id', $equipmentId)
                    ->where('name', 'электрооборудование и кабина')
                    ->value('id');

                // не нашел ДВС Cummins WD10
            }
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

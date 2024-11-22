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
            // HL770-9S
            $HL770_9SId = DB::table('equipment')
                ->where('name', 'HL770-9S')
                ->value('id');

            // электрооборудование и кабина
            $nodeId = DB::table('nodes')
                ->where('equipment_id', $HL770_9SId)
                ->where('name', 'электрооборудование и кабина')
                ->value('id');

            // "Замена фильтров кондиционера внешний" не нашел такой записи
            DB::table('components')
                ->where('name', 'Соленоид привода золотника')
                ->where('amount', 12)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена эл.двигателя кондиционера/отопителя')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена эл. Соединений F/M')
                ->where('amount', 60)
                ->where('node_id', $nodeId)
                ->delete();
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

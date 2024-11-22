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
                ->where('name', 'Т15.01 ЯБР-1')
                ->value('id');

            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'Гидросистема и рабочее оборудование')
                ->value('id');

            DB::table('components')
                ->where('name', 'Элемент сапуна гидробака')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Пилотный фильтр')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка приводных ремней')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка пальцев, шпилек и втулок в каждом центре вращения на состояние изношенности')
                ->where('amount', 12)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена возвратного фильтра гидравлики')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена фильтров пилотной линии и линий управления основного клапана гидросистемы')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена элементов пилотной линии')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена сливного фильтра гидросистемы')
                ->where('amount', 22)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена бокорезов отвала')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена тела отвала с раскосами')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена пилотного насоса гидравлики')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена колец бугелей')
                ->where('amount', 216)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена золотников клапанов управления')
                ->where('amount', 18)
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

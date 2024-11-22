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
            // HX300SL
            $equipmentId = DB::table('equipment')
                ->where('name', 'HX300SL')
                ->value('id');

            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'Гидросистема и рабочее оборудование')
                ->value('id');

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
                ->where('name', 'Замена фильтров пилотной линии и линий управления основного клапана гидросистемы')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена элементов пилотной линии')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена сливного фильтра гидросистемы')
                ->where('amount', 22)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена бокорезов ковша')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена днища ковша')
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

            /** Сетчатый фильтр на всасывающей линии гидросистемы */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Сетчатый фильтр на всасывающей линии гидросистемы',
                'amount' => 1,
                'vendor_code' => null,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 30, // 30 минут
                'service_period_in_engine_hours' => 2000,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => '2000'],
            );

            $component->operations()->attach($operation->id);
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

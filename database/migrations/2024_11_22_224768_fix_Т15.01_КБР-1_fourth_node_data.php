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
                ->where('name', 'Т15.01 КБР-1')
                ->value('id');

            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'ДВС Cummins QSC 8,3')
                ->value('id');

            DB::table('components')
                ->where('name', 'Предфильтр охлаждающей жидкости заменить')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена основного топливного фильтра (ГО)')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена ЭБУ')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена ПГБ')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена прокладок передней крышки')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена сальников коленвала')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена сальников распред вала')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена прокладок задней крышки')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена системы рециркуляции газов и сажевого фильтра')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена привода управления ТНВД')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена шкива привода вентилятора')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена прокладок банджо')
                ->where('amount', 12)
                ->where('node_id', $nodeId)
                ->delete();

            /** Замена воздушного фильтра (внутренний ‐ элемент безопасности) */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена воздушного фильтра (внутренний ‐ элемент безопасности)',
                'amount' => 1,
                'vendor_code' => 'Т-330-11095.60.01', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 30 * 60, // 30 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'То 1000 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Очистка радиаторов ДВС, гидравлики */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Очистка радиаторов ДВС, гидравлики',
                'amount' => 3,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 20 * 60, // 20 минут
                'service_period_in_hours' => 250, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'То 250 Обслуживание'],
            );

            $component->operations()->attach($operation->id);

            /** Замена ремня вентилятора */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена ремня вентилятора',
                'amount' => 1,
                'vendor_code' => 'А-1320III', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 30 * 60, // 30 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Замена'],
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

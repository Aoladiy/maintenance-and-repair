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
            // Robex 300 LC-9S (1)
            $equipmentId = DB::table('equipment')
                ->where('name', 'Robex 300 LC-9S (1)')
                ->value('id');

            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'ДВС Cummins 6CTA - 8,3')
                ->value('id');

            // Замена основного топливного фильтра (ГО)
            DB::table('components')
                ->where('name', 'Замена основного топливного фильтра (ГО)')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена ЭБУ
            DB::table('components')
                ->where('name', 'Замена ЭБУ')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена ПГБ
            DB::table('components')
                ->where('name', 'Замена ПГБ')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена прокладок передней крышки
            DB::table('components')
                ->where('name', 'Замена прокладок передней крышки')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена сальников коленвала
            DB::table('components')
                ->where('name', 'Замена сальников коленвала')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена сальников распред вала
            DB::table('components')
                ->where('name', 'Замена сальников распред вала')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена прокладок задней крышки
            DB::table('components')
                ->where('name', 'Замена прокладок задней крышки')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена системы рециркуляции газов и сажевого фильтра
            DB::table('components')
                ->where('name', 'Замена системы рециркуляции газов и сажевого фильтра')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена привода управления ТНВД
            DB::table('components')
                ->where('name', 'Замена привода управления ТНВД')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена шкива привода вентилятора
            DB::table('components')
                ->where('name', 'Замена шкива привода вентилятора')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена прокладок банджо
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
                'vendor_code' => '11NB-20130',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 30, // 30 минут
                'service_period_in_engine_hours' => 1000,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'То 1000'],
            );

            $component->operations()->attach($operation->id);

            /** Очистка радиаторов ДВС, гидравлики и кондиционера */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Очистка радиаторов ДВС, гидравлики и кондиционера',
                'amount' => 3,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 20, // 20 минут
                'service_period_in_engine_hours' => 250,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'То 250'],
            );

            $component->operations()->attach($operation->id);

            /** Замена фильтра водного сепаратора */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена фильтра водного сепаратора',
                'amount' => 1,
                'vendor_code' => '11LB-70030',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 30, // 30 минут
                'service_period_in_engine_hours' => 250,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 250'],
            );

            $component->operations()->attach($operation->id);

            /** Замена ремня вентилятора */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена ремня вентилятора',
                'amount' => 1,
                'vendor_code' => '3289997S',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 30, // 30 минут
                'service_period_in_engine_hours' => 1000,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'замена'],
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

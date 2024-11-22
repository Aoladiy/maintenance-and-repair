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
                ->where('name', 'электрооборудование и кабина')
                ->value('id');

            // АКБ проверка Вода дистилированная
            DB::table('components')
                ->where('name', 'АКБ проверка Вода дистилированная')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            // Соленоид привода золотника
            DB::table('components')
                ->where('name', 'Соленоид привода золотника')
                ->where('amount', 12)
                ->where('node_id', $nodeId)
                ->delete();

            // Мотор привода с/о
            DB::table('components')
                ->where('name', 'Мотор привода с/о')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            // Щетка с/о
            DB::table('components')
                ->where('name', 'Щетка с/о')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена эл.двигателя кондиционера/отопителя
            DB::table('components')
                ->where('name', 'Замена эл.двигателя кондиционера/отопителя')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена стекол кабины
            DB::table('components')
                ->where('name', 'Замена стекол кабины')
                ->where('amount', 8)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена эл. Ламп
            DB::table('components')
                ->where('name', 'Замена эл. Ламп')
                ->where('amount', 18)
                ->where('node_id', $nodeId)
                ->delete();

            // Замена эл. Соединений F/M
            DB::table('components')
                ->where('name', 'Замена эл. Соединений F/M')
                ->where('amount', 60)
                ->where('node_id', $nodeId)
                ->delete();

            /** Промывка конденсатора системы кондиционирования */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Промывка конденсатора системы кондиционирования',
                'amount' => 1,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 150, // 150 минут
                'service_period_in_engine_hours' => 1080,  // Частота обслуживания в днях
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'обслуживание'],
            );

            $component->operations()->attach($operation->id);

            /** Замена фильтра кондиционера кабины */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена фильтра кондиционера кабины',
                'amount' => 1,
                'vendor_code' => '11Q6-90510',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 15, // 15 минут
                'service_period_in_engine_hours' => 1000,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000'],
            );

            $component->operations()->attach($operation->id);

            /** Заправка кондиционера */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Заправка кондиционера',
                'amount' => 1,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 60, // 60 минут
                'service_period_in_engine_hours' => 360,  // Частота обслуживания в днях
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'проверка\заправка'],
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

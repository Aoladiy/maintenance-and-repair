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
                ->where('name', 'электрооборудование и кабина')
                ->value('id');

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

            /** Промывка конденсатора системы кондиционирования */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Промывка конденсатора системы кондиционирования',
                'amount' => 1,
                'vendor_code' => null,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 150, // 150 минут
                'service_period_in_days' => 1080, // 1080 дней
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
                'vendor_code' => '11K6-90770',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 15, // 15 минут
                'service_period_in_engine_hours' => 1000, // 1000 моточасов
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
                'vendor_code' => null,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 60, // 60 минут
                'service_period_in_days' => 360, // 360 дней
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

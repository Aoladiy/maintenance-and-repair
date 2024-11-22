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
            $equipmentId = DB::table('equipment')
                ->where('name', 'HL770-9S')
                ->value('id');

            // Трансмиссия и ходовая часть
            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'Трансмиссия и ходовая часть')
                ->value('id');

            DB::table('components')
                ->where('name', 'Приводы насосов бортовых тормозов')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Проверка сальниковых уплотнений мостов и КПП')
                ->where('amount', 28)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Очистка и продувка воздушный фильтр')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Проверка хладагента (антифриза) и соединения системы охлаждения Антифриз ER')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Проверка хладагента (антифриза) и соединения системы охлаждения Антифриз ER')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена карданных болтов')
                ->where('amount', 48)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Ревизия АКПП с заменой уплотнений')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена опорных дисков и ступиц мостов')
                ->where('amount', 4)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена поворотного сочленения рамы')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена стремянок крепления мостов')
                ->where('amount', 4)
                ->where('node_id', $nodeId)
                ->delete();
            DB::table('components')
                ->where('name', 'Замена опорных подшипников ступиц')
                ->where('amount', 8)
                ->where('node_id', $nodeId)
                ->delete();

            /** Замена фильтра трансмиссии */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена фильтра трансмиссии',
                'amount' => 1,
                'vendor_code' => 'ZGAQ-02400',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 30, // 30 минут
                'service_period_in_engine_hours' => 1000,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000'],
            );

            $component->operations()->attach($operation->id);

            /** Смазать рулевой механизм */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать рулевой механизм',
                'amount' => 1,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 7,  // 7 минут
                'service_period_in_engine_hours' => 50,  // 50 моточасов
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 50'],
            );

            $component->operations()->attach($operation->id);


            /** Смазать ось заднего моста */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать ось заднего моста',
                'amount' => 1,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10,  // 10 минут
                'service_period_in_engine_hours' => 50,  // 50 моточасов
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 50'],
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

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
                ->where('name', 'JCB 3CX')
                ->value('id');

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
                ->where('name', 'смазать оси сочленений')
                ->where('amount', 13)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка состояния электрической системы и электрических компонентов')
                ->where('amount', 5)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверить состояния мостов и приводных валов')
                ->where('amount', 5)
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
                ->where('name', 'Проверка уровня масла диференциала заднего моста')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка болтов крепления узлов трансмиссии')
                ->where('amount', 36)
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
                ->where('name', 'Замена РВД приводов насоса хода')
                ->where('amount', 12)
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
                'vendor_code' => '581/R5206', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 30 * 60, // 30 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена камеры колеса */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена камеры колеса',
                'amount' => 2,
                'vendor_code' => 'камера 16.9-24', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 240 * 60, // 240 минут
                'service_period_in_hours' => 1500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена трансмиссионного масла заднего моста */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена трансмиссионного масла заднего моста',
                'amount' => 20.5,
                'vendor_code' => 'JCB High Performance Gear Oil 90 4000/3905', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 40 * 60, // 40 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена трансмиссионного масла синхрончелнока */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена трансмиссионного масла синхрончелнока',
                'amount' => 15,
                'vendor_code' => 'JCB Transmission Fluid EP 10W', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 40 * 60, // 40 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Замена'],
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

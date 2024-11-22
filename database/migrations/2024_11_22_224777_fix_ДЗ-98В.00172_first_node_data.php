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
                ->where('name', 'ДЗ-98В.00172')
                ->value('id');

            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'Трансмиссия и ходовая часть')
                ->value('id');

            DB::table('components')
                ->where('name', 'Замена усилителей тормозов')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка сальниковых уплотнений мостов и КПП')
                ->where('amount', 28)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка состояния электрической системы и электрических компонентов')
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
                ->where('name', 'Замена колодок тормозной системы')
                ->where('amount', 8)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена поворотного сочленения рамы')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена основного редуктора')
                ->where('amount', 4)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена бортового редуктора')
                ->where('amount', 8)
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

            /** Проверка схождения передних колес */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Проверка схождение передних колес',
                'amount' => 1,
                'vendor_code' => null, // Нет идентификатора артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 45 * 60, // 45 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Проверка'],
            );

            $component->operations()->attach($operation->id);

            /** Проверка зазоров зацепления поворотного круга */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Проверка зазорав зацеплении поворотного круга',
                'amount' => 1,
                'vendor_code' => null, // Нет идентификатора артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 30 * 60, // 30 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Проверка'],
            );

            $component->operations()->attach($operation->id);

            /** Замена камеры колеса */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена камеры колеса',
                'amount' => 2,
                'vendor_code' => 'камера 20.5-25', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 240 * 60, // 240 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена масла в коробке передач, редукторе привода гидронасосов, раздаточном редукторе */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена масла в коробке передач, редукторе привода гидронасосов, раздаточном редукторе',
                'amount' => 35,
                'vendor_code' => 'ТЭП 15', // Идентификатор артикул
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

            /** Замена масла в главных передачах мостов */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена масла в главных передачах мостов',
                'amount' => 29,
                'vendor_code' => 'ТЭП 15', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 20 * 60, // 20 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена масла в бортовом редукторе моста */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена масла в бортовом редукторе моста',
                'amount' => 8.6,
                'vendor_code' => 'ТЭП 15', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 20 * 60, // 20 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена масла в картере колесного тормаза */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена масла в картере колесного тормаза',
                'amount' => 3.6,
                'vendor_code' => 'М8 ДМ', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 15 * 60, // 15 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Замена масла в редукторе отвала */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена масла в редукторе отвала',
                'amount' => 3,
                'vendor_code' => 'ТЭП 15', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 15 * 60, // 15 минут
                'service_period_in_hours' => 1000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000 Замена'],
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

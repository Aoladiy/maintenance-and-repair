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
            $equipmentIds = DB::table('equipment')
                ->where('name', 'like', '%CDM856М%')
                ->pluck('id');
            foreach ($equipmentIds as $equipmentId) {
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
                    ->where('name', 'Замена масла АКПП')
                    ->where('amount', 45)
                    ->where('vendor_code', 'SAE-10W')
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

                /** Затянуть болты соединен перед / задн оси и рамы */
                /** @var Component $component */
                $component = Component::query()->create([
                    'name' => 'Затянуть болты соединен перед / задн оси и рамы',
                    'amount' => 1,
                    'vendor_code' => '60301000042',
                    'node_id' => $nodeId,
                ]);

                $component->serviceCharacteristics()->create([
                    'service_duration_in_seconds' => 60 * 30, // 30 минут
                    'service_period_in_engine_hours' => 500, // 500 моточасов
                ]);

                /** @var Operation $operation */
                $operation = Operation::query()->firstOrCreate(
                    ['name' => 'ТО 500'],
                );

                $component->operations()->attach($operation->id);

                /** Затянуть болты для крепл перед и задн частей рамы */
                /** @var Component $component */
                $component = Component::query()->create([
                    'name' => 'Затянуть болты для крепл перед и задн частей рамы',
                    'amount' => 1,
                    'vendor_code' => '60301000042',
                    'node_id' => $nodeId,
                ]);

                $component->serviceCharacteristics()->create([
                    'service_duration_in_seconds' => 60 * 30, // 30 минут
                    'service_period_in_engine_hours' => 500, // 500 моточасов
                ]);

                /** @var Operation $operation */
                $operation = Operation::query()->firstOrCreate(
                    ['name' => 'ТО 500'],
                );

                $component->operations()->attach($operation->id);

                /** Замена камеры колеса */
                /** @var Component $component */
                $component = Component::query()->create([
                    'name' => 'Замена камеры колеса',
                    'amount' => 2,
                    'vendor_code' => 'камера 23.5-25',
                    'node_id' => $nodeId,
                ]);

                $component->serviceCharacteristics()->create([
                    'service_duration_in_seconds' => 60 * 240, // 240 минут
                    'service_period_in_engine_hours' => 1500, // 1500 моточасов
                ]);

                /** @var Operation $operation */
                $operation = Operation::query()->firstOrCreate(
                    ['name' => 'замена'],
                );

                $component->operations()->attach($operation->id);

                /** Замена насоса трансмиссии */
                /** @var Component $component */
                $component = Component::query()->create([
                    'name' => 'Замена насоса трансмиссии',
                    'amount' => 1,
                    'vendor_code' => '60301000042',
                    'node_id' => $nodeId,
                ]);

                $component->serviceCharacteristics()->create([
                    'service_duration_in_seconds' => 60 * 480, // 480 минут
                    'service_period_in_engine_hours' => 5000, // 5000 моточасов
                ]);

                /** @var Operation $operation */
                $operation = Operation::query()->firstOrCreate(
                    ['name' => 'ТО 1000'],
                );

                $component->operations()->attach($operation->id);

                /** Проверка тормозных колодок и дисков */
                /** @var Component $component */
                $component = Component::query()->create([
                    'name' => 'Проверка тормозных колодок и дисков',
                    'amount' => 2,
                    'vendor_code' => null,
                    'node_id' => $nodeId,
                ]);

                $component->serviceCharacteristics()->create([
                    'service_duration_in_seconds' => 60 * 30, // 30 минут
                    'service_period_in_engine_hours' => 500, // 500 моточасов
                ]);

                /** @var Operation $operation */
                $operation = Operation::query()->firstOrCreate(
                    ['name' => 'ТО 500'],
                );

                $component->operations()->attach($operation->id);

                /** Очистка сетчатого фильтра коробки передач */
                /** @var Component $component */
                $component = Component::query()->create([
                    'name' => 'Очистка сетчатого фильтра коробки передач',
                    'amount' => 1,
                    'vendor_code' => null,
                    'node_id' => $nodeId,
                ]);

                $component->serviceCharacteristics()->create([
                    'service_duration_in_seconds' => 60 * 30, // 30 минут
                    'service_period_in_engine_hours' => 500, // 500 моточасов
                ]);

                /** @var Operation $operation */
                $operation = Operation::query()->firstOrCreate(
                    ['name' => 'ТО 500'],
                );

                $component->operations()->attach($operation->id);
            }
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

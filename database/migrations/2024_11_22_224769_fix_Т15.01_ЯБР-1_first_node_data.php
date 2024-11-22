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
                ->where('name', 'Трансмиссия и ходовая часть')
                ->value('id');

            DB::table('components')
                ->where('name', 'Замена клапана управления АКПП')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка сальниковых уплотнений редукторов и КПП')
                ->where('amount', 28)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка состояния электрической системы и электрических компонентов')
                ->where('amount', 5)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверить состояния приводных редукторов')
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
                ->where('name', 'Проверка болтов крепления узлов трансмиссии')
                ->where('amount', 36)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена трансмиссионного масла Картер редукторахода')
                ->where('amount', 95)
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
                ->where('name', 'Замена поддерживающих катков')
                ->where('amount', 4)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена полурамы тележки')
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
                ->where('name', 'Замена опорных подшипников АКПП')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена защиты приводов рамы и агрегатов')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            /** Замена фильтра трансмиссии */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена фильтра трансмиссии',
                'amount' => 1,
                'vendor_code' => 'ЭФМ 021-1012040', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 30 * 60, // 30 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Смазка втулки осей и цапфы гидроцилиндров */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазка втулки осей и цапфы гидроцилиндров',
                'amount' => 2,
                'vendor_code' => 'Литол 24', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 20 * 60, // 20 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Смазка'],
            );

            $component->operations()->attach($operation->id);

            /** Смазка шар опор, толкающих брусьев и поперечных тяг */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазка шар опор, толкающих брусьев и поперечных тяг',
                'amount' => 2,
                'vendor_code' => 'Литол 24', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 20 * 60, // 20 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Смазка'],
            );

            $component->operations()->attach($operation->id);

            /** Смазка подвижных соединений винтов раскоса */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазка подвижных соединений винтов раскоса',
                'amount' => 2,
                'vendor_code' => 'Литол 24', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 20 * 60, // 20 минут
                'service_period_in_hours' => 500, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 500 Смазка'],
            );

            $component->operations()->attach($operation->id);

            /** Проверка зазоров в шаровых опорах толкающих брусьев */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Проверка зазоров в шаровых опорах толкающих брусьев',
                'amount' => 2,
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 40 * 60, // 40 минут
                'service_period_in_hours' => 2000, // Частота обслуживания в моточасах
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 2000 Проверка'],
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

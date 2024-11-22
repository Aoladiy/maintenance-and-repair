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
                ->where('name', 'Трансмиссия')
                ->value('id');

            DB::table('components')
                ->where('name', 'Приводы насосов бортовых тормозов')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Добавить смазку согласно "Карты смазки" консистентная смазка класса ЕР-1')
                ->where('amount', 28)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Натянуть гусеницу консистентная смазка класса ЕР-3')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка уровня масла конечной передачи')
                ->whereNull('amount') // Количество отсутствует
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка состояния электрической системы и электрических компонентов')
                ->whereNull('amount') // Количество отсутствует
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Очистка и продувка воздушный фильтр')
                ->where('amount', 5)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Проверка хладагента (антифриза) и соединения системы охлаждения Антифриз ER')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена смазки редуктора поворота и шестерни смазка консистентная')
                ->where('amount', 95)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена смазки поворотного круга')
                ->where('amount', 48)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена РВД приводов насоса хода')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена сегментов приводного колеса')
                ->where('amount', 12)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена натяжного колеса')
                ->where('amount', 4)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена натяжителя')
                ->where('amount', 1)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена гусеницы')
                ->where('amount', 4)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена защиты приводов рамы и агрегатов')
                ->where('amount', 8)
                ->where('node_id', $nodeId)
                ->delete();

            /** Смазать поршневую полость гидроцилиндра стрелы */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать поршневую полость гидроцилиндра стрелы',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 250'],
            );

            $component->operations()->attach($operation->id);

            /** Смазать основание стрелы */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать основание стрелы',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            $component->operations()->attach($operation->id);

            /** Смазать цапфу гильзы гидроцилиндра стрелы */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать цапфу гильзы гидроцилиндра стрелы',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            $component->operations()->attach($operation->id);

            /** Смазать цапфу гильзы гидроцилиндра рукояти */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать цапфу гильзы гидроцилиндра рукояти',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            $component->operations()->attach($operation->id);

            /** Смазать штоковую полость гидроцилиндра рукояти */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать штоковую полость гидроцилиндра рукояти',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            $component->operations()->attach($operation->id);

            /** Смазать соединение стрелы и рукояти */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать соединение стрелы и рукояти',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            $component->operations()->attach($operation->id);

            /** Смазать цапфу гильзы гидроцилиндра ковша */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Смазать цапфу гильзы гидроцилиндра ковша',
                'amount' => 1,
                'vendor_code' => 'Grease LX EP2',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 10, // 10 минут
                'service_period_in_engine_hours' => 250,
            ]);

            $component->operations()->attach($operation->id);

            /** Замена масла в картере ходового редуктора */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена масла в картере ходового редуктора',
                'amount' => 16.5, // Литры
                'vendor_code' => 'АРI 80/W90',
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 40, // 40 минут
                'service_period_in_engine_hours' => 1000,
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'ТО 1000'],
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

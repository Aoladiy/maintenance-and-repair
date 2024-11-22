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
                ->where('name', 'электрооборудование и кабина')
                ->value('id');

            DB::table('components')
                ->where('name', 'АКБ проверка Вода дистилированная')
                ->where('amount', 2)
                ->where('node_id', $nodeId)
                ->delete();

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
                ->where('name', 'Замена стекол кабины')
                ->where('amount', 8)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена эл. Ламп')
                ->where('amount', 18)
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
                'vendor_code' => '', // Идентификатор артикул пустой
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 150 * 60, // 150 минут
                'service_period_in_days' => 1080, // Частота обслуживания в днях
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Обслуживание'],
            );

            $component->operations()->attach($operation->id);

            /** Замена фильтра кондиционера кабины */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена фильтра кондиционера кабины',
                'amount' => 1,
                'vendor_code' => '30/926362', // Идентификатор артикул
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

            /** Замена осушителя кондиционера */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Замена осушителя кондиционера',
                'amount' => 1,
                'vendor_code' => '30/925633', // Идентификатор артикул
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 120 * 60, // 120 минут
                'service_period_in_days' => 1080, // Частота обслуживания в днях
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Замена'],
            );

            $component->operations()->attach($operation->id);

            /** Заправка кондиционера */
            /** @var Component $component */
            $component = Component::query()->create([
                'name' => 'Заправка кондиционера',
                'amount' => 1,
                'vendor_code' => '', // Идентификатор артикул пустой
                'node_id' => $nodeId,
            ]);

            $component->serviceCharacteristics()->create([
                'service_duration_in_seconds' => 60 * 60, // 60 минут
                'service_period_in_days' => 360, // Частота обслуживания в днях
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Проверка/Заправка'],
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

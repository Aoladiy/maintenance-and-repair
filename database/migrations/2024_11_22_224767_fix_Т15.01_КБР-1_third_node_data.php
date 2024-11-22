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
                ->where('name', 'Т15.01 КБР-1')
                ->value('id');

            $nodeId = DB::table('nodes')
                ->where('equipment_id', $equipmentId)
                ->where('name', 'электрооборудование и кабина')
                ->value('id');

            DB::table('components')
                ->where('name', 'Замена фильтров кондиционера внешний')
                ->where('amount', 1)
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
                ->where('name', 'Замена эл. Соединений F/M')
                ->where('amount', 60)
                ->where('node_id', $nodeId)
                ->delete();

            DB::table('components')
                ->where('name', 'Замена джойстиков управления')
                ->where('amount', 2)
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
                'service_period_in_days' => 1080, // 1080 дней
            ]);

            /** @var Operation $operation */
            $operation = Operation::query()->firstOrCreate(
                ['name' => 'Обслуживание'],
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
                'service_period_in_days' => 360, // 360 дней
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

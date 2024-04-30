<?php

namespace App\Console\Commands;

use App\Models\ScheduledMaintenance;
use App\Models\ScheduledPurchase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class seedPurchase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-purchases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Очищаем таблицу
        ScheduledPurchase::query()->truncate();
        // Используем Query Builder для получения данных и подсчета количества
        $scheduledPurchasesData = ScheduledMaintenance::query()->select('items.component', 'items.unit_id', DB::raw('COUNT(*) as number'))
            ->join('items', 'scheduled_maintenances.item_id', '=', 'items.id')
            ->groupBy('items.component', 'items.unit_id')
            ->get();

        // Вставляем данные в модель ScheduledPurchases
        foreach ($scheduledPurchasesData as $data) {
            ScheduledPurchase::query()->create([
                'component' => $data->component,
                'unit_id' => $data->unit_id,
                'number' => $data->number,
            ]);
        }

        // Выводим сообщение об успешном завершении операции
        $this->info('Scheduled purchases data has been inserted successfully.');
    }
}

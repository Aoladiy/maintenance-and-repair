<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\ScheduledMaintenance;
use Illuminate\Console\Command;

class seedSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command seeds the scheduled_maintenances table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Очищаем таблицу
        ScheduledMaintenance::query()->truncate();
        // Получаем все записи из таблицы Item, где datetime_of_next_service не равно null
        $items = Item::whereNotNull('datetime_of_next_service')->get();

        // Проходим по каждой записи и создаем запись в таблице ScheduledMaintenance
        foreach ($items as $item) {
            ScheduledMaintenance::query()->create([
                'item_id' => $item->id,
            ]);
        }

        $this->info('Scheduled Maintenance table seeded successfully.');
    }
}

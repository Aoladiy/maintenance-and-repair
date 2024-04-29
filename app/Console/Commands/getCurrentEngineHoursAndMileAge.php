<?php

namespace App\Console\Commands;

use App\Models\Item;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class getCurrentEngineHoursAndMileAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-current-engine-hours-and-mileage';

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
        $currentEngineHours = Http::get('http://localhost:81/external/api/currentEngineHours.php')->json();
        $currentMileage = Http::get('http://localhost:81/external/api/currentMileage.php')->json();
        $items = Item::all();

        foreach ($items as $item) {
            $now = new DateTime();
            $date = new DateTime($item->datetime_of_last_service);
            $maintenance_datetime_by_engine_hours = null;
            $maintenance_datetime_by_mileage = null;
            $maintenance_datetime_by_service_period = null;

            if ($item->service_period_in_engine_hours && ($currentEngineHours[$item->id]['number'] - $item->engine_hours_on_the_datetime_of_last_service >= $item->service_period_in_engine_hours)) {
                $maintenance_datetime_by_engine_hours = new DateTime();
            } elseif ($item->mileage && ($currentMileage[$item->id]['number'] - $item->mileage_on_the_datetime_of_last_service >= $item->mileage)) {
                $maintenance_datetime_by_mileage = new DateTime();
            }

            if (!is_null($item->service_period_in_days) && $item->datetime_of_last_service) {
                $maintenance_datetime_by_service_period = (new DateTime($item->datetime_of_last_service))->modify('+' . $item->service_period_in_days . ' days');
            }

            $maintenance_datetimes = array_filter([$maintenance_datetime_by_engine_hours, $maintenance_datetime_by_mileage, $maintenance_datetime_by_service_period]);
            $maintenance_datetime = $maintenance_datetimes ? min($maintenance_datetimes) : null;

            $alertConditions = (
                ($item->service_period_in_engine_hours && ($currentEngineHours[$item->id]['number'] - $item->engine_hours_on_the_datetime_of_last_service + $item->alert_time_in_engine_hours >= $item->service_period_in_engine_hours)) ||
                ($item->mileage && ($currentMileage[$item->id]['number'] - $item->mileage_on_the_datetime_of_last_service + $item->alert_time_in_mileage >= $item->mileage)) ||
                ($item->service_period_in_days * 24 && ($now->diff($date)->h + $item->alert_time_in_hours >= $item->service_period_in_days * 24))
            );

            $item->alert = $alertConditions;
            $item->datetime_of_next_service = $maintenance_datetime;
            $item->save();
        }
        $this->info('Command executed successfully.');
    }
}

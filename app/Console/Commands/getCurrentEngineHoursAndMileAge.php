<?php

namespace App\Console\Commands;

use App\Models\Item;
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
        for ($i = 0; $i < count($items); $i++) {
            if (
                $items[$i]->service_period_in_engine_hours && ($currentEngineHours[$i]['number'] - $items[$i]->engine_hours_on_the_datetime_of_last_service + $items[$i]->alert_time_in_engine_hours >= $items[$i]->service_period_in_engine_hours)
                ||
                $items[$i]->mileage && ($currentMileage[$i]['number'] - $items[$i]->mileage_on_the_datetime_of_last_service + $items[$i]->alert_time_in_mileage >= $items[$i]->mileage)
            )
            {
                $items[$i]->alert = true;
                $items[$i]->save();
            } else {
                $items[$i]->alert = false;
                $items[$i]->save();
            }
        }
    }
}

<?php

namespace App\Console\Commands\old_approach;

use App\Events\AlertChangedEvent;
use App\Interfaces\AlertableInterface;
use App\Models\AlertCharacteristics;
use App\Models\ServiceCharacteristics;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class CurrentAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Эта команда актуализирует данные по оповещениям';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            foreach (ServiceCharacteristics::all() as $serviceCharacteristics) {
                /** @var AlertableInterface $object */
                $object = $serviceCharacteristics->serviceable;
                /** @var AlertCharacteristics $alertCharacteristics */
                $alertCharacteristics = $object->alertCharacteristics()->firstOrNew();

                $datetime_of_last_service = $serviceCharacteristics->datetime_of_last_service ?? 0;
                $service_period_in_days = $serviceCharacteristics->service_period_in_days;
                $now = new Carbon();
                $alert_in_advance_in_hours = $alertCharacteristics->alert_in_advance_in_hours ?? 0;

                $engine_hours_by_the_datetime_of_last_service = $serviceCharacteristics->engine_hours_by_the_datetime_of_last_service ?? 0;
                $service_period_in_engine_hours = $serviceCharacteristics->service_period_in_engine_hours;
                $current_engine_hours = $serviceCharacteristics->current_engine_hours;
                $alert_in_advance_in_engine_hours = $alertCharacteristics->alert_in_advance_in_engine_hours ?? 0;

                $mileage_by_the_datetime_of_last_service = $serviceCharacteristics->mileage_by_the_datetime_of_last_service ?? 0;
                $service_period_in_mileage = $serviceCharacteristics->service_period_in_mileage;
                $current_mileage = $serviceCharacteristics->current_mileage;
                $alert_in_advance_in_mileage = $alertCharacteristics->alert_in_advance_in_mileage ?? 0;

                if (!empty($service_period_in_days)) {
                    $isAlertByDays = $now->diffInHours($datetime_of_last_service) + $alert_in_advance_in_hours >= $service_period_in_days * 24;
                } else {
                    $isAlertByDays = false;
                }

                if (!empty($current_engine_hours) && !empty($service_period_in_engine_hours)) {
                    $isAlertByEngineHours = $current_engine_hours - $engine_hours_by_the_datetime_of_last_service + $alert_in_advance_in_engine_hours >= $service_period_in_engine_hours;
                } else {
                    $isAlertByEngineHours = false;
                }

                if (!empty($current_mileage) && !empty($service_period_in_mileage)) {
                    $isAlertByMileage = $current_mileage - $mileage_by_the_datetime_of_last_service + $alert_in_advance_in_mileage >= $service_period_in_mileage;
                } else {
                    $isAlertByMileage = false;
                }

                $old_alert = $alertCharacteristics->alert;
                $alertCharacteristics->alert = $isAlertByDays || $isAlertByEngineHours || $isAlertByMileage;
                $alertCharacteristics->save();

                if ($old_alert != $alertCharacteristics->alert) {
                    AlertChangedEvent::dispatch($object);
                }

            }

            $this->info('Команда выполнилась успешно!');

        } catch (Throwable $exception) {
            $this->error('Команда не выполнилась успешно! Посмотрите логи (введите команду laratail)');
            logger()->error($exception->getMessage());
        }
    }
}

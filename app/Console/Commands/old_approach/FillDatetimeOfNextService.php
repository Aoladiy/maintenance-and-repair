<?php

namespace App\Console\Commands\old_approach;

use App\Models\ServiceCharacteristics;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class FillDatetimeOfNextService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill-next-services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Эта команда заполняет datetime_of_next_service';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            foreach (ServiceCharacteristics::all() as $serviceCharacteristics) {
                $datetime_of_last_service = $serviceCharacteristics->datetime_of_last_service ? Carbon::create($serviceCharacteristics->datetime_of_last_service) : Carbon::now();
                $service_period_in_days = $serviceCharacteristics->service_period_in_days;

                if (!empty($service_period_in_days)) {
                    $serviceCharacteristics->datetime_of_last_service = $serviceCharacteristics->datetime_of_last_service ?? Carbon::now();
                    $serviceCharacteristics->datetime_of_next_service = $datetime_of_last_service->addDays($service_period_in_days);
                    $serviceCharacteristics->save();
                }
            }

            $this->info('Команда выполнилась успешно!');

        } catch (Throwable $exception) {
            $this->error('Команда не выполнилась успешно! Посмотрите логи (введите команду laratail)');
            logger()->error($exception->getMessage());
        }
    }
}

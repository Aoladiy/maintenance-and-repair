<?php

namespace App\Listeners;

use App\Events\AlertChangedEvent;
use App\Interfaces\AlertableInterface;
use App\Models\Site;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Throwable;

class AlertChangedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AlertChangedEvent $event): void
    {
        try {
            DB::transaction(function () use ($event) {
                $alertable = $event->alertable;
                $parentAlertable = $alertable->parentAlertable()->first();
                if (method_exists($alertable, 'parentAlertable') && !empty($parentAlertable)) {
                    if (in_array(AlertableInterface::class, class_implements($parentAlertable))) {
                        AlertChangedEvent::dispatch($parentAlertable);
                    } elseif (method_exists($parentAlertable, 'allAlertsNumber')) {
                        $parentAlertable->all_alerts_number = $parentAlertable->allAlertsNumber();
                        $parentAlertable->save();
                    }
                }
                $alertable->all_alerts_number = $alertable->allAlertsNumber();
                $alertable->save();
            });
        } catch (Throwable $e) {
            logger()->error($e);
        }
    }
}

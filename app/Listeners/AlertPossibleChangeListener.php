<?php

namespace App\Listeners;

use App\Events\AlertChangedEvent;
use App\Events\AlertPossibleChangeEvent;
use App\Interfaces\AlertableInterface;
use App\Models\Site;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Throwable;

class AlertPossibleChangeListener implements ShouldQueue
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
    public function handle(AlertPossibleChangeEvent $event): void
    {
        Artisan::call('alerts');
    }
}

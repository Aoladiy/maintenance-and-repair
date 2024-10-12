<?php

namespace App\Listeners;

use App\Events\AlertPossibleChangeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

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

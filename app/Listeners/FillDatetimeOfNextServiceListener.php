<?php

namespace App\Listeners;

use App\Events\FillDatetimeOfNextServiceEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class FillDatetimeOfNextServiceListener implements ShouldQueue
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
    public function handle(FillDatetimeOfNextServiceEvent $event): void
    {
        Artisan::call('fill-next-services');
    }
}

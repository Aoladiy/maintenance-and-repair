<?php

namespace App\Providers;

use App\Events\AlertChangedEvent;
use App\Events\AlertPossibleChangeEvent;
use App\Events\FillDatetimeOfNextServiceEvent;
use App\Listeners\AlertChangedListener;
use App\Listeners\AlertPossibleChangeListener;
use App\Listeners\FillDatetimeOfNextServiceListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AlertChangedEvent::class => [
            AlertChangedListener::class,
        ],
        AlertPossibleChangeEvent::class => [
            AlertPossibleChangeListener::class,
        ],
        FillDatetimeOfNextServiceEvent::class => [
            FillDatetimeOfNextServiceListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

<?php

namespace App\Events;

use App\Interfaces\AlertableInterface;
use App\Models\AlertCharacteristics;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public AlertableInterface $alertable;

    /**
     * Create a new event instance.
     */
    public function __construct(AlertableInterface $alertable)
    {
        //
        $this->alertable = $alertable;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

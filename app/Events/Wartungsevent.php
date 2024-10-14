<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Wartungsevent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $message;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->message= 'In Kürze verbessern wir Abalo für Sie!
Nach einer kurzen Pause sind wir wieder
für Sie da! Versprochen.';
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('wartung');
    }

    public function broadcastAs(): string{
        return 'wartungsevent';
    }
}

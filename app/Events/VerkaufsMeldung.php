<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerkaufsMeldung implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $userId = 1;
    public string $message;
    public string $article;
    /**
     * Create a new event instance.
     */
    public function __construct(string $message, string $article, int $userId = 1)
    {
        $this->message = $message;
        $this->article = $article;
        $this->userId = $userId;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('verkaufsMeldung')
        ];
    }
    public function broadcastAs(): string{
        return 'verkaufs-Meldung';
    }
    public function broadcastWith(): array{
        return [

        ];
    }
}

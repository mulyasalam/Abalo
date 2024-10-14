<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleSold implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $userId;
    public string $message;
    public string $article;
    /**
     * Create a new event instance.
     */
    public function __construct(string $message,  string $userId, string $article)
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
    public function broadcastOn(): Channel
    {
        return new Channel('verkaufsMeldung.' . $this->userId);
    }
    public function broadcastAs(): string{
        return 'verkaufs-Meldung';
    }
    public function broadcastWith(): array{
        return [
            'message' => $this->message,
            'userId' => $this->userId,
            'articleName' => $this->article
        ];
    }
}

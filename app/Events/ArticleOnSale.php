<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleOnSale
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $articleName;
    public $articleId;

    public function __construct($articleName, $articleId)
    {
        $this->articleName = $articleName;
        $this->articleId = $articleId;
    }

    public function broadcastOn()
    {
        return new Channel('articles');
    }

    public function broadcastWith()
    {
        return [
            'message' => "Der Artikel {$this->articleName} wird nun günstiger angeboten! Greifen Sie schnell zu.",
            'articleId' => $this->articleId,
        ];
    }
}

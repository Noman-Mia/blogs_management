<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment; // Import the Comment model

class CommentPosted implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn()
    {
        return new Channel('post.' . $this->comment->post_id);  // Broadcasting to a specific post channel
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->comment->id,
            'user' => $this->comment->user->name,
            'content' => $this->comment->content,
        ];
    }
}


<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class CommentPosted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn()
    {
        return new Channel('comments.' . $this->comment->post_id);
    }
}

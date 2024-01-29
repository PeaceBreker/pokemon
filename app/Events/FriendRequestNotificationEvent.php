<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendRequestNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $friendUserId;
    public $senderName;
    /**
     * Create a new event instance.
     */
    public function __construct($friendUserId, $senderName)
    {
        $this->friendUserId = $friendUserId;
        $this->senderName = $senderName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('friend_request_channel.' . $this->friendUserId),
        ];
    }

    public function broadcastWith()
    {
        return [
            'type' => 'friend_request_notification',
            'message' => "You have a new friend request from {$this->senderName}.",
        ];
    }
}

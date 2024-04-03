<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Models\Brandname\BrandnameConfig;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Brandname\Brandname;

class BrandnameConfigCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $model;
    public $default;

    /**
     * Create a new event instance.
     */
    public function __construct(Brandname $brandname, array $default)
    {
        $this->model = $brandname;
        $this->default = $default;
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

<?php

namespace App\Events;

use App\Models\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestSuccssful
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $requestDocument;

    /**
     * Create a new event instance.
     */
    public function __construct(Request $requestDocument)
    {
        //
        $this->requestDocument = $requestDocument;
    }

}

<?php

namespace App\Events;

use App\Models\AccessLogs;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedOut
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithQueue;

    public function handle(UserLoggedIn $event)
    {
        $user = $event->user;-
        // Log user logout activity
        AccessLogs::create([
            'action_taken' => $user->username.' has logged out.',
            'user_id' => $user->id,
        ]);
    }
}

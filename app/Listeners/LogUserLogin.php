<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\AccessLogs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogin
{
    use InteractsWithQueue;
    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event)
    {
        $user = $event->user;
        // Log user logout activity
        AccessLogs::create([
            'action_taken' => $user->username . ' has logged out.',
            'user_id' => $user->id,
        ]);
    }
}

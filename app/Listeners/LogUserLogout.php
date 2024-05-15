<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use App\Models\AccessLogs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogout
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserLoggedOut $event): void
    {
        //
        $user = $event->user;
        // Log user logout activity
        AccessLogs::create([
            'action_taken' => $user->username . ' has logged in.',
            'user_id' => $user->id,
        ]);
    }
}

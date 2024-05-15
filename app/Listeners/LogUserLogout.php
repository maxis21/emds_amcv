<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use App\Models\AccessLogs;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogout implements ShouldQueue
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
            'action_taken' => $user->username . ' has logged out.',
            'user_id' => $user->id,
        ]);
    }
}

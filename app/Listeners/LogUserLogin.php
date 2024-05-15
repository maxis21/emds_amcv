<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\AccessLogs;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogin implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserLoggedIn $event)
    {
        $user = $event->user;
        $user = User::findOrFail(auth()->user()->id);
        $user->isOnline = 1;
        $user->save();
        // Log user logout activity
        AccessLogs::create([
            'action_taken' => $user->username . ' has logged in.',
            'user_id' => $user->id,
        ]);
    }
}

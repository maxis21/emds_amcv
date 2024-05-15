<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SessionExpiry
{
    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        // Check if the logout reason is due to session expiration
        if ($event->user && $event->user->wasRecentlyCreated) {
            // Session expired
            // Perform necessary actions here
            // For example, log out the user
            $user = User::findOrFail(auth()->user()->id);
            $user->isOnline = 0;
            $user->save();
            auth()->logout();
        }
    }
}

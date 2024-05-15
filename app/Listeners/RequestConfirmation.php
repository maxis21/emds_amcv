<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RequestConfirmation
{

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        $requestDocument = $event->requestDocument;
    }
}

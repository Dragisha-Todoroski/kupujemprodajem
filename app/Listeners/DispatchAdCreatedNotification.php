<?php

namespace App\Listeners;

use App\Events\AdCreated;
use App\Jobs\SendAdNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class DispatchAdCreatedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(AdCreated $event): void
    {
        // Dispatches the job to send the email
        SendAdNotification::dispatch($event->ad);
    }
}

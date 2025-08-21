<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Mail\AdCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Ad $ad) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send the mail to the ad owner's email
        Mail::to($this->ad->user->email)->send(new AdCreatedMail($this->ad));
    }
}

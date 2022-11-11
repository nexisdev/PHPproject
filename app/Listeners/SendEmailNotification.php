<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Helpers\Cache;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        $user = User::find($event->user->id)->toArray();

        Mail::send('emails.new-signup-email', $user, function($message) use ($user) {
            $message->to(Cache::settings('notification_email'));
            $message->subject('New User has registered!');
        });
    }
}

<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Mail\OrderShipped;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenerSendEmailEvent
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
     * @param  \App\Events\SendEmailEvent  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
       Mail::to($event->user->email)->send(new OrderShipped($event->user));
    }
}

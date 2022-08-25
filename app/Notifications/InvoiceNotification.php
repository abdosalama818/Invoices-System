<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class InvoiceNotification extends Notification
{
    use Queueable;



    private $invoice;
    public function __construct($invoice)
    {
        $this->invoice=$invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


   /* public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/


    public function toArray($notifiable)
    {
        return [
            'id'=>$this->invoice->id,
            'title'=>$this->invoice->invoice_number,
            'user_id'=>Auth::id(),
            'user'=>Auth::user()->name,
        ];
    }
}

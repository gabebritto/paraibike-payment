<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class CheckoutCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private array $data;

    public function __construct(Array $data)
    {
        $this->data = $data;
    }


    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->markdown('mail.notification.checkout', [
                'name' => $this->data['name'],
                'url' => $this->data['url'],
                'credits' => $this->data['credits'],
                'app_logo' => URL::to('/') . '/img/logo.png',
                'app_url' => URL::to('/')
            ])
            ->subject('Adicionar Crédito - Paraibike');

    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

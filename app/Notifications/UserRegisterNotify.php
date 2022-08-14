<?php

namespace App\Notifications;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserRegisterNotify extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private readonly User|Model $user)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verificação de email')
            ->line("Olá {$this->user->name} sua conta no sistema foi criado")
            ->action('Confirme seu email', route('api.verify-email', [$this->user->email_verificarion_hash]))
            ->line('Su período de teste:')
            ->line(
                new HtmlString(
                    '<strong>' .
                        Carbon::create($this->user->account->created_at)->format('d/m/Y') .
                    '</strong> até ' .
                    '<strong>' .
                        Carbon::create($this->user->account->expire_at)->format('d/m/Y') .
                    '</strong>'
                )
            )
            ->line('Obrigado por usar nossa plataforma!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

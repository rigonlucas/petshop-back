<?php

namespace App\Notifications\Auth;

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
            ->line(
                new HtmlString(
                'Olá **' . $this->user->name .'** sua conta no sistema foi criada'
                )
            )
            ->action('Confirme seu email', route('api.verify-email', [$this->user->email_verificarion_hash]))
            ->line(
                [
                    'Su período de teste:',
                    '**' .
                        Carbon::create($this->user->account->created_at)->format('d/m/Y') .
                    '** até ' .
                    '**' .
                        Carbon::create($this->user->account->expire_at)->format('d/m/Y') .
                    '**',
                ]
            )
            ->line('Você tem **'.config('app.trial_days').' dias** para testar')
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

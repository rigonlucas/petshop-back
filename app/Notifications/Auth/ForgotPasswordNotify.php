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

class ForgotPasswordNotify extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private readonly User|Model $user, private readonly string $recoveryHash)
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
            ->subject('Recuperação de senha')
            ->line("Olá {$this->user->name} foi solicitada uma recuperação de sua senha em sua conta")
            ->action(
                'Trocar minha senha',
                config('app.url_front') . '/recuperar-senha/'. $this->recoveryHash
            )
            ->success()
            ->line('Caso não tenha sido você, desconsidere este email')
            ->line(
                new HtmlString(
                    '<strong>Lembre-se: </strong> Não compartilhe sua senha'
                )
            );
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

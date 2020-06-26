<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SignupActivate_HRD_Anak_Perusahaan extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $url = url('/api/register/activate/'.$notifiable->activation_token);
        return (new MailMessage)
        ->subject('Konfirmasi Email Anda')
        ->line('Selamat Datang, '.$notifiable->name.', ')
        ->line('Bapak/Ibu telah terdaftar di website rekrutmen Koperasi Astra.')
        ->line('Kata Sandi Sementara: '.$notifiable->password)
        ->line('Untuk mengaktifkan akun anda, silahkan klik tombol dibawah.')
        ->action('Konfirmasi Akun', url($url))
        ->line('Thank you for using our application!');
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

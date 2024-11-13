<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $url = str_replace("http://127.0.0.1:8000/api", "http://localhost:5173", $url);
            return (new MailMessage)
                ->greeting('Halo!')
                ->subject('Verifikasi Email Anda')
                ->line('Klik tombol di bawah untuk memverifikasi email Anda di aplikasi Pelaporan Irigasi Kota Batu.')
                ->action('Verifikasi Email Anda', $url);
        });
    }
}

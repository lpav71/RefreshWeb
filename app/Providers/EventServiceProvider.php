<?php

namespace App\Providers;

use App\Http\Common\Logger;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //$this->registerPolicies();

        Event::listen(Login::class, function ($event) {
            $data = array(
                'email' => $event->user->email
            );
            $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE);
            Logger::create($dataJson, 'Вход пользователя в систему', 'login', $event->user->id);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

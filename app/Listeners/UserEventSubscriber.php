<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventSubscriber implements ShouldQueue
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event)
    {
        $user = $event->user;
        $user->is_online = true;
        $user->last_login_at = now();
        $user->save();
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event)
    {
        if ($event->user) {
            $event->user->is_online = false;
            $event->user->save();
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        return [
            Login::class => 'handleUserLogin',
            Logout::class => 'handleUserLogout',
        ];
    }
}
<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Request;

/**
 * Event Listener handling Requirement A (Logging User Logins).
 * Captures user ID, IP address, user agent, and timestamp upon login.
 */
class LogUserLogin
{
    /**
     * Handle the event when a user successfully logs in.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event): void
    {
        UserLogin::create([
            'user_id'    => $event->user->id,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'login_at'   => now(),
        ]);
    }
}
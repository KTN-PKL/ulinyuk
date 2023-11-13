<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\m_user;

class UpdateUserOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // Lakukan perubahan pada instance user di sini
        $user = $event->user;
        $user->last_login_at = now(); // contoh: menyimpan waktu login terakhir
        $user->save();
    }
}

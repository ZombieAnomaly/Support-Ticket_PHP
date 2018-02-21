<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider {
   public function register() {
        $this->app->bind('App\libs\DataBaseInterfaces\TicketsI', 'App\libs\DataBaseInterfaces\TicketEloquent');
    }

}

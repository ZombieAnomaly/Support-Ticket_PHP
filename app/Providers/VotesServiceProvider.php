<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VotesServiceProvider extends ServiceProvider {
   public function register() {
        $this->app->bind('App\libs\DataBaseInterfaces\VotesI', 'App\libs\DataBaseInterfaces\VotesEloquent');
    }

}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider {
   public function register() {
        $this->app->bind('App\libs\DataBaseInterfaces\CategoryI', 'App\libs\DataBaseInterfaces\CategoryEloquent');
    }

}

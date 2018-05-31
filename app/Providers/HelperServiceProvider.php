<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {


    /**
     * Get all helper files in Helpers Dir & load them
     *
     * @return void
     */
    public function register() {
        $dir = glob(app_path('Helpers/*'));

        foreach ($dir as $file) {
            require_once $file;
        }
    }
}

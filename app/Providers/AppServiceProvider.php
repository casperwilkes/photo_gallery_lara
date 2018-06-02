<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // Fix for db string length //
        Schema::defaultStringLength(191);

        // Custom username validation //
        Validator::extend('unique_name', function ($attribute, $value, $parameters, $validator) {
            // Allow:
            // .
            // -
            // _
            // #
            return preg_match('/^[0-9a-zA-Z.\-_#]+$/', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}

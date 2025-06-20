<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterViewResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register the custom RegisterViewResponse binding
        $this->app->singleton(RegisterViewResponse::class, function () {
            return new class implements RegisterViewResponse {
                public function toResponse($request)
                {
                    return view('auth.register');
                }
            };
        });
    }

    public function boot()
    {

    }
}

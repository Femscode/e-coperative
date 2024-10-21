<?php

namespace App\Providers;
use App\Models\Plan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CustomVariableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            // Check if user_id exists in the session
            $plans = Plan::all();
            // Share the number of items with all views
            $view->with(['plans' => $plans]);
        });
    }
}

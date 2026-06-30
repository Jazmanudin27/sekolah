<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\URL::defaults(['school_slug' => 'default']);

        // Share list of all schools globally for superadmin data filtering
        view()->composer('*', function ($view) {
            if (auth()->check() && auth()->user()->role === 'superadmin') {
                $view->with('allSchools', \App\Models\School::orderBy('name')->get());
            }
        });
    }
}

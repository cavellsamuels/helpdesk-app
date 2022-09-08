<?php

namespace App\Providers;

use App\Models\Ticket;
use App\Observers\TicketObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Ticket::observe(TicketObserver::class);

        view()->composer('*', function($view)
        {
            $view->with('itSupportUsers', \App\Models\User::all()->where('role_id', 2));
            $view->with('urgencies', \App\Models\Ticket::$urgencies);
            $view->with('categories', \App\Models\Ticket::$categories);
        });
    }
}

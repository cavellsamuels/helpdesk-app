<?php

namespace App\Providers;

use App\Interfaces\AssignedTicketRepositoryInterface;
use App\Interfaces\SearchRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Repositories\AssignedTicketRepository;
use App\Repositories\SearchRepository;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->bind(AssignedTicketRepositoryInterface::class, AssignedTicketRepository::class);
        $this->app->bind(SearchRepositoryInterface::class, SearchRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

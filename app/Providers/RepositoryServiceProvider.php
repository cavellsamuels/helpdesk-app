<?php

namespace App\Providers;

use App\Repositories\TicketRepository;
use App\Repositories\SearchRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\TicketRepositoryInterface;
use App\Interfaces\SearchRepositoryInterface;
use App\Repositories\AssignedTicketRepository;
use App\Interfaces\AssignedTicketRepositoryInterface;

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

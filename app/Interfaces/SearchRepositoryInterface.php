<?php

namespace App\Interfaces;

use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Collection;

interface SearchRepositoryInterface
{
    public function getTickets(SearchRequest $searchRequest): Collection;
}
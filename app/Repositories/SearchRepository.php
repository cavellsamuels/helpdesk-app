<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\SearchRepositoryInterface;

class SearchRepository implements SearchRepositoryInterface
{
    protected string $search;

    public function __construct(SearchRequest $request)
    {
        $this->search = $request->get('search');
    }
    public function getTickets(SearchRequest $searchRequest): Collection
    {
        return Ticket::where('id', 'LIKE', '%' . $this->search . '%')->orWhere('title', 'LIKE', '%' . $this->search . '%')->get();
    }
}

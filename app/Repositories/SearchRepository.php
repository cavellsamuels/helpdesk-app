<?php

namespace App\Repositories;

use App\Http\Requests\SearchRequest;
use App\Interfaces\SearchRepositoryInterface;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class SearchRepository implements SearchRepositoryInterface
{
    protected string $search;

    public function __construct(SearchRequest $request)
    {
        $this->search = $request->get('search');
    }

    public function getTickets(SearchRequest $searchRequest): Collection
    {
        return Ticket::where('id', 'LIKE', '%'.$this->search.'%')->orWhere('title', 'LIKE', '%'.$this->search.'%')->get();
    }
}

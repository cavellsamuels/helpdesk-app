<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Interfaces\SearchRepositoryInterface;

class SearchService
{
    protected SearchRepositoryInterface $searchRepository;

    public function __construct(SearchRepositoryInterface $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function search(SearchRequest $request)
    {
        $tickets = $this->searchRepository->getTickets($request);

        if (count($tickets) == 0) {
            return back()->with('error', 'No Results Found');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Interfaces\SearchRepositoryInterface;

class SearchController extends Controller
{
    protected SearchRepositoryInterface $searchRepository;

    public function __construct(SearchRepositoryInterface $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function __invoke(SearchRequest $request)
    {
        $tickets = $this->searchRepository->getTickets($request);

        if (count($tickets) == 0) {
            return back()->with('error', 'No Results Found');
        }

        return view('search', compact('tickets'));
    }
}

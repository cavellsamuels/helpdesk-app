<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\SearchService;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    protected $urgencies;

    protected $categories;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
    }

    public function show(SearchService $searchService, SearchRequest $request)
    {
        $search = $request->get('search');
        $ticketsId = Ticket::where('id', 'LIKE', '%' . $search . '%')->get();
        $ticketsTitle = Ticket::where('title', 'LIKE', '%' . $search . '%')->get();

        $searchService->search($request);

        return view('search', compact('ticketsId', 'ticketsTitle'), ['urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }
}

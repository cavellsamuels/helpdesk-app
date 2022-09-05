<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\SearchService;
use App\Http\Requests\SearchRequest;
use Illuminate\Contracts\View\View;

class SearchController extends Controller
{
    protected array $urgencies;

    protected array $categories;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
    }

    public function __invoke(SearchService $searchService, SearchRequest $request): View
    {
        $search = $request->get('search');
        $ticketsId = Ticket::where('id', 'LIKE', '%' . $search . '%')->get();
        $ticketsTitle = Ticket::where('title', 'LIKE', '%' . $search . '%')->get();

        $searchService->search($request);

        return view('search', compact('ticketsId', 'ticketsTitle'), ['urgencies' => $this->urgencies, 'categories' => $this->categories]);
    }
}

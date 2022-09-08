<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\SearchRequest;
use App\Traits\SearchTrait;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request)
    {
        $search = $request->get('search');
        $ticketsId = Ticket::where('id', 'LIKE', '%' . $search . '%')->get();
        $ticketsTitle = Ticket::where('title', 'LIKE', '%' . $search . '%')->get();

        if (count($ticketsId) == 0 && count($ticketsTitle) == 0) {
            return back()->with('error', 'No Results Found');
        }

        return view('search', compact('ticketsId', 'ticketsTitle'));
    }
}

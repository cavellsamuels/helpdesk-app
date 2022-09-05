<?php

namespace App\Services;

use App\Models\User;
use App\Models\Ticket;
use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    protected array $urgencies;

    protected array $categories;

    protected Collection $itSupportUsers;

    public function __construct()
    {
        $this->urgencies = Ticket::$urgencies;
        $this->categories = Ticket::$categories;
        $this->itSupportUsers = User::all()->where('role_id', 2);
    }

    public function search(SearchRequest $request)
    {
        $search = $request->get('search');
        $ticketsId = Ticket::where('id', 'LIKE', '%' . $search . '%')->get();
        $ticketsTitle = Ticket::where('title', 'LIKE', '%' . $search . '%')->get();

        if (count($ticketsId) == 0 && count($ticketsTitle) == 0) {
            return back()->with('error', 'No Results Found');
        }
        
    }
}

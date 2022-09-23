<?php

namespace App\Http\Controllers;

use App\Interfaces\AssignedTicketRepositoryInterface;
use Illuminate\Contracts\View\View;

class AllTicketsController extends Controller
{
    protected AssignedTicketRepositoryInterface $assignedTicketRepository;

    public function __construct(AssignedTicketRepositoryInterface $assignedTicketRepository)
    {
        $this->assignedTicketRepository = $assignedTicketRepository;
    }

    public function __invoke(): View
    {
        $tickets = $this->assignedTicketRepository->getAllTickets();

        return view('global-dashboard', compact('tickets'));
    }
}

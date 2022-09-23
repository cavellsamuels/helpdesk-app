<?php

namespace App\Http\Controllers;

use App\Interfaces\AssignedTicketRepositoryInterface;
use Illuminate\View\View;

class AssignedTicketContrroller extends Controller
{
    protected AssignedTicketRepositoryInterface $assignedTicketRepository;

    public function __construct(AssignedTicketRepositoryInterface $assignedTicketRepository)
    {
        $this->assignedTicketRepository = $assignedTicketRepository;
    }

    public function __invoke(): View
    {
        $tickets = $this->assignedTicketRepository->getAssignedTickets();

        return view('assigned-dashboard', compact('tickets'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Interfaces\AssignedTicketRepositoryInterface;

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

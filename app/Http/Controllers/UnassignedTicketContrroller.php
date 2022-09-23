<?php

namespace App\Http\Controllers;

use App\Interfaces\AssignedTicketRepositoryInterface;
use Illuminate\View\View;

class UnassignedTicketContrroller extends Controller
{
    protected AssignedTicketRepositoryInterface $assignedTicketRepository;

    public function __construct(AssignedTicketRepositoryInterface $assignedTicketRepository)
    {
        $this->assignedTicketRepository = $assignedTicketRepository;
    }

    public function __invoke(): View
    {
        $tickets = $this->assignedTicketRepository->getUnassignedTickets();

        return view('unassigned-dashboard', compact('tickets'));
    }
}

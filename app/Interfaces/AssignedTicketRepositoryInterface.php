<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface AssignedTicketRepositoryInterface
{
    public function getAssignedTickets(): Collection;
    public function getUnAssignedTickets(): Collection;
}

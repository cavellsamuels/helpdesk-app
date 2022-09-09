<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface AssignedTicketRepositoryInterface
{
    public function getAllTickets(): Collection;
    public function getAssignedTickets(): Collection;
    public function getUnAssignedTickets(): Collection;
}

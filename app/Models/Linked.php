<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Linked extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_ticket',
        'child_ticket',
    ];

    public function ticket(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);
    }
}

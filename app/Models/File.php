<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class File extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'path',
        'size',
        'ticket_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}

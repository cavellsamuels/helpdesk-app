<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    use HasFactory;
    use Notifiable;

    public static $urgencies = [
        1 => 'Critical',
        2 => 'Important',
        3 => 'Normal',
        4 => 'Low',
    ];

    public static $categories = [
        1 => 'Service Request',
        2 => 'Incident',
        3 => 'Problem',
        4 => 'Change Request',
    ];

    public const OPEN = true;

    public const CLOSED = false;

    protected $fillable = [
        'title',
        'details',
        'urgency',
        'category',
        'open',
        'logged_by',
        'assigned_to',
        'reporting_email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'ticket_id');
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class, 'ticket_id');
    }

    public function linked(): HasMany
    {
        return $this->hasMany(Linked::class, 'parent_ticket');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format(config('app.date_format.front'));
    }
}

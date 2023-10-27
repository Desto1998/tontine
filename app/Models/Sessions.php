<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sessions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'frequency',
        'meeting_day',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'contribution_id',
        'deleted_by',
    ];



    /**
     * Get the user that perform action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contributions sessions.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Sessions::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'date',
        'start_time',
        'end_time',
        'agenda',
        'coordinator',
        'user_id',
        'session_id',
        'deleted_by',
        'sanction_amount',
        'total_entries',
        'total_funds',
        'total_loans',
        'total_amount',
    ];

    /**
     * Get the user that perform action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the funds.
     */
    public function funds(): HasMany
    {
        return $this->hasMany(Fund::class);
    }
}

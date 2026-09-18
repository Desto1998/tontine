<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    /**
     * Get the user that perform action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that perform action.
     */
    public function coordinate(): BelongsTo
    {
        return $this->belongsTo(Member::class,'coordinator');
    }

    /**
     * Get the funds.
     */
    public function funds(): HasMany
    {
        return $this->hasMany(Fund::class);
    }
}

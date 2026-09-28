<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionContribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contribution_id',
        'session_id',
        'deleted_by',
        'loan_period',
        'fund_deadline',
        'loan_duration',
        'loan_interest',
        'fail_interest',
        'fail_interest_type',
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
     * Get the session
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Sessions::class);
    }

    /**
     * Get the contribution.
     */
    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sessions extends Model
{
    use HasFactory, SoftDeletes;

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
        'status_id',
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

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'session_members', 'member_id', 'session_id');
    }

    public function contributions(): BelongsToMany
    {
        return $this->belongsToMany(Contribution::class, 'session_contributions', 'contribution_id', 'session_id');
    }
}

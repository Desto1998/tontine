<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'take_order',
        'taken',
        'deleted_by',
        'user_id',
        'session_id',
        'member_id',
        'taken_date',
        'taken_amount',
    ];

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
     * Get the member.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

}

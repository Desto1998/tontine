<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reason',
        'amount',
        'deleted_by',
        'user_id',
        'contribution_id',
        'meeting_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class)->withDefault();
    }
}

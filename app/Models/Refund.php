<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comment',
        'date',
        'amount',
        'remain',
        'interest',
        'loan_id',
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

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class)->withDefault();
    }
}

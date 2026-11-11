<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'reason',
        'type',
        'interest',
        'interest_type',
        'total_amount',
        'status',
        'return_date',
        'real_return_date',
        'deleted_by',
        'user_id',
        'contribution_id',
        'create_id',
        'member_id',
        'meeting_id',
        'status_id',
        'interest_amount',
    ];


    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class)->withDefault();
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class,'status_id');
    }
}

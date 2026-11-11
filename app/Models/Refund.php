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
        'loan_id',
        'interest',
        'remain',
        'deleted_by',
        'user_id',
        'contribution_id',
        'meeting_id',
        'status_id',
        'deleted_at'
    ];
    protected static function booted()
    {
        static::creating(function ($refund) {
            $refund->user_id = auth()->id();
            $refund->status_id = 2;
            $refund->date = now();
        });
    }


//    protected $casts = [
//        'deleted_at' => 'datetime',
//        'date' => 'date',
//        'amount' => 'float',
//        'interest' => 'float',
//        'remain' => 'float',
//    ];

    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class)->withDefault();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class,'status_id');
    }
}

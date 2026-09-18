<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingMemberSanction extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'amount',
        'comment',
        'deleted_by',
        'user_id',
        'session_member_id',
        'meeting_id',
        'sanction_id',
        'pay_status',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusHistory extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'status_histories';
    protected $fillable = [
        'status_id',
        'old_status_id',
        'comment',
        'user_id',
        'deleted_at',
        'refund_id',
        'loan_id',
        'contribution_id',
        'investment_id',
        'member_id',
        'project_id',
        'session_id',
    ];

    public function status() : BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

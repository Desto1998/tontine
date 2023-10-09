<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}

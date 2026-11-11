<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionMemberContribution extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'contribution_amount',
        'max_loan',
        'take_amount',
        'taken_order',
        'taken',
        'taken_date',
        'avarist_id',
        'session_contribution_id',
        'session_member_id',
        'session_id',
        'comment',
        'user_id',
    ];

}

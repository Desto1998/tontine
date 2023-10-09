<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSessionMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'deleted_by',
        'user_id',
        'session_id',
        'session_member_id',
        'meeting_id',
        'present',
        'took',
    ];
}

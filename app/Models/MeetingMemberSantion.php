<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingMemberSantion extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'comment',
        'deleted_by',
        'user_id',
        'session_member_id',
        'meeting_id',
        'sanction_id',
    ];
}

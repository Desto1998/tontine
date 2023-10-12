<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionContribution extends Model
{
    use HasFactory;

    protected $fillable =[
        'contribution_id',
        'session_id',
        ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanctions extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'association_id',
        'user_id',
//        'amount',
    ];
}

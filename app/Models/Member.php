<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'has_fund',
        'fund_amount',
        'association_id',
        'deleted_at',
    ];

    public function association() : BelongsTo
    {
        return $this->belongsTo(Association::class);
    }


    public function fund() : HasMany
    {
        return $this->hasMany(Fund::class);
    }
}

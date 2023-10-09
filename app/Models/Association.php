<?php

namespace App\Models;

use App\Services\MemberService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Association extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'country',
        'town',
        'logo',
        'description',
        'deleted_at',
        'address',
    ];

    public function members() : HasMany
    {
        return $this->hasMany(Member::class);
    }
}

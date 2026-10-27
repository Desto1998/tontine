<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'has_fund',
        'fund_amount',
        'association_id',
        'deleted_by',
        'user_id',
        'status',
        'status_id',
    ];

    public function association() : BelongsTo
    {
        return $this->belongsTo(Association::class);
    }


    public function fund() : HasMany
    {
        return $this->hasMany(Fund::class);
    }

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function project(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members')->withDefault();
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Sessions::class, 'session_members','member_id', 'session_id')->withDefault();
    }
}

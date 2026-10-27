<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'amount',
        'type',
        'deleted_by',
        'user_id',
        'description',
        'contribution_id',
        'meeting_id',
        'status_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class)->withDefault();
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class)->withDefault();
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'project_members')->withDefault();
    }
}

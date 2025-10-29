<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssistantProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'bio', 'skills', 'years_of_experience', 'hourly_rate',
        'rating', 'total_jobs', 'has_own_tools', 'is_verified', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'hourly_rate' => 'decimal:2',
            'rating' => 'decimal:2',
            'has_own_tools' => 'boolean',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}

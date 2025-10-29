<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelperPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'driver_id', 'title', 'description', 'location_address', 'location_city',
        'location_latitude', 'location_longitude', 'required_date', 'duration_hours',
        'helpers_needed', 'offered_rate', 'contact_phone', 'requirements', 'status', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'required_date' => 'datetime',
            'offered_rate' => 'decimal:2',
            'location_latitude' => 'decimal:7',
            'location_longitude' => 'decimal:7',
            'is_published' => 'boolean',
        ];
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('is_published', true);
    }
}

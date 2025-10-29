<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'vehicle_type_id', 'vehicle_make', 'vehicle_model', 'vehicle_year',
        'vehicle_plate_number', 'vehicle_color', 'vehicle_capacity', 'bio',
        'base_rate_per_km', 'base_rate_fixed', 'rating', 'total_trips',
        'is_verified', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'vehicle_capacity' => 'decimal:2',
            'base_rate_per_km' => 'decimal:2',
            'base_rate_fixed' => 'decimal:2',
            'rating' => 'decimal:2',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(DriverProfileImage::class);
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

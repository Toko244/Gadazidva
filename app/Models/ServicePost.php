<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'cargo_type_id', 'title', 'origin_address', 'origin_city',
        'origin_latitude', 'origin_longitude', 'destination_address', 'destination_city',
        'destination_latitude', 'destination_longitude', 'loading_date', 'cargo_weight',
        'description', 'contact_phone', 'contact_email', 'status', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'loading_date' => 'datetime',
            'cargo_weight' => 'decimal:2',
            'origin_latitude' => 'decimal:7',
            'origin_longitude' => 'decimal:7',
            'destination_latitude' => 'decimal:7',
            'destination_longitude' => 'decimal:7',
            'is_published' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cargoType(): BelongsTo
    {
        return $this->belongsTo(CargoType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ServicePostImage::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('is_published', true);
    }
}

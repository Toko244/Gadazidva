<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePostImage extends Model
{
    use HasFactory;

    protected $fillable = ['service_post_id', 'image_path', 'image_name', 'order', 'is_primary'];

    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }

    public function servicePost(): BelongsTo
    {
        return $this->belongsTo(ServicePost::class);
    }
}

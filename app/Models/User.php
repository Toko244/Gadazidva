<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'city',
        'address',
        'is_available',
        'approved'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_available' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the service posts created by the user.
     */
    public function servicePosts(): HasMany
    {
        return $this->hasMany(ServicePost::class);
    }

    /**
     * Get the helper posts created by the driver.
     */
    public function helperPosts(): HasMany
    {
        return $this->hasMany(HelperPost::class, 'driver_id');
    }

    /**
     * Get the driver profile associated with the user.
     */
    public function driverProfile(): HasOne
    {
        return $this->hasOne(DriverProfile::class);
    }

    /**
     * Get the assistant profile associated with the user.
     */
    public function assistantProfile(): HasOne
    {
        return $this->hasOne(AssistantProfile::class);
    }

    /**
     * Check if user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->hasRole('user');
    }

    /**
     * Check if user is a driver.
     */
    public function isDriver(): bool
    {
        return $this->hasRole('driver');
    }

    /**
     * Check if user is an assistant.
     */
    public function isAssistant(): bool
    {
        return $this->hasRole('assistant');
    }
}

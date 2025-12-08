<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Constantes pour les rôles
    const ROLE_CLIENT = 0;
    const ROLE_COOPERATIVE = 1;
    const ROLE_ADMIN = 2;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'cooperative_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class);
    }

    public function jamInfo()
    {
        return $this->hasOne(JamInfo::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function createdCooperatives()
    {
        return $this->hasMany(Cooperative::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCooperative()
    {
        return $this->role === self::ROLE_COOPERATIVE;
    }

    public function isClient()
    {
        return $this->role === self::ROLE_CLIENT;
    }

    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default-avatar.png');
    }
}

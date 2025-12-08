<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    /**
     * Boot method pour générer automatiquement le slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sector) {
            if (empty($sector->slug)) {
                $sector->slug = Str::slug($sector->name);
            }
        });

        static::updating(function ($sector) {
            if ($sector->isDirty('name')) {
                $sector->slug = Str::slug($sector->name);
            }
        });
    }

    /**
     * Relation: Une filière a plusieurs coopératives
     */
    public function cooperatives()
    {
        return $this->hasMany(Cooperative::class);
    }

    /**
     * Relation: Une filière a plusieurs produits
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Accessor: Obtenir l'URL de l'icône ou une icône par défaut
     */
    public function getIconUrlAttribute()
    {
        return $this->icon 
            ? asset('storage/' . $this->icon) 
            : asset('images/default-sector-icon.png');
    }

    /**
     * Scope: Obtenir les filières avec le nombre de produits
     */
    public function scopeWithProductsCount($query)
    {
        return $query->withCount('products');
    }

    /**
     * Scope: Obtenir les filières avec le nombre de coopératives
     */
    public function scopeWithCooperativesCount($query)
    {
        return $query->withCount('cooperatives');
    }
}

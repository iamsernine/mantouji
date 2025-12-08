<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'short_description',
        'long_description',
        'price',
        'sector_id',
        'cooperative_id',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relation: Un produit appartient à une coopérative
     */
    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class);
    }

    /**
     * Relation: Un produit appartient à une filière
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * Relation: Un produit appartient à un utilisateur (legacy)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Un produit a plusieurs avis
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relation: Un produit a plusieurs commentaires (legacy - à migrer vers reviews)
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope: Seulement les produits actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filtrer par filière
     */
    public function scopeBySector($query, $sectorId)
    {
        return $query->where('sector_id', $sectorId);
    }

    /**
     * Scope: Filtrer par coopérative
     */
    public function scopeByCooperative($query, $cooperativeId)
    {
        return $query->where('cooperative_id', $cooperativeId);
    }

    /**
     * Scope: Recherche par nom
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('short_description', 'like', "%{$search}%");
    }

    /**
     * Accessor: Obtenir l'URL de l'image
     */
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default-product.png');
    }

    /**
     * Méthode: Calculer la note moyenne
     */
    public function averageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?: 0;
    }

    /**
     * Méthode: Nombre d'avis approuvés
     */
    public function reviewsCount()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    /**
     * Méthode: Obtenir le lien WhatsApp de la coopérative
     */
    public function getWhatsappUrl()
    {
        return $this->cooperative ? $this->cooperative->whatsapp_url : null;
    }

    /**
     * Méthode: Obtenir d'autres produits de la même coopérative
     */
    public function otherProductsFromSameCooperative($limit = 4)
    {
        return self::where('cooperative_id', $this->cooperative_id)
                   ->where('id', '!=', $this->id)
                   ->where('is_active', true)
                   ->limit($limit)
                   ->get();
    }
}

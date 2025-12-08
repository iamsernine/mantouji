<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cooperative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'email',
        'website',
        'whatsapp',
        'sector_id',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation: Une coopérative appartient à une filière principale
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * Relation: Une coopérative a plusieurs produits
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relation: Une coopérative a plusieurs utilisateurs
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relation: Une coopérative a été créée par un admin
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Seulement les coopératives actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: Formater le numéro WhatsApp pour l'URL
     */
    public function getWhatsappUrlAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$number}";
    }

    /**
     * Accessor: Obtenir l'URL du logo ou une image par défaut
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo 
            ? asset('storage/' . $this->logo) 
            : asset('images/default-cooperative-logo.png');
    }
}

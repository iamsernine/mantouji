<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'reviews', 'reviews_number', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Average rating helper
    public function averageRating()
    {
        return $this->comments()->avg('rating') ?: 0;
    }

    // Number of reviews (ratings)
    public function reviewsCount()
    {
        return $this->comments()->whereNotNull('rating')->count();
    }
}
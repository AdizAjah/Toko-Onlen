<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'category_id',
        'quantity',
        'image_url',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the carts associated with the product.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the ratings for the product.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the average rating for the product.
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'title', 'description', 'location',
        'rent_price', 'bedrooms', 'bathrooms', 'type',
        'category', 'is_available', 'image'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'rent_price'   => 'decimal:2',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['city'] ?? null, fn($q, $city) =>
            $q->where('location', 'like', "%{$city}%")
        );

        $query->when($filters['area'] ?? null, fn($q, $area) =>
            $q->where('location', 'like', "%{$area}%")
        );

        $query->when($filters['property_type'] ?? null, fn($q, $type) =>
            $q->where('type', $type)
        );

        $query->when($filters['category'] ?? null, fn($q, $cat) =>
            $q->where('category', $cat)
        );

        $query->when($filters['bedrooms'] ?? null, fn($q, $bed) =>
            $q->where('bedrooms', $bed)
        );

        $query->when($filters['bathrooms'] ?? null, fn($q, $bath) =>
            $q->where('bathrooms', $bath)
        );

        $query->when($filters['min_price'] ?? null, fn($q, $min) =>
            $q->where('rent_price', '>=', $min)
        );

        $query->when($filters['max_price'] ?? null, fn($q, $max) =>
            $q->where('rent_price', '<=', $max)
        );

        return $query;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('is_primary', 'desc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}
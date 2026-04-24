<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
{
    $query = Property::where('is_available', true);

    if ($request->sort === 'price_high_low') {
        $query->orderByDesc('rent_price');
    } elseif ($request->sort === 'price_low_high') {
        $query->orderBy('rent_price');
    } elseif ($request->sort === 'newest') {
        $query->latest();
    } elseif ($request->sort === 'most_viewed') {
        $query->orderByDesc('views');
    } elseif ($request->sort === 'highest_rated') {
    $query->latest();
}else {
        $query->latest();
    }

    $properties = $query->paginate(9)->withQueryString();

    return view('properties.index', compact('properties'));
}

    public function show(Property $property)
    {
        $property->load([
            'owner',
            'images',
            'reviews.tenant',
        ]);

        $averageRating = $property->reviews()->avg('rating');
        $reviewsCount = $property->reviews()->count();

        return view('properties.show', compact('property', 'averageRating', 'reviewsCount'));
    }

    public function search(Request $request)
    {
        $filters = $request->only([
            'city', 'area', 'property_type', 'category',
            'bedrooms', 'bathrooms', 'min_price', 'max_price'
        ]);

        $properties = Property::filter($filters)->paginate(12)->withQueryString();

        $cities = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barishal', 'Mymensingh'];
        $propertyTypes = ['Apartment', 'House', 'Room', 'Studio', 'Villa'];
        $categories = ['Family', 'Bachelor', 'Office', 'Sublet', 'Hostel', 'Shop'];

        return view('properties.search', compact('properties', 'filters', 'cities', 'propertyTypes', 'categories'));
    }
}
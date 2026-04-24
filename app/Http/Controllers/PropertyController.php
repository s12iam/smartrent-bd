<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->paginate(9);
        return view('properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function search(Request $request)
    {
        $filters = $request->only([
            'city', 'area', 'property_type', 'category',
            'bedrooms', 'bathrooms', 'min_price', 'max_price'
        ]);

        $properties = Property::filter($filters)->latest()->paginate(12)->withQueryString();

        $cities = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barishal', 'Mymensingh'];
        $propertyTypes = ['Apartment', 'House', 'Room', 'Studio', 'Villa'];
        $categories = ['Family', 'Bachelor', 'Office', 'Sublet', 'Hostel', 'Shop'];

        return view('properties.search', compact('properties', 'filters', 'cities', 'propertyTypes', 'categories'));
    }
}
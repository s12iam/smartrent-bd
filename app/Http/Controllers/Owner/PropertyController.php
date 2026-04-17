<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function create()
    {
        $cities = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barishal', 'Mymensingh'];
        $roomTypes = ['apartment', 'house', 'room'];
        $categories = ['Family', 'Bachelor', 'Office', 'Sublet', 'Hostel', 'Shop'];
        return view('owner.properties.create', compact('cities', 'roomTypes', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'unit'        => 'nullable|string|max:50',
            'city'        => 'required|string',
            'type'        => 'required|in:apartment,house,room',
            'category'    => 'nullable|string',
            'rent_price'  => 'required|numeric|min:0',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:2048',
        ]);

        $property = Property::create([
            'owner_id'    => Auth::id(),
            'title'       => $request->title,
            'location'    => $request->city . ', ' . $request->location . ($request->unit ? ', Unit ' . $request->unit : ''),
            'type'        => $request->type,
            'category'    => $request->category,
            'rent_price'  => $request->rent_price,
            'bedrooms'    => $request->bedrooms,
            'bathrooms'   => $request->bathrooms,
            'description' => $request->description,
            'is_available'=> true,
            'image'       => null,
        ]);

        if ($request->hasFile('images')) {
            $first = true;
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path'  => $path,
                    'is_primary'  => $first,
                ]);
                if ($first) {
                    $property->update(['image' => $path]);
                    $first = false;
                }
            }
        }

        return redirect()->route('owner.properties.index')->with('success', 'Property added successfully!');
    }

    public function index()
    {
        $properties = Property::where('owner_id', Auth::id())->latest()->paginate(10);
        return view('owner.properties.index', compact('properties'));
    }

    public function edit(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $cities = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barishal', 'Mymensingh'];
        $roomTypes = ['apartment', 'house', 'room'];
        $categories = ['Family', 'Bachelor', 'Office', 'Sublet', 'Hostel', 'Shop'];
        return view('owner.properties.edit', compact('property', 'cities', 'roomTypes', 'categories'));
    }

    public function update(Request $request, Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'unit'        => 'nullable|string|max:50',
            'city'        => 'required|string',
            'type'        => 'required|in:apartment,house,room',
            'category'    => 'nullable|string',
            'rent_price'  => 'required|numeric|min:0',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:2048',
        ]);

        $property->update([
            'title'       => $request->title,
            'location'    => $request->city . ', ' . $request->location . ($request->unit ? ', Unit ' . $request->unit : ''),
            'type'        => $request->type,
            'category'    => $request->category,
            'rent_price'  => $request->rent_price,
            'bedrooms'    => $request->bedrooms,
            'bathrooms'   => $request->bathrooms,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            $first = $property->image === null;
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path'  => $path,
                    'is_primary'  => $first,
                ]);
                if ($first) {
                    $property->update(['image' => $path]);
                    $first = false;
                }
            }
        }

        return redirect()->route('owner.properties.index')->with('success', 'Property updated successfully!');
    }

    public function destroy(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        foreach ($property->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        $property->delete();

        return redirect()->route('owner.properties.index')->with('success', 'Property deleted successfully!');
    }

    public function toggleAvailability(Property $property)
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $newStatus = !$property->is_available;
        $property->update(['is_available' => $newStatus]);

        $msg = $newStatus ? 'Property marked as available.' : 'Property marked as rented.';
        return redirect()->route('owner.properties.index')->with('success', $msg);
    }
}
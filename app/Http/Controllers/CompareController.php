<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        $compareIds = session()->get('compare', []);

        $properties = Property::whereIn('id', $compareIds)->get();

        return view('properties.compare', compact('properties'));
    }

    public function add(Property $property)
    {
        $compare = session()->get('compare', []);

        if (!in_array($property->id, $compare)) {
            $compare[] = $property->id;
        }

        session()->put('compare', $compare);

        return back()->with('success', 'Property added to compare.');
    }

    public function remove(Property $property)
    {
        $compare = session()->get('compare', []);

        $compare = array_values(array_filter($compare, function ($id) use ($property) {
            return $id != $property->id;
        }));

        session()->put('compare', $compare);

        return back()->with('success', 'Property removed from compare.');
    }

    public function clear()
    {
        session()->forget('compare');

        return redirect()->route('properties.index')
            ->with('success', 'Compare list cleared.');
    }
}

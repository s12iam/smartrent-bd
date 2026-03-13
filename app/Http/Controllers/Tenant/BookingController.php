<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('tenant_id', auth()->id())
                           ->with('property')
                           ->latest()
                           ->paginate(10);
        return view('tenant.booking.index', compact('bookings'));
    }

    public function create(Property $property)
    {
        return view('tenant.booking.create', compact('property'));
    }

    public function store(Request $request, Property $property)
    {
        $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date'   => 'required|date|after:start_date',
            'message'    => 'nullable|string|max:500',
        ]);

        Booking::create([
            'tenant_id'   => auth()->id(),
            'owner_id'    => $property->owner_id,
            'property_id' => $property->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'message'     => $request->message,
            'status'      => 'pending',
        ]);

        return redirect()->route('tenant.bookings.index')
                         ->with('success', 'Booking request sent successfully!');
    }

    public function cancel(Booking $booking)
    {
        abort_if($booking->tenant_id !== auth()->id(), 403);
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled.');
    }
}
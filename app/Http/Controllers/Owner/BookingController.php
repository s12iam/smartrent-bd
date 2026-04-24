<?php

namespace App\Http\Controllers\Owner;
use App\Notifications\BookingRejectedNotification;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\BookingAcceptedNotification;
class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('owner_id', auth()->id())
                           ->with(['property', 'tenant'])
                           ->latest()
                           ->paginate(10);
        return view('owner.booking.index', compact('bookings'));
    }

    public function approve(Booking $booking)
{
    abort_if($booking->owner_id !== auth()->id(), 403);

    $booking->update(['status' => 'approved']);

    $booking->tenant->notify(new BookingAcceptedNotification($booking));

    return back()->with('success', 'Booking approved!');
}
    public function reject(Booking $booking)
    {
        abort_if($booking->owner_id !== auth()->id(), 403);
        $booking->update(['status' => 'rejected']);
        $booking->tenant->notify(new BookingRejectedNotification($booking));
        return back()->with('success', 'Booking rejected.');
    }
}
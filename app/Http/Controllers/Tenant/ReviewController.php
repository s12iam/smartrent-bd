<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        abort_if($booking->tenant_id !== auth()->id(), 403);

        if ($booking->status !== 'approved' || $booking->payment_status !== 'paid') {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'You can only review after approved and paid booking.');
        }

        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'You already reviewed this booking.');
        }

        return view('tenant.review.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        abort_if($booking->tenant_id !== auth()->id(), 403);

        if ($booking->status !== 'approved' || $booking->payment_status !== 'paid') {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'You can only review after approved and paid booking.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'You already reviewed this booking.');
        }

        Review::create([
            'booking_id' => $booking->id,
            'property_id' => $booking->property_id,
            'tenant_id' => auth()->id(),
            'owner_id' => $booking->owner_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('tenant.bookings.index')
            ->with('success', 'Review submitted successfully.');
    }

    public function destroy(Review $review)
    {
        abort_if($review->tenant_id !== auth()->id(), 403);

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
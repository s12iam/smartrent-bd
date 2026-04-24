<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\SslCommerzService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        abort_if($booking->tenant_id !== auth()->id(), 403);

        if ($booking->status !== 'approved') {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'Payment is only available for approved bookings.');
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'This booking is already paid.');
        }

        $booking->load('property');

        return view('tenant.payment.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking, SslCommerzService $sslCommerzService)
    {
        abort_if($booking->tenant_id !== auth()->id(), 403);

        if ($booking->status !== 'approved') {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'Payment is only available for approved bookings.');
        }

        if ($booking->payment_status === 'paid') {
            return redirect()->route('tenant.bookings.index')
                ->with('error', 'This booking is already paid.');
        }

        $booking->load('property', 'tenant');

        $existingPayment = Payment::where('booking_id', $booking->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existingPayment) {
            $tranId = $existingPayment->transaction_id;
        } else {
            $tranId = 'BOOKING-' . $booking->id . '-' . Str::upper(Str::random(8));

            Payment::create([
                'booking_id'     => $booking->id,
                'tenant_id'      => $booking->tenant_id,
                'owner_id'       => $booking->owner_id,
                'amount'         => $booking->property->rent_price,
                'payment_method' => 'sslcommerz',
                'transaction_id' => $tranId,
                'status'         => 'pending',
                'paid_at'        => null,
            ]);
        }

        $response = $sslCommerzService->initPayment($booking, $tranId);

        if (!empty($response['GatewayPageURL'])) {
            return redirect()->away($response['GatewayPageURL']);
        }

        return redirect()->route('tenant.payment.create', $booking->id)
            ->with('error', 'Unable to initiate SSLCOMMERZ payment.');
    }

    public function success(Request $request)
    {
        $tranId = $request->input('tran_id');

        $payment = Payment::where('transaction_id', $tranId)->first();

        if ($payment) {
            $payment->update([
                'status' => 'paid',
                'payment_method' => 'sslcommerz',
                'paid_at' => now(),
            ]);

            $payment->booking->update([
                'payment_status' => 'paid',
                'payment_method' => 'sslcommerz',
                'paid_at' => now(),
            ]);
        }

        return response('Payment successful');
    }

    public function fail(Request $request)
    {
        $tranId = $request->input('tran_id');

        $payment = Payment::where('transaction_id', $tranId)->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
            ]);
        }

        return response('Payment failed');
    }

    public function cancel(Request $request)
    {
        $tranId = $request->input('tran_id');

        $payment = Payment::where('transaction_id', $tranId)->first();

        if ($payment) {
            $payment->update([
                'status' => 'cancelled',
            ]);
        }

        return response('Payment cancelled');
    }
}

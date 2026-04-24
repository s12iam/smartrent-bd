<?php

namespace App\Http\Controllers;
use App\Notifications\AgreementCreatedNotification;
use App\Models\Agreement;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class AgreementController extends Controller
{
    public function create(Booking $booking)
    {
        return view('agreements.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric|min:0',
        ]);

        $agreement = Agreement::create([
            'property_id' => $booking->property_id,
            'tenant_id' => $booking->tenant_id,
            'owner_id' => $booking->owner_id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'rent_amount' => $data['rent_amount'],
            'status' => 'active',
        ]);
$agreement->load(['property', 'tenant', 'owner']);
$agreement->tenant->notify(new AgreementCreatedNotification($agreement));
        return redirect()->route('agreements.show', $agreement)
                         ->with('success', 'Agreement created successfully.');
    }
public function download(Agreement $agreement)
{
    $agreement->load(['property', 'tenant', 'owner']);

    $pdf = Pdf::loadView('agreements.pdf', compact('agreement'));

    return $pdf->download('rental-agreement-' . $agreement->id . '.pdf');
}
    public function show(Agreement $agreement)
    {
        return view('agreements.show', compact('agreement'));
    }
}

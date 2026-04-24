<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Rental Agreement Details</h1>
        <p class="text-gray-500 mb-6">Agreement information for this booking.</p>

        <div class="bg-white rounded-2xl shadow p-6 space-y-4">
            <div>
                <strong>Property:</strong>
                {{ $agreement->property->title ?? 'Property' }}
            </div>

            <div>
                <strong>Location:</strong>
                {{ $agreement->property->location ?? '' }}
            </div>

            <div>
                <strong>Tenant:</strong>
                {{ $agreement->tenant->name ?? 'Tenant' }}
            </div>

            <div>
                <strong>Owner:</strong>
                {{ $agreement->owner->name ?? 'Owner' }}
            </div>

            <div>
                <strong>Start Date:</strong>
                {{ $agreement->start_date }}
            </div>

            <div>
                <strong>End Date:</strong>
                {{ $agreement->end_date }}
            </div>

            <div>
                <strong>Rent Amount:</strong>
                {{ number_format($agreement->rent_amount) }} Tk
            </div>

            <div>
                <strong>Status:</strong>
                {{ ucfirst($agreement->status) }}
            </div>
<div style="display:flex; gap:12px; margin-top:16px;">
    <a href="{{ route('agreements.download', $agreement) }}"
       style="display:inline-block; background:#4f46e5; color:white; padding:10px 20px; border-radius:8px; font-weight:600; text-decoration:none;">
        Download PDF
    </a>

    <a href="{{ route('owner.bookings.index') }}"
       style="display:inline-block; background:#111827; color:white; padding:10px 20px; border-radius:8px; font-weight:600; text-decoration:none;">
        Back to Bookings
    </a>
</div>
        </div>
    </div>
</x-app-layout>
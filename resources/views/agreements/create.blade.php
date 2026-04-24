<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Rental Agreement</h1>
        <p class="text-gray-500 mb-6">Create an agreement for this approved booking.</p>

        <div class="bg-white rounded-2xl shadow p-6">
            <div class="mb-6 bg-indigo-50 rounded-lg p-4">
                <div class="font-semibold text-gray-800">
                    {{ $booking->property->title ?? 'Property' }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ $booking->property->location ?? '' }}
                </div>
                <div class="text-sm text-gray-500 mt-1">
                    Tenant: {{ $booking->tenant->name ?? 'Tenant' }}
                </div>
            </div>

            <form method="POST" action="{{ route('agreements.store', $booking) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date"
                           value="{{ old('start_date', $booking->start_date) }}"
                           class="w-full border-gray-300 rounded-lg" required>
                    @error('start_date')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date"
                           value="{{ old('end_date', $booking->end_date) }}"
                           class="w-full border-gray-300 rounded-lg" required>
                    @error('end_date')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rent Amount</label>
                    <input type="number" name="rent_amount"
                           value="{{ old('rent_amount', $booking->property->rent_price ?? 0) }}"
                           class="w-full border-gray-300 rounded-lg" required>
                    @error('rent_amount')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-semibold">
                    Create Agreement
                </button>

                <a href="{{ route('owner.bookings.index') }}"
                   class="ml-2 border border-gray-300 px-5 py-2 rounded-lg text-gray-700">
                    Back
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
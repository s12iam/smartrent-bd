<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book Property</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow p-6">

            {{-- Property Summary --}}
            <div class="bg-indigo-50 rounded-lg p-4 mb-6 flex justify-between items-center">
                <div>
                    <p class="font-bold text-gray-800">{{ $property->title }}</p>
                    <p class="text-sm text-gray-500">📍 {{ $property->location }}</p>
                </div>
                <p class="text-indigo-600 font-bold text-lg">৳{{ number_format($property->rent_price) }}/mo</p>
            </div>

            {{-- Booking Form --}}
            <form method="POST" action="{{ route('tenant.bookings.store', $property) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message to Owner (optional)</label>
                    <textarea name="message" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Introduce yourself or ask any questions...">{{ old('message') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Send Booking Request
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $property->title }}</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow p-6">

            <img src="https://placehold.co/800x300?text={{ urlencode($property->title) }}"
                 class="w-full h-64 object-cover rounded-lg mb-6" alt="{{ $property->title }}">

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-400 text-xs">Location</p>
                    <p class="font-semibold text-sm">📍 {{ $property->location }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-400 text-xs">Monthly Rent</p>
                    <p class="font-bold text-indigo-600">৳{{ number_format($property->rent_price) }}/mo</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-400 text-xs">Type</p>
                    <p class="font-semibold text-sm">🏠 {{ ucfirst($property->type) }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-400 text-xs">Bedrooms</p>
                    <p class="font-semibold text-sm">🛏 {{ $property->bedrooms }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-400 text-xs">Bathrooms</p>
                    <p class="font-semibold text-sm">🚿 {{ $property->bathrooms }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-400 text-xs">Status</p>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Available</span>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-gray-400 text-xs mb-1">Description</p>
                <p class="text-gray-700 text-sm leading-relaxed">{{ $property->description }}</p>
            </div>

            @auth
                <a href="{{ route('tenant.bookings.create', $property) }}"
                   class="block text-center bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Book This Property
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="block text-center bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Login to Book
                </a>
            @endauth
        </div>
    </div>
</x-app-layout>
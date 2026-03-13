<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Property Listings</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header Row --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">List Of Properties</h2>
                <div class="h-1 w-12 bg-orange-400 rounded mt-1"></div>
            </div>
            <a href="{{ route('properties.index') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                View All Property
            </a>
        </div>

        {{-- Property Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($properties as $property)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                {{-- Property Image Placeholder --}}
                <div class="h-48 bg-indigo-100 flex items-center justify-center rounded-t-xl">
                  <span class="text-indigo-400 font-bold text-center px-4 text-sm">{{ $property->title }}</span>
                </div>

                <div class="p-4">
                    {{-- Location & Type --}}
                    <p class="text-gray-700 font-semibold text-sm">{{ $property->location }}</p>
                    <span class="text-xs text-gray-400">{{ ucfirst($property->type) }}</span>

                    {{-- Price --}}
                    <p class="text-indigo-600 font-bold text-lg mt-1">
                        ৳{{ number_format($property->rent_price) }}tk/Month
                    </p>

                    {{-- Specs --}}
                    <div class="flex gap-4 mt-2 text-xs text-gray-500">
                        <span>🛏 {{ $property->bedrooms }}</span>
                        <span>🚿 {{ $property->bathrooms }}</span>
                        <span>📐 {{ $property->bedrooms * 150 }} sqft</span>
                    </div>

                    {{-- Book Button --}}
                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('properties.show', $property) }}"
                           class="text-sm text-indigo-600 hover:underline">View Details</a>
                        @auth
                        <a href="{{ route('tenant.bookings.create', $property) }}"
                           class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-indigo-700">
                            Book Now
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                           class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-indigo-700">
                            Book Now
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-400 py-20 text-lg">
                No properties available right now.
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $properties->links() }}
        </div>

    </div>
</x-app-layout>
<x-app-layout>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Header Row --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">List Of Properties</h2>
                <div class="h-1 w-12 bg-orange-400 rounded mt-1"></div>
            </div>
            <a href="{{ route('properties.index') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
                View All Property
            </a>
        </div>

        {{-- Property Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5">
            @forelse($properties as $property)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                {{-- Image --}}
                @if($property->image)
                    <img src="{{ asset('storage/' . $property->image) }}"
                         class="w-full h-40 object-cover" alt="{{ $property->title }}">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                        No Image
                    </div>
                @endif

                <div class="p-3">
                    {{-- Location --}}
                    <p class="text-gray-800 font-semibold text-sm leading-tight">{{ $property->location }}</p>

                    {{-- Type --}}
                    <p class="text-gray-400 text-xs mt-1">{{ ucfirst($property->type) }}</p>

                    {{-- Price --}}
                    <p class="text-indigo-600 font-bold text-base mt-1">
                        {{ number_format($property->rent_price) }}tk/Month
                    </p>

                    {{-- Specs --}}
                    <div class="flex gap-3 mt-2 text-xs text-gray-500 border-t pt-2">
                        <span>🛏 {{ $property->bedrooms }}</span>
                        <span>🚿 {{ $property->bathrooms }}</span>
                        <span>📐 {{ $property->bedrooms * 150 }}</span>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-3 flex justify-between items-center">
                        <a href="{{ route('properties.show', $property) }}"
                           class="text-xs text-indigo-600 hover:underline">View Details</a>
                        @auth
                            <a href="{{ route('tenant.bookings.create', $property) }}"
                               class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-indigo-700">
                                Book Now
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-indigo-700">
                                Book Now
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-5 text-center text-gray-400 py-20 text-lg">
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
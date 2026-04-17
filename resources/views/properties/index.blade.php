<x-app-layout>
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Property Listings</h2>
                <div class="h-1 w-14 bg-orange-500 rounded mt-2"></div>
                <p class="text-sm text-gray-500 mt-2">Explore available rental properties.</p>
            </div>

            <a href="{{ route('properties.index') }}"
               class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                View All Properties
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($properties as $property)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100 flex flex-col">
                    
                    <div class="w-full h-52 bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($property->image)
                            <img src="{{ asset('storage/' . $property->image) }}"
                                 alt="property image"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-sm">No Image Available</span>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-base font-semibold text-gray-800 mb-1">
                            {{ Str::limit($property->location, 35) }}
                        </h3>

                        <p class="text-sm text-gray-500 mb-2">
                            {{ ucfirst($property->type) }}
                        </p>

                        <p class="text-xl font-bold text-indigo-600 mb-3">
                            {{ number_format($property->rent_price) }} Tk<span class="text-sm font-medium text-gray-500">/Month</span>
                        </p>

                        <div class="flex items-center gap-4 text-sm text-gray-600 border-t pt-3 mt-auto">
                            <span>🛏 {{ $property->bedrooms }}</span>
                            <span>🚿 {{ $property->bathrooms }}</span>
                            <span>📐 {{ $property->bedrooms * 150 }} sqft</span>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('properties.show', $property) }}"
                               class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                View Details
                            </a>

                            @auth
                                <a href="{{ route('tenant.bookings.create', $property) }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                    Book Now
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                    Book Now
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400 text-lg">
                    No properties available right now.
                </div>
            @endforelse
        </div>

        <div class="mt-10 flex justify-center">
            {{ $properties->links() }}
        </div>
    </div>
</x-app-layout>
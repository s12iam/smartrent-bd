<x-app-layout>
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Property Listings</h2>
                <div class="h-1 w-14 bg-orange-500 rounded mt-2"></div>
                <p class="text-sm text-gray-500 mt-2">Explore available rental properties.</p>
            </div>

            <div>
                <a href="{{ route('properties.index') }}"
                   style="background:#4f46e5; color:white; padding:8px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
                    View All Property
                </a>

                <a href="{{ route('properties.compare') }}"
                   style="background:#111827; color:white; padding:8px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none; margin-left:8px;">
                    View Compare
                </a>
            </div>
        </div>
<form method="GET" action="{{ route('properties.index') }}" style="display:flex; gap:10px; margin-bottom:20px; align-items:center;">
    <select name="sort" style="border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px;">
        <option value="">Sort Properties</option>
        <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Highest price to lowest</option>
        <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Lowest price to highest</option>
        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to oldest</option>
        <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Most viewed</option>
        <option value="highest_rated" {{ request('sort') == 'highest_rated' ? 'selected' : '' }}>Highest rated</option>
    </select>

    <button type="submit" style="background:#111827; color:white; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:600;">
        Apply
    </button>

    <a href="{{ route('properties.index') }}" style="border:1px solid #111827; color:#111827; padding:8px 16px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
        Reset
    </a>
</form>
        <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px;">
            @forelse($properties as $property)
                <div style="background:white; border-radius:16px; box-shadow:0 1px 6px rgba(0,0,0,0.1); overflow:hidden;">
                    <div style="width:100%; height:160px; overflow:hidden;">
                        @if($property->image)
                            <img src="{{ asset('storage/' . $property->image) }}"
                                 style="width:100%; height:160px; object-fit:cover; display:block;">
                        @else
                            <div style="width:100%; height:160px; background:#e5e7eb; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">
                                No Image
                            </div>
                        @endif
                    </div>

                    <div style="padding:12px;">
                        <p style="font-weight:600; font-size:12px; color:#1f2937; height:34px; overflow:hidden;">
                            {{ Str::limit($property->location, 45) }}
                        </p>

                        <p style="font-size:11px; color:#9ca3af;">
                            {{ ucfirst($property->type) }}
                        </p>

                        <p style="font-weight:700; color:#4f46e5; font-size:14px; margin-top:4px;">
                            {{ number_format($property->rent_price) }}tk/Month
                        </p>

                        <div style="display:flex; gap:8px; font-size:11px; color:#6b7280; border-top:1px solid #f3f4f6; margin-top:8px; padding-top:8px;">
                            <span>Bed: {{ $property->bedrooms }}</span>
                            <span>Bath: {{ $property->bathrooms }}</span>
                        </div>

                        <div style="display:flex; flex-wrap:wrap; gap:6px; align-items:center; margin-top:10px;">
                            <a href="{{ route('properties.show', $property) }}"
                               style="font-size:11px; color:#4f46e5; text-decoration:none;">
                                View Details
                            </a>

                            @auth
                                @if(auth()->user()->role === 'tenant')
                                    <a href="{{ route('tenant.bookings.create', $property) }}"
                                       style="background:#4f46e5; color:white; padding:4px 10px; border-radius:8px; font-size:11px; text-decoration:none;">
                                        Book Now
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   style="background:#4f46e5; color:white; padding:4px 10px; border-radius:8px; font-size:11px; text-decoration:none;">
                                    Book Now
                                </a>
                            @endauth

                            <form method="POST" action="{{ route('properties.compare.add', $property->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        style="border:1px solid #4f46e5; color:#4f46e5; padding:4px 10px; border-radius:8px; font-size:11px; background:white;">
                                    Compare
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column:span 5; text-align:center; padding:80px; color:#9ca3af;">
                    No properties available right now.
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $properties->links() }}
        </div>
    </div>
</x-app-layout>
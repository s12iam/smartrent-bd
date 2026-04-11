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
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h2 style="font-size:24px; font-weight:700; color:#1f2937;">List Of Properties</h2>
                <div style="height:4px; width:48px; background:#f97316; border-radius:4px; margin-top:4px;"></div>
            </div>
            <a href="{{ route('properties.index') }}"
               style="background:#4f46e5; color:white; padding:8px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
                View All Property
            </a>
        </div>

        {{-- Property Cards - Fixed 5 column grid --}}
        <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px; align-items:start;">
            @forelse($properties as $property)
            <div style="background:white; border-radius:16px; box-shadow:0 1px 6px rgba(0,0,0,0.1); overflow:hidden; display:flex; flex-direction:column;">

                {{-- Fixed height image container --}}
                <div style="width:100%; height:200px; overflow:hidden; flex-shrink:0;">
                    @if($property->images->count())
                        <img src="{{ asset('storage/' . $property->images->first()->image_path) }}"
                             style="width:100%; height:200px; object-fit:cover; display:block;"
                             alt="property image">
                    @else
                        <div style="width:100%; height:200px; background:#e5e7eb; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">
                            No Image
                        </div>
                    @endif
                </div>

                {{-- Card content - fixed layout --}}
                <div style="padding:12px; display:flex; flex-direction:column; flex:1;">

                    <p style="font-weight:600; font-size:12px; color:#1f2937; line-height:1.4; height:34px; overflow:hidden;">
                        {{ Str::limit($property->location, 45) }}
                    </p>

                    <p style="font-size:11px; color:#9ca3af; margin-top:2px;">
                        {{ ucfirst($property->type) }}
                    </p>

                    <p style="font-weight:700; color:#4f46e5; font-size:14px; margin-top:4px;">
                        {{ number_format($property->rent_price) }}tk/Month
                    </p>

                    <div style="display:flex; gap:8px; font-size:11px; color:#6b7280; border-top:1px solid #f3f4f6; margin-top:8px; padding-top:8px;">
                        <span>🛏 {{ $property->bedrooms }}</span>
                        <span>🚿 {{ $property->bathrooms }}</span>
                        <span>📐 {{ $property->bedrooms * 150 }}</span>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                        <a href="{{ route('properties.show', $property) }}"
                           style="font-size:11px; color:#4f46e5; text-decoration:none;">
                            View Details
                        </a>
                        @auth
                            <a href="{{ route('tenant.bookings.create', $property) }}"
                               style="background:#4f46e5; color:white; padding:4px 10px; border-radius:8px; font-size:11px; text-decoration:none;">
                                Book Now
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               style="background:#4f46e5; color:white; padding:4px 10px; border-radius:8px; font-size:11px; text-decoration:none;">
                                Book Now
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:span 5; text-align:center; padding:80px; color:#9ca3af; font-size:18px;">
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
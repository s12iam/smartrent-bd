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
<<<<<<< HEAD
               style="background:#4f46e5; color:white; padding:8px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
=======
               class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
>>>>>>> 2b5f55b2eedcad94f19f7b7a821cfec136195938
                View All Property
            </a>
        </div>

<<<<<<< HEAD
        {{-- Property Cards - Fixed 5 column grid --}}
        <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:16px; align-items:start;">
            @forelse($properties as $property)
            <div style="background:white; border-radius:16px; box-shadow:0 1px 6px rgba(0,0,0,0.1); overflow:hidden; display:flex; flex-direction:column;">

                {{-- Fixed height image container --}}
                <div style="width:100%; height:160px; overflow:hidden; flex-shrink:0;">
                    @if($property->image)
                        <img src="{{ asset('storage/' . $property->image) }}"
                             style="width:100%; height:160px; object-fit:cover; display:block;"
                             alt="property">
                    @else
                        <div style="width:100%; height:160px; background:#e5e7eb; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">
                            No Image
                        </div>
                    @endif
                </div>

                {{-- Card content --}}
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
=======
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
>>>>>>> 2b5f55b2eedcad94f19f7b7a821cfec136195938
                        <span>🛏 {{ $property->bedrooms }}</span>
                        <span>🚿 {{ $property->bathrooms }}</span>
                        <span>📐 {{ $property->bedrooms * 150 }}</span>
                    </div>

<<<<<<< HEAD
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                        <a href="{{ route('properties.show', $property) }}"
                           style="font-size:11px; color:#4f46e5; text-decoration:none;">
                            View Details
                        </a>
                        @auth
                            <a href="{{ route('tenant.bookings.create', $property) }}"
                               style="background:#4f46e5; color:white; padding:4px 10px; border-radius:8px; font-size:11px; text-decoration:none;">
=======
                    {{-- Buttons --}}
                    <div class="mt-3 flex justify-between items-center">
                        <a href="{{ route('properties.show', $property) }}"
                           class="text-xs text-indigo-600 hover:underline">View Details</a>
                        @auth
                            <a href="{{ route('tenant.bookings.create', $property) }}"
                               class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-indigo-700">
>>>>>>> 2b5f55b2eedcad94f19f7b7a821cfec136195938
                                Book Now
                            </a>
                        @else
                            <a href="{{ route('login') }}"
<<<<<<< HEAD
                               style="background:#4f46e5; color:white; padding:4px 10px; border-radius:8px; font-size:11px; text-decoration:none;">
=======
                               class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-indigo-700">
>>>>>>> 2b5f55b2eedcad94f19f7b7a821cfec136195938
                                Book Now
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
<<<<<<< HEAD
            <div style="grid-column:span 5; text-align:center; padding:80px; color:#9ca3af; font-size:18px;">
=======
            <div class="col-span-5 text-center text-gray-400 py-20 text-lg">
>>>>>>> 2b5f55b2eedcad94f19f7b7a821cfec136195938
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
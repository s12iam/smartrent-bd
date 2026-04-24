<x-app-layout>
    <div class="min-h-screen bg-gray-50">

        {{-- Page Header --}}
        <div class="flex justify-center pt-8 pb-4">
            <span class="bg-gray-700 text-white font-bold text-xl px-8 py-3 rounded-full shadow">
                Property Search
            </span>
        </div>

        <div class="max-w-6xl mx-auto px-6 pb-16">
            <form method="GET" action="{{ route('properties.search') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-24 gap-y-8 mt-6">

                    {{-- City --}}
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            City <span class="text-blue-600">*</span>
                        </label>
                        <select name="city"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ ($filters['city'] ?? '') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Property Type --}}
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Property Type <span class="text-blue-600">*</span>
                        </label>
                        <select name="property_type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Select Property Type</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type }}" {{ ($filters['property_type'] ?? '') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Area --}}
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Area <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" name="area" value="{{ $filters['area'] ?? '' }}"
                            placeholder="Enter Area"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>

                    {{-- Bedroom --}}
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Bedroom <span class="text-blue-600">*</span>
                        </label>
                        <select name="bedrooms"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Select Bedroom</option>
                            @foreach([1,2,3,4,5] as $n)
                                <option value="{{ $n }}" {{ ($filters['bedrooms'] ?? '') == $n ? 'selected' : '' }}>
                                    {{ $n }} Bedroom{{ $n > 1 ? 's' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Range --}}
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Price Range (BDT) <span class="text-blue-600">*</span>
                        </label>
                        <div class="flex gap-3 items-center">
                            <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                                placeholder="Min Price"
                                class="w-1/2 border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <span class="text-gray-500 font-medium">—</span>
                            <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                                placeholder="Max Price"
                                class="w-1/2 border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>

                        {{-- Slider --}}
                        <div class="mt-3 px-1">
                            <input type="range" id="price_slider" min="0" max="100000" step="1000"
                                value="{{ $filters['max_price'] ?? 100000 }}"
                                class="w-full accent-purple-600"
                                oninput="document.querySelector('[name=max_price]').value = this.value; document.getElementById('slider_val').textContent = '৳' + Number(this.value).toLocaleString()">
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>৳0</span>
                                <span id="slider_val" class="text-purple-600 font-semibold">
                                    ৳{{ number_format($filters['max_price'] ?? 100000) }}
                                </span>
                                <span>৳1,00,000</span>
                            </div>
                        </div>
                    </div>

                    {{-- Bathroom --}}
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Bathroom <span class="text-blue-600">*</span>
                        </label>
                        <select name="bathrooms"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Select Bathroom</option>
                            @foreach([1,2,3,4] as $n)
                                <option value="{{ $n }}" {{ ($filters['bathrooms'] ?? '') == $n ? 'selected' : '' }}>
                                    {{ $n }} Bathroom{{ $n > 1 ? 's' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Category Chips --}}
                <div class="mt-10">
                    <label class="block font-semibold text-gray-800 mb-3">Category</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $cat)
                            <label class="cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat }}" class="hidden peer"
                                    {{ ($filters['category'] ?? '') == $cat ? 'checked' : '' }}>
                                <span class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm font-medium
                                    peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600
                                    hover:border-purple-400 transition-all duration-200">
                                    {{ $cat }}
                                </span>
                            </label>
                        @endforeach
                        @if(!empty($filters['category']))
                            <a href="{{ request()->fullUrlWithoutQuery(['category']) }}"
                                class="px-4 py-2 rounded-full border border-red-300 text-red-500 text-sm hover:bg-red-50 transition">
                                ✕ Clear
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Search Button --}}
                <div class="flex justify-center mt-12">
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-lg px-24 py-4 rounded-xl shadow-lg transition duration-200 w-full max-w-lg">
                        Search
                    </button>
                </div>

            </form>

            {{-- Results --}}
            @if(request()->hasAny(['city','area','property_type','category','bedrooms','bathrooms','min_price','max_price']))
                <div class="mt-12">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        Search Results
                        <span class="text-purple-600">({{ $properties->total() }} found)</span>
                    </h2>

                    @if($properties->isEmpty())
                        <div class="text-center py-16 text-gray-400">
                            <p class="text-5xl mb-4">🏠</p>
                            <p class="text-lg">No properties found matching your criteria.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($properties as $property)
                                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                                    @if($property->image)
                                        <img src="{{ asset('storage/' . $property->image) }}"
                                            class="w-full h-48 object-cover" alt="{{ $property->title }}">
                                    @else
                                        <div class="w-full h-48 bg-purple-100 flex items-center justify-center text-purple-400 text-4xl">
                                            🏠
                                        </div>
                                    @endif

                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-bold text-gray-800">{{ $property->title }}</h3>
                                            @if($property->category)
                                                <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full">
                                                    {{ $property->category }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-gray-500 text-sm mb-3">{{ $property->location }}</p>

                                        <div class="mb-3">
                                            @if($property->is_available)
                                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-semibold">
                                                    Available
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-semibold">
                                                    Rented
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex gap-4 text-sm text-gray-600 mb-3">
                                            <span>🛏 {{ $property->bedrooms }} Bed</span>
                                            <span>🚿 {{ $property->bathrooms }} Bath</span>
                                            <span>🏢 {{ ucfirst($property->type) }}</span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <span class="text-purple-600 font-bold text-lg">
                                                ৳{{ number_format($property->rent_price) }}/mo
                                            </span>
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('properties.show', $property) }}"
                                                    class="bg-purple-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                                                    View
                                                </a>
                                                @if(!$property->is_available)
                                                    <span class="text-xs text-red-600 font-semibold">Not bookable</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $properties->links() }}
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">

        <div style="margin-bottom:24px;">
            <h2 style="font-size:24px; font-weight:700; color:#1f2937;">Edit Property</h2>
            <div style="height:4px; width:48px; background:#f97316; border-radius:4px; margin-top:4px;"></div>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('owner.properties.update', $property) }}" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow p-6 space-y-4">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $property->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            {{-- City --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <select name="city" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ str_contains($property->location, $city) ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Location --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Area / Street</label>
                <input type="text" name="location" value="{{ old('location', $property->location) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            {{-- Unit --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit (optional)</label>
                <input type="text" name="unit" value="{{ old('unit') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type }}" {{ $property->type === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $property->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Rent Price --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rent Price (tk/month)</label>
                <input type="number" name="rent_price" value="{{ old('rent_price', $property->rent_price) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            {{-- Bedrooms & Bathrooms --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('description', $property->description) }}</textarea>
            </div>

            {{-- Availability --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_available" value="1" id="is_available"
                       {{ $property->is_available ? 'checked' : '' }}
                       class="w-4 h-4 text-indigo-600">
                <label for="is_available" class="text-sm text-gray-700">Available for rent</label>
            </div>

            {{-- Images --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Add New Images (optional)</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full text-sm text-gray-500">
                @if($property->image)
                    <p class="text-xs text-gray-400 mt-1">Current image will be kept unless you upload new ones.</p>
                @endif
            </div>

            {{-- Buttons --}}
            <div class="flex justify-between pt-2">
                <a href="{{ route('owner.properties.index') }}"
                   class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
                    Update Property
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="min-h-screen bg-white">

        {{-- Page Header --}}
        <div class="flex justify-center pt-8 pb-6">
            <span class="bg-gray-700 text-white font-bold text-xl px-8 py-3 rounded-full shadow">
                Add A New Property
            </span>
        </div>

        <div class="max-w-5xl mx-auto px-8 pb-16">

            @if($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('owner.properties.store') }}" enctype="multipart/form-data">  
                @csrf

                {{-- Row 1: Name, Address, Unit Number --}}
                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Name <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Enter Name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Address <span class="text-blue-600">*</span>
                        </label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            placeholder="Enter Address"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Unit Number
                        </label>
                        <input type="text" name="unit" value="{{ old('unit') }}"
                            placeholder="Enter Unit"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                </div>

                {{-- Row 2: City, Room Type --}}
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            City <span class="text-blue-600">*</span>
                        </label>
                        <select name="city"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Room Type <span class="text-blue-600">*</span>
                        </label>
                        <select name="type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Select Room Type</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Row 3: Bedrooms, Bathrooms, Price --}}
                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Bedrooms <span class="text-blue-600">*</span>
                        </label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms') }}"
                            placeholder="e.g. 3" min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Bathrooms <span class="text-blue-600">*</span>
                        </label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms') }}"
                            placeholder="e.g. 2" min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2">
                            Price <span class="text-blue-600">*</span>
                        </label>
                        <input type="number" name="rent_price" value="{{ old('rent_price') }}"
                            placeholder="Enter Price" min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                </div>

                {{-- Category Chips --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-3">Category</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $cat)
                            <label class="cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat }}" class="hidden peer"
                                    {{ old('category') == $cat ? 'checked' : '' }}>
                                <span class="px-5 py-2 rounded-full border border-gray-300 text-gray-700 text-sm font-medium
                                    peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600
                                    hover:border-purple-400 transition-all duration-200">
                                    {{ $cat }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Enter description..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">{{ old('description') }}</textarea>
                </div>

                {{-- Upload Photos - MULTIPLE --}}
                <div class="mb-8">
                    <label class="block font-semibold text-gray-800 mb-3">
                        Upload Photos
                        <span class="text-xs text-gray-400 font-normal ml-2">You can select multiple images. First image will be the main photo.</span>
                    </label>

                    <div class="border-2 border-dashed border-purple-400 rounded-xl p-10 text-center cursor-pointer hover:bg-purple-50 transition"
                         onclick="document.getElementById('image_input').click()">
                        <div class="text-4xl mb-2">📷</div>
                        <p class="text-gray-500">
                            Drag your images here, or
                            <span class="text-purple-600 font-semibold">browse</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG up to 2MB each</p>

                        {{-- Preview thumbnails appear here --}}
                        <div id="preview_container" class="flex flex-wrap gap-3 mt-4 justify-center"></div>
                    </div>

                    {{-- IMPORTANT: name="images[]" and multiple --}}
                    <input type="file"
                           id="image_input"
                           name="images[]"
                           accept="image/*"
                           multiple
                           class="hidden"
                           onchange="previewImages(this)">
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-lg px-10 py-4 rounded-xl shadow-lg transition w-72">
                    Add New Property
                </button>

            </form>
        </div>
    </div>

    <script>
    function previewImages(input) {
        const container = document.getElementById('preview_container');
        container.innerHTML = '';

        if (input.files.length === 0) return;

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position:relative; display:inline-block;';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:96px; height:96px; object-fit:cover; border-radius:8px; border:2px solid ' + (index === 0 ? '#7c3aed' : '#d1d5db') + ';';

                wrapper.appendChild(img);

                if (index === 0) {
                    const badge = document.createElement('span');
                    badge.textContent = 'Main';
                    badge.style.cssText = 'position:absolute; top:4px; left:4px; background:#7c3aed; color:white; font-size:10px; padding:2px 6px; border-radius:4px;';
                    wrapper.appendChild(badge);
                }

                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        // Update label to show count
        const label = document.querySelector('#preview_container');
        const countMsg = document.createElement('p');
        countMsg.style.cssText = 'width:100%; text-align:center; font-size:12px; color:#6b7280; margin-top:8px;';  
        countMsg.textContent = input.files.length + ' image(s) selected';
        setTimeout(() => container.appendChild(countMsg), 100);
    }
    </script>

</x-app-layout>

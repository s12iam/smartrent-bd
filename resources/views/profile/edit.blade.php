<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 space-y-6">

            {{-- ===== FIGMA SECTION: Profile Photo + Extra Info ===== --}}
            <div class="bg-white shadow rounded-xl p-8">

                @if(session('status') === 'extra-updated')
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                        Profile updated successfully!
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update.extra') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Profile Photo --}}
                    <div class="flex justify-center mb-8">
                        <div class="relative">
                            
                            <div style="width:120px; height:120px; border-radius:50%; overflow:hidden; background:#d1d5db; flex-shrink:0;">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                         style="width:120px; height:120px; object-fit:cover; object-position:center; border-radius:50%;">
                                @else
                                    <div style="width:120px; height:120px; background:#d1d5db; "></div>
                                @endif
                            </div>
                            <label for="profile_photo_input"
                                   style="position:absolute; bottom:4px; right:4px; background:#4f46e5; color:white; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:16px;">
                                +
                            </label>
                            <input type="file" id="profile_photo_input" name="profile_photo"
                                   accept="image/*" class="hidden"
                                   onchange="previewPhoto(this)">
                        </div>
                    </div>
                    <p class="text-center text-xs text-gray-400 -mt-4 mb-6">Upload Photo</p>

                    {{-- Form Fields --}}
                    <div class="grid grid-cols-2 gap-x-16 gap-y-6">

                        {{-- Name --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2">
                                Name <span class="text-blue-600">*</span>
                            </label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                placeholder="Enter Name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>

                        {{-- NID Number --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2">
                                NID Number <span class="text-blue-600">*</span>
                            </label>
                            <input type="text" name="nid_number" value="{{ Auth::user()->nid_number }}"
                                placeholder="Enter NID Number"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>

                        {{-- Mobile Number --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2">
                                Mobile Number <span class="text-blue-600">*</span>
                            </label>
                            <input type="text" name="mobile_number" value="{{ Auth::user()->mobile_number }}"
                                placeholder="Enter number"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>

                        {{-- Optional Mobile --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2">
                                Optional Mobile Number
                            </label>
                            <input type="text" name="optional_mobile" value="{{ Auth::user()->optional_mobile }}"
                                placeholder="Enter number"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>

                        {{-- Address --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2">
                                Address <span class="text-blue-600">*</span>
                            </label>
                            <input type="text" name="address" value="{{ Auth::user()->address }}"
                                placeholder="Enter Address"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        </div>

                        {{-- View Booking History --}}
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2">
                                Booking History
                            </label>
                            <a href="{{ route('tenant.bookings.index') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 flex items-center justify-between text-gray-600 hover:bg-gray-50 transition">
                                <span>View Booking History</span>
                                <span>▾</span>
                            </a>
                        </div>

                    </div>

                    {{-- Save Button --}}
                    <div class="flex justify-center mt-8">
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-lg px-24 py-4 rounded-xl shadow-lg transition w-full max-w-sm">
                            Save
                        </button>
                    </div>

                </form>
            </div>

            {{-- ===== DEFAULT LARAVEL SECTIONS BELOW ===== --}}

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const circle = document.getElementById('photo_preview');
            circle.innerHTML = '<img src="' + e.target.result + '" style="width:120px; height:120px; object-fit:cover; object-position:center; border-radius:50%;">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}



    </script>

</x-app-layout>
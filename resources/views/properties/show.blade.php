<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ $property->title }}
            </h2>

            @if(($reviewsCount ?? 0) > 0)
                <div class="text-sm text-yellow-500 font-medium">
                    {{ number_format($averageRating, 1) }} ★
                    <span class="text-gray-500">({{ $reviewsCount }} {{ $reviewsCount == 1 ? 'review' : 'reviews' }})</span>
                </div>
            @else
                <div class="text-sm text-gray-500">
                    No reviews yet
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow p-6 md:p-8">

            {{-- Property Image --}}
            <img src="https://placehold.co/1000x380?text={{ urlencode($property->title) }}"
                 class="w-full h-72 object-cover rounded-xl mb-8"
                 alt="{{ $property->title }}">

            {{-- Top Summary --}}
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $property->title }}</h1>
                    <p class="text-gray-500 text-sm mb-2">📍 {{ $property->location }}</p>

                    @if(($reviewsCount ?? 0) > 0)
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-semibold text-yellow-500">
                                {{ number_format($averageRating, 1) }} ★
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $reviewsCount }} {{ $reviewsCount == 1 ? 'review' : 'reviews' }}
                            </span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No ratings available yet</p>
                    @endif
                </div>

                <div class="bg-indigo-50 rounded-xl px-5 py-4 min-w-[200px]">
                    <p class="text-gray-500 text-sm">Monthly Rent</p>
                    <p class="text-2xl font-bold text-indigo-600">৳{{ number_format($property->rent_price) }}</p>
                    <p class="text-sm text-gray-500">per month</p>
                </div>
            </div>

            {{-- Property Info Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-400 text-xs mb-1">Location</p>
                    <p class="font-semibold text-sm text-gray-800">📍 {{ $property->location }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-400 text-xs mb-1">Type</p>
                    <p class="font-semibold text-sm text-gray-800">🏠 {{ ucfirst($property->type) }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-400 text-xs mb-1">Category</p>
                    <p class="font-semibold text-sm text-gray-800">
                        {{ $property->category ?: 'Not specified' }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-400 text-xs mb-1">Bedrooms</p>
                    <p class="font-semibold text-sm text-gray-800">🛏 {{ $property->bedrooms }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-400 text-xs mb-1">Bathrooms</p>
                    <p class="font-semibold text-sm text-gray-800">🚿 {{ $property->bathrooms }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-400 text-xs mb-1">Status</p>
                    @if($property->is_available)
                        <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            Available
                        </span>
                    @else
                        <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            Not Available
                        </span>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-8">
                <p class="text-gray-400 text-xs mb-2">Description</p>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $property->description ?: 'No description available for this property.' }}
                    </p>
                </div>
            </div>

            {{-- Booking Button --}}
            <div class="mb-10">
                @auth
                    <a href="{{ route('tenant.bookings.create', $property) }}"
                       class="block text-center bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                        Book This Property
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="block text-center bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                        Login to Book
                    </a>
                @endauth
            </div>

            {{-- Reviews Section --}}
            <div class="border-t pt-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Ratings & Reviews</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            See what tenants are saying about this property.
                        </p>
                    </div>

                    @if(($reviewsCount ?? 0) > 0)
                        <div class="text-right">
                            <div class="text-xl font-bold text-yellow-500">
                                {{ number_format($averageRating, 1) }} ★
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $reviewsCount }} {{ $reviewsCount == 1 ? 'review' : 'reviews' }}
                            </div>
                        </div>
                    @endif
                </div>

                @if(($reviewsCount ?? 0) > 0)
                    <div class="space-y-4">
                        @foreach($property->reviews as $review)
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                <div class="flex items-start justify-between gap-4 mb-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $review->tenant->name ?? 'Tenant' }}
                                        </h4>
                                        <p class="text-xs text-gray-400">
                                            {{ $review->created_at?->format('d M Y') }}
                                        </p>
                                    </div>

                                    <div class="text-yellow-500 text-sm font-medium whitespace-nowrap">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $review->comment ?: 'No comment provided.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <p class="text-gray-500 text-sm">
                            No reviews yet for this property.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
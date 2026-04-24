<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-8">
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Write Review</h1>
                <p class="text-gray-500 mt-1">Share your experience about this property.</p>
            </div>

            <div class="mb-6 p-4 rounded-xl bg-gray-50 border">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $booking->property->title ?? 'Property' }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ $booking->property->location ?? '' }}
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Booking: {{ $booking->start_date }} to {{ $booking->end_date }}
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tenant.reviews.store', $booking) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                        Rating
                    </label>
                    <select name="rating" id="rating"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select rating</option>
                        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 - Excellent</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Very Good</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Good</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Fair</option>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Poor</option>
                    </select>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Comment
                    </label>
                    <textarea name="comment" id="comment" rows="5"
                              class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Write your review here...">{{ old('comment') }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium">
                        Submit Review
                    </button>

                    <a href="{{ route('tenant.bookings.index') }}"
                       class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
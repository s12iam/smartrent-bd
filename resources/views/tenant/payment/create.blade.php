<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="bg-white rounded-2xl shadow p-6">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Make Payment</h1>
            <p class="text-slate-500 mb-6">Complete payment for your approved booking.</p>

            <div class="border rounded-2xl p-5 mb-6">
                <h2 class="text-2xl font-semibold text-slate-800">
                    {{ $booking->property->title }}
                </h2>
                <p class="text-slate-500 mt-1">
                    {{ $booking->property->area }}, {{ $booking->property->city }}
                </p>
                <p class="text-slate-500 mt-4">
                    Booking: {{ \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}
                    to
                    {{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}
                </p>
                <p class="text-3xl text-indigo-600 font-bold mt-4">
                    ৳{{ number_format($booking->property->rent_price, 2) }}
                </p>
            </div>

            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('tenant.payments.store', $booking->id) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition"
                >
                    Confirm Payment
                </button>

                <a
                    href="{{ route('tenant.bookings.index') }}"
                    class="ml-3 text-slate-600 hover:text-slate-800"
                >
                    Cancel
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Booking Requests</h1>
                <p class="text-gray-500 mt-1">Manage tenant booking requests for your properties.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">Property</th>
                        <th class="px-4 py-3">Tenant</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3">Message</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Payment</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-t">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">
                                    {{ $booking->property->title ?? 'Property' }}
                                </div>
                                <div class="text-gray-500 text-xs">
                                    {{ $booking->property->location ?? '' }}
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="font-medium text-gray-800">
                                    {{ $booking->tenant->name ?? 'Tenant' }}
                                </div>
                                <div class="text-gray-500 text-xs">
                                    {{ $booking->tenant->email ?? '' }}
                                </div>
                            </td>

                            <td class="px-4 py-4 text-gray-700">
                                <div>{{ $booking->start_date }}</div>
                                <div class="text-xs text-gray-500">to {{ $booking->end_date }}</div>
                            </td>

                            <td class="px-4 py-4 text-gray-700">
                                {{ $booking->message ?: '—' }}
                            </td>

                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($booking->status === 'approved') bg-green-100 text-green-700
                                    @elseif($booking->status === 'rejected') bg-red-100 text-red-700
                                    @elseif($booking->status === 'cancelled') bg-gray-200 text-gray-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if(($booking->payment_status ?? 'unpaid') === 'paid') bg-green-100 text-green-700
                                    @else bg-orange-100 text-orange-700 @endif">
                                    {{ ucfirst($booking->payment_status ?? 'unpaid') }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                @if($booking->status === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('owner.bookings.approve', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('owner.bookings.reject', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">No action</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No booking requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>
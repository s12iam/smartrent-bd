<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Bookings</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Property</th>
                        <th class="px-4 py-3 text-left">Location</th>
                        <th class="px-4 py-3 text-left">Start Date</th>
                        <th class="px-4 py-3 text-left">End Date</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $booking->property->title }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $booking->property->location }}</td>
                        <td class="px-4 py-3">{{ $booking->start_date }}</td>
                        <td class="px-4 py-3">{{ $booking->end_date }}</td>
                        <td class="px-4 py-3">
                            @if($booking->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                            @elseif($booking->status === 'approved')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">Approved</span>
                            @elseif($booking->status === 'rejected')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">Rejected</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-semibold">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('tenant.bookings.cancel', $booking) }}">
                                @csrf @method('PATCH')
                                <button class="text-red-500 hover:underline text-xs">Cancel</button>
                            </form>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-400 py-10">No bookings yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $bookings->links() }}</div>
        </div>
    </div>
</x-app-layout>
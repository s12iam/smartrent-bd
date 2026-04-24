<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Notifications</h1>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @forelse($notifications as $notification)
                <div class="px-6 py-4 border-b">
                    <div class="font-semibold text-gray-800">
                        {{ $notification->data['message'] ?? 'Notification' }}
                    </div>

                    <div class="text-sm text-gray-500 mt-1">
                        Sent {{ $notification->created_at->diffForHumans() }}
                        — {{ $notification->created_at->format('M d, Y h:i A') }}
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    No notifications found.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
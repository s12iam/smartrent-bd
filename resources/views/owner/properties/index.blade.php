<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h2 style="font-size:24px; font-weight:700; color:#1f2937;">My Properties</h2>
                <div style="height:4px; width:48px; background:#f97316; border-radius:4px; margin-top:4px;"></div>
            </div>
            <a href="{{ route('owner.properties.create') }}"
               style="background:#4f46e5; color:white; padding:10px 24px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
                + Add New Property
            </a>
        </div>

        @if(session('success'))
            <div style="background:#dcfce7; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($properties->isEmpty())
            <div style="text-align:center; padding:80px; color:#9ca3af; font-size:18px;">
                You have no properties yet.
            </div>
        @else
            <div style="background:white; border-radius:16px; box-shadow:0 1px 6px rgba(0,0,0,0.1); overflow:hidden;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#6b7280; font-weight:600;">Image</th>
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#6b7280; font-weight:600;">Location</th>
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#6b7280; font-weight:600;">Type</th>
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#6b7280; font-weight:600;">Price</th>
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#6b7280; font-weight:600;">Status</th>
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#6b7280; font-weight:600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $property)
                        <tr style="border-bottom:1px solid #f3f4f6;">

                            {{-- Image --}}
                            <td style="padding:12px 16px;">
                                @if($property->image)
                                    <img src="{{ asset('storage/' . $property->image) }}"
                                         style="width:64px; height:48px; object-fit:cover; border-radius:8px;">
                                @else
                                    <div style="width:64px; height:48px; background:#e5e7eb; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:11px; color:#9ca3af;">
                                        No Img
                                    </div>
                                @endif
                            </td>

                            {{-- Location --}}
                            <td style="padding:12px 16px;">
                                <p style="font-weight:600; font-size:13px; color:#1f2937;">
                                    {{ Str::limit($property->location, 35) }}
                                </p>
                                <p style="font-size:11px; color:#9ca3af; margin-top:2px;">
                                    {{ $property->bedrooms }} bed · {{ $property->bathrooms }} bath
                                </p>
                            </td>

                            {{-- Type --}}
                            <td style="padding:12px 16px; font-size:13px; color:#6b7280;">
                                {{ ucfirst($property->type) }}
                                @if($property->category)
                                    <br>
                                    <span style="font-size:11px; color:#a78bfa;">{{ $property->category }}</span>
                                @endif
                            </td>

                            {{-- Price --}}
                            <td style="padding:12px 16px; font-weight:700; color:#4f46e5; font-size:14px;">
                                {{ number_format($property->rent_price) }}tk/mo
                            </td>

                            {{-- Status --}}
                            <td style="padding:12px 16px;">
                                @if($property->is_available)
                                    <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                        Available
                                    </span>
                                @else
                                    <span style="background:#fee2e2; color:#991b1b; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                        Rented
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td style="padding:12px 16px;">
                                <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">

                                    {{-- Edit --}}
                                    <a href="{{ route('owner.properties.edit', $property) }}"
                                       style="background:#4f46e5; color:white; padding:5px 12px; border-radius:6px; font-size:11px; text-decoration:none; font-weight:500;">
                                        Edit
                                    </a>

                                    {{-- Toggle Available/Rented --}}
                                    <form method="POST" action="{{ route('owner.properties.toggle', $property) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            style="background:{{ $property->is_available ? '#f59e0b' : '#10b981' }}; color:white; padding:5px 12px; border-radius:6px; font-size:11px; border:none; cursor:pointer; font-weight:500;">
                                            {{ $property->is_available ? 'Mark Rented' : 'Mark Available' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('owner.properties.destroy', $property) }}"
                                          onsubmit="return confirm('Delete this property? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background:#ef4444; color:white; padding:5px 12px; border-radius:6px; font-size:11px; border:none; cursor:pointer; font-weight:500;">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $properties->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
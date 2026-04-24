<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Compare Properties</h2>
                <div class="h-1 w-14 bg-orange-500 rounded mt-2"></div>
                <p class="text-sm text-gray-500 mt-2">Compare selected properties side by side.</p>
            </div>

            <a href="{{ route('properties.index') }}"
               style="background:#4f46e5; color:white; padding:8px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">
                Back to Properties
            </a>
        </div>

        @if($properties->isEmpty())
            <div style="background:white; border-radius:16px; padding:40px; text-align:center; color:#9ca3af;">
                No properties added to compare yet.
            </div>
        @else
            <form method="POST" action="{{ route('properties.compare.clear') }}" style="margin-bottom:16px;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="background:#dc2626; color:white; padding:8px 16px; border-radius:8px; border:none;">
                    Clear Compare
                </button>
            </form>

            <div style="overflow-x:auto; background:white; border-radius:16px; box-shadow:0 1px 6px rgba(0,0,0,0.1);">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f9fafb;">
                            <th style="padding:14px; text-align:left; border-bottom:1px solid #e5e7eb;">Feature</th>
                            @foreach($properties as $property)
                                <th style="padding:14px; text-align:left; border-bottom:1px solid #e5e7eb;">
                                    {{ $property->title ?? $property->location }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="padding:14px; font-weight:600;">Location</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">{{ $property->location }}</td>
                            @endforeach
                        </tr>

                        <tr style="background:#f9fafb;">
                            <td style="padding:14px; font-weight:600;">Price</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">{{ number_format($property->rent_price) }} tk/month</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td style="padding:14px; font-weight:600;">Type</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">{{ ucfirst($property->type) }}</td>
                            @endforeach
                        </tr>

                        <tr style="background:#f9fafb;">
                            <td style="padding:14px; font-weight:600;">Bedrooms</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">{{ $property->bedrooms }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td style="padding:14px; font-weight:600;">Bathrooms</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">{{ $property->bathrooms }}</td>
                            @endforeach
                        </tr>

                        <tr style="background:#f9fafb;">
                            <td style="padding:14px; font-weight:600;">Size</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">{{ $property->size ?? ($property->bedrooms * 150) }} sqft</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td style="padding:14px; font-weight:600;">Status</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">
                                    {{ $property->is_available ? 'Available' : 'Rented' }}
                                </td>
                            @endforeach
                        </tr>

                        <tr style="background:#f9fafb;">
                            <td style="padding:14px; font-weight:600;">Action</td>
                            @foreach($properties as $property)
                                <td style="padding:14px;">
                                    <form method="POST" action="{{ route('properties.compare.remove', $property->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="background:#ef4444; color:white; padding:6px 12px; border-radius:8px; border:none;">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
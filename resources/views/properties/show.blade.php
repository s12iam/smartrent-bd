<x-app-layout>

    <div class="py-8 max-w-4xl mx-auto px-4">

        {{-- Property Title --}}
        <h2 style="font-size:20px; font-weight:700; color:#1f2937; margin-bottom:20px;">
            {{ $property->title }}
        </h2>

        <div class="bg-white rounded-xl shadow p-6">

            {{-- ===== IMAGE GALLERY / CAROUSEL ===== --}}
            @php
                $images = $property->images->count() > 0 ? $property->images : null;
            @endphp

            @if($images)
            <div style="margin-bottom:24px;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                    <span style="font-size:16px;">🖼</span>
                    <span style="font-weight:600; font-size:16px; color:#1f2937;">Images</span>
                </div>

                <div style="position:relative; overflow:hidden; border-radius:12px; border:1px solid #e5e7eb;">

                    <div id="carousel" style="display:flex; transition:transform 0.4s ease;">
                        @foreach($images as $i => $img)
                            <div style="min-width:100%;">
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     style="width:100%; height:360px; object-fit:cover; display:block; cursor:zoom-in;"
                                     alt="Property image {{ $i + 1 }}"
                                     onclick="openLightbox('{{ asset('storage/' . $img->image_path) }}')">
                            </div>
                        @endforeach
                    </div>

                    @if($images->count() > 1)
                    <button onclick="prevSlide()"
                        style="position:absolute; left:12px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.85); border:none; border-radius:50%; width:36px; height:36px; font-size:18px; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.2); display:flex; align-items:center; justify-content:center;">
                        ‹
                    </button>

                    <button onclick="nextSlide()"
                        style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.85); border:none; border-radius:50%; width:36px; height:36px; font-size:18px; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.2); display:flex; align-items:center; justify-content:center;">
                        ›
                    </button>

                    <div style="position:absolute; bottom:12px; left:50%; transform:translateX(-50%); display:flex; gap:6px;">
                        @foreach($images as $i => $img)
                            <div class="dot" data-index="{{ $i }}"
                                 style="width:8px; height:8px; border-radius:50%; background:{{ $i === 0 ? 'white' : 'rgba(255,255,255,0.5)' }}; cursor:pointer; transition:background 0.3s;"
                                 onclick="goToSlide({{ $i }})">
                            </div>
                        @endforeach
                    </div>
                    @endif

                </div>

                @if($images->count() > 1)
                <div style="display:flex; gap:8px; margin-top:10px; overflow-x:auto; padding-bottom:4px;">
                    @foreach($images as $i => $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}"
                             onclick="goToSlide({{ $i }})"
                             id="thumb-{{ $i }}"
                             style="width:72px; height:52px; object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid {{ $i === 0 ? '#4f46e5' : '#e5e7eb' }}; flex-shrink:0; transition:border 0.3s;"
                             alt="thumb">
                    @endforeach
                </div>
                @endif

            </div>
            @elseif($property->image)
            <div style="margin-bottom:24px;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                    <span style="font-size:16px;">🖼</span>
                    <span style="font-weight:600; font-size:16px; color:#1f2937;">Image</span>
                </div>
                <img src="{{ asset('storage/' . $property->image) }}"
                     style="width:100%; height:360px; object-fit:cover; border-radius:12px; border:1px solid #e5e7eb; cursor:zoom-in;"
                     onclick="openLightbox('{{ asset('storage/' . $property->image) }}')">
            </div>
            @endif

            {{-- ===== BASIC INFORMATION ===== --}}
            <div style="border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                    <span style="font-size:16px;">📋</span>
                    <span style="font-weight:600; font-size:16px; color:#1f2937;">Basic Information</span>
                </div>

                <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; padding-bottom:16px; border-bottom:1px solid #f3f4f6;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:18px;">🏢</span>
                        <div>
                            <p style="font-size:11px; color:#9ca3af;">Type</p>
                            <p style="font-size:13px; font-weight:600; color:#1f2937;">{{ ucfirst($property->type) }} : {{ $property->bedrooms }}</p>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:18px;">🚿</span>
                        <div>
                            <p style="font-size:11px; color:#9ca3af;">Bathroom</p>
                            <p style="font-size:13px; font-weight:600; color:#1f2937;">{{ $property->bathrooms }}</p>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:18px;">🛏</span>
                        <div>
                            <p style="font-size:11px; color:#9ca3af;">Bedrooms</p>
                            <p style="font-size:13px; font-weight:600; color:#1f2937;">{{ $property->bedrooms }}</p>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-size:18px;">📐</span>
                        <div>
                            <p style="font-size:11px; color:#9ca3af;">Size</p>
                            <p style="font-size:13px; font-weight:600; color:#1f2937;">{{ $property->bedrooms * 150 }} sqft</p>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-top:16px;">
                    <div>
                        <p style="font-size:11px; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Property ID</p>
                        <p style="font-size:14px; font-weight:600; color:#1f2937; margin-top:4px;">{{ $property->id }}</p>
                    </div>
                    <div>
                        <p style="font-size:11px; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Updated At</p>
                        <p style="font-size:14px; font-weight:600; color:#1f2937; margin-top:4px;">{{ $property->updated_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p style="font-size:11px; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:0.05em;">Availability Status</p>
                        <div style="margin-top:4px;">
                            @if($property->is_available)
                                <span style="background:#16a34a; color:white; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">Available</span>
                            @else
                                <span style="background:#dc2626; color:white; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">Rented</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== DETAILS ===== --}}
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px;">
                <div style="background:#f9fafb; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; color:#9ca3af; margin-bottom:4px;">Location</p>
                    <p style="font-weight:600; font-size:13px; color:#1f2937;">📍 {{ $property->location }}</p>
                </div>
                <div style="background:#f9fafb; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; color:#9ca3af; margin-bottom:4px;">Monthly Rent</p>
                    <p style="font-weight:700; font-size:16px; color:#4f46e5;">{{ number_format($property->rent_price) }}tk/mo</p>
                </div>
                <div style="background:#f9fafb; border-radius:10px; padding:14px;">
                    <p style="font-size:11px; color:#9ca3af; margin-bottom:4px;">Category</p>
                    <p style="font-weight:600; font-size:13px; color:#1f2937;">{{ $property->category ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Description --}}
            @if($property->description)
            <div style="background:#f9fafb; border-radius:10px; padding:14px; margin-bottom:20px;">
                <p style="font-size:11px; color:#9ca3af; margin-bottom:6px;">Description</p>
                <p style="font-size:13px; color:#374151; line-height:1.6;">{{ $property->description }}</p>
            </div>
            @endif

            {{-- ===== BOOK BUTTON ===== --}}
            @if($property->is_available)
                @auth
                    <a href="{{ route('tenant.bookings.create', $property) }}"
                       style="display:block; text-align:center; background:#4f46e5; color:white; padding:16px; border-radius:10px; font-weight:700; font-size:16px; text-decoration:none;">
                        Book This Property
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       style="display:block; text-align:center; background:#4f46e5; color:white; padding:16px; border-radius:10px; font-weight:700; font-size:16px; text-decoration:none;">
                        Login to Book
                    </a>
                @endauth
            @else
                <div style="text-align:center; background:#fee2e2; color:#991b1b; padding:16px; border-radius:10px; font-weight:600;">
                    This property is currently rented
                </div>
            @endif

        </div>
    </div>

    {{-- ===== LIGHTBOX ===== --}}
    <div id="lightbox"
         onclick="closeLightbox()"
         style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center; cursor:zoom-out;">

        <button onclick="closeLightbox()"
            style="position:absolute; top:20px; right:28px; background:none; border:none; color:white; font-size:40px; cursor:pointer; line-height:1;">
            &times;
        </button>

        <button onclick="event.stopPropagation(); lightboxPrev()"
            style="position:absolute; left:20px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.15); border:none; color:white; font-size:32px; width:48px; height:48px; border-radius:50%; cursor:pointer;">
            ‹
        </button>

        <img id="lightbox-img"
             src=""
             style="max-width:90vw; max-height:90vh; object-fit:contain; border-radius:8px; box-shadow:0 8px 40px rgba(0,0,0,0.6);"
             onclick="event.stopPropagation()">

        <button onclick="event.stopPropagation(); lightboxNext()"
            style="position:absolute; right:20px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,0.15); border:none; color:white; font-size:32px; width:48px; height:48px; border-radius:50%; cursor:pointer;">
            ›
        </button>

        <p id="lightbox-counter"
           style="position:absolute; bottom:20px; left:50%; transform:translateX(-50%); color:rgba(255,255,255,0.6); font-size:13px;">
        </p>
    </div>

    <script>
    // Carousel
    let current = 0;
    const total = {{ $property->images->count() > 0 ? $property->images->count() : 1 }};

    function updateCarousel() {
        const carousel = document.getElementById('carousel');
        if (!carousel) return;
        carousel.style.transform = 'translateX(-' + (current * 100) + '%)';
        document.querySelectorAll('.dot').forEach((dot, i) => {
            dot.style.background = i === current ? 'white' : 'rgba(255,255,255,0.5)';
        });
        for (let i = 0; i < total; i++) {
            const thumb = document.getElementById('thumb-' + i);
            if (thumb) thumb.style.border = i === current ? '2px solid #4f46e5' : '2px solid #e5e7eb';
        }
    }

    function nextSlide() { current = (current + 1) % total; updateCarousel(); }
    function prevSlide() { current = (current - 1 + total) % total; updateCarousel(); }
    function goToSlide(index) { current = index; updateCarousel(); }

    // Lightbox
    const allImages = [
        @if($property->images->count() > 0)
            @foreach($property->images as $img)
                "{{ asset('storage/' . $img->image_path) }}",
            @endforeach
        @elseif($property->image)
            "{{ asset('storage/' . $property->image) }}",
        @endif
    ];

    let lightboxIndex = 0;

    function openLightbox(src) {
        lightboxIndex = allImages.indexOf(src);
        if (lightboxIndex === -1) lightboxIndex = 0;
        showLightboxImage();
        const lb = document.getElementById('lightbox');
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = '';
    }

    function showLightboxImage() {
        document.getElementById('lightbox-img').src = allImages[lightboxIndex];
        document.getElementById('lightbox-counter').textContent =
            (lightboxIndex + 1) + ' / ' + allImages.length;
    }

    function lightboxNext() { lightboxIndex = (lightboxIndex + 1) % allImages.length; showLightboxImage(); }
    function lightboxPrev() { lightboxIndex = (lightboxIndex - 1 + allImages.length) % allImages.length; showLightboxImage(); }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') lightboxNext();
        if (e.key === 'ArrowLeft') lightboxPrev();
    });
    </script>

</x-app-layout>
@extends('layouts.app')

@section('title', 'Accommodation | Mahua House')
@section('meta_description', 'Accommodation at Mahua House — Super Deluxe AC Rooms, Deluxe AC Rooms and Independent Cottages nestled in 3.5 acres of forest near Bhopal. Comfort meets rustic charm.')
@section('meta_keywords', 'Accommodation Mahua House, Forest Stay Bhopal, Eco Cottage Bhopal, AC Room Forest, Bhopal Nature Resort Stay')

@section('styles')
<style>
    /* =============================================
       ACCOMMODATION PAGE — STYLES  prefix: .ac-
       Palette: #033631 | #DAA520 | #E7EEEE
       ============================================= */

    .ac-section       { padding: 90px 0; }
    .ac-section-alt   { background: #E7EEEE; }
    .ac-section-dark  { background: #033631; }
    .ac-section-cream { background: #faf8f3; }

    .ac-label {
        display: inline-block; font-size: 11px; font-weight: 700;
        letter-spacing: 4px; text-transform: uppercase;
        color: #DAA520; margin-bottom: 12px;
    }
    .ac-label-light { color: rgba(218,165,32,0.9); }

    .ac-heading {
        font-size: clamp(28px, 3.5vw, 44px); font-weight: 700;
        color: #033631; line-height: 1.2; margin-bottom: 14px;
    }
    .ac-heading-light { color: #ffffff; }
    .ac-heading em { font-style: normal; color: #DAA520; }

    .ac-divider {
        display: flex; align-items: center;
        gap: 12px; color: #DAA520; margin-bottom: 22px;
    }
    .ac-divider.centered { justify-content: center; }
    .ac-divider span { display: block; width: 60px; height: 1px; background: #DAA520; }
    .ac-divider i { font-size: 9px; }

    .ac-body {
        font-size: 15px; color: rgba(3,54,49,0.6);
        line-height: 1.85; margin-bottom: 0;
    }
    .ac-body-light { color: rgba(255,255,255,0.62); }

    .ac-btn {
        display: inline-block; padding: 13px 32px;
        border-radius: 100px; font-size: 14px; font-weight: 700;
        letter-spacing: 0.5px; text-decoration: none;
        transition: all 0.3s ease; border: 2px solid transparent; cursor: pointer;
    }
    .ac-btn-primary { background: #033631; color: #fff; border-color: #033631; }
    .ac-btn-primary:hover { background: transparent; color: #033631; }
    .ac-btn-gold    { background: #DAA520; color: #033631; border-color: #DAA520; }
    .ac-btn-gold:hover { background: transparent; color: #DAA520; }
    .ac-btn-outline { background: transparent; color: #fff; border-color: rgba(255,255,255,0.45); }
    .ac-btn-outline:hover { background: #DAA520; color: #033631; border-color: #DAA520; }

    /* HERO */
    .ac-hero {
        position: relative; height: 580px;
        background: url('{{ asset("assets/images/about/5.jpeg") }}') center center / cover no-repeat;
        display: flex; align-items: flex-end; overflow: hidden;
    }
    .ac-hero::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(3,54,49,0.22) 0%, rgba(3,54,49,0.88) 100%);
    }
    .ac-hero-content { position: relative; z-index: 2; padding-bottom: 80px; width: 100%; }
    .ac-breadcrumb {
        list-style: none; padding: 0; margin: 0 0 14px;
        display: flex; align-items: center; gap: 8px;
    }
    .ac-breadcrumb li { font-size: 13px; color: rgba(255,255,255,0.5); }
    .ac-breadcrumb li a { color: #DAA520; text-decoration: none; }
    .ac-breadcrumb li + li::before { content: '/'; margin-right: 8px; }
    .ac-hero h1 {
        font-size: clamp(32px, 5vw, 62px); font-weight: 800;
        color: #fff; line-height: 1.1; margin-bottom: 18px;
    }
    .ac-hero h1 em { font-style: italic; color: #DAA520; }
    .ac-hero p { font-size: 16px; color: rgba(255,255,255,0.75); max-width: 580px; line-height: 1.75; margin-bottom: 30px; }
    .ac-hero-shape { position: absolute; bottom: 0; left: 0; right: 0; z-index: 2; line-height: 0; }
    .ac-hero-shape img { width: 100%; }

    /* ROOM CARDS */
    .ac-room-card {
        border-radius: 22px; overflow: hidden;
        border: 1px solid rgba(3,54,49,0.08);
        box-shadow: 0 6px 28px rgba(3,54,49,0.08);
        height: 100%; display: flex; flex-direction: column;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .ac-room-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(3,54,49,0.13); }
    .ac-room-img { height: 240px; overflow: hidden; position: relative; }
    .ac-room-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .ac-room-card:hover .ac-room-img img { transform: scale(1.05); }
    .ac-room-badge {
        position: absolute; top: 16px; left: 16px;
        background: #DAA520; color: #033631;
        font-size: 11px; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; padding: 5px 14px; border-radius: 100px;
    }
    .ac-room-body { background: #fff; padding: 28px 26px; flex: 1; display: flex; flex-direction: column; }
    .ac-room-title { font-size: 20px; font-weight: 700; color: #033631; margin-bottom: 6px; }
    .ac-room-occ { font-size: 13px; color: rgba(3,54,49,0.5); margin-bottom: 16px; display: flex; align-items: center; gap: 6px; }
    .ac-room-price {
        font-size: 32px; font-weight: 800; color: #DAA520;
        margin-bottom: 4px; line-height: 1;
    }
    .ac-room-price-note { font-size: 13px; color: rgba(3,54,49,0.45); margin-bottom: 20px; }
    .ac-room-amenities { list-style: none; padding: 0; margin: 0 0 24px; }
    .ac-room-amenities li {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: rgba(3,54,49,0.65);
        padding: 7px 0; border-bottom: 1px solid rgba(3,54,49,0.06);
    }
    .ac-room-amenities li:last-child { border-bottom: none; }
    .ac-room-amenities li i { color: #DAA520; font-size: 10px; min-width: 12px; }
    .ac-room-cta { margin-top: auto; }
    .ac-room-btn {
        display: block; text-align: center; padding: 12px;
        background: #033631; color: #fff; border-radius: 12px;
        font-size: 14px; font-weight: 700; text-decoration: none;
        transition: background 0.3s ease;
    }
    .ac-room-btn:hover { background: #DAA520; color: #033631; }

    /* FEATURED ROOM (best value) */
    .ac-room-card.featured { border-color: #DAA520; }
    .ac-room-card.featured .ac-room-body { background: #033631; }
    .ac-room-card.featured .ac-room-title { color: #fff; }
    .ac-room-card.featured .ac-room-occ { color: rgba(255,255,255,0.5); }
    .ac-room-card.featured .ac-room-price-note { color: rgba(255,255,255,0.4); }
    .ac-room-card.featured .ac-room-amenities li { color: rgba(255,255,255,0.65); border-bottom-color: rgba(255,255,255,0.08); }
    .ac-room-card.featured .ac-room-btn { background: #DAA520; color: #033631; }
    .ac-room-card.featured .ac-room-btn:hover { background: #fff; color: #033631; }

    /* CHECK IN/OUT BAR */
    .ac-timing-bar {
        background: #033631; border-radius: 18px; padding: 32px 40px;
        display: flex; align-items: center; justify-content: center;
        gap: 60px; flex-wrap: wrap;
    }
    .ac-timing-item { text-align: center; }
    .ac-timing-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(218,165,32,0.15); border: 1px solid rgba(218,165,32,0.3);
        display: inline-flex; align-items: center; justify-content: center;
        color: #DAA520; font-size: 22px; margin-bottom: 12px;
    }
    .ac-timing-label { font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-bottom: 4px; }
    .ac-timing-value { font-size: 24px; font-weight: 800; color: #fff; }
    .ac-timing-divider { width: 1px; height: 70px; background: rgba(255,255,255,0.1); }

    /* AMENITIES GRID */
    .ac-amenity-item {
        text-align: center; padding: 28px 18px;
        border-radius: 16px; border: 1px solid rgba(3,54,49,0.08);
        background: #fff; height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .ac-amenity-item:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(3,54,49,0.1); }
    .ac-amenity-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(218,165,32,0.1); border: 1px solid rgba(218,165,32,0.2);
        display: inline-flex; align-items: center; justify-content: center;
        color: #DAA520; font-size: 20px; margin-bottom: 14px;
    }
    .ac-amenity-title { font-size: 14px; font-weight: 700; color: #033631; margin: 0; }

    /* CTA BOX */
    .ac-cta-box {
        background: linear-gradient(135deg, #033631 0%, #07554D 100%);
        border-radius: 24px; padding: 70px 60px;
        text-align: center; position: relative; overflow: hidden;
    }
    .ac-cta-box::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 350px; height: 350px; border-radius: 50%; background: rgba(218,165,32,0.08);
    }
    .ac-cta-box::after {
        content: ''; position: absolute; bottom: -80px; left: -80px;
        width: 260px; height: 260px; border-radius: 50%; background: rgba(218,165,32,0.06);
    }

    @media (max-width: 991px) {
        .ac-hero { height: 460px; }
        .ac-section { padding: 70px 0; }
        .ac-cta-box { padding: 50px 30px; }
        .ac-timing-bar { gap: 30px; padding: 24px 20px; }
        .ac-timing-divider { display: none; }
    }
    @media (max-width: 575px) {
        .ac-hero h1 { font-size: 30px; }
        .ac-cta-box { padding: 40px 20px; }
    }
</style>
@endsection

@section('content')

    <!-- HERO -->
    <section class="ac-hero">
        <div class="container ac-hero-content">
            <ul class="ac-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Accommodation</li>
            </ul>
            <span class="ac-label wow fadeInUp" data-wow-delay=".2s">Where You'll Stay</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">
                Comfort Meets <em>Rustic Charm</em>
            </h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">
                Wake up to birdsong and forest air. Our rooms and cottages blend modern comfort with the warmth of nature — every stay at Mahua House is a retreat from the ordinary.
            </p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#rooms" class="ac-btn ac-btn-gold">View Rooms &amp; Pricing</a>
                <a href="{{ route('booking') }}" class="ac-btn ac-btn-outline"><i class="fa-solid fa-calendar-check me-2"></i>Book Now</a>
            </div>
        </div>
        <div class="ac-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>


    <!-- CHECK-IN TIMING BAR -->
    <section style="padding: 60px 0; background: #faf8f3;">
        <div class="container">
            <div class="ac-timing-bar wow fadeInUp" data-wow-delay=".2s">
                <div class="ac-timing-item">
                    <div class="ac-timing-icon"><i class="fa-solid fa-right-to-bracket"></i></div>
                    <p class="ac-timing-label">Check-In</p>
                    <p class="ac-timing-value">11:00 AM</p>
                </div>
                <div class="ac-timing-divider"></div>
                <div class="ac-timing-item">
                    <div class="ac-timing-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                    <p class="ac-timing-label">Check-Out</p>
                    <p class="ac-timing-value">10:00 AM</p>
                </div>
                <div class="ac-timing-divider"></div>
                <div class="ac-timing-item">
                    <div class="ac-timing-icon"><i class="fa-solid fa-phone-volume"></i></div>
                    <p class="ac-timing-label">Reservations</p>
                    <p class="ac-timing-value" style="font-size:18px;"><a href="tel:+919425651754" style="color:#fff;text-decoration:none;">+91 9425651754</a></p>
                </div>
                <div class="ac-timing-divider"></div>
                <div class="ac-timing-item">
                    <div class="ac-timing-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <p class="ac-timing-label">WhatsApp</p>
                    <p class="ac-timing-value" style="font-size:18px;"><a href="https://wa.me/919425651754" target="_blank" rel="noopener" style="color:#fff;text-decoration:none;">Message Us</a></p>
                </div>
            </div>
        </div>
    </section>


    <!-- ROOM CARDS -->
    <section class="ac-section" id="rooms">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ac-label wow fadeInUp" data-wow-delay=".1s">Room Options</span>
                    <h2 class="ac-heading wow fadeInUp" data-wow-delay=".2s">Choose Your <em>Forest Retreat</em></h2>
                    <div class="ac-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="ac-body wow fadeInUp" data-wow-delay=".4s">Three distinct room categories — each designed for comfort, each surrounded by the natural beauty of the Samardha Reserved Forest.</p>
                </div>
            </div>
            <div class="row g-4 align-items-stretch">

                @if($rooms->count())
                    @foreach($rooms as $i => $room)
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="{{ '.'.($i+1).'s' }}">
                        <div class="ac-room-card {{ $room->is_featured ? 'featured' : '' }}">
                            <div class="ac-room-img">
                                @if($room->image_url)
                                <img src="{{ $room->image_url }}" alt="{{ $room->name }}">
                                @else
                                <img src="{{ asset('assets/images/about/'.($i*2+6).'.jpeg') }}" alt="{{ $room->name }}">
                                @endif
                                @if($room->badge_text)
                                <span class="ac-room-badge" style="background:{{ $room->badge_color ?? '#DAA520' }};">{{ $room->badge_text }}</span>
                                @endif
                            </div>
                            <div class="ac-room-body">
                                <h3 class="ac-room-title">{{ $room->name }}</h3>
                                <p class="ac-room-occ"><i class="fa-solid fa-user-group"></i> Up to {{ $room->max_guests }} Guests</p>
                                <p class="ac-room-price">&#8377;{{ number_format($room->price_per_night, 0) }}</p>
                                <p class="ac-room-price-note">per night &nbsp;|&nbsp; {{ $room->room_type ?? 'double occupancy' }}</p>
                                @if($room->amenities && count($room->amenities))
                                <ul class="ac-room-amenities">
                                    @foreach(array_slice($room->amenities, 0, 6) as $amenity)
                                    <li><i class="fa-solid fa-check"></i> {{ $amenity }}</li>
                                    @endforeach
                                </ul>
                                @elseif($room->description)
                                <p style="font-size:13px;color:rgba(3,54,49,0.6);line-height:1.7;margin-bottom:16px;">{{ Str::limit($room->description, 120) }}</p>
                                @endif
                                <div class="ac-room-cta">
                                    <a href="{{ route('booking') }}" class="ac-room-btn">Book This {{ Str::contains(strtolower($room->name), 'cottage') ? 'Cottage' : 'Room' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="col-lg-4 wow fadeInUp" data-wow-delay=".1s">
                    <div class="ac-room-card">
                        <div class="ac-room-img">
                            <img src="{{ asset('assets/images/about/6.jpeg') }}" alt="Super Deluxe AC Room">
                            <span class="ac-room-badge">Best Experience</span>
                        </div>
                        <div class="ac-room-body">
                            <h3 class="ac-room-title">Super Deluxe AC Room</h3>
                            <p class="ac-room-occ"><i class="fa-solid fa-user-group"></i> Double Occupancy</p>
                            <p class="ac-room-price">&#8377;3,500</p>
                            <p class="ac-room-price-note">per night &nbsp;|&nbsp; double occupancy</p>
                            <ul class="ac-room-amenities">
                                <li><i class="fa-solid fa-check"></i> Spacious air-conditioned room</li>
                                <li><i class="fa-solid fa-check"></i> Premium forest-view setting</li>
                                <li><i class="fa-solid fa-check"></i> Attached bathroom with hot water</li>
                                <li><i class="fa-solid fa-check"></i> Comfortable beds &amp; linen</li>
                                <li><i class="fa-solid fa-check"></i> Wi-Fi access</li>
                            </ul>
                            <div class="ac-room-cta"><a href="{{ route('booking') }}" class="ac-room-btn">Book This Room</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay=".2s">
                    <div class="ac-room-card featured">
                        <div class="ac-room-img">
                            <img src="{{ asset('assets/images/about/8.jpeg') }}" alt="Deluxe AC Room">
                            <span class="ac-room-badge">Most Popular</span>
                        </div>
                        <div class="ac-room-body">
                            <h3 class="ac-room-title">Deluxe AC Room</h3>
                            <p class="ac-room-occ"><i class="fa-solid fa-user-group"></i> Double Occupancy</p>
                            <p class="ac-room-price">&#8377;3,000</p>
                            <p class="ac-room-price-note">per night &nbsp;|&nbsp; double occupancy</p>
                            <ul class="ac-room-amenities">
                                <li><i class="fa-solid fa-check"></i> Comfortable air-conditioned room</li>
                                <li><i class="fa-solid fa-check"></i> Forest surroundings</li>
                                <li><i class="fa-solid fa-check"></i> Attached bathroom with hot water</li>
                                <li><i class="fa-solid fa-check"></i> Wi-Fi access</li>
                            </ul>
                            <div class="ac-room-cta"><a href="{{ route('booking') }}" class="ac-room-btn">Book This Room</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                    <div class="ac-room-card">
                        <div class="ac-room-img">
                            <img src="{{ asset('assets/images/about/10.jpeg') }}" alt="Independent Cottage">
                            <span class="ac-room-badge">Most Private</span>
                        </div>
                        <div class="ac-room-body">
                            <h3 class="ac-room-title">Independent Cottage</h3>
                            <p class="ac-room-occ"><i class="fa-solid fa-user-group"></i> Double Occupancy</p>
                            <p class="ac-room-price">&#8377;2,500</p>
                            <p class="ac-room-price-note">per night &nbsp;|&nbsp; double occupancy</p>
                            <ul class="ac-room-amenities">
                                <li><i class="fa-solid fa-check"></i> Standalone private cottage</li>
                                <li><i class="fa-solid fa-check"></i> Direct forest access</li>
                                <li><i class="fa-solid fa-check"></i> Attached bathroom</li>
                                <li><i class="fa-solid fa-check"></i> Wi-Fi access</li>
                            </ul>
                            <div class="ac-room-cta"><a href="{{ route('booking') }}" class="ac-room-btn">Book This Cottage</a></div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Dining Add-On Note -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10 wow fadeInUp" data-wow-delay=".3s">
                    <div style="background:#faf8f3;border-radius:18px;padding:28px 32px;border:1px solid rgba(218,165,32,0.25);display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                        <div style="width:52px;height:52px;border-radius:50%;background:#DAA520;display:flex;align-items:center;justify-content:center;font-size:22px;color:#033631;flex-shrink:0;">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <div style="flex:1;">
                            <p style="font-size:16px;font-weight:700;color:#033631;margin:0 0 4px;">Add Dining to Your Stay</p>
                            <p style="font-size:14px;color:rgba(3,54,49,0.6);margin:0;">Meals are available at just <strong style="color:#DAA520;">&#8377;1,000 per person</strong> — includes traditional meals, multi-cuisine buffet and customised menus. <a href="{{ route('food-dining') }}" style="color:#033631;font-weight:700;">View the full dining menu &rarr;</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- AMENITIES -->
    <section class="ac-section ac-section-alt">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ac-label wow fadeInUp" data-wow-delay=".1s">Property Amenities</span>
                    <h2 class="ac-heading wow fadeInUp" data-wow-delay=".2s">Everything You Need for a <em>Perfect Stay</em></h2>
                    <div class="ac-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".05s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-snowflake"></i></div>
                        <p class="ac-amenity-title">Air Conditioning</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".1s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-wifi"></i></div>
                        <p class="ac-amenity-title">Free Wi-Fi</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".15s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-utensils"></i></div>
                        <p class="ac-amenity-title">In-House Dining</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".2s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-person-hiking"></i></div>
                        <p class="ac-amenity-title">Nature Walks</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".25s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-fire"></i></div>
                        <p class="ac-amenity-title">Bonfire</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".3s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-parking"></i></div>
                        <p class="ac-amenity-title">Free Parking</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".35s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-dumbbell"></i></div>
                        <p class="ac-amenity-title">Outdoor Sports</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".4s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-tree"></i></div>
                        <p class="ac-amenity-title">Forest Access</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".45s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-spa"></i></div>
                        <p class="ac-amenity-title">Yoga Lawn</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".5s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <p class="ac-amenity-title">24/7 Security</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".55s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-droplet"></i></div>
                        <p class="ac-amenity-title">Hot Water</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-4 wow fadeInUp" data-wow-delay=".6s">
                    <div class="ac-amenity-item">
                        <div class="ac-amenity-icon"><i class="fa-solid fa-certificate"></i></div>
                        <p class="ac-amenity-title">MP Tourism Certified</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA -->
    <section class="ac-section">
        <div class="container">
            <div class="ac-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="ac-label ac-label-light">Book Your Stay</span>
                    <h2 class="ac-heading ac-heading-light" style="margin-bottom:14px;">
                        Your Forest Getaway is <em>Ready for You</em>
                    </h2>
                    <p class="ac-body ac-body-light" style="max-width:520px;margin:0 auto 36px;">
                        Contact Sushma Kalambe to check availability, arrange a custom package, or book your room and cottage at Mahua House today.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('booking') }}" class="ac-btn ac-btn-gold"><i class="fa-solid fa-calendar-check me-2"></i>Book Now</a>
                        <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="ac-btn ac-btn-outline"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp</a>
                        <a href="tel:+919425651754" class="ac-btn ac-btn-outline"><i class="fa-solid fa-phone me-2"></i>Call Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

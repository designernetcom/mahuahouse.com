@extends('layouts.app')

@php
    $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
    $contactValue = fn ($key, $default = '') => optional($contact[$key] ?? null)->value ?? $default;
    $imageUrl = function ($url, $fallback = '') {
        $url = $url ?: $fallback;
        if (!$url) {
            return '';
        }
        return \Illuminate\Support\Str::startsWith($url, ['http://', 'https://', '/']) ? $url : asset($url);
    };
    $whatsappNumber = preg_replace('/\D+/', '', $setting('whatsapp_number', $contactValue('whatsapp', '919425651754')));
    $phoneDisplay = $setting('phone_primary', $contactValue('phone', '+91 9425651754'));
    $phoneHref = preg_replace('/\D+/', '', $phoneDisplay);
    $email = $setting('email_primary', $contactValue('email', 'mahuahouse17@gmail.com'));
    $facebookUrl = $setting('facebook_url', $contactValue('facebook', 'https://www.facebook.com/mahuahouse'));
    $heroImage = $setting('booking_hero_image', optional($galleryItems->get(0))->image_url ?? 'assets/images/about/14.jpeg');
    $contactImage = $setting('booking_contact_image', optional($galleryItems->get(1))->image_url ?? 'assets/images/about/8.jpeg');
    $policies = array_filter(array_map('trim', explode("\n", $setting('booking_policies', "Check-in & Out|Check-in from 11:00 AM|Check-out by 10:00 AM|Early check-in on request\nCancellations|Free cancellation 7+ days prior|Special terms for peak season|No-show policy applies\nChildren & Pets|Children of all ages welcome|Extra bed available on request|Pet policy on pre-arrangement\nGeneral Rules|No smoking inside rooms|Quiet hours after 10:00 PM|Respect the forest and wildlife"))));
    $meals = array_filter(array_map('trim', explode("\n", $setting('booking_meal_items', "Breakfast|Fresh poha, parathas, chai and seasonal fruits.\nLunch|Full dal-chawal-sabzi thali with homemade pickles and salad.\nEvening Snacks|Chai with namkeen or seasonal snacks.\nDinner|Traditional Madhya Pradesh dinner served family-style."))));
@endphp

@section('title', $setting('booking_meta_title', 'Book a Room | Mahua House'))
@section('meta_description', $setting('booking_meta_description', 'Book your stay at Mahua House.'))
@section('meta_keywords', $setting('booking_meta_keywords', 'Mahua House Booking, Forest Stay Bhopal, Eco Resort Booking'))

@section('styles')
<style>
    .bk-section { padding: 90px 0; }
    .bk-section-alt { background: #E7EEEE; }
    .bk-section-cream { background: #faf8f3; }
    .bk-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #DAA520; margin-bottom: 12px; }
    .bk-label-light { color: rgba(218,165,32,.9); }
    .bk-heading { font-size: clamp(28px, 3.5vw, 44px); font-weight: 700; color: #033631; line-height: 1.2; margin-bottom: 14px; }
    .bk-heading-light { color: #fff; }
    .bk-heading em { font-style: italic; color: #DAA520; }
    .bk-divider { display: flex; align-items: center; gap: 12px; color: #DAA520; margin-bottom: 22px; }
    .bk-divider.centered { justify-content: center; }
    .bk-divider span { display: block; width: 60px; height: 1px; background: #DAA520; }
    .bk-body { font-size: 15px; color: rgba(3,54,49,.62); line-height: 1.85; margin-bottom: 0; }
    .bk-body-light { color: rgba(255,255,255,.72); }
    .bk-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 32px; border-radius: 100px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all .3s ease; border: 2px solid transparent; cursor: pointer; }
    .bk-btn-primary { background:#033631; color:#fff; border-color:#033631; }
    .bk-btn-primary:hover { background:transparent; color:#033631; }
    .bk-btn-gold { background:#DAA520; color:#033631; border-color:#DAA520; }
    .bk-btn-gold:hover { background:transparent; color:#DAA520; }
    .bk-btn-green { background:#25D366; color:#fff; border-color:#25D366; }
    .bk-btn-green:hover { background:#1ebe5a; color:#fff; border-color:#1ebe5a; }
    .bk-btn-outline { background:transparent; color:#fff; border-color:rgba(255,255,255,.5); }
    .bk-btn-outline:hover { background:#DAA520; color:#033631; border-color:#DAA520; }
    .bk-btn-outline-dark { background:transparent; color:#033631; border-color:rgba(3,54,49,.35); }
    .bk-btn-outline-dark:hover { background:#033631; color:#fff; border-color:#033631; }
    .bk-hero { position: relative; min-height: 560px; background: var(--booking-hero) center / cover no-repeat; display: flex; align-items: flex-end; overflow: hidden; }
    .bk-hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(3,54,49,.2), rgba(3,54,49,.88)); }
    .bk-hero-content { position: relative; z-index: 2; padding-bottom: 90px; width: 100%; }
    .bk-breadcrumb { list-style: none; padding: 0; margin: 0 0 14px; display: flex; gap: 8px; }
    .bk-breadcrumb li { font-size: 13px; color: rgba(255,255,255,.58); }
    .bk-breadcrumb li a { color: #DAA520; text-decoration: none; }
    .bk-breadcrumb li + li::before { content: '/'; margin-right: 8px; }
    .bk-hero h1 { font-size: clamp(36px, 5vw, 68px); font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 18px; }
    .bk-hero p { font-size: 16px; color: rgba(255,255,255,.75); max-width: 560px; line-height: 1.75; margin-bottom: 30px; }
    .bk-hero-shape { position: absolute; bottom: 0; left: 0; right: 0; z-index: 2; line-height: 0; }
    .bk-hero-shape img { width: 100%; }
    .bk-how-banner { background: #DAA520; padding: 22px 0; }
    .bk-how-banner p { margin: 0; font-size: 15px; font-weight: 600; color: #033631; text-align: center; }
    .bk-how-banner a { color: #033631; text-decoration: underline; }
    .bk-room-card, .bk-policy-card, .bk-contact-card, .bk-form-card { background: #fff; border-radius: 18px; box-shadow: 0 6px 36px rgba(3,54,49,.10); overflow: hidden; height: 100%; }
    .bk-room-img { position: relative; height: 230px; overflow: hidden; }
    .bk-room-img img, .bk-contact-img img { width: 100%; height: 100%; object-fit: cover; }
    .bk-room-badge { position: absolute; top: 16px; left: 16px; background: #DAA520; color: #033631; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 14px; border-radius: 100px; }
    .bk-room-body { padding: 28px 28px 32px; }
    .bk-room-title { font-size: 20px; font-weight: 700; color: #033631; margin-bottom: 6px; }
    .bk-room-price { font-size: 28px; font-weight: 800; color: #DAA520; margin-bottom: 4px; line-height: 1; }
    .bk-room-price .per { font-size: 14px; color: rgba(3,54,49,.5); font-weight: 500; }
    .bk-room-occ { font-size: 12px; color: rgba(3,54,49,.55); margin-bottom: 20px; }
    .bk-amenity-list, .bk-policy-list { list-style: none; padding: 0; margin: 0; }
    .bk-amenity-list { margin-bottom: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px 12px; }
    .bk-amenity-list li, .bk-policy-list li { font-size: 13px; color: rgba(3,54,49,.7); display: flex; align-items: flex-start; gap: 8px; }
    .bk-amenity-list i, .bk-policy-list i { color: #DAA520; font-size: 12px; margin-top: 4px; }
    .bk-form-card { padding: 44px 40px; border: 1px solid rgba(3,54,49,.08); }
    .bk-field-label { font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #033631; margin-bottom: 7px; display:block; }
    .bk-input { border:1px solid rgba(3,54,49,.15); border-radius:10px; padding:13px 18px; font-size:14px; color:#033631; background:#fafafa; width:100%; }
    .bk-alert { border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-size: 14px; }
    .bk-alert-success { color: #033631; background: rgba(218,165,32,.18); border: 1px solid rgba(218,165,32,.35); }
    .bk-alert-error { color: #9b2d20; background: rgba(192,57,43,.08); border: 1px solid rgba(192,57,43,.2); }
    .bk-dining-card { background: #033631; border-radius: 18px; padding: 40px 36px; color: #fff; height: 100%; }
    .bk-dining-meal { display: flex; align-items: flex-start; gap: 14px; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,.1); }
    .bk-dining-meal:last-child { border-bottom: none; padding-bottom: 0; }
    .bk-dining-meal-icon, .bk-policy-icon, .bk-ci-icon { width: 44px; height: 44px; border-radius: 50%; background: rgba(218,165,32,.15); flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: #DAA520; font-size: 16px; }
    .bk-dining-meal-name, .bk-policy-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 3px; }
    .bk-dining-meal-desc { font-size: 13px; color: rgba(255,255,255,.65); margin: 0; }
    .bk-policy-card { padding: 28px 26px; }
    .bk-policy-icon { border-radius: 12px; background: rgba(3,54,49,.06); font-size: 20px; margin-bottom: 16px; }
    .bk-policy-title { color: #033631; font-size: 16px; margin-bottom: 12px; }
    .bk-contact-inner { display: grid; grid-template-columns: 1fr 1fr; align-items: center; }
    .bk-contact-img { height: 100%; min-height: 300px; }
    .bk-contact-body { padding: 48px 44px; }
    .bk-contact-info-item { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
    .bk-ci-icon { background: rgba(3,54,49,.06); font-size: 18px; }
    .bk-ci-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(3,54,49,.45); }
    .bk-ci-value { font-size: 15px; font-weight: 600; color: #033631; text-decoration: none; }
    .bk-cta-box { background: linear-gradient(135deg, #033631, #045e55); border-radius: 24px; padding: 70px 40px; text-align: center; position: relative; overflow: hidden; }
    @media (max-width: 991px) { .bk-hero { min-height: 480px; } .bk-section { padding: 70px 0; } .bk-contact-inner { grid-template-columns: 1fr; } .bk-contact-body { padding: 36px 28px; } }
    @media (max-width: 575px) { .bk-hero h1 { font-size: 32px; } .bk-amenity-list { grid-template-columns: 1fr; } .bk-form-card { padding: 28px 20px; } .bk-cta-box { padding: 48px 22px; } }
</style>
@endsection

@section('content')
    <section class="bk-hero" style="--booking-hero: url('{{ $imageUrl($heroImage, 'assets/images/about/14.jpeg') }}');">
        <div class="container bk-hero-content">
            <ul class="bk-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $setting('booking_breadcrumb', 'Book a Room') }}</li>
            </ul>
            <span class="bk-label wow fadeInUp" data-wow-delay=".2s">{{ $setting('booking_hero_label', 'Simple Booking') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $setting('booking_hero_heading', 'Reserve Your <em>Forest Stay</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $setting('booking_hero_text', 'Send us a WhatsApp message or submit a booking request and we will confirm your stay.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".5s">
                @if($whatsappNumber)
                    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="bk-btn bk-btn-green"><i class="fa-brands fa-whatsapp"></i> Book via WhatsApp</a>
                @endif
                <a href="#rooms" class="bk-btn bk-btn-outline">See All Rooms</a>
            </div>
        </div>
        <div class="bk-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    <div class="bk-how-banner">
        <div class="container">
            <p><i class="fa-brands fa-whatsapp me-2"></i>{!! $setting('booking_how_to_book', '<strong>How to Book:</strong> Choose your room, message us with your dates, or send the form below.') !!} @if($phoneHref)&nbsp;|&nbsp; <a href="tel:+{{ $phoneHref }}">Call: {{ $phoneDisplay }}</a>@endif</p>
        </div>
    </div>

    @if($rooms->isNotEmpty())
        <section class="bk-section" id="rooms">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="bk-label wow fadeInUp" data-wow-delay=".1s">{{ $setting('booking_rooms_label', 'Your Accommodation Options') }}</span>
                        <h2 class="bk-heading wow fadeInUp" data-wow-delay=".2s">{!! $setting('booking_rooms_heading', 'Choose Your <em>Room</em>') !!}</h2>
                        <div class="bk-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                        <p class="bk-body wow fadeInUp" data-wow-delay=".4s">{{ $setting('booking_rooms_text', 'Comfortable accommodation options surrounded by nature.') }}</p>
                    </div>
                </div>

                <div class="row g-4" id="bk-rooms-grid">
                    @foreach($rooms as $room)
                        @php
                            $roomMessage = rawurlencode('Hi, I would like to book the ' . $room->name . ' at Mahua House.');
                            $badgeColor = $room->badge_color ?: '#DAA520';
                        @endphp
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s">
                            <div class="bk-room-card">
                                <div class="bk-room-img">
                                    <img src="{{ $imageUrl($room->image_url, 'assets/images/room/room-1.jpg') }}" alt="{{ $room->name }}">
                                    @if($room->badge_text)
                                        <span class="bk-room-badge" style="background:{{ $badgeColor }};color:{{ strtolower($badgeColor) === '#ffffff' ? '#033631' : '#fff' }};">{{ $room->badge_text }}</span>
                                    @endif
                                </div>
                                <div class="bk-room-body">
                                    <h3 class="bk-room-title">{{ $room->name }}</h3>
                                    <div class="bk-room-price">&#8377;{{ number_format($room->price_per_night) }} <span class="per">/ night</span></div>
                                    <p class="bk-room-occ"><i class="fa-solid fa-user-group me-1"></i> Up to {{ $room->max_guests }} Guests @if($room->room_type)&nbsp;|&nbsp;{{ $room->room_type }}@endif</p>
                                    <ul class="bk-amenity-list">
                                        @foreach(array_slice($room->amenities ?? [], 0, 8) as $amenity)
                                            <li><i class="fa-solid fa-check"></i> {{ $amenity }}</li>
                                        @endforeach
                                    </ul>
                                    @if($whatsappNumber)
                                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $roomMessage }}" target="_blank" rel="noopener" class="bk-btn bk-btn-green w-100"><i class="fa-brands fa-whatsapp"></i> Book via WhatsApp</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="text-center mt-4" style="font-size:14px;color:rgba(3,54,49,.5);"><i class="fa-solid fa-circle-info me-1"></i>{{ $setting('booking_price_note', 'All prices are per night. Additional guests on request.') }}</p>
            </div>
        </section>
    @endif

    <section class="bk-section bk-section-cream" id="enquiry">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="bk-label wow fadeInUp" data-wow-delay=".1s">{{ $setting('booking_form_label', 'Online Enquiry') }}</span>
                    <h2 class="bk-heading wow fadeInUp" data-wow-delay=".2s">{!! $setting('booking_form_heading', 'Send a <em>Booking Request</em>') !!}</h2>
                    <div class="bk-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-paper-plane"></i><span></span></div>
                    <p class="bk-body wow fadeInUp" data-wow-delay=".4s">{{ $setting('booking_form_text', "Fill in your details and we'll confirm your booking via call or WhatsApp.") }}</p>
                </div>
            </div>
            <div class="row justify-content-center wow fadeInUp" data-wow-delay=".3s">
                <div class="col-lg-8">
                    <div class="bk-form-card">
                        @if(session('booking_success'))
                            <div class="bk-alert bk-alert-success"><i class="fa-solid fa-circle-check me-1"></i>{{ session('booking_success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="bk-alert bk-alert-error">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="bk-field-label">Full Name *</label>
                                    <input type="text" name="name" class="bk-input" value="{{ old('name') }}" placeholder="Your full name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="bk-field-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="bk-input" value="{{ old('phone') }}" placeholder="+91 00000 00000" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="bk-field-label">Email Address</label>
                                    <input type="email" name="email" class="bk-input" value="{{ old('email') }}" placeholder="your@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="bk-field-label">Room Preference</label>
                                    <select name="room_type" class="bk-input">
                                        <option value="">Any / Not sure yet</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->name }}" @selected(old('room_type') === $room->name)>{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="bk-field-label">Check-in Date</label>
                                    <input type="date" name="check_in" class="bk-input" value="{{ old('check_in') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="bk-field-label">Check-out Date</label>
                                    <input type="date" name="check_out" class="bk-input" value="{{ old('check_out') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="bk-field-label">Guests</label>
                                    <input type="number" name="guests" min="1" max="50" class="bk-input" value="{{ old('guests', 2) }}">
                                </div>
                                <div class="col-12">
                                    <label class="bk-field-label">Special Requests / Message</label>
                                    <textarea name="message" rows="4" class="bk-input" placeholder="Number of guests, dietary requirements, special occasions...">{{ old('message') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="bk-btn bk-btn-primary w-100" style="font-size:15px;padding:15px;"><i class="fa-solid fa-paper-plane"></i> Send Booking Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p class="text-center mt-3" style="font-size:13px;color:rgba(3,54,49,.5);"><i class="fa-solid fa-lock me-1" style="color:#DAA520;"></i>{{ $setting('booking_privacy_note', 'Your information is kept private and used only to confirm your booking.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bk-section bk-section-alt">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                    <span class="bk-label">{{ $setting('booking_dining_label', 'Add to Your Stay') }}</span>
                    <h2 class="bk-heading">{!! $setting('booking_dining_heading', 'Dining at <em>Mahua House</em>') !!}</h2>
                    <div class="bk-divider"><span></span><i class="fa-solid fa-utensils"></i><span></span></div>
                    <p class="bk-body mb-4">{{ $setting('booking_dining_text', 'Our traditional home-style meals are cooked fresh using locally sourced ingredients.') }}</p>
                    <div style="background:#033631;border-radius:14px;padding:22px 24px;display:inline-block;text-align:center;">
                        <div style="font-size:36px;font-weight:800;color:#DAA520;line-height:1;">{{ $setting('booking_meal_price', 'Rs. 1,000') }}</div>
                        <div style="font-size:13px;color:rgba(255,255,255,.7);margin-top:6px;">{{ $setting('booking_meal_price_note', 'per head - full day meal plan') }}</div>
                    </div>
                    @if($whatsappNumber)
                        <div class="mt-4"><a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode("Hi, I'd like to add a meal plan to my booking at Mahua House.") }}" target="_blank" rel="noopener" class="bk-btn bk-btn-primary"><i class="fa-brands fa-whatsapp"></i> Add Meal Plan</a></div>
                    @endif
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                    <div class="bk-dining-card">
                        <span class="bk-label bk-label-light">{{ $setting('booking_meal_list_label', "What's Included") }}</span>
                        <h3 style="font-size:22px;font-weight:700;color:#fff;margin-bottom:24px;">{{ $setting('booking_meal_list_heading', 'Full Day Meal Plan') }}</h3>
                        @foreach($meals as $meal)
                            @php
                                [$mealName, $mealDesc] = array_pad(explode('|', $meal, 2), 2, '');
                            @endphp
                            <div class="bk-dining-meal">
                                <div class="bk-dining-meal-icon"><i class="fa-solid fa-utensils"></i></div>
                                <div><div class="bk-dining-meal-name">{{ $mealName }}</div><p class="bk-dining-meal-desc">{{ $mealDesc }}</p></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bk-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="bk-label wow fadeInUp" data-wow-delay=".1s">{{ $setting('booking_policy_label', 'Before You Book') }}</span>
                    <h2 class="bk-heading wow fadeInUp" data-wow-delay=".2s">{!! $setting('booking_policy_heading', 'Stay <em>Policies</em>') !!}</h2>
                    <div class="bk-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-circle-info"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($policies as $policy)
                    @php
                        $parts = array_pad(explode('|', $policy), 4, '');
                        $title = array_shift($parts);
                    @endphp
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s">
                        <div class="bk-policy-card">
                            <div class="bk-policy-icon"><i class="fa-solid fa-circle-info"></i></div>
                            <h5 class="bk-policy-title">{{ $title }}</h5>
                            <ul class="bk-policy-list">
                                @foreach(array_filter($parts) as $point)
                                    <li><i class="fa-solid fa-circle-dot"></i> {{ $point }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bk-section bk-section-alt">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="bk-label wow fadeInUp" data-wow-delay=".1s">{{ $setting('booking_contact_label', 'Speak to Us Directly') }}</span>
                    <h2 class="bk-heading wow fadeInUp" data-wow-delay=".2s">{!! $setting('booking_contact_heading', 'Your Booking <em>Contact</em>') !!}</h2>
                    <div class="bk-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-phone"></i><span></span></div>
                    <p class="bk-body wow fadeInUp" data-wow-delay=".4s">{{ $setting('booking_contact_text', 'Reach out directly to confirm your booking, ask about packages, or customise your stay experience.') }}</p>
                </div>
            </div>

            <div class="bk-contact-card wow fadeInUp" data-wow-delay=".3s">
                <div class="bk-contact-inner">
                    <div class="bk-contact-img"><img src="{{ $imageUrl($contactImage, 'assets/images/about/8.jpeg') }}" alt="{{ $setting('booking_contact_image_alt', 'Mahua House Property') }}"></div>
                    <div class="bk-contact-body">
                        <span class="bk-label">{{ $setting('booking_host_label', 'Your Host') }}</span>
                        <h3 class="bk-heading" style="font-size:28px;margin-bottom:6px;">{{ $setting('booking_host_name', 'Mahua House Team') }}</h3>
                        <p class="bk-body" style="margin-bottom:28px;">{{ $setting('booking_host_description', $setting('address', $contactValue('address', 'Raisen Road, Bhopal'))) }}</p>

                        @if($whatsappNumber)
                            <div class="bk-contact-info-item"><div class="bk-ci-icon"><i class="fa-brands fa-whatsapp"></i></div><div><div class="bk-ci-label">WhatsApp</div><a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="bk-ci-value">{{ $phoneDisplay }}</a></div></div>
                        @endif
                        @if($phoneHref)
                            <div class="bk-contact-info-item"><div class="bk-ci-icon"><i class="fa-solid fa-phone"></i></div><div><div class="bk-ci-label">Phone</div><a href="tel:+{{ $phoneHref }}" class="bk-ci-value">{{ $phoneDisplay }}</a></div></div>
                        @endif
                        @if($email)
                            <div class="bk-contact-info-item"><div class="bk-ci-icon"><i class="fa-solid fa-envelope"></i></div><div><div class="bk-ci-label">Email</div><a href="mailto:{{ $email }}" class="bk-ci-value">{{ $email }}</a></div></div>
                        @endif
                        <div class="d-flex gap-3 flex-wrap mt-4">
                            @if($whatsappNumber)<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="bk-btn bk-btn-green"><i class="fa-brands fa-whatsapp"></i> WhatsApp Now</a>@endif
                            <a href="{{ route('contact') }}" class="bk-btn bk-btn-outline-dark">Send an Enquiry</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bk-section">
        <div class="container">
            <div class="bk-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="bk-label bk-label-light">{{ $setting('booking_cta_label', 'Ready to Book?') }}</span>
                    <h2 class="bk-heading bk-heading-light" style="margin-bottom:14px;">{!! $setting('booking_cta_heading', 'Your Forest Escape <em>Awaits</em>') !!}</h2>
                    <p class="bk-body bk-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $setting('booking_cta_text', "Book via WhatsApp, give us a call, or send an enquiry. We'll confirm your stay and welcome you to the forest.") }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="bk-btn bk-btn-outline"><i class="fa-brands fa-facebook-f"></i>Visit Facebook</a>@endif
                        @if($whatsappNumber)<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="bk-btn bk-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        <a href="{{ route('contact') }}" class="bk-btn bk-btn-outline">Enquire Today</a>
                        @if($phoneHref)<a href="tel:+{{ $phoneHref }}" class="bk-btn bk-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

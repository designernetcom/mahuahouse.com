@extends('layouts.app')

@php
    $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
    $section = fn ($key, $default = '') => $sections[$key] ?? $setting('events_' . $key, $default);
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
    $facebookUrl = $setting('facebook_url', $contactValue('facebook', 'https://www.facebook.com/mahuahouse'));

    $eventCards = $eventTypes->map(fn ($item) => [
        'title' => $item->title,
        'description' => $item->description,
        'icon' => $item->icon ?: 'fa-solid fa-calendar-check',
        'image' => $item->image_url,
        'tag' => $item->link ?: 'Event',
    ]);
    if ($eventCards->isEmpty()) {
        $eventCards = collect([
            ['title' => 'Destination Weddings', 'description' => 'Ceremonies, receptions, mehendi and sangeet in a forest setting.', 'icon' => 'fa-solid fa-heart', 'image' => 'assets/images/about/12.jpeg', 'tag' => 'Most Popular'],
            ['title' => 'Corporate Retreats', 'description' => 'Team building, offsites, workshops and leadership programs.', 'icon' => 'fa-solid fa-briefcase', 'image' => 'assets/images/about/20.jpeg', 'tag' => 'Business'],
            ['title' => 'Picnic & Day Outings', 'description' => 'A full day of nature, activities, food and fresh air for groups.', 'icon' => 'fa-solid fa-sun', 'image' => 'assets/images/about/30.jpeg', 'tag' => 'Day Out'],
        ]);
    }

    $venueCards = $venueItems->map(fn ($item) => [
        'title' => $item->title,
        'description' => $item->description,
        'icon' => $item->icon ?: 'fa-solid fa-location-dot',
        'image' => $item->image_url,
        'tag' => $item->link ?: 'Venue',
    ]);
    if ($venueCards->isEmpty()) {
        $venueCards = collect([
            ['title' => 'Mahua Vedika', 'description' => 'A spacious outdoor setting for weddings, receptions and large celebrations.', 'icon' => 'fa-solid fa-users', 'image' => 'assets/images/about/70.jpeg', 'tag' => 'Grand Venue'],
            ['title' => 'Chaupal-e-Mahua', 'description' => 'A warm gathering space for rituals, family events and intimate celebrations.', 'icon' => 'fa-solid fa-people-roof', 'image' => 'assets/images/about/75.jpeg', 'tag' => 'Intimate'],
            ['title' => 'Full Property Exclusive', 'description' => 'Book the entire property for multi-day weddings, retreats and private events.', 'icon' => 'fa-solid fa-lock', 'image' => 'assets/images/about/85.jpeg', 'tag' => 'Exclusive'],
        ]);
    }

    $featureCards = $whyHostItems->map(fn ($item) => [
        'title' => $item->title,
        'description' => $item->description,
        'icon' => $item->icon ?: 'fa-solid fa-check',
    ]);
    if ($featureCards->isEmpty()) {
        $featureCards = collect([
            ['title' => 'Forest Backdrop', 'description' => 'Natural scenery, open skies and quiet surroundings for memorable gatherings.', 'icon' => 'fa-solid fa-tree'],
            ['title' => 'Event Support', 'description' => 'Coordination support for decor, food, sound, seating and guest flow.', 'icon' => 'fa-solid fa-handshake-angle'],
            ['title' => 'Stay & Dining', 'description' => 'Rooms, cottages and meal plans can be combined with your event package.', 'icon' => 'fa-solid fa-utensils'],
        ]);
    }

    $galleryCards = $galleryItems->isNotEmpty()
        ? $galleryItems->map(fn ($item) => ['title' => $item->title, 'image' => $item->image_url])
        : collect([
            ['title' => 'Event', 'image' => 'assets/images/about/16.jpeg'],
            ['title' => 'Event', 'image' => 'assets/images/about/22.jpeg'],
            ['title' => 'Event', 'image' => 'assets/images/about/28.jpeg'],
            ['title' => 'Event', 'image' => 'assets/images/about/32.jpeg'],
            ['title' => 'Event', 'image' => 'assets/images/about/38.jpeg'],
            ['title' => 'Event', 'image' => 'assets/images/about/42.jpeg'],
        ]);

    $steps = collect(array_filter(array_map('trim', explode("\n", $section('steps', "Initial Enquiry|Call, email, or fill our enquiry form with your event type, date and guest count.|fa-solid fa-phone\nSite Visit & Planning|Explore the venue and shape your event plan with our team.|fa-solid fa-map-location-dot\nCustomise & Confirm|Finalise decor, menus, entertainment and timeline.|fa-solid fa-palette\nYour Perfect Event|Arrive, relax and celebrate while our team manages the day.|fa-solid fa-star")))))
        ->map(function ($row) {
            [$title, $text, $icon] = array_pad(explode('|', $row, 3), 3, '');
            return ['title' => $title, 'text' => $text, 'icon' => $icon ?: 'fa-solid fa-star'];
        });

    $heroImage = $section('hero_image', 'assets/images/about/7.jpeg');
    $whyImage = $section('why_image', 'assets/images/about/25.jpeg');
@endphp

@section('title', $section('meta_title', 'Events | Mahua House'))
@section('meta_description', $section('meta_description', 'Host weddings, corporate retreats, birthdays and private events at Mahua House near Bhopal.'))
@section('meta_keywords', $section('meta_keywords', 'Events Mahua House, Forest Event Venue Bhopal, Wedding Venue, Corporate Retreat'))

@section('styles')
<style>
    .ev-section { padding: 90px 0; }
    .ev-section-alt { background: #E7EEEE; }
    .ev-section-dark { background: #033631; }
    .ev-section-cream { background: #faf8f3; }
    .ev-label { display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px; }
    .ev-label-light { color:rgba(218,165,32,.9); }
    .ev-heading { font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px; }
    .ev-heading-light { color:#fff; }
    .ev-heading em { font-style:italic;color:#DAA520; }
    .ev-divider { display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px; }
    .ev-divider.centered { justify-content:center; }
    .ev-divider span { display:block;width:60px;height:1px;background:#DAA520; }
    .ev-body { font-size:15px;color:rgba(3,54,49,.62);line-height:1.85;margin-bottom:0; }
    .ev-body-light { color:rgba(255,255,255,.68); }
    .ev-btn { display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer; }
    .ev-btn-primary { background:#033631;color:#fff;border-color:#033631; }
    .ev-btn-primary:hover { background:transparent;color:#033631; }
    .ev-btn-gold { background:#DAA520;color:#033631;border-color:#DAA520; }
    .ev-btn-gold:hover { background:transparent;color:#DAA520; }
    .ev-btn-outline { background:transparent;color:#fff;border-color:rgba(255,255,255,.45); }
    .ev-btn-outline:hover { background:#DAA520;color:#033631;border-color:#DAA520; }
    .ev-btn-outline-green { background:transparent;color:#033631;border-color:rgba(3,54,49,.35); }
    .ev-btn-outline-green:hover { background:#033631;color:#fff;border-color:#033631; }
    .ev-hero { position:relative;min-height:580px;background:var(--event-hero) center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden; }
    .ev-hero::before { content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.28),rgba(3,54,49,.86)); }
    .ev-hero-content { position:relative;z-index:2;padding-bottom:80px;width:100%; }
    .ev-breadcrumb { list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px; }
    .ev-breadcrumb li { font-size:13px;color:rgba(255,255,255,.55); }
    .ev-breadcrumb li a { color:#DAA520;text-decoration:none; }
    .ev-breadcrumb li + li::before { content:'/';margin-right:8px; }
    .ev-hero h1 { font-size:clamp(34px,5vw,64px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px; }
    .ev-hero p { font-size:16px;color:rgba(255,255,255,.78);max-width:580px;line-height:1.75;margin-bottom:30px; }
    .ev-hero-shape { position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0; }
    .ev-hero-shape img { width:100%; }
    .ev-type-card { position:relative;border-radius:20px;overflow:hidden;height:340px; }
    .ev-type-card img,.ev-venue-img img,.ev-gallery-grid .eg img { width:100%;height:100%;object-fit:cover;transition:transform .55s ease; }
    .ev-type-card:hover img,.ev-venue-card:hover img,.ev-gallery-grid .eg:hover img { transform:scale(1.07); }
    .ev-type-overlay { position:absolute;inset:0;background:linear-gradient(to top,rgba(3,54,49,.92),rgba(3,54,49,.3) 55%,transparent);display:flex;flex-direction:column;justify-content:flex-end;padding:28px 26px; }
    .ev-type-icon { width:48px;height:48px;border-radius:12px;background:rgba(218,165,32,.2);border:1px solid rgba(218,165,32,.4);display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:20px;margin-bottom:14px; }
    .ev-type-title { font-size:20px;font-weight:700;color:#fff;margin-bottom:8px; }
    .ev-type-desc { font-size:13px;color:rgba(255,255,255,.7);line-height:1.65;margin:0; }
    .ev-type-tag { display:inline-block;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#DAA520;margin-bottom:8px; }
    .ev-feature-item { display:flex;align-items:flex-start;gap:18px;padding:22px 0;border-bottom:1px solid rgba(3,54,49,.08); }
    .ev-feature-item:last-child { border-bottom:none; }
    .ev-feature-icon { width:52px;height:52px;min-width:52px;border-radius:14px;background:rgba(3,54,49,.07);display:flex;align-items:center;justify-content:center;color:#033631;font-size:20px; }
    .ev-feature-title { font-size:16px;font-weight:700;color:#033631;margin-bottom:5px; }
    .ev-feature-text { font-size:14px;color:rgba(3,54,49,.58);line-height:1.7;margin:0; }
    .ev-venue-card { background:#fff;border-radius:18px;overflow:hidden;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 24px rgba(3,54,49,.07);height:100%; }
    .ev-venue-img { position:relative;height:220px;overflow:hidden; }
    .ev-venue-badge { position:absolute;top:14px;left:14px;background:#DAA520;color:#033631;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:5px 12px;border-radius:100px; }
    .ev-venue-body { padding:26px; }
    .ev-venue-title { font-size:18px;font-weight:700;color:#033631;margin-bottom:8px; }
    .ev-venue-text { font-size:13px;color:rgba(3,54,49,.58);line-height:1.7;margin-bottom:18px; }
    .ev-venue-specs { display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px; }
    .ev-venue-spec { display:flex;align-items:center;gap:6px;font-size:12px;color:rgba(3,54,49,.62);font-weight:500; }
    .ev-venue-spec i { color:#DAA520;font-size:11px; }
    .ev-gallery-grid { display:grid;grid-template-columns:repeat(4,1fr);grid-template-rows:220px 220px;gap:10px; }
    .ev-gallery-grid .eg { border-radius:14px;overflow:hidden;position:relative; }
    .ev-gallery-grid .eg-wide { grid-column:span 2; }
    .ev-gallery-grid .eg-overlay { position:absolute;inset:0;background:rgba(3,54,49,.4);opacity:0;transition:opacity .35s ease;display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:26px; }
    .ev-gallery-grid .eg:hover .eg-overlay { opacity:1; }
    .ev-step-card { text-align:center;padding:36px 24px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:18px;height:100%;position:relative;margin:8px; }
    .ev-step-num { font-size:60px;font-weight:900;line-height:1;color:rgba(218,165,32,.15);position:absolute;top:16px;right:20px;font-family:Georgia,serif; }
    .ev-step-icon { width:64px;height:64px;border-radius:50%;background:rgba(218,165,32,.15);display:inline-flex;align-items:center;justify-content:center;color:#DAA520;font-size:24px;margin-bottom:20px; }
    .ev-step-title { font-size:17px;font-weight:700;color:#fff;margin-bottom:10px; }
    .ev-step-text { font-size:13px;color:rgba(255,255,255,.6);line-height:1.75;margin:0; }
    .ev-form-wrap { background:#fff;border-radius:20px;padding:48px 44px;box-shadow:0 8px 40px rgba(3,54,49,.1);border:1px solid rgba(3,54,49,.08); }
    .ev-form-label { font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#033631;margin-bottom:7px;display:block; }
    .ev-input { border:1px solid rgba(3,54,49,.15);border-radius:10px;padding:13px 16px;font-size:14px;color:#033631;background:#fafafa;width:100%; }
    .ev-alert { background:rgba(25,135,84,.1);border:1px solid rgba(25,135,84,.3);border-radius:12px;padding:16px 20px;margin-bottom:24px;color:#146c43;font-weight:500;font-size:14px; }
    .ev-cta-box { background:linear-gradient(135deg,#033631,#07554D);border-radius:24px;padding:70px 60px;text-align:center;position:relative;overflow:hidden; }
    @media (max-width:1199px){.ev-gallery-grid{grid-template-columns:repeat(3,1fr);grid-template-rows:200px 200px 200px}.ev-gallery-grid .eg-wide{grid-column:span 1}}
    @media (max-width:991px){.ev-hero{min-height:460px}.ev-section{padding:70px 0}.ev-cta-box{padding:50px 30px}}
    @media (max-width:767px){.ev-gallery-grid{grid-template-columns:1fr 1fr;grid-template-rows:repeat(3,180px)}}
    @media (max-width:575px){.ev-hero h1{font-size:32px}.ev-cta-box,.ev-form-wrap{padding:34px 20px}.ev-gallery-grid{grid-template-columns:1fr;grid-template-rows:repeat(6,180px)}}
</style>
@endsection

@section('content')
    <section class="ev-hero" style="--event-hero: url('{{ $imageUrl($heroImage, 'assets/images/about/7.jpeg') }}');">
        <div class="container ev-hero-content">
            <ul class="ev-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $section('breadcrumb', 'Events') }}</li>
            </ul>
            <span class="ev-label wow fadeInUp" data-wow-delay=".2s">{{ $section('hero_label', 'Celebrate in the Forest') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $section('hero_heading', 'Unforgettable <em>Events</em><br>in Nature\'s Embrace') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $section('hero_text', 'From intimate gatherings to grand celebrations, Mahua House provides a one-of-a-kind forest setting for every occasion that matters.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".5s">
                <a href="#enquire" class="ev-btn ev-btn-gold">Plan Your Event</a>
                <a href="#event-types" class="ev-btn ev-btn-outline">Explore Events</a>
            </div>
        </div>
        <div class="ev-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    <section class="ev-section" id="event-types">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ev-label wow fadeInUp" data-wow-delay=".1s">{{ $section('types_label', 'What We Host') }}</span>
                    <h2 class="ev-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('types_heading', 'Events for <em>Every Occasion</em>') !!}</h2>
                    <div class="ev-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="ev-body wow fadeInUp" data-wow-delay=".4s">{{ $section('types_text', 'Whatever the celebration, our forest provides a backdrop that no banquet hall ever could.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($eventCards as $item)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s">
                        <div class="ev-type-card">
                            <img src="{{ $imageUrl($item['image'], 'assets/images/about/12.jpeg') }}" alt="{{ $item['title'] }}">
                            <div class="ev-type-overlay">
                                <span class="ev-type-tag">{{ $item['tag'] }}</span>
                                <div class="ev-type-icon"><i class="{{ $item['icon'] }}"></i></div>
                                <h4 class="ev-type-title">{{ $item['title'] }}</h4>
                                <p class="ev-type-desc">{{ $item['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ev-section ev-section-alt">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                    <div style="position:relative;border-radius:20px;overflow:hidden;height:520px;">
                        <img src="{{ $imageUrl($whyImage, 'assets/images/about/25.jpeg') }}" alt="Event at Mahua House" style="width:100%;height:100%;object-fit:cover;">
                        <div style="position:absolute;bottom:24px;left:24px;right:24px;background:rgba(3,54,49,.92);border-radius:14px;padding:20px 22px;display:flex;align-items:center;gap:16px;">
                            <div style="width:48px;height:48px;border-radius:50%;background:#DAA520;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:20px;color:#033631;"><i class="fa-solid fa-trophy"></i></div>
                            <div><p style="font-size:16px;font-weight:700;color:#fff;margin:0;line-height:1.2;">{{ $section('why_badge_title', 'MP Tourism Accredited') }}</p><p style="font-size:12px;color:rgba(255,255,255,.6);margin:0;">{{ $section('why_badge_text', 'Trusted nature retreat on Raisen Road, Bhopal') }}</p></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                    <span class="ev-label">{{ $section('why_label', 'Why Host Here') }}</span>
                    <h2 class="ev-heading">{!! $section('why_heading', 'A Venue That Feels <em>Alive</em>') !!}</h2>
                    <div class="ev-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    <p class="ev-body mb-4">{{ $section('why_text', 'Mahua House combines a forest setting with practical event support, making celebrations beautiful, grounded and easy to manage.') }}</p>
                    @foreach($featureCards as $feature)
                        <div class="ev-feature-item">
                            <div class="ev-feature-icon"><i class="{{ $feature['icon'] }}"></i></div>
                            <div><h5 class="ev-feature-title">{{ $feature['title'] }}</h5><p class="ev-feature-text">{{ $feature['description'] }}</p></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="ev-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ev-label wow fadeInUp" data-wow-delay=".1s">{{ $section('venues_label', 'Spaces & Venues') }}</span>
                    <h2 class="ev-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('venues_heading', 'Choose Your <em>Forest Setting</em>') !!}</h2>
                    <div class="ev-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($venueCards as $venue)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s">
                        <div class="ev-venue-card">
                            <div class="ev-venue-img">
                                <img src="{{ $imageUrl($venue['image'], 'assets/images/about/70.jpeg') }}" alt="{{ $venue['title'] }}">
                                <span class="ev-venue-badge">{{ $venue['tag'] }}</span>
                            </div>
                            <div class="ev-venue-body">
                                <h4 class="ev-venue-title">{{ $venue['title'] }}</h4>
                                <p class="ev-venue-text">{{ $venue['description'] }}</p>
                                <div class="ev-venue-specs"><span class="ev-venue-spec"><i class="{{ $venue['icon'] }}"></i> {{ $venue['tag'] }}</span></div>
                                <a href="#enquire" class="ev-btn ev-btn-outline-green" style="font-size:13px;padding:10px 22px;">Enquire</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ev-section ev-section-cream">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="ev-label wow fadeInUp" data-wow-delay=".1s">{{ $section('gallery_label', 'Event Gallery') }}</span>
                    <h2 class="ev-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('gallery_heading', 'Moments from Our <em>Forest Events</em>') !!}</h2>
                </div>
                <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s"><a href="#enquire" class="ev-btn ev-btn-primary">Plan Your Event</a></div>
            </div>
            <div class="ev-gallery-grid wow fadeInUp" data-wow-delay=".3s">
                @foreach($galleryCards as $item)
                    <div class="eg {{ $loop->first || $loop->last ? 'eg-wide' : '' }}"><img src="{{ $imageUrl($item['image'], 'assets/images/about/16.jpeg') }}" alt="{{ $item['title'] }}"><div class="eg-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ev-section ev-section-dark">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ev-label ev-label-light wow fadeInUp" data-wow-delay=".1s">{{ $section('steps_label', 'How It Works') }}</span>
                    <h2 class="ev-heading ev-heading-light wow fadeInUp" data-wow-delay=".2s">{!! $section('steps_heading', 'Your Event in <em>4 Easy Steps</em>') !!}</h2>
                    <div class="ev-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row align-items-start g-0 wow fadeInUp" data-wow-delay=".3s">
                @foreach($steps as $step)
                    <div class="col-lg-3 col-md-6">
                        <div class="ev-step-card">
                            <span class="ev-step-num">{{ $loop->iteration }}</span>
                            <div class="ev-step-icon"><i class="{{ $step['icon'] }}"></i></div>
                            <h5 class="ev-step-title">{{ $step['title'] }}</h5>
                            <p class="ev-step-text">{{ $step['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ev-section ev-section-alt" id="enquire">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ev-label wow fadeInUp" data-wow-delay=".1s">{{ $section('form_label', 'Get In Touch') }}</span>
                    <h2 class="ev-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('form_heading', 'Start Planning Your <em>Event Today</em>') !!}</h2>
                    <div class="ev-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="ev-body wow fadeInUp" data-wow-delay=".4s">{{ $section('form_text', 'Fill in your details and our events team will respond with availability and a tailored proposal.') }}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 wow fadeInUp" data-wow-delay=".3s">
                    <div class="ev-form-wrap">
                        @if(session('enquiry_success'))
                            <div class="ev-alert"><i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="ev-alert" style="background:rgba(192,57,43,.08);border-color:rgba(192,57,43,.25);color:#9b2d20;">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('enquiry.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="events">
                            <div class="row g-4">
                                <div class="col-md-4"><label class="ev-form-label">Full Name *</label><input type="text" name="name" class="ev-input" placeholder="Your name" value="{{ old('name') }}" required></div>
                                <div class="col-md-4"><label class="ev-form-label">Email Address</label><input type="email" name="email" class="ev-input" placeholder="your@email.com" value="{{ old('email') }}"></div>
                                <div class="col-md-4"><label class="ev-form-label">Phone Number *</label><input type="tel" name="phone" class="ev-input" placeholder="+91 00000 00000" value="{{ old('phone') }}" required></div>
                                <div class="col-md-4">
                                    <label class="ev-form-label">Event Type</label>
                                    <select name="room_type" class="ev-input">
                                        <option value="">Select event type</option>
                                        @foreach($eventCards as $item)<option @selected(old('room_type') === $item['title'])>{{ $item['title'] }}</option>@endforeach
                                        <option @selected(old('room_type') === 'Other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><label class="ev-form-label">Event Date</label><input type="date" name="check_in" class="ev-input" value="{{ old('check_in') }}"></div>
                                <div class="col-md-4">
                                    <label class="ev-form-label">Guest Range</label>
                                    <select id="ev_guest_range" class="ev-input">
                                        <option value="">Select range</option>
                                        <option>Up to 25</option><option>26 - 50</option><option>51 - 100</option><option>101 - 150</option><option>151 - 300</option><option>300+</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="ev-form-label">Preferred Venue</label>
                                    <select name="subject" class="ev-input">
                                        <option value="">Select venue</option>
                                        @foreach($venueCards as $item)<option @selected(old('subject') === $item['title'])>{{ $item['title'] }}</option>@endforeach
                                        <option>Not Sure Yet</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="ev-form-label">Budget Range</label>
                                    <select id="ev_budget" class="ev-input">
                                        <option value="">Approximate budget</option>
                                        <option>Under Rs. 50,000</option><option>Rs. 50,000 - Rs. 1,50,000</option><option>Rs. 1,50,000 - Rs. 4,00,000</option><option>Rs. 4,00,000 - Rs. 10,00,000</option><option>Above Rs. 10,00,000</option>
                                    </select>
                                </div>
                                <div class="col-12"><label class="ev-form-label">Tell Us About Your Event</label><textarea name="message" class="ev-input" rows="4" placeholder="Share your vision, theme, special requirements, or any questions...">{{ old('message') }}</textarea></div>
                                <div class="col-12"><button type="submit" class="ev-btn ev-btn-primary w-100" style="font-size:15px;border-radius:12px;padding:16px;"><i class="fa-solid fa-paper-plane"></i> Send Event Enquiry</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ev-section">
        <div class="container">
            <div class="ev-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="ev-label ev-label-light">{{ $section('cta_label', "Let's Create Something") }}</span>
                    <h2 class="ev-heading ev-heading-light" style="margin-bottom:14px;">{!! $section('cta_heading', 'Your Forest Event is <em>One Call Away</em>') !!}</h2>
                    <p class="ev-body ev-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $section('cta_text', "From the first conversation to the final farewell, we're with you every step.") }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="ev-btn ev-btn-outline"><i class="fa-brands fa-facebook-f"></i>Visit Facebook</a>@endif
                        @if($whatsappNumber)<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="ev-btn ev-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        <a href="{{ route('contact') }}" class="ev-btn ev-btn-outline">Enquire Today</a>
                        @if($phoneHref)<a href="tel:+{{ $phoneHref }}" class="ev-btn ev-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
(function() {
    var form = document.querySelector('form[action="{{ route('enquiry.store') }}"]');
    if (!form) return;
    form.addEventListener('submit', function() {
        var budget = document.getElementById('ev_budget') ? document.getElementById('ev_budget').value : '';
        var guests = document.getElementById('ev_guest_range') ? document.getElementById('ev_guest_range').value : '';
        var msgField = form.querySelector('textarea[name="message"]');
        if (!msgField) return;
        var extras = [];
        if (guests && !msgField.value.includes('Guest Range:')) extras.push('Guest Range: ' + guests);
        if (budget && !msgField.value.includes('Budget:')) extras.push('Budget: ' + budget);
        if (extras.length) msgField.value = (msgField.value ? msgField.value + "\n\n" : '') + extras.join("\n");
    });
})();
</script>
@endsection

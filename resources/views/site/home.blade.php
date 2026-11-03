@extends('layouts.app')

@php
    $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
    $section = fn ($key, $default = '') => $sections[$key] ?? $setting('home_' . $key, $default);
    $contactValue = fn ($key, $default = '') => optional($contact[$key] ?? null)->value ?? $default;
    $imageUrl = function ($url, $fallback = '') {
        $url = $url ?: $fallback;
        if (!$url) {
            return '';
        }
        return \Illuminate\Support\Str::startsWith($url, ['http://', 'https://', '/']) ? $url : asset($url);
    };
    $whatsappNumber = preg_replace('/\D+/', '', $setting('whatsapp_number', $contactValue('whatsapp', '919425651754')));
    $facebookUrl = $setting('facebook_url', $contactValue('facebook', 'https://www.facebook.com/mahuahouse'));
    $mapsUrl = $setting('maps_url', $contactValue('google_maps', 'https://maps.app.goo.gl/K2ag8CT2Nza4JZrb9'));
    $hero = $heroSlides->first();
    $introImages = $galleryItems->take(3)->values();
@endphp

@section('title', $section('meta_title', 'Home | ' . $setting('site_name', 'Mahua House')))
@section('meta_description', $section('meta_description', $setting('site_description', 'Mahua House - A serene eco-resort nestled in Bhopal forest.')))
@section('meta_keywords', $section('meta_keywords', $setting('meta_keywords', 'Mahua House, Eco Resort Bhopal, Forest Retreat')))

@section('styles')
<style>
    .hm-section { padding: 90px 0; }
    .hm-section-alt { background: #E7EEEE; }
    .hm-section-cream { background: #faf8f3; }
    .hm-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #DAA520; margin-bottom: 12px; }
    .hm-label-light { color: rgba(218,165,32,0.9); }
    .hm-heading { font-size: clamp(28px, 3.5vw, 46px); font-weight: 700; color: #033631; line-height: 1.15; margin-bottom: 16px; }
    .hm-heading-light { color: #fff; }
    .hm-heading em { font-style: italic; color: #DAA520; }
    .hm-divider { display: flex; align-items: center; gap: 12px; color: #DAA520; margin-bottom: 24px; }
    .hm-divider.centered { justify-content: center; }
    .hm-divider span { display: block; width: 60px; height: 1px; background: #DAA520; }
    .hm-body { font-size: 15px; color: rgba(3,54,49,0.62); line-height: 1.85; margin-bottom: 0; }
    .hm-body-light { color: rgba(255,255,255,0.72); }
    .hm-btn { display: inline-block; padding: 13px 32px; border-radius: 100px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all .3s ease; border: 2px solid transparent; }
    .hm-btn-primary { background: #033631; color: #fff; border-color: #033631; }
    .hm-btn-primary:hover { background: transparent; color: #033631; }
    .hm-btn-gold { background: #DAA520; color: #033631; border-color: #DAA520; }
    .hm-btn-gold:hover { background: transparent; color: #DAA520; }
    .hm-btn-outline { background: transparent; color: #fff; border-color: rgba(255,255,255,.45); }
    .hm-btn-outline:hover { background: #DAA520; color: #033631; border-color: #DAA520; }
    .hm-hero { position: relative; height: 100vh; min-height: 620px; overflow: hidden; }
    .hm-hero-slide { position: absolute; inset: 0; background-size: cover; background-position: center; opacity: 0; transition: opacity 1.2s ease; z-index: 1; }
    .hm-hero-slide.active { opacity: 1; z-index: 2; }
    .hm-hero-slide::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(3,54,49,.3), rgba(3,54,49,.15) 40%, rgba(3,54,49,.72)); }
    .hm-hero-content { position: relative; z-index: 10; height: 100%; display: flex; flex-direction: column; align-items: flex-start; justify-content: flex-end; padding-bottom: 110px; }
    .hm-hero h1 { font-size: clamp(30px, 5vw, 58px); font-weight: 800; color: #fff; line-height: 1.08; margin-bottom: 20px; }
    .hm-hero h1 em { font-style: italic; color: #DAA520; }
    .hm-hero-sub { font-size: 17px; color: rgba(255,255,255,.78); line-height: 1.7; max-width: 620px; margin-bottom: 36px; }
    .hm-hero-controls { position: absolute; bottom: 36px; right: 40px; z-index: 10; display: flex; gap: 14px; }
    .hm-hero-btn { width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3); color: #fff; display: flex; align-items: center; justify-content: center; }
    .hm-hero-btn:hover { background: #DAA520; border-color: #DAA520; color: #033631; }
    .hm-hero-dots { position: absolute; bottom: 44px; left: 50%; transform: translateX(-50%); z-index: 10; display: flex; gap: 8px; }
    .hm-hero-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.35); cursor: pointer; transition: all .3s ease; }
    .hm-hero-dot.active { background: #DAA520; width: 28px; border-radius: 4px; }
    .hm-hero-scroll { position: absolute; bottom: 36px; left: 40px; z-index: 10; color: rgba(255,255,255,.5); font-size: 12px; letter-spacing: 2px; text-transform: uppercase; writing-mode: vertical-lr; transform: rotate(180deg); }
    .hm-hero-shape { position: absolute; bottom: 0; left: 0; right: 0; z-index: 5; line-height: 0; pointer-events: none; }
    .hm-hero-shape img { width: 100%; }
    .hm-intro-img-grid { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 340px 200px; gap: 12px; }
    .hm-intro-img-grid .img-tall { grid-row: span 2; border-radius: 18px; overflow: hidden; }
    .hm-intro-img-grid .img-sm { border-radius: 14px; overflow: hidden; }
    .hm-intro-img-grid img, .hm-exp-card img, .hm-room-img img, .hm-gallery-strip .gph img { width: 100%; height: 100%; object-fit: cover; transition: transform .55s ease; }
    .hm-founded-badge { position: absolute; bottom: 20px; left: 20px; background: #DAA520; border-radius: 14px; padding: 14px 20px; text-align: center; box-shadow: 0 8px 30px rgba(3,54,49,.25); }
    .hm-founded-badge .big { font-size: 32px; font-weight: 800; color: #033631; display: block; line-height: 1; }
    .hm-founded-badge .sm { font-size: 11px; font-weight: 700; color: #033631; letter-spacing: 2px; text-transform: uppercase; }
    .hm-intro-list { list-style: none; padding: 0; margin: 0 0 30px; }
    .hm-intro-list li { display: flex; gap: 10px; font-size: 14px; color: rgba(3,54,49,.7); margin-bottom: 10px; line-height: 1.5; }
    .hm-intro-list i { color: #DAA520; margin-top: 2px; }
    .hm-stats-bar { background: #033631; padding: 60px 0; }
    .hm-stat-item { text-align: center; }
    .hm-stat-item .num { font-size: clamp(38px, 4.5vw, 58px); font-weight: 800; color: #DAA520; line-height: 1; display: block; margin-bottom: 6px; }
    .hm-stat-item .lbl { font-size: 13px; color: rgba(255,255,255,.55); letter-spacing: 2px; text-transform: uppercase; font-weight: 500; }
    .hm-stat-divider { width: 1px; background: rgba(255,255,255,.12); align-self: stretch; margin: auto 0; }
    .hm-why-card, .hm-testi-card { background: #fff; border-radius: 16px; padding: 32px; border: 1px solid rgba(3,54,49,.08); box-shadow: 0 4px 20px rgba(3,54,49,.06); height: 100%; }
    .hm-why-icon, .hm-exp-icon { width: 56px; height: 56px; border-radius: 50%; background: rgba(218,165,32,.12); color: #DAA520; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 18px; }
    .hm-why-title { font-size: 18px; font-weight: 700; color: #033631; margin-bottom: 10px; }
    .hm-why-text { font-size: 14px; color: rgba(3,54,49,.6); line-height: 1.75; margin: 0; }
    .hm-exp-card { position: relative; border-radius: 18px; overflow: hidden; height: 300px; }
    .hm-exp-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(3,54,49,.9), rgba(3,54,49,.15) 60%, transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 26px; }
    .hm-exp-icon { background: #DAA520; color: #033631; width: 44px; height: 44px; font-size: 17px; margin-bottom: 10px; }
    .hm-exp-title { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 6px; }
    .hm-exp-desc { font-size: 13px; color: rgba(255,255,255,.72); line-height: 1.65; margin: 0; }
    .hm-room-card { background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid rgba(3,54,49,.08); box-shadow: 0 4px 24px rgba(3,54,49,.07); height: 100%; display: flex; flex-direction: column; }
    .hm-room-img { position: relative; height: 240px; overflow: hidden; }
    .hm-room-badge { position: absolute; top: 14px; left: 14px; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 12px; border-radius: 100px; background: #DAA520; color: #033631; }
    .hm-room-price-tag { position: absolute; bottom: 14px; right: 14px; background: rgba(3,54,49,.9); border-radius: 10px; padding: 8px 14px; text-align: right; }
    .hm-room-price-tag .from, .hm-room-price-tag .night { font-size: 10px; color: rgba(255,255,255,.55); display: block; }
    .hm-room-price-tag .price { font-size: 20px; font-weight: 800; color: #DAA520; line-height: 1; }
    .hm-room-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
    .hm-room-type { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #DAA520; margin-bottom: 6px; }
    .hm-room-title { font-size: 19px; font-weight: 700; color: #033631; margin-bottom: 8px; }
    .hm-room-desc { font-size: 13px; color: rgba(3,54,49,.55); line-height: 1.7; margin-bottom: 16px; flex: 1; }
    .hm-room-amenities { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
    .hm-amenity { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; color: rgba(3,54,49,.6); background: rgba(3,54,49,.05); border-radius: 100px; padding: 5px 12px; }
    .hm-room-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid rgba(3,54,49,.08); gap: 10px; flex-wrap: wrap; }
    .hm-gallery-strip { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; grid-template-rows: 260px 200px; gap: 10px; }
    .hm-gallery-strip .gph { border-radius: 12px; overflow: hidden; position: relative; }
    .hm-gallery-strip .gph-large { grid-row: span 2; }
    .hm-gallery-strip .gph-overlay { position: absolute; inset: 0; background: rgba(3,54,49,.35); opacity: 0; transition: opacity .35s ease; display: flex; align-items: center; justify-content: center; color: #DAA520; font-size: 26px; }
    .hm-gallery-strip .gph:hover .gph-overlay { opacity: 1; }
    .hm-testi-quote { font-size: 46px; color: #DAA520; line-height: .8; font-family: Georgia, serif; margin-bottom: 14px; }
    .hm-testi-stars { color: #DAA520; font-size: 12px; margin-bottom: 16px; gap: 2px; display: flex; }
    .hm-testi-text { font-size: 14px; color: rgba(3,54,49,.65); line-height: 1.8; font-style: italic; margin-bottom: 22px; }
    .hm-testi-author { display: flex; align-items: center; gap: 12px; }
    .hm-testi-author img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #DAA520; }
    .hm-testi-name { font-size: 14px; font-weight: 700; color: #033631; margin: 0; }
    .hm-testi-loc { font-size: 12px; color: rgba(3,54,49,.45); margin: 0; }
    .hm-cta-wrap { position: relative; overflow: hidden; background: linear-gradient(135deg, #033631, #07554D); border-radius: 24px; padding: 80px 60px; text-align: center; }
    @media (max-width: 991px) { .hm-hero { height: 70vh; min-height: 500px; } .hm-section { padding: 70px 0; } .hm-intro-img-grid { grid-template-rows: 280px 160px; } .hm-gallery-strip { grid-template-columns: 1fr 1fr; grid-template-rows: repeat(4, 180px); } }
    @media (max-width: 767px) { .hm-hero h1 { font-size: 30px; } .hm-hero-scroll, .hm-stat-divider { display: none; } .hm-intro-img-grid { grid-template-columns: 1fr; grid-template-rows: 300px 180px 180px; } .hm-intro-img-grid .img-tall { grid-row: span 1; } .hm-cta-wrap { padding: 44px 22px; } }
</style>
@endsection

@section('content')
    <section class="hm-hero" id="hm-hero">
        @forelse($heroSlides as $slide)
            <div class="hm-hero-slide {{ $loop->first ? 'active' : '' }}" style="background-image: url('{{ $imageUrl($slide->image_url, 'assets/images/logo/1.jpeg') }}');"></div>
        @empty
            <div class="hm-hero-slide active" style="background-image: url('{{ asset('assets/images/logo/1.jpeg') }}');"></div>
        @endforelse

        <div class="container hm-hero-content">
            <span class="hm-label hm-label-light wow fadeInUp" data-wow-delay=".2s">{{ $section('hero_label', 'MP Tourism Accredited - Raisen Road, Bhopal') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{{ $hero->title ?? $setting('site_name', 'Mahua House') }}<br><em>{{ $hero->subtitle ?? $setting('site_tagline', 'The Nostalgic Woods') }}</em></h1>
            <p class="hm-hero-sub wow fadeInUp" data-wow-delay=".4s">{{ $hero->description ?? $setting('site_description', 'Where Tradition Meets Tranquility - A Nature Retreat for Weddings, Events and Peaceful Getaways in Bhopal') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".5s">
                @if($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="hm-btn hm-btn-outline"><i class="fa-brands fa-facebook-f" style="margin-right:7px;"></i>Visit FB</a>@endif
                @if($whatsappNumber)<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="hm-btn hm-btn-outline"><i class="fa-brands fa-whatsapp" style="margin-right:7px;"></i>WhatsApp Enquiry</a>@endif
                <a href="{{ route('video-tours') }}" class="hm-btn hm-btn-outline"><i class="fa-solid fa-play" style="margin-right:7px;"></i>Watch Videos</a>
                <a href="{{ route('booking') }}" class="hm-btn hm-btn-gold"><i class="fa-solid fa-phone" style="margin-right:7px;"></i>Book Your Stay</a>
            </div>
        </div>

        <div class="hm-hero-scroll">Scroll</div>
        <div class="hm-hero-dots" id="hm-dots">
            @forelse($heroSlides as $slide)
                <div class="hm-hero-dot {{ $loop->first ? 'active' : '' }}" data-idx="{{ $loop->index }}"></div>
            @empty
                <div class="hm-hero-dot active" data-idx="0"></div>
            @endforelse
        </div>
        <div class="hm-hero-controls">
            <button class="hm-hero-btn" id="hm-prev" aria-label="previous slide"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="hm-hero-btn" id="hm-next" aria-label="next slide"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
        <div class="hm-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    <section class="hm-section" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div class="position-relative">
                        <div class="hm-intro-img-grid">
                            <div class="img-tall"><img src="{{ $imageUrl(optional($introImages->get(0))->image_url, 'assets/images/about/6.jpeg') }}" alt="{{ optional($introImages->get(0))->title ?? 'Mahua House forest' }}"></div>
                            <div class="img-sm"><img src="{{ $imageUrl(optional($introImages->get(1))->image_url, 'assets/images/about/10.jpeg') }}" alt="{{ optional($introImages->get(1))->title ?? 'Mahua House cottage' }}"></div>
                            <div class="img-sm"><img src="{{ $imageUrl(optional($introImages->get(2))->image_url, 'assets/images/about/14.jpeg') }}" alt="{{ optional($introImages->get(2))->title ?? 'Mahua House nature' }}"></div>
                        </div>
                        <div class="hm-founded-badge"><span class="big">{{ $section('established_year', '2014') }}</span><span class="sm">{{ $section('established_label', 'Est. Year') }}</span></div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <span class="hm-label">{{ $section('intro_label', 'Welcome to Mahua House') }}</span>
                    <h2 class="hm-heading">{!! $section('intro_heading', 'The Nostalgic <em>Woods</em>') !!}</h2>
                    <div class="hm-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    <p class="hm-body mb-3">{{ $section('intro_text_1', 'Mahua House - The Nostalgic Woods is an MP Tourism accredited countryside retreat located on Raisen Road, Bhopal, surrounded by serene forest landscapes.') }}</p>
                    <p class="hm-body mb-4">{{ $section('intro_text_2', 'Designed for those who value peace, culture, and meaningful gatherings, Mahua House blends rustic charm with modern comfort.') }}</p>
                    <ul class="hm-intro-list">
                        @foreach(array_filter(array_map('trim', explode("\n", $section('intro_points', "MP Tourism Accredited countryside retreat\nAdjoining Samardha Reserved Forest, Bhopal\nTrusted by Doordarshan productions\nIdeal for weddings, events, picnics and peaceful stays")))) as $point)
                            <li><i class="fa-solid fa-check"></i> {{ $point }}</li>
                        @endforeach
                    </ul>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('about') }}" class="hm-btn hm-btn-primary">Our Story</a>
                        <a href="{{ route('booking') }}" class="hm-btn hm-btn-gold">Book a Stay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($stats->isNotEmpty())
        <div class="hm-stats-bar">
            <div class="container">
                <div class="row g-4 align-items-center justify-content-center" id="hm-stats-inner">
                    @foreach($stats as $stat)
                        <div class="col-auto wow fadeInUp" data-wow-delay=".{{ $loop->iteration }}s"><div class="hm-stat-item"><span class="num">{{ $stat->value }}</span><span class="lbl">{{ $stat->label }}</span></div></div>
                        @unless($loop->last)<div class="col-auto d-none d-md-block"><div class="hm-stat-divider" style="height:70px;"></div></div>@endunless
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($whyChooseItems->isNotEmpty())
        <section class="hm-section hm-section-alt" id="why-choose">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-8 text-center">
                        <span class="hm-label wow fadeInUp" data-wow-delay=".1s">{{ $section('why_label', 'Why Choose Us') }}</span>
                        <h2 class="hm-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('why_heading', 'Why <em>Mahua House</em>') !!}</h2>
                        <div class="hm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    </div>
                </div>
                <div class="row g-4" id="hm-why-grid">
                    @foreach($whyChooseItems as $item)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration }}s"><div class="hm-why-card"><div class="hm-why-icon"><i class="{{ $item->icon ?: 'fa-solid fa-leaf' }}"></i></div><h4 class="hm-why-title">{{ $item->title }}</h4><p class="hm-why-text">{{ $item->description }}</p></div></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($experiences->isNotEmpty())
        <section class="hm-section hm-section-cream">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="hm-label wow fadeInUp" data-wow-delay=".1s">{{ $section('experiences_label', 'What We Offer') }}</span>
                        <h2 class="hm-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('experiences_heading', 'Experiences That <em>Stay With You</em>') !!}</h2>
                        <div class="hm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                        <p class="hm-body wow fadeInUp" data-wow-delay=".4s">{{ $section('experiences_text', 'Every moment at Mahua House is crafted for memory.') }}</p>
                    </div>
                </div>
                <div class="row g-4" id="hm-exp-grid">
                    @foreach($experiences as $experience)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s"><div class="hm-exp-card"><img src="{{ $imageUrl($experience->image_url, 'assets/images/about/22.jpeg') }}" alt="{{ $experience->title }}"><div class="hm-exp-overlay"><div class="hm-exp-icon"><i class="{{ $experience->icon ?: 'fa-solid fa-leaf' }}"></i></div><h4 class="hm-exp-title">{{ $experience->title }}</h4><p class="hm-exp-desc">{{ $experience->description }}</p></div></div></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($featuredRooms->isNotEmpty())
        <section class="hm-section">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-lg-7">
                        <span class="hm-label wow fadeInUp" data-wow-delay=".1s">{{ $section('rooms_label', 'Our Rooms & Suites') }}</span>
                        <h2 class="hm-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('rooms_heading', 'Sleep Amidst the <em>Whispering Forest</em>') !!}</h2>
                        <div class="hm-divider wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    </div>
                    <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s"><a href="{{ route('rooms') }}" class="hm-btn hm-btn-primary">Browse All Rooms</a></div>
                </div>
                <div class="row g-4" id="hm-rooms-grid">
                    @foreach($featuredRooms as $room)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s">
                            <div class="hm-room-card">
                                <div class="hm-room-img">
                                    <img src="{{ $imageUrl($room->image_url, 'assets/images/room/room-1.jpg') }}" alt="{{ $room->name }}">
                                    @if($room->badge_text)<span class="hm-room-badge" style="background:{{ $room->badge_color ?: '#DAA520' }};color:{{ strtolower($room->badge_color) === '#ffffff' ? '#033631' : '#fff' }};">{{ $room->badge_text }}</span>@endif
                                    <div class="hm-room-price-tag"><span class="from">From</span><span class="price">&#8377;{{ number_format($room->price_per_night) }}</span><span class="night">/ night</span></div>
                                </div>
                                <div class="hm-room-body">
                                    <span class="hm-room-type">{{ $room->room_type }}</span>
                                    <h3 class="hm-room-title">{{ $room->name }}</h3>
                                    <p class="hm-room-desc">{{ $room->description }}</p>
                                    <div class="hm-room-amenities">
                                        @foreach(array_slice($room->amenities ?? [], 0, 4) as $amenity)
                                            <span class="hm-amenity"><i class="fa-solid fa-check"></i> {{ $amenity }}</span>
                                        @endforeach
                                    </div>
                                    <div class="hm-room-footer">
                                        <span style="font-size:13px;color:rgba(3,54,49,.5);"><i class="fa-solid fa-user" style="color:#DAA520;margin-right:4px;"></i> {{ $room->max_guests }} Guests</span>
                                        <a href="{{ route('rooms') }}" class="hm-btn hm-btn-primary" style="padding:9px 20px;font-size:13px;">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($galleryItems->isNotEmpty())
        <section class="hm-section hm-section-cream" style="padding-bottom: 90px;">
            <div class="container">
                <div class="row align-items-end mb-4">
                    <div class="col-lg-7"><span class="hm-label wow fadeInUp" data-wow-delay=".1s">{{ $section('gallery_label', 'Through the Lens') }}</span><h2 class="hm-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('gallery_heading', 'A Glimpse of <em>Mahua House</em>') !!}</h2></div>
                    <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s"><a href="{{ route('gallery') }}" class="hm-btn hm-btn-primary">Full Gallery</a></div>
                </div>
                <div class="hm-gallery-strip wow fadeInUp" data-wow-delay=".3s" id="hm-gallery-strip">
                    @foreach($galleryItems as $item)
                        <div class="gph {{ $loop->first ? 'gph-large' : '' }}"><img src="{{ $imageUrl($item->image_url, 'assets/images/about/65.jpeg') }}" alt="{{ $item->title }}"><div class="gph-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($testimonials->isNotEmpty())
        <section class="hm-section hm-section-alt">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="hm-label wow fadeInUp" data-wow-delay=".1s">{{ $section('testimonials_label', 'Guest Stories') }}</span>
                        <h2 class="hm-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('testimonials_heading', 'What Our <em>Guests Say</em>') !!}</h2>
                        <div class="hm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    </div>
                </div>
                <div class="row g-4" id="hm-testi-grid">
                    @foreach($testimonials as $testimonial)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->iteration + 1 }}s">
                            <div class="hm-testi-card">
                                <div class="hm-testi-quote">"</div>
                                <div class="hm-testi-stars">@for($i = 1; $i <= max(1, (int) $testimonial->rating); $i++)<i class="fa-solid fa-star"></i>@endfor</div>
                                <p class="hm-testi-text">{{ $testimonial->review }}</p>
                                <div class="hm-testi-author">
                                    @if($testimonial->photo_url)<img src="{{ $imageUrl($testimonial->photo_url) }}" alt="{{ $testimonial->name }}">@endif
                                    <div><p class="hm-testi-name">{{ $testimonial->name }}</p>@if($testimonial->location)<p class="hm-testi-loc">{{ $testimonial->location }}</p>@endif</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="hm-section">
        <div class="container">
            <div class="hm-cta-wrap wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="hm-label hm-label-light wow fadeInUp" data-wow-delay=".2s">{{ $section('cta_label', 'Ready to Visit?') }}</span>
                    <h2 class="hm-heading hm-heading-light wow fadeInUp" data-wow-delay=".3s" style="margin-bottom:16px;">{!! $section('cta_heading', 'Ready to Experience <em>Mahua House?</em>') !!}</h2>
                    <p class="hm-body hm-body-light wow fadeInUp" data-wow-delay=".4s" style="max-width:560px;margin:0 auto 36px;">{{ $section('cta_text', 'Book your stay, plan your event, or simply come to unwind in nature. Our forest is waiting for you.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center wow fadeInUp" data-wow-delay=".5s">
                        @if($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" rel="noopener" class="hm-btn hm-btn-outline"><i class="fa-brands fa-facebook-f" style="margin-right:7px;"></i>Visit Facebook</a>@endif
                        @if($mapsUrl)<a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="hm-btn hm-btn-outline"><i class="fa-solid fa-star" style="margin-right:7px;"></i>Read Google Reviews</a>@endif
                        <a href="{{ route('contact') }}" class="hm-btn hm-btn-outline"><i class="fa-solid fa-envelope" style="margin-right:7px;"></i>Enquire Today</a>
                        @if($whatsappNumber)<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="hm-btn hm-btn-gold"><i class="fa-brands fa-whatsapp" style="margin-right:7px;"></i>WhatsApp or Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = Array.from(document.querySelectorAll('.hm-hero-slide'));
    const dots = Array.from(document.querySelectorAll('.hm-hero-dot'));
    let current = 0;

    function showSlide(index) {
        if (!slides.length) return;
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => slide.classList.toggle('active', i === current));
        dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
    }

    document.getElementById('hm-prev')?.addEventListener('click', () => showSlide(current - 1));
    document.getElementById('hm-next')?.addEventListener('click', () => showSlide(current + 1));
    dots.forEach(dot => dot.addEventListener('click', () => showSlide(Number(dot.dataset.idx || 0))));
    if (slides.length > 1) {
        setInterval(() => showSlide(current + 1), 6000);
    }
});
</script>
@endsection

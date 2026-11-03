@extends('layouts.app')

@section('title', 'Rooms & Cottages | Mahua House')
@section('meta_description', 'Explore all rooms and cottages at Mahua House — unique forest accommodations in the heart of Bhopal.')
@section('meta_keywords', 'Mahua House Rooms, Forest Resort Rooms Bhopal, Eco Cottage, Nature Suite')

@section('styles')
<style>
    .rm-section { padding: 90px 0; } .rm-section-alt { background: #E7EEEE; } .rm-section-dark { background: #033631; } .rm-section-cream { background: #faf8f3; }
    .rm-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #DAA520; margin-bottom: 12px; }
    .rm-label-light { color: rgba(218,165,32,0.9); }
    .rm-heading { font-size: clamp(28px, 3.5vw, 44px); font-weight: 700; color: #033631; line-height: 1.2; margin-bottom: 14px; }
    .rm-heading-light { color: #ffffff; } .rm-heading em { font-style: normal; color: #DAA520; }
    .rm-divider { display: flex; align-items: center; gap: 12px; color: #DAA520; margin-bottom: 22px; }
    .rm-divider.centered { justify-content: center; } .rm-divider span { display: block; width: 60px; height: 1px; background: #DAA520; } .rm-divider i { font-size: 9px; }
    .rm-body { font-size: 15px; color: rgba(3,54,49,0.6); line-height: 1.85; margin-bottom: 0; } .rm-body-light { color: rgba(255,255,255,0.65); }
    .rm-btn { display: inline-block; padding: 13px 32px; border-radius: 100px; font-size: 14px; font-weight: 700; letter-spacing: 0.5px; text-decoration: none; transition: all 0.3s ease; border: 2px solid transparent; cursor: pointer; }
    .rm-btn-primary { background:#033631; color:#fff; border-color:#033631; } .rm-btn-primary:hover { background:transparent; color:#033631; }
    .rm-btn-gold { background:#DAA520; color:#033631; border-color:#DAA520; } .rm-btn-gold:hover { background:transparent; color:#DAA520; }
    .rm-btn-outline { background:transparent; color:#fff; border-color:rgba(255,255,255,0.5); } .rm-btn-outline:hover { background:#DAA520; color:#033631; border-color:#DAA520; }
    .rm-btn-outline-dark { background:transparent; color:#033631; border-color:rgba(3,54,49,0.4); } .rm-btn-outline-dark:hover { background:#033631; color:#fff; border-color:#033631; }
    .rm-btn-sm { padding: 10px 22px; font-size: 13px; }
    .rm-breadcrumb { list-style: none; padding: 0; margin: 0 0 20px; display: flex; gap: 8px; align-items: center; font-size: 13px; color: rgba(255,255,255,0.65); }
    .rm-breadcrumb li + li::before { content: "/"; margin-right: 8px; opacity: 0.5; } .rm-breadcrumb a { color: rgba(255,255,255,0.8); text-decoration: none; } .rm-breadcrumb a:hover { color: #DAA520; }
    .rm-hero { position: relative; height: 600px; background: linear-gradient(135deg, rgba(3,54,49,0.88) 0%, rgba(3,54,49,0.5) 60%, rgba(0,0,0,0.2) 100%), url('{{ asset("assets/images/room/room-1.jpg") }}') center/cover no-repeat; display: flex; align-items: center; }
    .rm-hero-content { position: relative; z-index: 2; }
    .rm-hero h1 { font-size: clamp(36px, 5.5vw, 66px); font-weight: 800; line-height: 1.05; margin-bottom: 18px; color: #fff; }
    .rm-hero h1 em { font-style: normal; color: #DAA520; }
    .rm-hero p { font-size: 16px; color: rgba(255,255,255,0.78); max-width: 540px; margin-bottom: 32px; }
    .rm-hero-shape { position: absolute; bottom: -1px; left: 0; right: 0; z-index: 3; line-height: 0; } .rm-hero-shape img { width: 100%; }
    .rm-filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; justify-content: center; }
    .rm-filter-btn { padding: 10px 24px; border-radius: 100px; border: 1.5px solid rgba(3,54,49,0.15); background: #fff; color: rgba(3,54,49,0.65); font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.25s ease; text-decoration: none; }
    .rm-filter-btn:hover, .rm-filter-btn.active { background: #033631; color: #fff; border-color: #033631; }
    .rm-featured { display: grid; grid-template-columns: 55% 45%; border-radius: 24px; overflow: hidden; box-shadow: 0 12px 60px rgba(3,54,49,0.15); }
    .rm-featured-imgs { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; gap: 4px; }
    .rm-featured-imgs .rfi { overflow: hidden; position: relative; } .rm-featured-imgs .rfi img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; } .rm-featured-imgs .rfi:hover img { transform: scale(1.06); } .rm-featured-imgs .rfi-main { grid-row: 1 / 3; }
    .rm-featured-content { background: #fff; padding: 52px 48px; display: flex; flex-direction: column; justify-content: center; }
    .rm-price-tag { display: inline-flex; align-items: baseline; gap: 4px; margin-bottom: 28px; }
    .rm-price-tag .curr { font-size: 20px; color: #033631; font-weight: 700; } .rm-price-tag .amt { font-size: 44px; color: #033631; font-weight: 800; line-height: 1; } .rm-price-tag .per { font-size: 13px; color: rgba(3,54,49,0.5); font-weight: 500; }
    .rm-amenity-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 20px 0 28px; }
    .rm-amenity-item { display: flex; align-items: center; gap: 10px; font-size: 13px; color: rgba(3,54,49,0.7); font-weight: 500; } .rm-amenity-item i { color: #DAA520; width: 16px; }
    .rm-featured-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(218,165,32,0.12); color: #a07a00; border-radius: 100px; padding: 6px 16px; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 16px; }
    .rm-card { background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid rgba(3,54,49,0.08); box-shadow: 0 4px 24px rgba(3,54,49,0.06); transition: transform 0.35s ease, box-shadow 0.35s ease; height: 100%; display: flex; flex-direction: column; }
    .rm-card:hover { transform: translateY(-8px); box-shadow: 0 20px 56px rgba(3,54,49,0.13); }
    .rm-card-img { position: relative; height: 240px; overflow: hidden; } .rm-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; } .rm-card:hover .rm-card-img img { transform: scale(1.06); }
    .rm-card-badges { position: absolute; top: 14px; left: 14px; display: flex; gap: 6px; flex-wrap: wrap; }
    .rm-badge { font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 5px 12px; border-radius: 100px; }
    .rm-badge-gold { background: #DAA520; color: #033631; } .rm-badge-green { background: #033631; color: #fff; } .rm-badge-white { background: #fff; color: #033631; }
    .rm-card-price { position: absolute; bottom: 0; right: 0; background: linear-gradient(135deg, #033631, #055a50); color: #fff; padding: 10px 18px 10px 22px; border-radius: 16px 0 0 0; }
    .rm-card-price .from { font-size: 10px; color: rgba(255,255,255,0.6); display: block; } .rm-card-price .amount { font-size: 20px; font-weight: 800; color: #DAA520; line-height: 1; } .rm-card-price .night { font-size: 10px; color: rgba(255,255,255,0.6); }
    .rm-card-body { padding: 26px 28px 30px; flex: 1; display: flex; flex-direction: column; }
    .rm-card-type { font-size: 10px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: #DAA520; margin-bottom: 6px; display: block; }
    .rm-card-title { font-size: 21px; font-weight: 700; color: #033631; margin-bottom: 10px; } .rm-card-desc { font-size: 14px; color: rgba(3,54,49,0.6); line-height: 1.75; margin-bottom: 18px; flex: 1; }
    .rm-card-specs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
    .rm-spec { display: inline-flex; align-items: center; gap: 6px; background: #E7EEEE; border-radius: 100px; padding: 6px 14px; font-size: 12px; font-weight: 600; color: #033631; } .rm-spec i { color: #DAA520; font-size: 11px; }
    .rm-card-amenities { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 22px; }
    .rm-amenity-tag { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; color: rgba(3,54,49,0.65); border: 1px solid rgba(3,54,49,0.1); border-radius: 6px; padding: 5px 10px; } .rm-amenity-tag i { color: #DAA520; font-size: 10px; }
    .rm-card-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-top: 18px; border-top: 1px solid rgba(3,54,49,0.08); flex-wrap: wrap; }
    .rm-card-capacity { font-size: 13px; color: rgba(3,54,49,0.6); font-weight: 600; display: flex; align-items: center; gap: 6px; } .rm-card-capacity i { color: #DAA520; }
    .rm-detail-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0; border-radius: 24px; overflow: hidden; box-shadow: 0 8px 40px rgba(3,54,49,0.1); margin-bottom: 32px; }
    .rm-detail-row.reverse { direction: rtl; } .rm-detail-row.reverse > * { direction: ltr; }
    .rm-detail-img { position: relative; overflow: hidden; min-height: 420px; } .rm-detail-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; } .rm-detail-row:hover .rm-detail-img img { transform: scale(1.04); }
    .rm-detail-img-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(3,54,49,0.4) 0%, transparent 50%); }
    .rm-detail-img-badge { position: absolute; top: 20px; left: 20px; display: flex; gap: 8px; flex-wrap: wrap; }
    .rm-detail-img-price { position: absolute; bottom: 20px; left: 20px; }
    .rm-detail-img-price .dp-from { font-size: 11px; color: rgba(255,255,255,0.7); display: block; margin-bottom: 2px; } .rm-detail-img-price .dp-amount { font-size: 28px; font-weight: 800; color: #DAA520; line-height: 1; } .rm-detail-img-price .dp-per { font-size: 12px; color: rgba(255,255,255,0.7); margin-left: 4px; }
    .rm-detail-content { background: #fff; padding: 50px 48px; display: flex; flex-direction: column; justify-content: center; }
    .rm-detail-features { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 10px; }
    .rm-detail-features li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: rgba(3,54,49,0.7); line-height: 1.5; } .rm-detail-features li i { color: #DAA520; margin-top: 3px; font-size: 11px; flex-shrink: 0; }
    .rm-detail-specs { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; }
    .rm-compare-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .rm-compare-table thead tr { background: #033631; color: #fff; }
    .rm-compare-table thead th { padding: 16px 18px; text-align: left; font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700; }
    .rm-compare-table thead th:first-child { border-radius: 12px 0 0 0; } .rm-compare-table thead th:last-child { border-radius: 0 12px 0 0; }
    .rm-compare-table tbody tr { border-bottom: 1px solid rgba(3,54,49,0.07); transition: background 0.2s; } .rm-compare-table tbody tr:hover { background: #E7EEEE; } .rm-compare-table tbody tr:last-child { border-bottom: none; }
    .rm-compare-table td { padding: 14px 18px; color: rgba(3,54,49,0.7); vertical-align: middle; } .rm-compare-table td:first-child { font-weight: 700; color: #033631; }
    .rm-compare-table .rc-price { color: #DAA520; font-weight: 800; font-size: 16px; } .rm-compare-table .rc-check { color: #2d8c5e; font-size: 14px; } .rm-compare-table .rc-cross { color: rgba(3,54,49,0.2); font-size: 12px; }
    .rm-amenity-block { background: #fff; border-radius: 18px; padding: 36px 28px; text-align: center; border: 1px solid rgba(3,54,49,0.07); box-shadow: 0 4px 20px rgba(3,54,49,0.05); transition: transform 0.3s, box-shadow 0.3s; height: 100%; }
    .rm-amenity-block:hover { transform: translateY(-6px); box-shadow: 0 14px 44px rgba(3,54,49,0.11); }
    .rm-amenity-block-icon { width: 64px; height: 64px; border-radius: 50%; background: rgba(3,54,49,0.07); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; transition: background 0.3s; } .rm-amenity-block-icon i { font-size: 24px; color: #033631; transition: color 0.3s; }
    .rm-amenity-block:hover .rm-amenity-block-icon { background: #033631; } .rm-amenity-block:hover .rm-amenity-block-icon i { color: #DAA520; }
    .rm-amenity-block h5 { font-size: 15px; font-weight: 700; color: #033631; margin-bottom: 8px; } .rm-amenity-block p { font-size: 13px; color: rgba(3,54,49,0.55); line-height: 1.65; margin: 0; }
    .rm-policy-card { background: #fff; border-radius: 16px; padding: 28px 24px; border-left: 4px solid #DAA520; height: 100%; box-shadow: 0 4px 20px rgba(3,54,49,0.06); }
    .rm-policy-card h5 { font-size: 15px; font-weight: 700; color: #033631; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; } .rm-policy-card h5 i { color: #DAA520; }
    .rm-policy-list { list-style: none; padding: 0; margin: 0; }
    .rm-policy-list li { font-size: 13px; color: rgba(3,54,49,0.65); padding: 5px 0; border-bottom: 1px solid rgba(3,54,49,0.06); display: flex; align-items: flex-start; gap: 8px; } .rm-policy-list li:last-child { border-bottom: none; } .rm-policy-list li i { color: #DAA520; font-size: 8px; margin-top: 5px; flex-shrink: 0; }
    .rm-cta-box { background: linear-gradient(135deg, #033631 0%, #055a50 100%); border-radius: 24px; padding: 70px 50px; text-align: center; position: relative; overflow: hidden; }
    .rm-cta-box::before { content: ''; position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; border-radius: 50%; background: rgba(218,165,32,0.08); }
    .rm-cta-box::after { content: ''; position: absolute; bottom: -60px; left: -60px; width: 220px; height: 220px; border-radius: 50%; background: rgba(218,165,32,0.06); }
    @media (max-width: 1199px) { .rm-featured { grid-template-columns: 1fr 1fr; } .rm-featured-content { padding: 40px 36px; } }
    @media (max-width: 991px) { .rm-featured { grid-template-columns: 1fr; } .rm-featured-imgs { grid-template-rows: 200px 200px; } .rm-featured-imgs .rfi-main { grid-row: auto; } .rm-detail-row { grid-template-columns: 1fr; } .rm-detail-row.reverse { direction: ltr; } .rm-detail-img { min-height: 280px; } .rm-detail-content { padding: 36px 32px; } }
    @media (max-width: 767px) { .rm-amenity-grid { grid-template-columns: 1fr; } .rm-cta-box { padding: 50px 28px; } }
    @media (max-width: 575px) { .rm-hero h1 { font-size: 32px; } .rm-price-tag .amt { font-size: 34px; } }
</style>
@endsection

@section('content')

        <!-- HERO -->
        <section class="rm-hero">
            <div class="container rm-hero-content">
                <ul class="rm-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Rooms &amp; Cottages</li>
                </ul>
                <span class="rm-label wow fadeInUp" data-wow-delay=".2s">Forest Accommodations</span>
                <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size: 30px;">Sleep Inside<br><em>the Forest</em></h1>
                <p class="wow fadeInUp" data-wow-delay=".4s">Unique rooms and cottages — each designed with natural materials, earthy tones and thoughtful details that connect you to the land outside your window.</p>
            </div>
            <div class="rm-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
        </section>

        <!-- FEATURED -->
        <section class="rm-section" style="padding-top:30px;">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-lg-7">
                        <span class="rm-label wow fadeInUp" data-wow-delay=".1s">Our Accommodation</span>
                        <h2 class="rm-heading wow fadeInUp" data-wow-delay=".2s">Comfort Meets <em>Rustic Charm</em></h2>
                        <p class="rm-body wow fadeInUp" data-wow-delay=".35s" style="margin-top:10px;"><i class="fa-solid fa-clock" style="color:#DAA520;margin-right:6px;"></i><strong>Check-in:</strong> 11:00 AM &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Check-out:</strong> 10:00 AM</p>
                    </div>
                    <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                        <a href="#rooms" class="rm-btn rm-btn-outline-dark rm-btn-sm">View All Rooms</a>
                    </div>
                </div>
                <div class="rm-featured wow fadeInUp" data-wow-delay=".3s" id="rm-featured">
                    <div class="rm-featured-imgs">
                        <div class="rfi rfi-main"><img src="{{ asset('assets/images/room/room-1.jpg') }}" alt="Super Deluxe AC Room"></div>
                        <div class="rfi"><img src="{{ asset('assets/images/room/room-2.jpg') }}" alt="Deluxe AC Room"></div>
                        <div class="rfi"><img src="{{ asset('assets/images/room/room-3.jpg') }}" alt="Forest Cottage"></div>
                    </div>
                    <div class="rm-featured-content">
                        <div class="rm-featured-badge"><i class="fa-solid fa-star"></i> Most Popular</div>
                        <span class="rm-label">Best Pick</span>
                        <h2 class="rm-heading" style="font-size:34px;">Super Deluxe AC Room</h2>
                        <div class="rm-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                        <p class="rm-body mb-0">Our most popular accommodation — a spacious, fully air-conditioned room designed to blend modern comfort with natural forest charm. Enjoy serene forest views, power backup, and the peaceful sounds of nature just outside your window.</p>
                        <div class="rm-amenity-grid">
                            <div class="rm-amenity-item"><i class="fa-solid fa-snowflake"></i> Air Conditioning</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-bed"></i> Double Bed</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-shower"></i> En Suite Bath</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-bolt"></i> Power Backup</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-tv"></i> Television</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-square-parking"></i> Parking</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-shield-halved"></i> CCTV &amp; Security</div>
                            <div class="rm-amenity-item"><i class="fa-solid fa-utensils"></i> Dining Available</div>
                        </div>
                        <div class="rm-price-tag"><span class="curr">&#8377;</span><span class="amt">3,500</span><span class="per">/ night · Double Occupancy</span></div>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary">WhatsApp to Book</a>
                            <a href="{{ route('contact') }}" class="rm-btn rm-btn-gold">Enquire Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ALL ROOMS GRID -->
        <section class="rm-section rm-section-alt" id="rooms">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="rm-label wow fadeInUp" data-wow-delay=".1s">All Accommodations</span>
                        <h2 class="rm-heading wow fadeInUp" data-wow-delay=".2s">Choose Your <em>Forest Retreat</em></h2>
                        <div class="rm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                        <p class="rm-body wow fadeInUp" data-wow-delay=".35s">Every room is a window into the forest — designed with natural materials, earthy tones and thoughtful details.</p>
                    </div>
                </div>
                <div class="rm-filters wow fadeInUp" data-wow-delay=".3s" id="rm-filter-wrap">
                    <a href="#" class="rm-filter-btn active" data-filter="all">All Rooms</a>
                    <a href="#" class="rm-filter-btn" data-filter="deluxe">Deluxe AC</a>
                    <a href="#" class="rm-filter-btn" data-filter="super">Super Deluxe</a>
                    <a href="#" class="rm-filter-btn" data-filter="cottage">Cottage</a>
                </div>
                <div class="row g-4" id="rm-rooms-grid">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s" data-category="super">
                        <div class="rm-card">
                            <div class="rm-card-img">
                                <img src="{{ asset('assets/images/room/room-1.jpg') }}" alt="Super Deluxe AC Room">
                                <div class="rm-card-badges"><span class="rm-badge rm-badge-gold">Popular</span><span class="rm-badge rm-badge-green">AC Room</span></div>
                                <div class="rm-card-price"><span class="from">from</span><span class="amount">&#8377;3,500</span><span class="night">/night</span></div>
                            </div>
                            <div class="rm-card-body">
                                <span class="rm-card-type">Super Deluxe AC</span>
                                <h4 class="rm-card-title">Super Deluxe AC Room</h4>
                                <p class="rm-card-desc">Spacious and fully air-conditioned, this room offers the best of modern comfort surrounded by nature. Double occupancy.</p>
                                <div class="rm-card-specs"><span class="rm-spec"><i class="fa-solid fa-users"></i> 2 Guests</span><span class="rm-spec"><i class="fa-solid fa-clock"></i> CI: 11AM</span><span class="rm-spec"><i class="fa-solid fa-clock"></i> CO: 10AM</span></div>
                                <div class="rm-card-amenities">
                                    <span class="rm-amenity-tag"><i class="fa-solid fa-snowflake"></i> AC</span><span class="rm-amenity-tag"><i class="fa-solid fa-bed"></i> Double Bed</span><span class="rm-amenity-tag"><i class="fa-solid fa-shower"></i> Attached Bath</span><span class="rm-amenity-tag"><i class="fa-solid fa-tv"></i> TV</span><span class="rm-amenity-tag"><i class="fa-solid fa-bolt"></i> Power Backup</span><span class="rm-amenity-tag"><i class="fa-solid fa-square-parking"></i> Parking</span>
                                </div>
                                <div class="rm-card-footer">
                                    <span class="rm-card-capacity"><i class="fa-solid fa-user-group"></i> Double Occupancy</span>
                                    <div class="d-flex gap-2"><a href="{{ route('contact') }}" class="rm-btn rm-btn-outline-dark rm-btn-sm">Enquire</a><a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary rm-btn-sm">Book Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s" data-category="deluxe">
                        <div class="rm-card">
                            <div class="rm-card-img">
                                <img src="{{ asset('assets/images/room/room-2.jpg') }}" alt="Deluxe AC Room">
                                <div class="rm-card-badges"><span class="rm-badge rm-badge-green">Best Value</span></div>
                                <div class="rm-card-price"><span class="from">from</span><span class="amount">&#8377;3,000</span><span class="night">/night</span></div>
                            </div>
                            <div class="rm-card-body">
                                <span class="rm-card-type">Deluxe AC</span>
                                <h4 class="rm-card-title">Deluxe AC Room</h4>
                                <p class="rm-card-desc">Comfortable air-conditioned room with a natural forest ambience. Perfect for couples or solo travellers. Double occupancy.</p>
                                <div class="rm-card-specs"><span class="rm-spec"><i class="fa-solid fa-users"></i> 2 Guests</span><span class="rm-spec"><i class="fa-solid fa-clock"></i> CI: 11AM</span><span class="rm-spec"><i class="fa-solid fa-clock"></i> CO: 10AM</span></div>
                                <div class="rm-card-amenities">
                                    <span class="rm-amenity-tag"><i class="fa-solid fa-snowflake"></i> AC</span><span class="rm-amenity-tag"><i class="fa-solid fa-bed"></i> Double Bed</span><span class="rm-amenity-tag"><i class="fa-solid fa-shower"></i> Attached Bath</span><span class="rm-amenity-tag"><i class="fa-solid fa-tv"></i> TV</span><span class="rm-amenity-tag"><i class="fa-solid fa-bolt"></i> Power Backup</span><span class="rm-amenity-tag"><i class="fa-solid fa-shield-halved"></i> CCTV</span>
                                </div>
                                <div class="rm-card-footer">
                                    <span class="rm-card-capacity"><i class="fa-solid fa-user-group"></i> Double Occupancy</span>
                                    <div class="d-flex gap-2"><a href="{{ route('contact') }}" class="rm-btn rm-btn-outline-dark rm-btn-sm">Enquire</a><a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary rm-btn-sm">Book Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s" data-category="cottage">
                        <div class="rm-card">
                            <div class="rm-card-img">
                                <img src="{{ asset('assets/images/room/room-3.jpg') }}" alt="Independent Cottage">
                                <div class="rm-card-badges"><span class="rm-badge rm-badge-gold">Cottage</span></div>
                                <div class="rm-card-price"><span class="from">from</span><span class="amount">&#8377;2,500</span><span class="night">/night</span></div>
                            </div>
                            <div class="rm-card-body">
                                <span class="rm-card-type">Independent Cottage</span>
                                <h4 class="rm-card-title">Forest Cottage</h4>
                                <p class="rm-card-desc">A charming, private independent cottage nestled in nature. Enjoy rustic charm with basic modern comforts. Double occupancy.</p>
                                <div class="rm-card-specs"><span class="rm-spec"><i class="fa-solid fa-users"></i> 2 Guests</span><span class="rm-spec"><i class="fa-solid fa-house"></i> Private</span><span class="rm-spec"><i class="fa-solid fa-tree"></i> Forest View</span></div>
                                <div class="rm-card-amenities">
                                    <span class="rm-amenity-tag"><i class="fa-solid fa-house"></i> Independent</span><span class="rm-amenity-tag"><i class="fa-solid fa-bed"></i> Double Bed</span><span class="rm-amenity-tag"><i class="fa-solid fa-shower"></i> Attached Bath</span><span class="rm-amenity-tag"><i class="fa-solid fa-bolt"></i> Power Backup</span><span class="rm-amenity-tag"><i class="fa-solid fa-square-parking"></i> Parking</span>
                                </div>
                                <div class="rm-card-footer">
                                    <span class="rm-card-capacity"><i class="fa-solid fa-user-group"></i> Double Occupancy</span>
                                    <div class="d-flex gap-2"><a href="{{ route('contact') }}" class="rm-btn rm-btn-outline-dark rm-btn-sm">Enquire</a><a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary rm-btn-sm">Book Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ROOM DETAIL ROWS -->
        <section class="rm-section rm-section-cream">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="rm-label wow fadeInUp" data-wow-delay=".1s">Room Details</span>
                        <h2 class="rm-heading wow fadeInUp" data-wow-delay=".2s">Inside Each <em>Room</em></h2>
                        <div class="rm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-door-open"></i><span></span></div>
                    </div>
                </div>
                <div id="rm-detail-rows">
                <div class="rm-detail-row wow fadeInUp" data-wow-delay=".2s">
                    <div class="rm-detail-img">
                        <img src="{{ asset('assets/images/room/room-4.jpg') }}" alt="Teak Wood Cottage">
                        <div class="rm-detail-img-overlay"></div>
                        <div class="rm-detail-img-badge"><span class="rm-badge rm-badge-gold">Popular</span><span class="rm-badge rm-badge-green">Cottage</span></div>
                        <div class="rm-detail-img-price"><span class="dp-from">from</span><span class="dp-amount">&#8377;5,200</span><span class="dp-per">/night</span></div>
                    </div>
                    <div class="rm-detail-content">
                        <span class="rm-label">Private Cottage</span>
                        <h3 class="rm-heading" style="font-size:30px;">Teak Wood Cottage</h3>
                        <div class="rm-divider"><span></span><i class="fa-solid fa-tree"></i><span></span></div>
                        <p class="rm-body mb-4">A standalone cottage built entirely with reclaimed teak wood. The warm natural grain of the walls, the scent of the timber, and the private sit-out verandah with sweeping forest views make this our most requested room for romantic getaways.</p>
                        <ul class="rm-detail-features">
                            <li><i class="fa-solid fa-check"></i> King-size bed with premium forest linen</li>
                            <li><i class="fa-solid fa-check"></i> Private sit-out verandah facing the forest</li>
                            <li><i class="fa-solid fa-check"></i> Open rain shower with forest-view window</li>
                            <li><i class="fa-solid fa-check"></i> Air conditioning + ceiling fan</li>
                        </ul>
                        <div class="rm-detail-specs"><span class="rm-spec"><i class="fa-solid fa-users"></i> Up to 2</span><span class="rm-spec"><i class="fa-solid fa-snowflake"></i> AC</span></div>
                        <div class="d-flex gap-3 flex-wrap"><a href="{{ route('booking') }}" class="rm-btn rm-btn-primary">Book This Cottage</a><a href="{{ route('contact') }}" class="rm-btn rm-btn-gold">Enquire</a></div>
                    </div>
                </div>
                <div class="rm-detail-row reverse wow fadeInUp" data-wow-delay=".2s">
                    <div class="rm-detail-img">
                        <img src="{{ asset('assets/images/room/room-8.jpg') }}" alt="Treetop Loft">
                        <div class="rm-detail-img-overlay"></div>
                        <div class="rm-detail-img-badge"><span class="rm-badge rm-badge-gold">Premium</span></div>
                        <div class="rm-detail-img-price"><span class="dp-from">from</span><span class="dp-amount">&#8377;6,500</span><span class="dp-per">/night</span></div>
                    </div>
                    <div class="rm-detail-content">
                        <span class="rm-label">Premium Room</span>
                        <h3 class="rm-heading" style="font-size:30px;">Treetop Loft Room</h3>
                        <div class="rm-divider"><span></span><i class="fa-solid fa-binoculars"></i><span></span></div>
                        <p class="rm-body mb-4">Elevated on a raised teak platform within the Mahua canopy, this unique loft room offers unobstructed treetop views from every angle. Wake up to birdsong at eye-level with the forest.</p>
                        <ul class="rm-detail-features">
                            <li><i class="fa-solid fa-check"></i> King-size bed facing the canopy</li>
                            <li><i class="fa-solid fa-check"></i> 270° panoramic private balcony</li>
                            <li><i class="fa-solid fa-check"></i> Floor-to-ceiling forest-view windows</li>
                            <li><i class="fa-solid fa-check"></i> Air conditioning + ceiling fan</li>
                        </ul>
                        <div class="rm-detail-specs"><span class="rm-spec"><i class="fa-solid fa-users"></i> Up to 2</span><span class="rm-spec"><i class="fa-solid fa-snowflake"></i> AC</span></div>
                        <div class="d-flex gap-3 flex-wrap"><a href="{{ route('booking') }}" class="rm-btn rm-btn-primary">Book This Room</a><a href="{{ route('contact') }}" class="rm-btn rm-btn-gold">Enquire</a></div>
                    </div>
                </div>
                <div class="rm-detail-row wow fadeInUp" data-wow-delay=".2s">
                    <div class="rm-detail-img">
                        <img src="{{ asset('assets/images/room/room-6.jpg') }}" alt="Forest Family Cabin">
                        <div class="rm-detail-img-overlay"></div>
                        <div class="rm-detail-img-badge"><span class="rm-badge rm-badge-green">Family</span></div>
                        <div class="rm-detail-img-price"><span class="dp-from">from</span><span class="dp-amount">&#8377;7,000</span><span class="dp-per">/night</span></div>
                    </div>
                    <div class="rm-detail-content">
                        <span class="rm-label">Family Cabin</span>
                        <h3 class="rm-heading" style="font-size:30px;">Forest Family Cabin</h3>
                        <div class="rm-divider"><span></span><i class="fa-solid fa-people-roof"></i><span></span></div>
                        <p class="rm-body mb-4">Designed for families who want to experience the forest together. A two-room cabin with a king bedroom for parents and a separate bunk area for children, connected by a cosy shared living space.</p>
                        <ul class="rm-detail-features">
                            <li><i class="fa-solid fa-check"></i> 1 King bedroom + 1 Kids bunk room</li>
                            <li><i class="fa-solid fa-check"></i> Shared living area with sofa seating</li>
                            <li><i class="fa-solid fa-check"></i> Large forest-facing deck</li>
                            <li><i class="fa-solid fa-check"></i> Kids welcome kit included</li>
                        </ul>
                        <div class="rm-detail-specs"><span class="rm-spec"><i class="fa-solid fa-users"></i> 2+2 Guests</span><span class="rm-spec"><i class="fa-solid fa-snowflake"></i> AC</span></div>
                        <div class="d-flex gap-3 flex-wrap"><a href="{{ route('booking') }}" class="rm-btn rm-btn-primary">Book This Cabin</a><a href="{{ route('contact') }}" class="rm-btn rm-btn-gold">Enquire</a></div>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <!-- COMPARISON TABLE -->
        <section class="rm-section">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="rm-label wow fadeInUp" data-wow-delay=".1s">At a Glance</span>
                        <h2 class="rm-heading wow fadeInUp" data-wow-delay=".2s">Compare All <em>Rooms</em></h2>
                        <div class="rm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-table"></i><span></span></div>
                    </div>
                </div>
                <div class="wow fadeInUp" data-wow-delay=".3s" style="overflow-x:auto; border-radius:16px; box-shadow:0 4px 32px rgba(3,54,49,0.1);">
                    <table class="rm-compare-table">
                        <thead><tr><th>Room</th><th>Size</th><th>Guests</th><th>Price/Night</th><th>AC</th><th>Pool</th><th>Verandah</th><th>Breakfast</th></tr></thead>
                        <tbody id="rm-compare-tbody">
                            <tr><td>Forest View Room</td><td>280 sq ft</td><td>1–2</td><td class="rc-price">&#8377;3,500</td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-xmark rc-cross"></i></td><td><i class="fa-solid fa-check rc-check"></i></td></tr>
                            <tr><td>Bamboo Nest Room</td><td>320 sq ft</td><td>1–2</td><td class="rc-price">&#8377;4,200</td><td><i class="fa-solid fa-xmark rc-cross"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td></tr>
                            <tr><td>Teak Wood Cottage</td><td>420 sq ft</td><td>2</td><td class="rc-price">&#8377;5,200</td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td></tr>
                            <tr><td>Treetop Loft Room</td><td>480 sq ft</td><td>2</td><td class="rc-price">&#8377;6,500</td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td></tr>
                            <tr><td>Forest Family Cabin</td><td>580 sq ft</td><td>2+2</td><td class="rc-price">&#8377;7,000</td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td></tr>
                            <tr style="background:rgba(218,165,32,0.05);"><td><strong style="color:#DAA520;">The Mahua Suite ★</strong></td><td>650 sq ft</td><td>2</td><td class="rc-price">&#8377;8,500</td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td><td><i class="fa-solid fa-check rc-check"></i></td></tr>
                        </tbody>
                    </table>
                </div>
                <p style="font-size:13px;color:rgba(3,54,49,0.5);margin-top:14px;text-align:center;">All prices are per night. Pool access included for all room types.</p>
            </div>
        </section>

        <!-- RESORT AMENITIES -->
        <section class="rm-section rm-section-alt">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="rm-label wow fadeInUp" data-wow-delay=".1s">Included for All Guests</span>
                        <h2 class="rm-heading wow fadeInUp" data-wow-delay=".2s">Resort <em>Amenities</em></h2>
                        <div class="rm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                        <p class="rm-body wow fadeInUp" data-wow-delay=".35s">Every staying guest has full access to everything Mahua House has to offer.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s"><div class="rm-amenity-block"><div class="rm-amenity-block-icon"><i class="fa-solid fa-person-swimming"></i></div><h5>Forest Pool</h5><p>Natural-edge swimming pool open daily 7 AM–7 PM. Towels and changing rooms included.</p></div></div>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s"><div class="rm-amenity-block"><div class="rm-amenity-block-icon"><i class="fa-solid fa-utensils"></i></div><h5>Breakfast Included</h5><p>Farm-to-table breakfast for all guests, served on the open verandah from 7:30–10 AM.</p></div></div>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s"><div class="rm-amenity-block"><div class="rm-amenity-block-icon"><i class="fa-solid fa-person-hiking"></i></div><h5>Nature Trails</h5><p>Guided forest walks through the Samardha Reserve every morning and evening.</p></div></div>
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s"><div class="rm-amenity-block"><div class="rm-amenity-block-icon"><i class="fa-solid fa-fire-flame-curved"></i></div><h5>Campfire Evenings</h5><p>Nightly campfire with folk music, chai and snacks. The most memorable part of every stay.</p></div></div>
                </div>
            </div>
        </section>

        <!-- POLICIES -->
        <section class="rm-section rm-section-cream">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="rm-label wow fadeInUp" data-wow-delay=".1s">Good to Know</span>
                        <h2 class="rm-heading wow fadeInUp" data-wow-delay=".2s">Stay <em>Policies</em></h2>
                        <div class="rm-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-circle-info"></i><span></span></div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s"><div class="rm-policy-card"><h5><i class="fa-solid fa-clock"></i> Check-in / Out</h5><ul class="rm-policy-list"><li><i class="fa-solid fa-circle-dot"></i> Check-in from 11:00 AM</li><li><i class="fa-solid fa-circle-dot"></i> Check-out by 10:00 AM</li><li><i class="fa-solid fa-circle-dot"></i> Early check-in on request</li><li><i class="fa-solid fa-circle-dot"></i> 24-hr reception</li></ul></div></div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s"><div class="rm-policy-card"><h5><i class="fa-solid fa-ban"></i> Cancellations</h5><ul class="rm-policy-list"><li><i class="fa-solid fa-circle-dot"></i> Free cancellation 7+ days prior</li><li><i class="fa-solid fa-circle-dot"></i> 50% charge within 3–7 days</li><li><i class="fa-solid fa-circle-dot"></i> No-show: 100% charge</li><li><i class="fa-solid fa-circle-dot"></i> Rescheduling always welcome</li></ul></div></div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s"><div class="rm-policy-card"><h5><i class="fa-solid fa-children"></i> Children &amp; Pets</h5><ul class="rm-policy-list"><li><i class="fa-solid fa-circle-dot"></i> Children of all ages welcome</li><li><i class="fa-solid fa-circle-dot"></i> Under 5 stay free</li><li><i class="fa-solid fa-circle-dot"></i> Ages 5–12 at 50% adult rate</li><li><i class="fa-solid fa-circle-dot"></i> Pet-friendly (request in advance)</li></ul></div></div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".5s"><div class="rm-policy-card"><h5><i class="fa-solid fa-circle-info"></i> General Rules</h5><ul class="rm-policy-list"><li><i class="fa-solid fa-circle-dot"></i> Non-smoking in all rooms</li><li><i class="fa-solid fa-circle-dot"></i> Quiet hours after 10 PM</li><li><i class="fa-solid fa-circle-dot"></i> Plastic-free resort</li><li><i class="fa-solid fa-circle-dot"></i> Forest trail safety rules apply</li></ul></div></div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="rm-section">
            <div class="container">
                <div class="rm-cta-box wow fadeInUp" data-wow-delay=".2s">
                    <div style="position:relative;z-index:1;">
                        <span class="rm-label rm-label-light">Ready to Book?</span>
                        <h2 class="rm-heading rm-heading-light" style="margin-bottom:14px;">Your Forest Room is <em>Waiting</em></h2>
                        <p class="rm-body rm-body-light" style="max-width:520px;margin:0 auto 36px;">Check availability, choose your room and book directly for the best rates.</p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="{{ route('booking') }}" class="rm-btn rm-btn-gold">Check Availability</a>
                            <a href="{{ route('stay') }}" class="rm-btn rm-btn-outline">More About Stay</a>
                            <a href="{{ route('contact') }}" class="rm-btn rm-btn-outline">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection

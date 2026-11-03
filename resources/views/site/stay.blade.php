@extends('layouts.app')
@section('title', 'Stay | Mahua House')
@section('meta_description', 'Stay at Mahua House — boutique forest rooms, luxury cottages and nature suites in Bhopal\'s most enchanting eco retreat.')
@section('meta_keywords', 'Stay Mahua House, Forest Resort Rooms Bhopal, Eco Cottage, Nature Suite, Forest Hotel Bhopal')

@section('styles')
<style>
    /* =============================================
       STAY PAGE — STYLES
       Palette: #033631 | #DAA520 | #E7EEEE
       ============================================= */

    .st-section       { padding: 90px 0; }
    .st-section-alt   { background: #E7EEEE; }
    .st-section-dark  { background: #033631; }
    .st-section-cream { background: #faf8f3; }

    .st-label {
        display: inline-block; font-size: 11px; font-weight: 700;
        letter-spacing: 4px; text-transform: uppercase;
        color: #DAA520; margin-bottom: 12px;
    }
    .st-label-light { color: rgba(218,165,32,0.9); }

    .st-heading {
        font-size: clamp(28px, 3.5vw, 44px); font-weight: 700;
        color: #033631; line-height: 1.2; margin-bottom: 14px;
    }
    .st-heading-light { color: #ffffff; }
    .st-heading em { font-style: normal; color: #DAA520; }

    .st-divider {
        display: flex; align-items: center;
        gap: 12px; color: #DAA520; margin-bottom: 22px;
    }
    .st-divider.centered { justify-content: center; }
    .st-divider span { display: block; width: 60px; height: 1px; background: #DAA520; }
    .st-divider i { font-size: 9px; }

    .st-body {
        font-size: 15px; color: rgba(3,54,49,0.6);
        line-height: 1.85; margin-bottom: 0;
    }
    .st-body-light { color: rgba(255,255,255,0.62); }

    .st-btn {
        display: inline-block; padding: 13px 30px;
        border-radius: 100px; font-size: 14px; font-weight: 700;
        letter-spacing: 0.5px; text-decoration: none;
        transition: all 0.3s ease; border: 2px solid transparent; cursor: pointer;
    }
    .st-btn-primary { background:#033631; color:#fff; border-color:#033631; }
    .st-btn-primary:hover { background:transparent; color:#033631; }
    .st-btn-gold    { background:#DAA520; color:#033631; border-color:#DAA520; }
    .st-btn-gold:hover { background:transparent; color:#DAA520; }
    .st-btn-outline { background:transparent; color:#fff; border-color:rgba(255,255,255,0.45); }
    .st-btn-outline:hover { background:#DAA520; color:#033631; border-color:#DAA520; }
    .st-btn-sm { padding: 10px 22px; font-size: 13px; }

    .st-hero {
        position: relative; height: 600px;
        background: url('{{ asset("assets/images/room/room-1.jpg") }}') center center / cover no-repeat;
        display: flex; align-items: flex-end; overflow: hidden;
    }
    .st-hero::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(3,54,49,0.25) 0%, rgba(3,54,49,0.88) 100%);
    }
    .st-hero-content {
        position: relative; z-index: 2;
        padding-bottom: 90px; width: 100%;
    }
    .st-breadcrumb {
        list-style: none; padding: 0; margin: 0 0 14px;
        display: flex; align-items: center; gap: 8px;
    }
    .st-breadcrumb li { font-size: 13px; color: rgba(255,255,255,0.5); }
    .st-breadcrumb li a { color: #DAA520; text-decoration: none; }
    .st-breadcrumb li + li::before { content: '/'; margin-right: 8px; }
    .st-hero h1 {
        font-size: clamp(38px, 5vw, 72px); font-weight: 800;
        color: #fff; line-height: 1.1; margin-bottom: 18px;
    }
    .st-hero h1 em { font-style: italic; color: #DAA520; }
    .st-hero p {
        font-size: 16px; color: rgba(255,255,255,0.75);
        max-width: 520px; line-height: 1.75; margin-bottom: 30px;
    }
    .st-hero-shape {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 2; line-height: 0;
    }
    .st-hero-shape img { width: 100%; }

    .st-filter-tabs {
        display: flex; flex-wrap: wrap; gap: 10px;
        justify-content: center; margin-bottom: 48px;
    }
    .st-filter-tab {
        padding: 10px 24px; border-radius: 100px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        border: 1.5px solid rgba(3,54,49,0.2);
        color: rgba(3,54,49,0.6); background: #fff;
        transition: all 0.25s ease; text-decoration: none;
    }
    .st-filter-tab:hover,
    .st-filter-tab.active {
        background: #033631; color: #fff; border-color: #033631;
    }

    .st-room-card {
        background: #fff; border-radius: 20px; overflow: hidden;
        border: 1px solid rgba(3,54,49,0.08);
        box-shadow: 0 4px 24px rgba(3,54,49,0.07);
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        height: 100%;
        display: flex; flex-direction: column;
    }
    .st-room-card:hover { transform: translateY(-8px); box-shadow: 0 24px 60px rgba(3,54,49,0.15); }

    .st-room-img {
        position: relative; height: 260px; overflow: hidden; flex-shrink: 0;
    }
    .st-room-img img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.55s ease;
    }
    .st-room-card:hover .st-room-img img { transform: scale(1.07); }

    .st-room-badges {
        position: absolute; top: 14px; left: 14px;
        display: flex; gap: 8px; flex-wrap: wrap;
    }
    .st-room-badge {
        font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; padding: 5px 12px; border-radius: 100px;
    }
    .st-badge-green { background: #033631; color: #fff; }
    .st-badge-gold  { background: #DAA520; color: #033631; }
    .st-badge-white { background: rgba(255,255,255,0.92); color: #033631; }

    .st-room-price-tag {
        position: absolute; bottom: 14px; right: 14px;
        background: rgba(3,54,49,0.88); backdrop-filter: blur(6px);
        border-radius: 10px; padding: 8px 14px; text-align: right;
    }
    .st-room-price-tag .from { font-size: 10px; color: rgba(255,255,255,0.5); display: block; }
    .st-room-price-tag .price { font-size: 20px; font-weight: 800; color: #DAA520; line-height: 1; }
    .st-room-price-tag .night { font-size: 10px; color: rgba(255,255,255,0.5); }

    .st-room-body { padding: 26px; flex: 1; display: flex; flex-direction: column; }
    .st-room-type { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #DAA520; margin-bottom: 6px; }
    .st-room-title { font-size: 20px; font-weight: 700; color: #033631; margin-bottom: 10px; }
    .st-room-desc { font-size: 13px; color: rgba(3,54,49,0.55); line-height: 1.7; margin-bottom: 18px; flex: 1; }

    .st-room-amenities {
        display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
    }
    .st-amenity {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; color: rgba(3,54,49,0.6); font-weight: 500;
        background: rgba(3,54,49,0.05); border-radius: 100px;
        padding: 5px 12px;
    }
    .st-amenity i { color: #DAA520; font-size: 10px; }

    .st-room-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 16px; border-top: 1px solid rgba(3,54,49,0.08);
        gap: 10px; flex-wrap: wrap;
    }
    .st-room-capacity { font-size: 13px; color: rgba(3,54,49,0.5); }
    .st-room-capacity i { color: #DAA520; margin-right: 4px; }

    .st-featured-room {
        display: grid; grid-template-columns: 1fr 1fr;
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 12px 50px rgba(3,54,49,0.14);
        border: 1px solid rgba(3,54,49,0.08);
    }
    .st-featured-img { position: relative; min-height: 500px; }
    .st-featured-img img { width: 100%; height: 100%; object-fit: cover; }
    .st-featured-content {
        background: #fff; padding: 56px 48px;
        display: flex; flex-direction: column; justify-content: center;
    }
    .st-featured-amenities {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 12px 20px; margin-bottom: 32px;
    }
    .st-feat-amenity {
        display: flex; align-items: center; gap: 10px;
        font-size: 13px; color: rgba(3,54,49,0.65); font-weight: 500;
    }
    .st-feat-amenity .fa-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: rgba(218,165,32,0.15); color: #DAA520;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; flex-shrink: 0;
    }
    .st-featured-price {
        display: flex; align-items: baseline; gap: 6px; margin-bottom: 28px;
    }
    .st-featured-price .curr { font-size: 16px; color: rgba(3,54,49,0.5); font-weight: 600; }
    .st-featured-price .amt  { font-size: 42px; font-weight: 800; color: #033631; line-height: 1; }
    .st-featured-price .per  { font-size: 14px; color: rgba(3,54,49,0.45); }

    .st-amenity-big-card {
        background: #fff; border-radius: 18px; padding: 32px 26px; text-align: center;
        border: 1px solid rgba(3,54,49,0.08);
        box-shadow: 0 4px 20px rgba(3,54,49,0.06);
        transition: transform 0.35s ease, box-shadow 0.35s ease, background 0.35s ease;
        height: 100%;
    }
    .st-amenity-big-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 44px rgba(3,54,49,0.13);
        background: #033631;
    }
    .st-amenity-big-icon {
        width: 64px; height: 64px; border-radius: 18px; margin: 0 auto 18px;
        background: rgba(3,54,49,0.07); border: 1px solid rgba(3,54,49,0.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; color: #033631;
        transition: background 0.35s, color 0.35s, border-color 0.35s;
    }
    .st-amenity-big-card:hover .st-amenity-big-icon { background: #DAA520; color: #033631; border-color: #DAA520; }
    .st-amenity-big-title {
        font-size: 15px; font-weight: 700; color: #033631; margin-bottom: 8px;
        transition: color 0.35s;
    }
    .st-amenity-big-card:hover .st-amenity-big-title { color: #DAA520; }
    .st-amenity-big-text {
        font-size: 13px; color: rgba(3,54,49,0.5); line-height: 1.65; margin: 0;
        transition: color 0.35s;
    }
    .st-amenity-big-card:hover .st-amenity-big-text { color: rgba(255,255,255,0.6); }

    .st-exp-item {
        display: flex; align-items: flex-start; gap: 18px;
        padding: 22px 0; border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .st-exp-item:first-child { padding-top: 0; }
    .st-exp-item:last-child  { border-bottom: none; padding-bottom: 0; }
    .st-exp-icon {
        width: 50px; height: 50px; min-width: 50px; border-radius: 14px;
        background: rgba(218,165,32,0.15); border: 1px solid rgba(218,165,32,0.3);
        display: flex; align-items: center; justify-content: center;
        color: #DAA520; font-size: 20px;
    }
    .st-exp-title { font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .st-exp-text  { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.65; margin: 0; }

    .st-gallery {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        grid-template-rows: 260px 200px;
        gap: 10px;
    }
    .st-gallery .sg { border-radius: 14px; overflow: hidden; position: relative; }
    .st-gallery .sg-tall { grid-row: span 2; }
    .st-gallery .sg img { width:100%; height:100%; object-fit:cover; transition: transform 0.5s; }
    .st-gallery .sg:hover img { transform: scale(1.06); }
    .st-gallery .sg-ov {
        position: absolute; inset: 0;
        background: rgba(3,54,49,0.35); opacity: 0; transition: opacity 0.35s;
        display: flex; align-items: center; justify-content: center; color: #DAA520; font-size: 26px;
    }
    .st-gallery .sg:hover .sg-ov { opacity: 1; }

    .st-policy-card {
        background: #fff; border-radius: 18px; padding: 32px;
        border: 1px solid rgba(3,54,49,0.08);
        box-shadow: 0 4px 20px rgba(3,54,49,0.06); height: 100%;
    }
    .st-policy-title {
        font-size: 17px; font-weight: 700; color: #033631;
        margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
    }
    .st-policy-title i { color: #DAA520; }
    .st-policy-list { list-style: none; padding: 0; margin: 0; }
    .st-policy-list li {
        display: flex; align-items: flex-start; gap: 10px;
        font-size: 13px; color: rgba(3,54,49,0.6); line-height: 1.65;
        padding: 9px 0; border-bottom: 1px solid rgba(3,54,49,0.07);
    }
    .st-policy-list li:last-child { border-bottom: none; }
    .st-policy-list li i { color: #DAA520; font-size: 11px; margin-top: 3px; flex-shrink: 0; }

    .st-cta-box {
        background: linear-gradient(135deg, #033631 0%, #07554D 100%);
        border-radius: 24px; padding: 70px 60px; text-align: center;
        position: relative; overflow: hidden;
    }
    .st-cta-box::before { content:''; position:absolute; top:-100px; right:-100px; width:350px; height:350px; border-radius:50%; background:rgba(218,165,32,0.08); }
    .st-cta-box::after  { content:''; position:absolute; bottom:-80px; left:-80px; width:260px; height:260px; border-radius:50%; background:rgba(218,165,32,0.06); }

    @media (max-width: 991px) {
        .st-hero { height: 480px; }
        .st-section { padding: 70px 0; }
        .st-featured-room { grid-template-columns: 1fr; }
        .st-featured-img { min-height: 320px; }
        .st-featured-content { padding: 36px 28px; }
        .st-gallery { grid-template-columns: 1fr 1fr; grid-template-rows: 200px 200px 200px; }
        .st-gallery .sg-tall { grid-row: span 1; }
        .st-cta-box { padding: 50px 28px; }
    }
    @media (max-width: 767px) {
        .st-featured-amenities { grid-template-columns: 1fr; }
        .st-gallery { grid-template-columns: 1fr; grid-template-rows: repeat(5, 200px); }
    }
    @media (max-width: 575px) {
        .st-hero h1 { font-size: 32px; }
        .st-cta-box { padding: 40px 20px; }
    }
</style>
@endsection

@section('content')

    <!-- HERO -->
    <section class="st-hero">
        <div class="container st-hero-content">
            <ul class="st-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Stay</li>
            </ul>
            <span class="st-label wow fadeInUp" data-wow-delay=".2s">Sleep in the Forest</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size: 30px;">
                Wake Up to<br><em>Birdsong &amp; Trees</em>
            </h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">
                Boutique rooms and nature cottages designed to bring you closer to the forest — without giving up a single comfort.
            </p>
        </div>
        <div class="st-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>


    <!-- FEATURED ROOM -->
    <section class="st-section" style="padding-top: 110px;">
        <div class="container">
            <div class="row align-items-end mb-5">
                <div class="col-lg-7">
                    <span class="st-label wow fadeInUp" data-wow-delay=".1s">Featured Accommodation</span>
                    <h2 class="st-heading wow fadeInUp" data-wow-delay=".2s">Our <em>Finest Room</em></h2>
                </div>
                <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                    <a href="#rooms" class="st-btn st-btn-primary">All Rooms</a>
                </div>
            </div>
            <div class="st-featured-room wow fadeInUp" data-wow-delay=".3s">
                <div class="st-featured-img">
                    <img src="{{ asset('assets/images/room/room-3.jpg') }}" alt="Super Deluxe AC Room">
                    <div style="position:absolute;top:20px;left:20px;">
                        <span class="st-room-badge st-badge-gold">Most Comfortable</span>
                    </div>
                </div>
                <div class="st-featured-content">
                    <span class="st-label">Featured Room</span>
                    <h2 class="st-heading" style="font-size:32px;">Super Deluxe AC Room</h2>
                    <div class="st-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    <p class="st-body mb-4">Our most comfortable room — spacious AC accommodation with all modern amenities, designed for peaceful stays in the heart of Mahua House's forest property. Ideal for couples, families, and anyone seeking a relaxing getaway away from city life.</p>
                    <div class="st-featured-amenities">
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-bed"></i></div> Double Bed</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-snowflake"></i></div> Air Conditioning</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-shower"></i></div> En-suite Bathroom</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-fire"></i></div> Hot Water</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-tv"></i></div> Television</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-wifi"></i></div> Wi-Fi</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-bolt"></i></div> Power Backup</div>
                        <div class="st-feat-amenity"><div class="fa-icon"><i class="fa-solid fa-tree"></i></div> Forest View</div>
                    </div>
                    <div class="st-featured-price">
                        <span class="curr">₹</span>
                        <span class="amt">3,500</span>
                        <span class="per">/ night</span>
                    </div>
                    <p style="font-size:13px;color:rgba(3,54,49,0.55);margin-bottom:20px;">Check-in: 11:00 AM &nbsp;|&nbsp; Check-out: 10:00 AM &nbsp;|&nbsp; Double Occupancy</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="st-btn st-btn-primary"><i class="fa-brands fa-whatsapp me-2"></i>Book via WhatsApp</a>
                        <a href="{{ route('contact') }}" class="st-btn st-btn-gold">Enquire</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ALL ROOMS GRID -->
    <section class="st-section st-section-alt" id="rooms">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="st-label wow fadeInUp" data-wow-delay=".1s">Our Accommodations</span>
                    <h2 class="st-heading wow fadeInUp" data-wow-delay=".2s">Choose Your <em>Forest Retreat</em></h2>
                    <div class="st-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="st-body wow fadeInUp" data-wow-delay=".4s">Three comfortable accommodation options — all double occupancy, all surrounded by nature. Book via WhatsApp for the quickest confirmation.</p>
                </div>
            </div>

            <div class="st-filter-tabs wow fadeInUp" data-wow-delay=".3s">
                <a href="#" class="st-filter-tab active">All Rooms</a>
                <a href="#" class="st-filter-tab">Super Deluxe</a>
                <a href="#" class="st-filter-tab">Deluxe AC</a>
                <a href="#" class="st-filter-tab">Cottage</a>
            </div>

            <div class="row g-4">

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="st-room-card">
                        <div class="st-room-img">
                            <img src="{{ asset('assets/images/room/room-2.jpg') }}" alt="Super Deluxe AC Room">
                            <div class="st-room-badges"><span class="st-room-badge st-badge-green">Super Deluxe</span></div>
                            <div class="st-room-price-tag">
                                <span class="from">from</span>
                                <span class="price">₹3,500</span>
                                <span class="night">/night</span>
                            </div>
                        </div>
                        <div class="st-room-body">
                            <span class="st-room-type">Super Deluxe</span>
                            <h4 class="st-room-title">Super Deluxe AC Room</h4>
                            <p class="st-room-desc">Spacious, well-ventilated AC room with double bed and all essential amenities for a comfortable forest stay.</p>
                            <div class="st-room-amenities">
                                <span class="st-amenity"><i class="fa-solid fa-bed"></i> Double Bed</span>
                                <span class="st-amenity"><i class="fa-solid fa-snowflake"></i> AC</span>
                                <span class="st-amenity"><i class="fa-solid fa-shower"></i> En-suite</span>
                                <span class="st-amenity"><i class="fa-solid fa-tv"></i> TV</span>
                            </div>
                            <div class="st-room-footer">
                                <span class="st-room-capacity"><i class="fa-solid fa-user-group"></i> 2 Guests</span>
                                <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="st-btn st-btn-primary st-btn-sm">Book via WhatsApp</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="st-room-card">
                        <div class="st-room-img">
                            <img src="{{ asset('assets/images/room/room-4.jpg') }}" alt="Deluxe AC Room">
                            <div class="st-room-badges">
                                <span class="st-room-badge st-badge-gold">Popular</span>
                                <span class="st-room-badge st-badge-green">Deluxe</span>
                            </div>
                            <div class="st-room-price-tag">
                                <span class="from">from</span>
                                <span class="price">₹3,000</span>
                                <span class="night">/night</span>
                            </div>
                        </div>
                        <div class="st-room-body">
                            <span class="st-room-type">Deluxe</span>
                            <h4 class="st-room-title">Deluxe AC Room</h4>
                            <p class="st-room-desc">Comfortable AC room with a double bed, en-suite bathroom and forest-facing window — ideal for couples and families seeking a peaceful retreat.</p>
                            <div class="st-room-amenities">
                                <span class="st-amenity"><i class="fa-solid fa-bed"></i> Double Bed</span>
                                <span class="st-amenity"><i class="fa-solid fa-snowflake"></i> AC</span>
                                <span class="st-amenity"><i class="fa-solid fa-shower"></i> Hot Water</span>
                                <span class="st-amenity"><i class="fa-solid fa-tree"></i> Forest View</span>
                            </div>
                            <div class="st-room-footer">
                                <span class="st-room-capacity"><i class="fa-solid fa-user-group"></i> 2 Guests</span>
                                <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="st-btn st-btn-primary st-btn-sm">Book via WhatsApp</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="st-room-card">
                        <div class="st-room-img">
                            <img src="{{ asset('assets/images/room/room-5.jpg') }}" alt="Independent Forest Cottage">
                            <div class="st-room-badges"><span class="st-room-badge st-badge-gold">Cottage</span></div>
                            <div class="st-room-price-tag">
                                <span class="from">from</span>
                                <span class="price">₹2,500</span>
                                <span class="night">/night</span>
                            </div>
                        </div>
                        <div class="st-room-body">
                            <span class="st-room-type">Independent Cottage</span>
                            <h4 class="st-room-title">Independent Forest Cottage</h4>
                            <p class="st-room-desc">A standalone independent cottage nestled within the forest grounds — offering privacy, fresh air, and direct access to nature.</p>
                            <div class="st-room-amenities">
                                <span class="st-amenity"><i class="fa-solid fa-bed"></i> Double Bed</span>
                                <span class="st-amenity"><i class="fa-solid fa-house"></i> Private Space</span>
                                <span class="st-amenity"><i class="fa-solid fa-shower"></i> En-suite</span>
                                <span class="st-amenity"><i class="fa-solid fa-leaf"></i> Forest Access</span>
                            </div>
                            <div class="st-room-footer">
                                <span class="st-room-capacity"><i class="fa-solid fa-user-group"></i> 2 Guests</span>
                                <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="st-btn st-btn-gold st-btn-sm">Book via WhatsApp</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- PROPERTY AMENITIES -->
    <section class="st-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="st-label wow fadeInUp" data-wow-delay=".1s">Resort Amenities</span>
                    <h2 class="st-heading wow fadeInUp" data-wow-delay=".2s">Everything You Need, <em>Nothing You Don't</em></h2>
                    <div class="st-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="st-body wow fadeInUp" data-wow-delay=".4s">Our amenities are chosen to enhance your forest experience — not replace it.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="st-amenity-big-card">
                        <div class="st-amenity-big-icon"><i class="fa-solid fa-person-swimming"></i></div>
                        <h5 class="st-amenity-big-title">Swimming Pool</h5>
                        <p class="st-amenity-big-text">A natural-edge pool surrounded by trees — open daily from 7am to 7pm for all guests.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="st-amenity-big-card">
                        <div class="st-amenity-big-icon"><i class="fa-solid fa-utensils"></i></div>
                        <h5 class="st-amenity-big-title">Restaurant &amp; Cafe</h5>
                        <p class="st-amenity-big-text">Farm-to-table dining with seasonal menus and locally sourced ingredients. In-room dining available.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                    <div class="st-amenity-big-card">
                        <div class="st-amenity-big-icon"><i class="fa-solid fa-fire-flame-curved"></i></div>
                        <h5 class="st-amenity-big-title">Campfire Evenings</h5>
                        <p class="st-amenity-big-text">Gather around the forest campfire every evening — with folk music, storytelling, and stargazing.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="st-amenity-big-card">
                        <div class="st-amenity-big-icon"><i class="fa-solid fa-person-hiking"></i></div>
                        <h5 class="st-amenity-big-title">Guided Forest Treks</h5>
                        <p class="st-amenity-big-text">Morning and sunset guided walks through the Samardha forest with our resident naturalist.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FOREST EXPERIENCE STRIP (DARK) -->
    <section class="st-section st-section-dark">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                    <span class="st-label st-label-light">Your Day at Mahua House</span>
                    <h2 class="st-heading st-heading-light">A Typical <em>Forest Day</em></h2>
                    <div class="st-divider"><span></span><i class="fa-solid fa-sun"></i><span></span></div>
                    <p class="st-body st-body-light mb-4">No schedules. No alarms. Just a gentle rhythm set by the forest itself. Here's what a day at Mahua House can look like.</p>
                    <a href="{{ route('contact') }}" class="st-btn st-btn-gold">Plan Your Stay</a>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                    <div class="st-exp-item">
                        <div class="st-exp-icon"><i class="fa-solid fa-sun"></i></div>
                        <div>
                            <h5 class="st-exp-title">6:30 AM — Sunrise Birdwatching</h5>
                            <p class="st-exp-text">Greet the day with our naturalist guide as the forest comes alive — peacocks, Indian rollers, painted storks and the chorus of the dawn chorus.</p>
                        </div>
                    </div>
                    <div class="st-exp-item">
                        <div class="st-exp-icon"><i class="fa-solid fa-bowl-food"></i></div>
                        <div>
                            <h5 class="st-exp-title">8:00 AM — Farm Breakfast</h5>
                            <p class="st-exp-text">A leisurely farm-to-table breakfast on the verandah — seasonal fruits, hot parathas, local honey, and filter coffee as the forest hums around you.</p>
                        </div>
                    </div>
                    <div class="st-exp-item">
                        <div class="st-exp-icon"><i class="fa-solid fa-person-hiking"></i></div>
                        <div>
                            <h5 class="st-exp-title">10:00 AM — Forest Trail Walk</h5>
                            <p class="st-exp-text">Take a guided walk through the Samardha forest. Learn about medicinal plants, spot wildlife tracks, and breathe the cleanest air you've had in years.</p>
                        </div>
                    </div>
                    <div class="st-exp-item">
                        <div class="st-exp-icon"><i class="fa-solid fa-spa"></i></div>
                        <div>
                            <h5 class="st-exp-title">2:00 PM — Pool Time</h5>
                            <p class="st-exp-text">Unwind with an Ayurvedic massage, float in the natural-edge pool, or simply read in a hammock as the afternoon light filters through the trees.</p>
                        </div>
                    </div>
                    <div class="st-exp-item">
                        <div class="st-exp-icon"><i class="fa-solid fa-fire-flame-curved"></i></div>
                        <div>
                            <h5 class="st-exp-title">7:00 PM — Campfire &amp; Folk Music</h5>
                            <p class="st-exp-text">As darkness falls, gather around the campfire. Folk musicians play, stories are shared, dinner is served under a canopy of stars. Sleep comes easy here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- GALLERY -->
    <section class="st-section st-section-cream">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="st-label wow fadeInUp" data-wow-delay=".1s">Room Gallery</span>
                    <h2 class="st-heading wow fadeInUp" data-wow-delay=".2s">Inside <em>Mahua House</em></h2>
                </div>
                <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('booking') }}" class="st-btn st-btn-primary">Book a Room</a>
                </div>
            </div>
            <div class="st-gallery wow fadeInUp" data-wow-delay=".3s">
                <div class="sg sg-tall">
                    <img src="{{ asset('assets/images/room/room-9.jpg') }}" alt="Room">
                    <div class="sg-ov"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                </div>
                <div class="sg">
                    <img src="{{ asset('assets/images/about/18.jpeg') }}" alt="Cottage">
                    <div class="sg-ov"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                </div>
                <div class="sg">
                    <img src="{{ asset('assets/images/about/24.jpeg') }}" alt="Verandah">
                    <div class="sg-ov"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                </div>
                <div class="sg">
                    <img src="{{ asset('assets/images/services/swimming-pool.jpg') }}" alt="Pool">
                    <div class="sg-ov"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                </div>
                <div class="sg">
                    <img src="{{ asset('assets/images/services/restaurant-bar.jpg') }}" alt="Restaurant">
                    <div class="sg-ov"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                </div>
            </div>
        </div>
    </section>


    <!-- POLICIES -->
    <section class="st-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="st-label wow fadeInUp" data-wow-delay=".1s">Good to Know</span>
                    <h2 class="st-heading wow fadeInUp" data-wow-delay=".2s">Stay <em>Policies</em></h2>
                    <div class="st-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                    <div class="st-policy-card">
                        <h5 class="st-policy-title"><i class="fa-solid fa-clock"></i> Check-in / Out</h5>
                        <ul class="st-policy-list">
                            <li><i class="fa-solid fa-circle-dot"></i> Check-in from 11:00 AM</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Check-out by 10:00 AM</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Early check-in on request</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Late checkout available (fee may apply)</li>
                            <li><i class="fa-solid fa-circle-dot"></i> 24-hr reception for staying guests</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                    <div class="st-policy-card">
                        <h5 class="st-policy-title"><i class="fa-solid fa-ban"></i> Cancellations</h5>
                        <ul class="st-policy-list">
                            <li><i class="fa-solid fa-circle-dot"></i> Free cancellation 7+ days prior</li>
                            <li><i class="fa-solid fa-circle-dot"></i> 50% charge within 7 days</li>
                            <li><i class="fa-solid fa-circle-dot"></i> No-show: 100% charge</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Peak season — special policy applies</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Event bookings — separate terms</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                    <div class="st-policy-card">
                        <h5 class="st-policy-title"><i class="fa-solid fa-child"></i> Children &amp; Pets</h5>
                        <ul class="st-policy-list">
                            <li><i class="fa-solid fa-circle-dot"></i> Children of all ages welcome</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Under 5 stay free</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Extra bed available on request</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Pet-friendly on pre-arrangement</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Pet fee: ₹500/night</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                    <div class="st-policy-card">
                        <h5 class="st-policy-title"><i class="fa-solid fa-circle-info"></i> General Rules</h5>
                        <ul class="st-policy-list">
                            <li><i class="fa-solid fa-circle-dot"></i> Non-smoking inside rooms</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Designated smoking area available</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Quiet hours after 10:00 PM</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Outside food &amp; alcohol policy applies</li>
                            <li><i class="fa-solid fa-circle-dot"></i> Respect the forest &amp; wildlife</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA -->
    <section class="st-section">
        <div class="container">
            <div class="st-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="st-label st-label-light">Ready to Stay?</span>
                    <h2 class="st-heading st-heading-light" style="margin-bottom:14px;">
                        Your Forest Room is <em>Waiting</em>
                    </h2>
                    <p class="st-body st-body-light" style="max-width:520px;margin:0 auto 36px;">
                        Book your stay at Mahua House directly via WhatsApp or phone. We confirm quickly and welcome you to the forest.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="https://www.facebook.com/mahuahouse" target="_blank" rel="noopener" class="st-btn st-btn-outline"><i class="fa-brands fa-facebook-f me-2"></i>Visit Facebook</a>
                        <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="st-btn st-btn-gold"><i class="fa-brands fa-whatsapp me-2"></i>WhatsApp Enquiry</a>
                        <a href="{{ route('contact') }}" class="st-btn st-btn-outline">Enquire Today</a>
                        <a href="tel:+919425651754" class="st-btn st-btn-outline"><i class="fa-solid fa-phone me-2"></i>Call Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

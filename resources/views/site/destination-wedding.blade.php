@extends('layouts.app')

@section('title', $sections['meta_title'] ?? 'Destination Wedding | Mahua House')
@section('meta_description', $sections['meta_description'] ?? 'Host your dream forest wedding at Mahua House, Bhopal — with four named venues, full planning support, and a 3.5-acre natural setting.')
@section('meta_keywords', $sections['meta_keywords'] ?? 'Destination Wedding Bhopal, Forest Wedding Venue, Mahua House Wedding, Outdoor Wedding Bhopal')

@section('styles')
<style>
    .dw-hero { position: relative; height: 560px; background: url('{{ $sections["hero_image"] ?? asset("assets/images/about/1.jpeg") }}') center center / cover no-repeat; display: flex; align-items: flex-end; }
    .dw-hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(3,54,49,0.45) 0%, rgba(3,54,49,0.75) 100%); }
    .dw-hero-content { position: relative; z-index: 2; padding-bottom: 70px; width: 100%; }
    .dw-hero-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #DAA520; margin-bottom: 14px; }
    .dw-hero h1 { font-size: clamp(36px, 5vw, 68px); font-weight: 800; color: #ffffff; line-height: 1.15; margin-bottom: 20px; }
    .dw-hero h1 em { font-style: italic; color: #DAA520; }
    .dw-hero p { font-size: 17px; color: rgba(255,255,255,0.8); max-width: 540px; line-height: 1.7; margin-bottom: 32px; }
    .dw-hero-shape { position: absolute; bottom: 0; left: 0; right: 0; z-index: 2; line-height: 0; }
    .dw-hero-shape img { width: 100%; }
    .dw-breadcrumb { display: flex; align-items: center; gap: 8px; list-style: none; padding: 0; margin: 0 0 20px; }
    .dw-breadcrumb li { font-size: 14px; color: rgba(255,255,255,0.6); }
    .dw-breadcrumb li a { color: #DAA520; text-decoration: none; }
    .dw-breadcrumb li + li::before { content: '/'; margin-right: 8px; }
    .dw-section { padding: 90px 0; }
    .dw-section-alt { background: #E7EEEE; }
    .dw-section-dark { background: #033631; }
    .dw-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #DAA520; margin-bottom: 14px; }
    .dw-label-light { color: rgba(218,165,32,0.9); }
    .dw-heading { font-size: clamp(28px, 3.5vw, 42px); font-weight: 700; color: #033631; line-height: 1.25; margin-bottom: 16px; }
    .dw-heading-light { color: #ffffff; }
    .dw-heading em { font-style: normal; color: #DAA520; }
    .dw-divider { display: flex; align-items: center; gap: 12px; color: #DAA520; margin-bottom: 24px; }
    .dw-divider span { display: block; width: 60px; height: 1px; background: #DAA520; }
    .dw-divider i { font-size: 9px; }
    .dw-body-text { font-size: 15px; color: rgba(3,54,49,0.6); line-height: 1.8; margin-bottom: 0; }
    .dw-body-text-light { color: rgba(255,255,255,0.65); }
    .dw-intro-image-wrap { position: relative; }
    .dw-intro-image-wrap .img-main { width: 100%; height: 480px; object-fit: cover; border-radius: 20px; }
    .dw-intro-image-wrap .img-badge { position: absolute; bottom: -24px; right: -20px; width: 160px; height: 160px; border-radius: 16px; object-fit: cover; border: 5px solid #ffffff; box-shadow: 0 12px 40px rgba(3,54,49,0.2); }
    .dw-intro-image-wrap .dw-years-badge { position: absolute; top: 24px; left: -20px; background: #DAA520; color: #ffffff; border-radius: 14px; padding: 18px 22px; text-align: center; box-shadow: 0 8px 30px rgba(218,165,32,0.4); }
    .dw-years-badge .num { font-size: 36px; font-weight: 800; line-height: 1; display: block; }
    .dw-years-badge .txt { font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; opacity: 0.9; }
    .dw-checklist { list-style: none; padding: 0; margin: 28px 0 36px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px 20px; }
    .dw-checklist li { display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; color: #033631; }
    .dw-checklist li i { width: 22px; height: 22px; min-width: 22px; border-radius: 50%; background: #DAA520; color: #033631; display: inline-flex; align-items: center; justify-content: center; font-size: 9px; }
    .dw-why-card { background: #ffffff; border-radius: 16px; padding: 36px 28px; text-align: center; border: 1px solid rgba(3,54,49,0.1); box-shadow: 0 4px 24px rgba(3,54,49,0.06); transition: transform 0.35s ease, box-shadow 0.35s ease, background 0.35s ease; height: 100%; }
    .dw-why-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(3,54,49,0.14); background: #033631; }
    .dw-why-icon { width: 70px; height: 70px; border-radius: 50%; background: rgba(3,54,49,0.07); border: 1px solid rgba(3,54,49,0.15); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 22px; transition: background 0.35s ease, border-color 0.35s ease; }
    .dw-why-icon i { font-size: 28px; color: #033631; transition: color 0.35s ease; }
    .dw-why-card:hover .dw-why-icon { background: #DAA520; border-color: #DAA520; }
    .dw-why-card:hover .dw-why-icon i { color: #033631; }
    .dw-why-title { font-size: 18px; font-weight: 700; color: #033631; margin-bottom: 12px; transition: color 0.35s ease; }
    .dw-why-card:hover .dw-why-title { color: #DAA520; }
    .dw-why-text { font-size: 14px; color: rgba(3,54,49,0.55); line-height: 1.7; margin: 0; transition: color 0.35s ease; }
    .dw-why-card:hover .dw-why-text { color: rgba(255,255,255,0.65); }
    .dw-gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: 240px 240px; gap: 12px; }
    .dw-gallery-grid .dw-gitem { overflow: hidden; border-radius: 14px; position: relative; }
    .dw-gallery-grid .dw-gitem:first-child { grid-row: span 2; }
    .dw-gallery-grid .dw-gitem img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .dw-gallery-grid .dw-gitem:hover img { transform: scale(1.07); }
    .dw-gallery-grid .dw-gitem .dw-overlay { position: absolute; inset: 0; background: rgba(3,54,49,0.4); opacity: 0; transition: opacity 0.35s ease; display: flex; align-items: center; justify-content: center; }
    .dw-gallery-grid .dw-gitem:hover .dw-overlay { opacity: 1; }
    .dw-overlay i { font-size: 28px; color: #DAA520; }
    .dw-timeline { position: relative; padding-left: 50px; }
    .dw-timeline::before { content: ''; position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg, #DAA520, rgba(218,165,32,0.1)); }
    .dw-timeline-item { position: relative; margin-bottom: 40px; }
    .dw-timeline-item:last-child { margin-bottom: 0; }
    .dw-timeline-dot { position: absolute; left: -40px; top: 4px; width: 36px; height: 36px; border-radius: 50%; background: #DAA520; display: flex; align-items: center; justify-content: center; color: #033631; font-size: 13px; font-weight: 800; box-shadow: 0 0 0 4px rgba(218,165,32,0.2); }
    .dw-timeline-title { font-size: 17px; font-weight: 700; color: #ffffff; margin-bottom: 6px; }
    .dw-timeline-text { font-size: 14px; color: rgba(255,255,255,0.55); line-height: 1.7; margin: 0; }
    .dw-cta-box { background: linear-gradient(135deg, #033631 0%, #07554D 100%); border-radius: 24px; padding: 60px 50px; position: relative; overflow: hidden; }
    .dw-cta-box::before { content: ''; position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; border-radius: 50%; background: rgba(218,165,32,0.1); pointer-events: none; }
    .dw-cta-box::after { content: ''; position: absolute; bottom: -60px; left: -60px; width: 220px; height: 220px; border-radius: 50%; background: rgba(218,165,32,0.07); pointer-events: none; }
    .dw-inquiry-form .form-control { border: 1px solid rgba(3,54,49,0.15); border-radius: 10px; padding: 14px 18px; font-size: 14px; color: #033631; background: #ffffff; }
    .dw-inquiry-form .form-control:focus { border-color: #DAA520; box-shadow: 0 0 0 3px rgba(218,165,32,0.15); outline: none; }
    .dw-inquiry-form select.form-control { appearance: none; }
    .dw-inquiry-form textarea.form-control { resize: none; }
    .dw-btn { display: inline-block; padding: 14px 32px; border-radius: 100px; font-size: 14px; font-weight: 700; letter-spacing: 1px; text-decoration: none; text-align: center; transition: all 0.3s ease; }
    .dw-btn-primary { background: #033631; color: #ffffff; border: 2px solid #033631; }
    .dw-btn-primary:hover { background: transparent; color: #033631; }
    .dw-btn-gold { background: #DAA520; color: #033631; border: 2px solid #DAA520; }
    .dw-btn-gold:hover { background: transparent; color: #DAA520; }
    .dw-btn-outline { background: transparent; color: #ffffff; border: 2px solid rgba(255,255,255,0.5); }
    .dw-btn-outline:hover { background: #DAA520; color: #033631; border-color: #DAA520; }
    @media (max-width: 991px) { .dw-hero { height: 420px; } .dw-section { padding: 70px 0; } .dw-intro-image-wrap .img-badge { display: none; } .dw-intro-image-wrap .dw-years-badge { left: 12px; } .dw-cta-box { padding: 40px 28px; } .dw-gallery-grid { grid-template-columns: 1fr 1fr; grid-template-rows: 200px 200px 200px; } .dw-gallery-grid .dw-gitem:first-child { grid-row: span 1; } }
    @media (max-width: 575px) { .dw-hero h1 { font-size: 32px; } .dw-checklist { grid-template-columns: 1fr; } .dw-gallery-grid { grid-template-columns: 1fr; grid-template-rows: repeat(5, 200px); } }
</style>
@endsection

@section('content')

        <!-- ===== HERO ===== -->
        <section class="dw-hero">
            <div class="container dw-hero-content">
                <ul class="dw-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Destination Wedding</li>
                </ul>
                <span class="dw-hero-label wow fadeInUp" data-wow-delay=".2s">
                    {{ $sections['hero_label'] ?? 'Your Dream Awaits' }}
                </span>
                <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size: 30px;">
                    {!! $sections['hero_title'] ?? 'A <em>Forest Wedding</em> Like No Other' !!}
                </h1>
                <p class="wow fadeInUp" data-wow-delay=".4s">
                    {{ $sections['hero_subtitle'] ?? "Say \"I do\" beneath a canopy of ancient Mahua trees at Bhopal's most enchanting eco-retreat." }}
                </p>
            </div>
            <div class="dw-hero-shape">
                <img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape">
            </div>
        </section>
        <!-- ===== HERO END ===== -->


        <!-- ===== INTRO SECTION ===== -->
        <section class="dw-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <!-- Image column -->
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                        <div class="dw-intro-image-wrap">
                            <div class="dw-years-badge">
                                <span class="num">{{ $sections['intro_years_num'] ?? '10+' }}</span>
                                <span class="txt">{!! nl2br(e($sections['intro_years_text'] ?? "Years of\nWeddings")) !!}</span>
                            </div>
                            <img src="{{ $sections['intro_image_main'] ?? asset('assets/images/about/5.jpeg') }}" alt="Wedding at Mahua House" class="img-main">
                            <img src="{{ $sections['intro_image_badge'] ?? asset('assets/images/about/8.jpeg') }}" alt="Wedding detail" class="img-badge">
                        </div>
                    </div>
                    <!-- Content column -->
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                        <span class="dw-label">{{ $sections['intro_label'] ?? 'Complete Destination Wedding Experience' }}</span>
                        <h2 class="dw-heading">{!! $sections['intro_heading'] ?? 'Create Unforgettable Memories <em>Amidst Nature</em>' !!}</h2>
                        <div class="dw-divider"><span></span><i class="fa-solid fa-heart"></i><span></span></div>
                        <p class="dw-body-text mb-3">
                            {{ $sections['intro_description'] ?? 'Mahua House offers a complete destination wedding experience with multiple themed spaces. From grand reception halls to intimate ceremony gardens — every function finds its perfect setting here.' }}
                        </p>
                        @if(!empty($sections['venue_list_label']))
                        <p class="dw-body-text mb-3">
                            <strong style="color:#033631;">{{ $sections['venue_list_label'] }}</strong>
                        </p>
                        @else
                        <p class="dw-body-text mb-3">
                            <strong style="color:#033631;">Our Wedding Venues:</strong>
                        </p>
                        @endif
                        <ul class="dw-checklist">
                            @if(!empty($sections['venue_checklist']))
                                @foreach(array_filter(array_map('trim', explode("\n", $sections['venue_checklist']))) as $item)
                                <li><i class="fa-solid fa-check"></i> {!! $item !!}</li>
                                @endforeach
                            @else
                                <li><i class="fa-solid fa-check"></i> <strong>Mahua Vedika</strong> — Grand wedding &amp; reception venue</li>
                                <li><i class="fa-solid fa-check"></i> <strong>Chaupal-e-Mahua</strong> — Mehendi &amp; intimate functions</li>
                                <li><i class="fa-solid fa-check"></i> <strong>Mahua Ras Vritta</strong> — Haldi ceremonies</li>
                                <li><i class="fa-solid fa-check"></i> <strong>Poolside &amp; Forest Edge</strong> — Sangeet &amp; photography</li>
                                <li><i class="fa-solid fa-check"></i> Pre-wedding shoots in natural forest settings</li>
                                <li><i class="fa-solid fa-check"></i> Stay + Food + Decoration + Event Support packages</li>
                            @endif
                        </ul>
                        <a href="#inquiry" class="dw-btn dw-btn-primary">{{ $sections['intro_cta_text'] ?? 'Enquire Now' }}</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- ===== INTRO SECTION END ===== -->


        <!-- ===== WHY CHOOSE US ===== -->
        @if($weddingFeatures->isNotEmpty())
        <section class="dw-section dw-section-alt">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 text-center">
                        <span class="dw-label wow fadeInUp" data-wow-delay=".1s">{{ $sections['why_label'] ?? 'Why Mahua House' }}</span>
                        <h2 class="dw-heading wow fadeInUp" data-wow-delay=".2s">{!! $sections['why_heading'] ?? 'Everything You Need for a <em>Perfect Day</em>' !!}</h2>
                        <div class="dw-divider justify-content-center wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    </div>
                </div>
                <div class="row g-4 mt-2">
                    @foreach($weddingFeatures as $i => $feature)
                    <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2 + $i * .1, 1) }}s">
                        <div class="dw-why-card">
                            <div class="dw-why-icon"><i class="{{ $feature->icon ?: 'fa-solid fa-star' }}"></i></div>
                            <h4 class="dw-why-title">{{ $feature->title }}</h4>
                            <p class="dw-why-text">{{ $feature->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <!-- ===== WHY CHOOSE US END ===== -->


        <!-- ===== GALLERY ===== -->
        @if($galleryItems->isNotEmpty())
        <section class="dw-section">
            <div class="container">
                <div class="row align-items-end mb-40">
                    <div class="col-lg-7">
                        <span class="dw-label wow fadeInUp" data-wow-delay=".1s">{{ $sections['gallery_label'] ?? 'Wedding Gallery' }}</span>
                        <h2 class="dw-heading wow fadeInUp" data-wow-delay=".2s">{!! $sections['gallery_heading'] ?? 'Moments Captured in Our <em>Forest</em>' !!}</h2>
                    </div>
                    <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                        <a href="#inquiry" class="dw-btn dw-btn-primary">{{ $sections['gallery_cta_text'] ?? 'Book a Site Visit' }}</a>
                    </div>
                </div>
                <div class="dw-gallery-grid wow fadeInUp" data-wow-delay=".3s">
                    @foreach($galleryItems as $item)
                    <div class="dw-gitem">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                        <div class="dw-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <!-- ===== GALLERY END ===== -->


        <!-- ===== PLANNING PROCESS ===== -->
        @if($weddingTimeline->isNotEmpty())
        <section class="dw-section dw-section-dark">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                        <span class="dw-label dw-label-light">{{ $sections['process_label'] ?? 'How It Works' }}</span>
                        <h2 class="dw-heading dw-heading-light">{!! $sections['process_heading'] ?? 'From First Call to <em>First Dance</em>' !!}</h2>
                        <div class="dw-divider"><span></span><i class="fa-solid fa-heart"></i><span></span></div>
                        <p class="dw-body-text dw-body-text-light mb-4">
                            {{ $sections['process_description'] ?? 'We believe planning your wedding should feel as magical as the day itself. Our streamlined process keeps everything stress-free and transparent.' }}
                        </p>
                        <a href="#inquiry" class="dw-btn dw-btn-gold">{{ $sections['process_cta_text'] ?? 'Start Planning' }}</a>
                    </div>
                    <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                        <div class="dw-timeline">
                            @foreach($weddingTimeline as $step)
                            <div class="dw-timeline-item">
                                <div class="dw-timeline-dot">{{ $step->sort_order }}</div>
                                <h4 class="dw-timeline-title">{{ $step->title }}</h4>
                                <p class="dw-timeline-text">{{ $step->description }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        <!-- ===== PLANNING PROCESS END ===== -->


        <!-- ===== INQUIRY FORM ===== -->
        <section class="dw-section dw-section-alt" id="inquiry">
            <div class="container">
                <div class="dw-cta-box">
                    <div class="row align-items-center g-5 position-relative" style="z-index:1">
                        <!-- Left text -->
                        <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                            <span class="dw-label dw-label-light">{{ $sections['cta_label'] ?? 'Get In Touch' }}</span>
                            <h2 class="dw-heading dw-heading-light">{!! $sections['cta_heading'] ?? 'Start Planning Your <em>Dream Wedding</em>' !!}</h2>
                            <div class="dw-divider"><span></span><i class="fa-solid fa-heart"></i><span></span></div>
                            <p class="dw-body-text dw-body-text-light mb-4">
                                {{ $sections['cta_description'] ?? 'Tell us about your dream day. Our wedding team will get back to you within 24 hours with availability and a tailored quote.' }}
                            </p>
                            <div class="d-flex flex-column gap-3">
                                @if(!empty($contact['phone']))
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:42px;height:42px;border-radius:50%;background:rgba(218,165,32,0.2);display:flex;align-items:center;justify-content:center;color:#DAA520;flex-shrink:0;">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div>
                                        <p style="font-size:11px;color:rgba(255,255,255,0.5);margin:0;letter-spacing:1px;text-transform:uppercase;">Call Us</p>
                                        <p style="font-size:15px;font-weight:600;color:#fff;margin:0;">{{ $contact['phone']->value }}</p>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($contact['email']))
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:42px;height:42px;border-radius:50%;background:rgba(218,165,32,0.2);display:flex;align-items:center;justify-content:center;color:#DAA520;flex-shrink:0;">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div>
                                        <p style="font-size:11px;color:rgba(255,255,255,0.5);margin:0;letter-spacing:1px;text-transform:uppercase;">Email Us</p>
                                        <p style="font-size:15px;font-weight:600;color:#fff;margin:0;">{{ $contact['email']->value }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- Right form -->
                        <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                            <div style="background:#fff;border-radius:20px;padding:40px 36px;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
                                <h4 style="font-size:20px;font-weight:700;color:#033631;margin-bottom:24px;">Wedding Enquiry Form</h4>

                                @if(session('enquiry_success'))
                                <div class="alert alert-success mb-3" style="border-radius:10px;font-size:13.5px;">
                                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}
                                </div>
                                @endif

                                <form class="dw-inquiry-form" method="POST" action="{{ route('enquiry.store') }}">
                                    @csrf
                                    <input type="hidden" name="type" value="wedding">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control" placeholder="Your Name" required value="{{ old('name') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required value="{{ old('phone') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" name="check_in" class="form-control" placeholder="Wedding Date" value="{{ old('check_in') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="guests" class="form-control">
                                                <option value="" disabled selected>Estimated Guests</option>
                                                <option value="Up to 50" {{ old('guests') == 'Up to 50' ? 'selected' : '' }}>Up to 50</option>
                                                <option value="51-100" {{ old('guests') == '51-100' ? 'selected' : '' }}>51 – 100</option>
                                                <option value="101-200" {{ old('guests') == '101-200' ? 'selected' : '' }}>101 – 200</option>
                                                <option value="200+" {{ old('guests') == '200+' ? 'selected' : '' }}>200+</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="subject" class="form-control" placeholder="Preferred Package / Occasion" value="{{ old('subject') }}">
                                        </div>
                                        <div class="col-12">
                                            <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your dream wedding...">{{ old('message') }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="dw-btn dw-btn-gold w-100" style="border:none;cursor:pointer;font-size:15px;">
                                                <i class="fa-solid fa-paper-plane me-2"></i> Send Enquiry
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ===== INQUIRY FORM END ===== -->

@endsection

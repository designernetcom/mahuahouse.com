@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url,$fb='') => $url ? (Str::startsWith($url,['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key,$default='') => optional($contact[$key] ?? null)->value ?? $default;
    $phone    = $settings['phone_primary']   ?? $contactValue('phone','+91 9425651754');
    $whatsapp = $settings['whatsapp_number'] ?? $contactValue('whatsapp','919425651754');
@endphp

@section('title', $s('meta_title','Film & Media Shoots | Mahua House'))
@section('meta_description', $s('meta_description','Film & Media Shoots at Mahua House — a preferred natural location for film shoots, documentaries, interviews and cultural recordings near Bhopal.'))
@section('meta_keywords', $s('meta_keywords','Film Shoot Location Bhopal, Documentary Shoot Forest, Photography Location Bhopal, Media Shoot Nature'))

@section('styles')
<style>
    .fs-section{padding:90px 0}.fs-section-alt{background:#E7EEEE}.fs-section-dark{background:#033631}.fs-section-cream{background:#faf8f3}
    .fs-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .fs-label-light{color:rgba(218,165,32,.9)}
    .fs-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .fs-heading-light{color:#fff}.fs-heading em{font-style:normal;color:#DAA520}
    .fs-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.fs-divider.centered{justify-content:center}
    .fs-divider span{display:block;width:60px;height:1px;background:#DAA520}.fs-divider i{font-size:9px}
    .fs-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.fs-body-light{color:rgba(255,255,255,.62)}
    .fs-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .fs-btn-primary{background:#033631;color:#fff;border-color:#033631}.fs-btn-primary:hover{background:transparent;color:#033631}
    .fs-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.fs-btn-gold:hover{background:transparent;color:#DAA520}
    .fs-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.fs-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .fs-hero{position:relative;height:580px;background:url('{{ $iUrl($s("hero_image"),"assets/images/about/18.jpeg") }}') center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden}
    .fs-hero::before{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.2),rgba(3,54,49,.9))}
    .fs-hero-content{position:relative;z-index:2;padding-bottom:80px;width:100%}
    .fs-breadcrumb{list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px}
    .fs-breadcrumb li{font-size:13px;color:rgba(255,255,255,.5)}.fs-breadcrumb li a{color:#DAA520;text-decoration:none}
    .fs-breadcrumb li+li::before{content:'/';margin-right:8px}
    .fs-hero h1{font-size:clamp(32px,5vw,62px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px}
    .fs-hero h1 em{font-style:italic;color:#DAA520}
    .fs-hero p{font-size:16px;color:rgba(255,255,255,.75);max-width:580px;line-height:1.75;margin-bottom:30px}
    .fs-hero-shape{position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0}.fs-hero-shape img{width:100%}
    .fs-type-card{border-radius:18px;overflow:hidden;height:100%;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.07);transition:transform .35s,box-shadow .35s}
    .fs-type-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(3,54,49,.12)}
    .fs-type-img{height:200px;overflow:hidden;position:relative}
    .fs-type-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .fs-type-card:hover .fs-type-img img{transform:scale(1.05)}
    .fs-type-tag{position:absolute;top:14px;left:14px;background:#DAA520;color:#033631;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;padding:5px 14px;border-radius:100px}
    .fs-type-body{background:#fff;padding:24px}
    .fs-type-icon{width:44px;height:44px;border-radius:12px;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:18px;margin-bottom:14px}
    .fs-type-title{font-size:17px;font-weight:700;color:#033631;margin-bottom:8px}
    .fs-type-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.7;margin:0}
    .fs-location-item{display:flex;align-items:flex-start;gap:16px;padding:20px 0;border-bottom:1px solid rgba(3,54,49,.08)}
    .fs-location-item:first-child{padding-top:0}.fs-location-item:last-child{border-bottom:none;padding-bottom:0}
    .fs-location-icon{width:50px;height:50px;min-width:50px;border-radius:14px;background:rgba(3,54,49,.06);border:1px solid rgba(3,54,49,.12);display:flex;align-items:center;justify-content:center;color:#033631;font-size:19px;flex-shrink:0;transition:background .3s,color .3s}
    .fs-location-item:hover .fs-location-icon{background:#DAA520;color:#033631;border-color:#DAA520}
    .fs-location-title{font-size:16px;font-weight:700;color:#033631;margin-bottom:5px}
    .fs-location-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.7;margin:0}
    .fs-info-img{border-radius:20px;overflow:hidden;height:480px;position:relative}.fs-info-img img{width:100%;height:100%;object-fit:cover}
    .fs-info-badge{position:absolute;bottom:24px;left:24px;right:24px;background:rgba(3,54,49,.92);backdrop-filter:blur(8px);border-radius:14px;padding:18px 20px;display:flex;align-items:center;gap:14px}
    .fs-info-badge-icon{width:44px;height:44px;border-radius:50%;background:#DAA520;display:flex;align-items:center;justify-content:center;font-size:18px;color:#033631;flex-shrink:0}
    .fs-trust-badge{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:16px;padding:28px 22px;text-align:center;height:100%;transition:background .35s,border-color .35s}
    .fs-trust-badge:hover{background:rgba(255,255,255,.11);border-color:rgba(218,165,32,.35)}
    .fs-trust-icon{width:58px;height:58px;border-radius:50%;background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);display:inline-flex;align-items:center;justify-content:center;color:#DAA520;font-size:22px;margin-bottom:16px}
    .fs-trust-title{font-size:16px;font-weight:700;color:#fff;margin-bottom:8px}
    .fs-trust-text{font-size:13px;color:rgba(255,255,255,.5);line-height:1.65;margin:0}
    .fs-cta-box{background:linear-gradient(135deg,#033631,#07554D);border-radius:24px;padding:70px 60px;text-align:center;position:relative;overflow:hidden}
    .fs-cta-box::before{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:rgba(218,165,32,.08)}
    .fs-cta-box::after{content:'';position:absolute;bottom:-80px;left:-80px;width:260px;height:260px;border-radius:50%;background:rgba(218,165,32,.06)}
    .fs-form-control{border:1px solid rgba(3,54,49,.15);border-radius:10px;padding:13px 16px;font-size:14px;color:#033631;background:#fafafa;width:100%}
    .fs-form-control:focus{outline:none;border-color:#DAA520}
    .fs-form-label{font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#033631;margin-bottom:7px;display:block}
    .fs-alert{background:rgba(25,135,84,.1);border:1px solid rgba(25,135,84,.3);border-radius:12px;padding:16px 20px;margin-bottom:24px;color:#146c43;font-weight:500;font-size:14px}
    @media(max-width:991px){.fs-hero{height:460px}.fs-section{padding:70px 0}.fs-cta-box{padding:50px 30px}}
    @media(max-width:575px){.fs-hero h1{font-size:30px}.fs-cta-box{padding:40px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="fs-hero">
        <div class="container fs-hero-content">
            <ul class="fs-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb','Film & Media Shoots') }}</li>
            </ul>
            <span class="fs-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label','Film & Media Productions') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $s('hero_heading',"Bhopal's Most <em>Natural</em><br>Shoot Location") !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text','Quiet environment, authentic forest backdrops and permit guidance — Mahua House is a preferred location for film shoots, documentaries, interviews and cultural recordings.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#enquire" class="fs-btn fs-btn-gold">{{ $s('hero_cta1','Enquire for Shoot') }}</a>
                @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="fs-btn fs-btn-outline"><i class="fa-brands fa-whatsapp"></i>{{ $s('hero_cta2','WhatsApp Us') }}</a>@endif
            </div>
        </div>
        <div class="fs-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ SHOOT TYPES ═══ --}}
    @if($shootTypes->isNotEmpty())
    <section class="fs-section" style="padding-top:110px;">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="fs-label wow fadeInUp" data-wow-delay=".1s">{{ $s('types_label','What We Host') }}</span>
                    <h2 class="fs-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('types_heading','Productions We <em>Welcome</em>') !!}</h2>
                    <div class="fs-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="fs-body wow fadeInUp" data-wow-delay=".4s">{{ $s('types_text','From television commercials to independent documentaries — the natural forest of Mahua House creates a genuinely stunning backdrop for every type of production.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($shootTypes as $i => $type)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    <div class="fs-type-card">
                        <div class="fs-type-img">
                            <img src="{{ $iUrl($type->image_url,'assets/images/about/30.jpeg') }}" alt="{{ $type->title }}">
                            <span class="fs-type-tag">{{ $type->link ?: 'Production' }}</span>
                        </div>
                        <div class="fs-type-body">
                            <div class="fs-type-icon"><i class="{{ $type->icon ?: 'fa-solid fa-film' }}"></i></div>
                            <h4 class="fs-type-title">{{ $type->title }}</h4>
                            <p class="fs-type-text">{{ $type->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ LOCATION FEATURES ═══ --}}
    @if($locationFeatures->isNotEmpty())
    <section class="fs-section fs-section-alt">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div class="fs-info-img">
                        <img src="{{ $iUrl($s('loc_image'),'assets/images/about/38.jpeg') }}" alt="Natural Backdrop at Mahua House">
                        <div class="fs-info-badge">
                            <div class="fs-info-badge-icon"><i class="{{ $s('loc_badge_icon','fa-solid fa-video') }}"></i></div>
                            <div>
                                <p style="font-size:15px;font-weight:700;color:#fff;margin:0;">{{ $s('loc_badge_title','Preferred Shoot Location') }}</p>
                                <p style="font-size:13px;color:rgba(255,255,255,.55);margin:4px 0 0;">{{ $s('loc_badge_sub','Multiple natural backdrops — no artificial sets needed') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <span class="fs-label">{{ $s('loc_label','The Location Advantage') }}</span>
                    <h2 class="fs-heading">{!! $s('loc_heading',"Why Mahua House is a <em>Filmmaker's Choice</em>") !!}</h2>
                    <div class="fs-divider"><span></span><i class="fa-solid fa-clapperboard"></i><span></span></div>
                    @foreach($locationFeatures as $f)
                    <div class="fs-location-item">
                        <div class="fs-location-icon"><i class="{{ $f->icon ?: 'fa-solid fa-check' }}"></i></div>
                        <div>
                            <h5 class="fs-location-title">{{ $f->title }}</h5>
                            <p class="fs-location-text">{{ $f->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ TRUST BADGES ═══ --}}
    @if($trustBadges->isNotEmpty())
    <section class="fs-section fs-section-dark">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="fs-label fs-label-light wow fadeInUp" data-wow-delay=".1s">{{ $s('trust_label','Why Choose Us') }}</span>
                    <h2 class="fs-heading fs-heading-light wow fadeInUp" data-wow-delay=".2s">{!! $s('trust_heading',"Everything Your Production <em>Needs</em>") !!}</h2>
                    <div class="fs-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($trustBadges as $i => $badge)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    <div class="fs-trust-badge">
                        <div class="fs-trust-icon"><i class="{{ $badge->icon ?: 'fa-solid fa-star' }}"></i></div>
                        <h4 class="fs-trust-title">{{ $badge->title }}</h4>
                        <p class="fs-trust-text">{{ $badge->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ ENQUIRY FORM ═══ --}}
    <section class="fs-section fs-section-cream" id="enquire">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="fs-label wow fadeInUp" data-wow-delay=".1s">{{ $s('form_label','Book a Location Visit') }}</span>
                    <h2 class="fs-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('form_heading','Enquire for Your <em>Production</em>') !!}</h2>
                    <div class="fs-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="fs-body wow fadeInUp" data-wow-delay=".4s">{{ $s('form_text','Share your production details and we\'ll respond with availability, location options and pricing.') }}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 wow fadeInUp" data-wow-delay=".3s">
                    <div style="background:#fff;border-radius:20px;padding:48px 44px;box-shadow:0 8px 40px rgba(3,54,49,.1);border:1px solid rgba(3,54,49,.08);">
                        @if(session('enquiry_success'))<div class="fs-alert"><i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}</div>@endif
                        <form method="POST" action="{{ route('enquiry.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="film-shoot">
                            <div class="row g-4">
                                <div class="col-md-4"><label class="fs-form-label">Production Name *</label><input type="text" name="name" class="fs-form-control" placeholder="Production / Company name" value="{{ old('name') }}" required></div>
                                <div class="col-md-4"><label class="fs-form-label">Phone Number *</label><input type="tel" name="phone" class="fs-form-control" placeholder="+91 00000 00000" value="{{ old('phone') }}" required></div>
                                <div class="col-md-4"><label class="fs-form-label">Email Address</label><input type="email" name="email" class="fs-form-control" placeholder="your@email.com" value="{{ old('email') }}"></div>
                                <div class="col-md-4">
                                    <label class="fs-form-label">Production Type</label>
                                    <select name="room_type" class="fs-form-control" style="appearance:none;">
                                        <option value="">Select type</option>
                                        @foreach(['Feature Film / Short Film','Documentary','TV Commercial / Brand Film','Music Video','Interview / Talk Show','Cultural Recording','Photography Session','Other'] as $opt)
                                        <option @selected(old('room_type')===$opt)>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-form-label">Crew Size</label>
                                    <select name="guests" class="fs-form-control" style="appearance:none;">
                                        <option value="">Select size</option>
                                        <option @selected(old('guests')==='1-10')>1 – 10 people</option>
                                        <option @selected(old('guests')==='11-30')>11 – 30 people</option>
                                        <option @selected(old('guests')==='31-60')>31 – 60 people</option>
                                        <option @selected(old('guests')==='60+')>60+ people</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><label class="fs-form-label">Shoot Date</label><input type="date" name="check_in" class="fs-form-control" value="{{ old('check_in') }}"></div>
                                <div class="col-12"><label class="fs-form-label">Production Brief</label><textarea name="message" class="fs-form-control" rows="4" placeholder="Describe your production, required backdrops, accommodation needs, permit requirements..." style="resize:none;">{{ old('message') }}</textarea></div>
                                <div class="col-12"><button type="submit" class="fs-btn fs-btn-primary w-100" style="font-size:15px;border-radius:12px;padding:16px;justify-content:center;"><i class="fa-solid fa-paper-plane"></i>Send Production Enquiry</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="fs-section">
        <div class="container">
            <div class="fs-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="fs-label fs-label-light">{{ $s('cta_label','Ready to Shoot?') }}</span>
                    <h2 class="fs-heading fs-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading',"Your Next Production's <em>Perfect Location</em> Awaits") !!}</h2>
                    <p class="fs-body fs-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text','Contact us at Mahua House to schedule a location recce or submit your production enquiry today.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="fs-btn fs-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/','',$phone) }}" class="fs-btn fs-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                        <a href="{{ route('contact') }}" class="fs-btn fs-btn-outline">Enquire Today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

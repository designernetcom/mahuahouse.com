@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url,$fb='') => $url ? (Str::startsWith($url,['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key,$default='') => optional($contact[$key] ?? null)->value ?? $default;
    $phone    = $settings['phone_primary']   ?? $contactValue('phone','+91 9425651754');
    $whatsapp = $settings['whatsapp_number'] ?? $contactValue('whatsapp','919425651754');

    // Parse meal card description: split on "---" → [paragraph, items[]]
    $parseMeal = function($desc) {
        $parts = explode('---', $desc ?? '', 2);
        $para  = trim($parts[0] ?? '');
        $items = array_filter(array_map('trim', explode("\n", $parts[1] ?? '')));
        return [$para, array_values($items)];
    };
@endphp

@section('title', $s('meta_title','Food & Dining | Mahua House'))
@section('meta_description', $s('meta_description','Food & Dining at Mahua House — authentic traditional meals, multi-cuisine buffet and customised menus at ₹1,000 per head.'))
@section('meta_keywords', $s('meta_keywords','Food Dining Mahua House, Traditional Meals Forest Bhopal, Buffet Forest Resort, Authentic Food Bhopal'))

@section('styles')
<style>
    .fd-section{padding:90px 0}.fd-section-alt{background:#E7EEEE}.fd-section-dark{background:#033631}.fd-section-cream{background:#faf8f3}
    .fd-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .fd-label-light{color:rgba(218,165,32,.9)}
    .fd-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .fd-heading-light{color:#fff}.fd-heading em{font-style:normal;color:#DAA520}
    .fd-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.fd-divider.centered{justify-content:center}
    .fd-divider span{display:block;width:60px;height:1px;background:#DAA520}.fd-divider i{font-size:9px}
    .fd-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.fd-body-light{color:rgba(255,255,255,.62)}
    .fd-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .fd-btn-primary{background:#033631;color:#fff;border-color:#033631}.fd-btn-primary:hover{background:transparent;color:#033631}
    .fd-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.fd-btn-gold:hover{background:transparent;color:#DAA520}
    .fd-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.fd-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .fd-hero{position:relative;height:580px;background:url('{{ $iUrl($s("hero_image"),"assets/images/about/25.jpeg") }}') center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden}
    .fd-hero::before{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.2),rgba(3,54,49,.9))}
    .fd-hero-content{position:relative;z-index:2;padding-bottom:80px;width:100%}
    .fd-breadcrumb{list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px}
    .fd-breadcrumb li{font-size:13px;color:rgba(255,255,255,.5)}.fd-breadcrumb li a{color:#DAA520;text-decoration:none}
    .fd-breadcrumb li+li::before{content:'/';margin-right:8px}
    .fd-hero h1{font-size:clamp(32px,5vw,62px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px}
    .fd-hero h1 em{font-style:italic;color:#DAA520}
    .fd-hero p{font-size:16px;color:rgba(255,255,255,.75);max-width:580px;line-height:1.75;margin-bottom:30px}
    .fd-hero-shape{position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0}.fd-hero-shape img{width:100%}
    .fd-price-banner{background:#DAA520;border-radius:20px;padding:40px 50px;text-align:center}
    .fd-trust-strip{display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap}
    .fd-trust-pill{display:inline-flex;align-items:center;gap:8px;background:rgba(218,165,32,.12);border:1px solid rgba(218,165,32,.3);border-radius:100px;padding:10px 20px;font-size:13px;font-weight:600;color:#DAA520}
    .fd-option-card{background:#fff;border-radius:18px;padding:30px 24px;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 18px rgba(3,54,49,.06);height:100%;text-align:center;transition:transform .35s,box-shadow .35s,background .35s}
    .fd-option-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(3,54,49,.12);background:#033631}
    .fd-option-icon{width:68px;height:68px;border-radius:50%;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:inline-flex;align-items:center;justify-content:center;color:#DAA520;font-size:26px;margin-bottom:18px;transition:background .35s}
    .fd-option-card:hover .fd-option-icon{background:#DAA520;color:#033631;border-color:#DAA520}
    .fd-option-title{font-size:18px;font-weight:700;color:#033631;margin-bottom:10px;transition:color .35s}.fd-option-card:hover .fd-option-title{color:#DAA520}
    .fd-option-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.7;margin:0;transition:color .35s}.fd-option-card:hover .fd-option-text{color:rgba(255,255,255,.6)}
    .fd-meal-card{background:#fff;border-radius:20px;overflow:hidden;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.07);height:100%;transition:transform .35s,box-shadow .35s}
    .fd-meal-card:hover{transform:translateY(-6px);box-shadow:0 18px 44px rgba(3,54,49,.12)}
    .fd-meal-card-img{height:200px;overflow:hidden}
    .fd-meal-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .fd-meal-card:hover .fd-meal-card-img img{transform:scale(1.05)}
    .fd-meal-card-body{padding:24px 22px}
    .fd-meal-time{display:inline-flex;align-items:center;gap:6px;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);border-radius:100px;padding:4px 12px;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .fd-meal-title{font-size:20px;font-weight:700;color:#033631;margin-bottom:8px}
    .fd-meal-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.7;margin-bottom:16px}
    .fd-meal-items{list-style:none;padding:0;margin:0}
    .fd-meal-items li{display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(3,54,49,.65);padding:6px 0;border-bottom:1px dashed rgba(3,54,49,.08)}
    .fd-meal-items li:last-child{border-bottom:none}.fd-meal-items li i{color:#DAA520;font-size:9px}
    .fd-quality-card{text-align:center;padding:32px 20px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:18px;height:100%}
    .fd-quality-icon{width:62px;height:62px;border-radius:50%;background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);display:inline-flex;align-items:center;justify-content:center;color:#DAA520;font-size:24px;margin-bottom:18px}
    .fd-cta-box{background:linear-gradient(135deg,#033631,#07554D);border-radius:24px;padding:70px 60px;text-align:center;position:relative;overflow:hidden}
    .fd-cta-box::before{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:rgba(218,165,32,.08)}
    .fd-cta-box::after{content:'';position:absolute;bottom:-80px;left:-80px;width:260px;height:260px;border-radius:50%;background:rgba(218,165,32,.06)}
    @media(max-width:991px){.fd-hero{height:460px}.fd-section{padding:70px 0}.fd-cta-box{padding:50px 30px}.fd-price-banner{padding:32px 24px}}
    @media(max-width:575px){.fd-hero h1{font-size:30px}.fd-cta-box{padding:40px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="fd-hero">
        <div class="container fd-hero-content">
            <ul class="fd-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb','Food & Dining') }}</li>
            </ul>
            <span class="fd-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label','Authentic Flavours') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $s('hero_heading','A Taste of the <em>Forest</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text','Fresh, hygienic and locally inspired — every meal at Mahua House is a celebration of flavour. From bed tea at sunrise to a hearty dinner under the stars, we make every bite memorable.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#menu" class="fd-btn fd-btn-gold">{{ $s('hero_cta1',"See What's on the Menu") }}</a>
                @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="fd-btn fd-btn-outline"><i class="fa-brands fa-whatsapp"></i>{{ $s('hero_cta2','Custom Menu Enquiry') }}</a>@endif
            </div>
        </div>
        <div class="fd-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ PRICING BANNER ═══ --}}
    <section style="padding:60px 0;">
        <div class="container">
            <div class="fd-price-banner wow fadeInUp" data-wow-delay=".2s">
                <p style="font-size:13px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:rgba(3,54,49,.6);margin-bottom:8px;">{{ $s('price_label','All-Inclusive Meal Plan') }}</p>
                <p style="font-size:clamp(38px,6vw,72px);font-weight:900;color:#033631;line-height:1;margin-bottom:8px;">{{ $s('price_value','₹1,000') }} <span style="font-size:22px;font-weight:500;color:rgba(3,54,49,.6);">{{ $s('price_unit','per person') }}</span></p>
                <p style="font-size:16px;color:rgba(3,54,49,.65);margin-bottom:24px;">{{ $s('price_includes','Includes Bed Tea, Breakfast, Lunch, Hi Tea & Dinner') }}</p>
                <div class="fd-trust-strip">
                    @foreach(array_filter(array_map('trim', explode("\n", $s('price_pills',"Fresh Ingredients\nHygienic Kitchen\nLocally Inspired\nCustomisable Menus")))) as $pill)
                    <span class="fd-trust-pill"><i class="fa-solid fa-check"></i> {{ $pill }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ DINING OPTIONS ═══ --}}
    @if($diningOptions->isNotEmpty())
    <section class="fd-section" style="padding-top:0;">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="fd-label wow fadeInUp" data-wow-delay=".1s">{{ $s('opt_label','Dining Options') }}</span>
                    <h2 class="fd-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('opt_heading','Three Ways to <em>Dine With Us</em>') !!}</h2>
                    <div class="fd-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="fd-body wow fadeInUp" data-wow-delay=".4s">{{ $s('opt_text','Whether you prefer the comfort of tradition, the variety of a buffet, or a menu tailored precisely to your group — we have you covered.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($diningOptions as $i => $opt)
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    <div class="fd-option-card">
                        <div class="fd-option-icon"><i class="{{ $opt->icon ?: 'fa-solid fa-utensils' }}"></i></div>
                        <h4 class="fd-option-title">{{ $opt->title }}</h4>
                        <p class="fd-option-text">{{ $opt->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ MEAL SCHEDULE ═══ --}}
    @if($mealCards->isNotEmpty())
    <section class="fd-section fd-section-alt" id="menu">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="fd-label wow fadeInUp" data-wow-delay=".1s">{{ $s('meal_label','Daily Menu') }}</span>
                    <h2 class="fd-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('meal_heading','From Sunrise to <em>Sunset</em>') !!}</h2>
                    <div class="fd-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="fd-body wow fadeInUp" data-wow-delay=".4s">{{ $s('meal_text','A full day of authentic flavours — every meal crafted with fresh, locally sourced ingredients.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($mealCards as $i => $meal)
                @php [$para, $items] = $parseMeal($meal->description); @endphp
                {{-- Last card gets wide layout if it's the last and we have odd total --}}
                @php $isLast = $loop->last; $isWide = $isLast && ($mealCards->count() % 2 !== 0); @endphp
                <div class="{{ $isWide ? 'col-lg-8' : 'col-lg-4 col-md-6' }} wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    @if($isWide)
                    <div class="fd-meal-card" style="flex-direction:row;display:flex;height:100%;">
                        <div class="fd-meal-card-img" style="height:auto;min-width:260px;max-width:260px;">
                            <img src="{{ $iUrl($meal->image_url,'assets/images/about/45.jpeg') }}" alt="{{ $meal->title }}" style="height:100%;width:100%;object-fit:cover;">
                        </div>
                        <div class="fd-meal-card-body" style="flex:1;">
                            <span class="fd-meal-time"><i class="{{ $meal->icon ?: 'fa-solid fa-utensils' }}"></i> {{ $meal->link ?: '' }}</span>
                            <h4 class="fd-meal-title">{{ $meal->title }}</h4>
                            @if($para)<p class="fd-meal-text">{{ $para }}</p>@endif
                            @if($items)<ul class="fd-meal-items">@foreach($items as $item)<li><i class="fa-solid fa-circle"></i> {{ $item }}</li>@endforeach</ul>@endif
                        </div>
                    </div>
                    @else
                    <div class="fd-meal-card">
                        <div class="fd-meal-card-img">
                            <img src="{{ $iUrl($meal->image_url,'assets/images/about/45.jpeg') }}" alt="{{ $meal->title }}">
                        </div>
                        <div class="fd-meal-card-body">
                            <span class="fd-meal-time"><i class="{{ $meal->icon ?: 'fa-solid fa-utensils' }}"></i> {{ $meal->link ?: '' }}</span>
                            <h4 class="fd-meal-title">{{ $meal->title }}</h4>
                            @if($para)<p class="fd-meal-text">{{ $para }}</p>@endif
                            @if($items)<ul class="fd-meal-items">@foreach($items as $item)<li><i class="fa-solid fa-circle"></i> {{ $item }}</li>@endforeach</ul>@endif
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ CUSTOM MENU + IMAGE SPLIT ═══ --}}
    <section class="fd-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div style="border-radius:20px;overflow:hidden;height:460px;position:relative;">
                        <img src="{{ $iUrl($s('custom_image'),'assets/images/about/50.jpeg') }}" alt="Custom Dining Mahua House" style="width:100%;height:100%;object-fit:cover;">
                        <div style="position:absolute;bottom:24px;left:24px;right:24px;background:rgba(3,54,49,.92);backdrop-filter:blur(8px);border-radius:14px;padding:18px 20px;display:flex;align-items:center;gap:14px;">
                            <div style="width:44px;height:44px;border-radius:50%;background:#DAA520;display:flex;align-items:center;justify-content:center;font-size:18px;color:#033631;flex-shrink:0;"><i class="{{ $s('custom_badge_icon','fa-solid fa-leaf') }}"></i></div>
                            <div>
                                <p style="font-size:15px;font-weight:700;color:#fff;margin:0;">{{ $s('custom_badge_title','Fresh & Locally Inspired') }}</p>
                                <p style="font-size:13px;color:rgba(255,255,255,.55);margin:4px 0 0;">{{ $s('custom_badge_sub','Farm-fresh ingredients, hygienic kitchen, authentic flavours') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <span class="fd-label">{{ $s('custom_label','Group & Event Catering') }}</span>
                    <h2 class="fd-heading">{!! $s('custom_heading','Custom Menus for <em>Every Occasion</em>') !!}</h2>
                    <div class="fd-divider"><span></span><i class="fa-solid fa-utensils"></i><span></span></div>
                    <p class="fd-body mb-4">{{ $s('custom_text','Planning a large group visit, corporate retreat, wedding function or educational tour? Our kitchen team will design a menu tailored to your group size, dietary preferences and occasion.') }}</p>
                    <div class="row g-3 mb-4">
                        @foreach([
                            [$s('mini1_icon','fa-solid fa-briefcase'),      $s('mini1_title','Corporate Groups'),        $s('mini1_desc','Buffet spreads, working lunches & tea breaks')],
                            [$s('mini2_icon','fa-solid fa-graduation-cap'), $s('mini2_title','School & Institutions'),   $s('mini2_desc','Packed meals, thali service & snack packs')],
                            [$s('mini3_icon','fa-solid fa-champagne-glasses'),$s('mini3_title','Weddings & Events'),    $s('mini3_desc','Elaborate event menus for special celebrations')],
                            [$s('mini4_icon','fa-solid fa-seedling'),       $s('mini4_title','Dietary Preferences'),     $s('mini4_desc','Veg, non-veg, Jain & custom requests honoured')],
                        ] as [$icon,$title,$desc])
                        <div class="col-sm-6">
                            <div style="background:#faf8f3;border-radius:14px;padding:18px;border:1px solid rgba(3,54,49,.08);">
                                <i class="{{ $icon }}" style="color:#DAA520;font-size:20px;margin-bottom:8px;display:block;"></i>
                                <p style="font-size:15px;font-weight:700;color:#033631;margin:0 0 4px;">{{ $title }}</p>
                                <p style="font-size:13px;color:rgba(3,54,49,.55);margin:0;">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="fd-btn fd-btn-primary"><i class="fa-brands fa-whatsapp"></i>{{ $s('custom_cta','Enquire for Custom Menu') }}</a>@endif
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ QUALITY ASSURANCE ═══ --}}
    @if($qualityCards->isNotEmpty())
    <section class="fd-section fd-section-dark">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="fd-label fd-label-light wow fadeInUp" data-wow-delay=".1s">{{ $s('quality_label','Our Promise') }}</span>
                    <h2 class="fd-heading fd-heading-light wow fadeInUp" data-wow-delay=".2s">{!! $s('quality_heading','Fresh, Hygienic &amp; <em>Locally Inspired</em>') !!}</h2>
                    <div class="fd-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($qualityCards as $i => $q)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    <div class="fd-quality-card">
                        <div class="fd-quality-icon"><i class="{{ $q->icon ?: 'fa-solid fa-star' }}"></i></div>
                        <h4 style="font-size:17px;font-weight:700;color:#fff;margin-bottom:10px;">{{ $q->title }}</h4>
                        <p style="font-size:13px;color:rgba(255,255,255,.5);line-height:1.7;margin:0;">{{ $q->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ CTA ═══ --}}
    <section class="fd-section">
        <div class="container">
            <div class="fd-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="fd-label fd-label-light">{{ $s('cta_label','Dine With Us') }}</span>
                    <h2 class="fd-heading fd-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading','Authentic Flavours in a <em>Forest Setting</em>') !!}</h2>
                    <p class="fd-body fd-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text','Contact us to arrange dining for your group, request a custom menu or ask about meal packages alongside accommodation.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="fd-btn fd-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        <a href="{{ route('accommodation') }}" class="fd-btn fd-btn-outline"><i class="fa-solid fa-bed"></i>View Accommodation</a>
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/','',$phone) }}" class="fd-btn fd-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

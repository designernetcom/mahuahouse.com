@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url, $fb='') => $url ? (Str::startsWith($url, ['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key, $default='') => optional($contact[$key] ?? null)->value ?? $default;

    $phone    = $settings['phone_primary']   ?? $contactValue('phone', '+91 9425651754');
    $whatsapp = $settings['whatsapp_number'] ?? $contactValue('whatsapp', '919425651754');
    $facebook = $settings['facebook_url']    ?? $contactValue('facebook', 'https://www.facebook.com/mahuahouse');

    $heroImage = $iUrl($s('hero_image'), 'assets/images/about/3.jpeg');

    // Story list: one item per line
    $storyListItems = array_filter(array_map('trim', explode("\n", $s('story_list',
        "MP Tourism Accredited countryside retreat\nAdjoining Samardha Reserved Forest, Raisen Road, Bhopal\nTrusted by Doordarshan productions\nIdeal for weddings, events, picnics & peaceful stays"
    ))));

    // Property stats: "icon|value|label" per line
    $propStats = collect(array_filter(array_map('trim', explode("\n", $s('property_stats',
        "fa-solid fa-tree|Ancient Mahua & Teak Groves|Centuries-old trees on the property\nfa-solid fa-person-hiking|3 Guided Trail Routes|Easy, moderate & sunrise treks\nfa-solid fa-campground|Open-air Campfire Lawn|Stargazing & evening storytelling\nfa-solid fa-binoculars|Bird & Wildlife Spotting|150+ bird species recorded on site"
    )))))->map(function($row) {
        [$icon, $val, $lbl] = array_pad(explode('|', $row, 3), 3, '');
        return compact('icon', 'val', 'lbl');
    });

    // House rules: "icon|text" per line
    $houseRules = collect(array_filter(array_map('trim', explode("\n", $s('house_rules',
        "fa-solid fa-seedling|Respect nature — no littering on the property or forest\nfa-solid fa-volume-xmark|Maintain a peaceful environment for all guests\nfa-solid fa-ban|No illegal activities permitted on the property\nfa-solid fa-helmet-safety|All outdoor activities must be done under supervision\nfa-solid fa-wine-bottle|Alcohol Policy: Alcohol is allowed with prior permission for groups, but Mahua House is not a party-only destination."
    )))))->map(function($row) {
        [$icon, $text] = array_pad(explode('|', $row, 2), 2, '');
        return compact('icon', 'text');
    });

    // Philosophy tags: one per line
    $philosophyTags = array_filter(array_map('trim', explode("\n", $s('philosophy_tags',
        "🌿 Nature\n🕊️ Peace\n👨‍👩‍👧 Family-Friendly\n🎭 Cultural\n🌱 Eco-Conscious"
    ))));

    // Default experience cards fallback
    $defaultExps = [
        ['img'=>'assets/images/about/35.jpeg','icon'=>'fa-solid fa-person-hiking','title'=>'Forest Treks','desc'=>'Guided morning and sunset walks through the Samardha forest corridor with our naturalist team.'],
        ['img'=>'assets/images/about/40.jpeg','icon'=>'fa-solid fa-fire-flame-curved','title'=>'Campfire Evenings','desc'=>'Gather around a crackling fire under an open sky — with folk music, stories, and forest-inspired snacks.'],
        ['img'=>'assets/images/about/45.jpeg','icon'=>'fa-solid fa-binoculars','title'=>'Birdwatching','desc'=>'150+ species call our forest home. Spot Indian rollers, painted storks, and rare migrants at dawn.'],
        ['img'=>'assets/images/about/55.jpeg','icon'=>'fa-solid fa-road','title'=>'Village Safari','desc'=>'Explore nearby tribal villages, witness traditional crafts, and share a meal with local families.'],
        ['img'=>'assets/images/about/60.jpeg','icon'=>'fa-solid fa-utensils','title'=>'Farm-to-Table Dining','desc'=>'Seasonal menus using ingredients from our kitchen garden and local farms — cooked over wood fire.'],
    ];

    // Default photo strip fallback
    $defaultPhotos = [65,70,75,80,85,88,91];
@endphp

@section('title', $s('meta_title', 'About Us | Mahua House'))
@section('meta_description', $s('meta_description', 'Learn about Mahua House — The Nostalgic Woods, an MP Tourism accredited eco-retreat near Bhopal surrounded by Samardha Reserved Forest.'))
@section('meta_keywords', $s('meta_keywords', 'About Mahua House, Eco Retreat Bhopal, Forest Resort About, MP Tourism Accredited Resort'))

@section('styles')
<style>
    .au-section{padding:90px 0}.au-section-alt{background:#E7EEEE}.au-section-cream{background:#faf8f3}
    .au-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .au-label-light{color:rgba(218,165,32,.9)}
    .au-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:16px}
    .au-heading-light{color:#fff}.au-heading em{font-style:normal;color:#DAA520}
    .au-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}
    .au-divider.centered{justify-content:center}.au-divider span{display:block;width:60px;height:1px;background:#DAA520}.au-divider i{font-size:9px}
    .au-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.au-body-light{color:rgba(255,255,255,.62)}
    .au-btn{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent}
    .au-btn-primary{background:#033631;color:#fff;border-color:#033631}.au-btn-primary:hover{background:transparent;color:#033631}
    .au-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.au-btn-gold:hover{background:transparent;color:#DAA520}
    .au-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.5)}.au-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .au-hero{position:relative;height:580px;background:url('{{ $heroImage }}') center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden}
    .au-hero::before{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.35),rgba(3,54,49,.82))}
    .au-hero-content{position:relative;z-index:2;padding-bottom:80px;width:100%}
    .au-hero-breadcrumb{list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px}
    .au-hero-breadcrumb li{font-size:13px;color:rgba(255,255,255,.55)}.au-hero-breadcrumb li a{color:#DAA520;text-decoration:none}.au-hero-breadcrumb li+li::before{content:'/';margin-right:8px}
    .au-hero h1{font-size:clamp(38px,5vw,70px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px}.au-hero h1 em{font-style:italic;color:#DAA520}
    .au-hero p{font-size:16px;color:rgba(255,255,255,.75);max-width:520px;line-height:1.75;margin-bottom:30px}
    .au-hero-shape{position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0}.au-hero-shape img{width:100%}
    .au-story-img-grid{display:grid;grid-template-columns:1fr 1fr;grid-template-rows:240px 200px;gap:12px;position:relative}
    .au-story-img-grid .img-tall{grid-row:span 2;border-radius:18px;overflow:hidden}
    .au-story-img-grid .img-tall img,.au-story-img-grid .img-sm img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .au-story-img-grid .img-tall:hover img,.au-story-img-grid .img-sm:hover img{transform:scale(1.05)}
    .au-story-img-grid .img-sm{border-radius:18px;overflow:hidden}
    .au-founded-badge{position:absolute;bottom:-18px;left:50%;transform:translateX(-50%);background:#DAA520;color:#033631;padding:16px 28px;border-radius:14px;text-align:center;box-shadow:0 8px 30px rgba(218,165,32,.4);white-space:nowrap;z-index:2}
    .au-founded-badge .big{font-size:32px;font-weight:800;line-height:1;display:block}.au-founded-badge .sm{font-size:11px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase}
    .au-story-list{list-style:none;padding:0;margin:24px 0 32px;display:flex;flex-direction:column;gap:12px}
    .au-story-list li{display:flex;align-items:flex-start;gap:12px;font-size:14px;color:rgba(3,54,49,.65);line-height:1.6}
    .au-story-list li i{width:22px;height:22px;min-width:22px;border-radius:50%;background:rgba(218,165,32,.15);color:#DAA520;display:inline-flex;align-items:center;justify-content:center;font-size:9px;margin-top:2px}
    .au-stats-bar{background:#033631;padding:60px 0}
    .au-stat-item{text-align:center}.au-stat-item .num{font-size:clamp(42px,5vw,64px);font-weight:800;color:#DAA520;line-height:1;display:block;margin-bottom:6px}
    .au-stat-item .unit{font-size:28px}.au-stat-item .lbl{font-size:13px;color:rgba(255,255,255,.55);letter-spacing:2px;text-transform:uppercase;font-weight:500}
    .au-stat-divider{width:1px;background:rgba(255,255,255,.12);align-self:stretch;margin:auto 0}
    .au-value-card{padding:36px 28px;border-radius:18px;background:#fff;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 24px rgba(3,54,49,.06);height:100%;transition:transform .35s,box-shadow .35s;position:relative;overflow:hidden}
    .au-value-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:3px;background:linear-gradient(90deg,#033631,#DAA520);transform:scaleX(0);transform-origin:left;transition:transform .4s}
    .au-value-card:hover{transform:translateY(-8px);box-shadow:0 20px 50px rgba(3,54,49,.13)}.au-value-card:hover::before{transform:scaleX(1)}
    .au-value-icon{width:62px;height:62px;border-radius:14px;background:rgba(3,54,49,.07);border:1px solid rgba(3,54,49,.12);display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;transition:background .35s}
    .au-value-icon i{font-size:24px;color:#033631;transition:color .35s}
    .au-value-card:hover .au-value-icon{background:#033631}.au-value-card:hover .au-value-icon i{color:#DAA520}
    .au-value-title{font-size:18px;font-weight:700;color:#033631;margin-bottom:10px}.au-value-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.75;margin:0}
    .au-property-split{display:grid;grid-template-columns:1fr 1fr;min-height:520px}
    .au-property-image{position:relative;overflow:hidden}.au-property-image img{width:100%;height:100%;object-fit:cover;transition:transform .6s}.au-property-image:hover img{transform:scale(1.05)}
    .au-property-content{background:#033631;padding:80px 60px;display:flex;flex-direction:column;justify-content:center}
    .au-prop-stat{display:flex;align-items:center;gap:16px;padding:16px 0;border-bottom:1px solid rgba(255,255,255,.1)}
    .au-prop-stat:first-of-type{border-top:1px solid rgba(255,255,255,.1)}
    .au-prop-stat .icon{width:44px;height:44px;min-width:44px;border-radius:10px;background:rgba(218,165,32,.15);display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:18px}
    .au-prop-stat .info .val{font-size:20px;font-weight:700;color:#fff;display:block;line-height:1}.au-prop-stat .info .lbl{font-size:12px;color:rgba(255,255,255,.45);letter-spacing:1px;text-transform:uppercase}
    .au-exp-card{position:relative;border-radius:18px;overflow:hidden;height:280px}
    .au-exp-card img{width:100%;height:100%;object-fit:cover;transition:transform .5s}.au-exp-card:hover img{transform:scale(1.1)}
    .au-exp-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(3,54,49,.88),rgba(3,54,49,.2) 60%,transparent);display:flex;flex-direction:column;justify-content:flex-end;padding:24px;transition:background .4s}
    .au-exp-card:hover .au-exp-overlay{background:linear-gradient(to top,rgba(3,54,49,.95),rgba(3,54,49,.5) 60%,rgba(3,54,49,.1))}
    .au-exp-icon{width:42px;height:42px;border-radius:50%;background:#DAA520;color:#033631;display:inline-flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:10px}
    .au-exp-title{font-size:18px;font-weight:700;color:#fff;margin-bottom:6px}
    .au-exp-desc{font-size:13px;color:rgba(255,255,255,.6);line-height:1.6;margin:0;max-height:0;overflow:hidden;transition:max-height .4s,opacity .4s;opacity:0}
    .au-exp-card:hover .au-exp-desc{max-height:80px;opacity:1}
    .au-photo-strip{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;grid-template-rows:260px 200px;gap:10px}
    .au-photo-strip .ph{border-radius:12px;overflow:hidden;position:relative}.au-photo-strip .ph-large{grid-row:span 2}
    .au-photo-strip .ph img{width:100%;height:100%;object-fit:cover;transition:transform .5s}.au-photo-strip .ph:hover img{transform:scale(1.07)}
    .au-photo-strip .ph-overlay{position:absolute;inset:0;background:rgba(3,54,49,.35);opacity:0;transition:opacity .35s;display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:26px}
    .au-photo-strip .ph:hover .ph-overlay{opacity:1}
    .au-testi-card{background:#fff;border-radius:16px;padding:30px;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.06);height:100%}
    .au-testi-quote{font-size:42px;color:#DAA520;line-height:.8;font-family:Georgia,serif;margin-bottom:14px}
    .au-testi-text{font-size:14px;color:rgba(3,54,49,.65);line-height:1.75;font-style:italic;margin-bottom:22px}
    .au-testi-stars{color:#DAA520;font-size:12px;margin-bottom:16px;gap:2px;display:flex}
    .au-testi-author{display:flex;align-items:center;gap:12px}
    .au-testi-name{font-size:14px;font-weight:700;color:#033631;margin:0}.au-testi-loc{font-size:12px;color:rgba(3,54,49,.45);margin:0}
    .au-cta-wrap{position:relative;overflow:hidden;background:linear-gradient(135deg,#033631,#07554D);border-radius:24px;padding:70px 60px;text-align:center}
    .au-cta-wrap::before{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:rgba(218,165,32,.08)}
    .au-cta-wrap::after{content:'';position:absolute;bottom:-80px;left:-80px;width:260px;height:260px;border-radius:50%;background:rgba(218,165,32,.06)}
    @media(max-width:991px){.au-hero{height:440px}.au-section{padding:70px 0}.au-property-split{grid-template-columns:1fr}.au-property-content{padding:50px 36px}.au-photo-strip{grid-template-columns:1fr 1fr;grid-template-rows:repeat(3,200px)}.au-photo-strip .ph-large{grid-row:span 1}.au-cta-wrap{padding:50px 30px}}
    @media(max-width:767px){.au-story-img-grid{grid-template-columns:1fr;grid-template-rows:260px 180px}.au-story-img-grid .img-tall{grid-row:span 1}.au-stat-divider{display:none}.au-photo-strip{grid-template-columns:1fr;grid-template-rows:repeat(5,200px)}}
    @media(max-width:575px){.au-hero h1{font-size:32px}.au-cta-wrap{padding:40px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="au-hero">
        <div class="container au-hero-content">
            <ul class="au-hero-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb', 'About Us') }}</li>
            </ul>
            <span class="au-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label', 'Our Story') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size:30px;">{!! $s('hero_heading', 'Where the Forest<br><em>Tells a Story</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text', 'A 3.5-acre woodland sanctuary in Bhopal — built on the belief that the best hospitality is the kind nature itself provides.') }}</p>
        </div>
        <div class="au-hero-shape">
            <img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape">
        </div>
    </section>

    {{-- ═══ OUR STORY ═══ --}}
    <section class="au-section" id="story">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div class="au-story-img-grid">
                        <div class="img-tall">
                            <img src="{{ $iUrl($s('story_img1'), 'assets/images/about/6.jpeg') }}" alt="Mahua House forest">
                        </div>
                        <div class="img-sm">
                            <img src="{{ $iUrl($s('story_img2'), 'assets/images/about/10.jpeg') }}" alt="Mahua House cottage">
                        </div>
                        <div class="img-sm">
                            <img src="{{ $iUrl($s('story_img3'), 'assets/images/about/14.jpeg') }}" alt="Mahua House nature">
                        </div>
                        <div class="au-founded-badge">
                            <span class="big">{{ $s('founded_year', '2014') }}</span>
                            <span class="sm">{{ $s('founded_label', 'Est. Year') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <span class="au-label">{{ $s('story_label', 'Who We Are') }}</span>
                    <h2 class="au-heading">{!! $s('story_heading', 'Mahua House — <em>The Nostalgic Woods</em>') !!}</h2>
                    <div class="au-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    <p class="au-body mb-3">{{ $s('story_text1', 'Mahua House — The Nostalgic Woods is an MP Tourism accredited countryside retreat located on Raisen Road, Bhopal, surrounded by serene forest landscapes.') }}</p>
                    <p class="au-body mb-3">{{ $s('story_text2', 'Designed for those who value peace, culture, and meaningful gatherings, Mahua House blends rustic charm with modern comfort. Whether it is a wedding celebration, corporate retreat, educational tour, or a quiet family getaway, the space offers an environment that encourages connection — with nature and with each other.') }}</p>
                    <p class="au-body">{{ $s('story_text3', 'With curated experiences like traditional cuisine, jungle walks, cultural activities, and open natural spaces, Mahua House is not just a venue — it is an experience.') }}</p>
                    @if($storyListItems)
                    <ul class="au-story-list">
                        @foreach($storyListItems as $item)
                        <li><i class="fa-solid fa-check"></i> {{ $item }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="d-flex flex-wrap gap-3">
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="au-btn au-btn-primary"><i class="fa-brands fa-whatsapp"></i>{{ $s('story_btn1', 'WhatsApp Enquiry') }}</a>@endif
                        <a href="{{ route('contact') }}" class="au-btn au-btn-gold">{{ $s('story_btn2', 'Contact Us') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ STATS BAR ═══ --}}
    <div class="au-stats-bar">
        <div class="container">
            <div class="row g-4 align-items-center justify-content-center">
                @if($stats->count())
                    @foreach($stats as $i => $stat)
                    @if($i > 0)<div class="col-auto d-none d-md-block"><div class="au-stat-divider" style="height:70px;"></div></div>@endif
                    <div class="col-auto wow fadeInUp" data-wow-delay="{{ '.'.($i+1).'s' }}">
                        <div class="au-stat-item">
                            <span class="num">{{ $stat->value }}</span>
                            <span class="lbl">{{ $stat->label }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach([['3.5ac','Forest Land'],['10+','Years of Hospitality'],['5000+','Happy Guests'],['200+','Tree Species'],['4.9★','Average Rating']] as $i => $st)
                    @if($i > 0)<div class="col-auto d-none d-md-block"><div class="au-stat-divider" style="height:70px;"></div></div>@endif
                    <div class="col-auto wow fadeInUp" data-wow-delay="{{ '.'.($i+1).'s' }}">
                        <div class="au-stat-item"><span class="num">{{ $st[0] }}</span><span class="lbl">{{ $st[1] }}</span></div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ OUR VALUES ═══ --}}
    <section class="au-section au-section-alt">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="au-label wow fadeInUp" data-wow-delay=".1s">{{ $s('values_label', 'What Drives Us') }}</span>
                    <h2 class="au-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('values_heading', 'Our <em>Values &amp; Philosophy</em>') !!}</h2>
                    <div class="au-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="au-body wow fadeInUp" data-wow-delay=".4s">{{ $s('values_text', 'Every decision we make — from how we build our cottages to how we serve your meals — is guided by these principles.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @if($whyChooseItems->count())
                    @foreach($whyChooseItems as $i => $item)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+($i%3)*.1,1) }}s">
                        <div class="au-value-card">
                            <div class="au-value-icon"><i class="{{ $item->icon ?: 'fa-solid fa-star' }}"></i></div>
                            <h4 class="au-value-title">{{ $item->title }}</h4>
                            <p class="au-value-text">{{ $item->description }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach([
                        ['fa-solid fa-seedling','Eco Responsibility','We operate with a minimal ecological footprint — rainwater harvesting, composting, solar lighting, and zero single-use plastics. The forest gives us everything; we owe it our care.'],
                        ['fa-solid fa-heart','Heartfelt Hospitality','Every guest is welcomed like family. From a warm cup of chai on arrival to a personalised farewell, our team puts genuine warmth into every interaction.'],
                        ['fa-solid fa-bowl-rice','Farm-to-Table Food','Our kitchen draws from local farms and the forest itself — wild herbs, seasonal vegetables, and traditional recipes that tell the story of Madhya Pradesh on every plate.'],
                        ['fa-solid fa-people-group','Community First','We employ locally, source locally, and invest locally. Over 90% of our team comes from surrounding villages. Your stay directly supports livelihoods in our community.'],
                        ['fa-solid fa-spa','Nature & Peace','We welcome guests who value nature, peace, and the healing power of the outdoors. Mahua House is a calm, dignified and eco-conscious space.'],
                        ['fa-solid fa-people-group','Family-Friendly Culture','We promote a family-friendly environment and cultural, respectful gatherings. Every guest is welcomed with warmth and genuine care.'],
                    ] as $i => $v)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+($i%3)*.1,1) }}s">
                        <div class="au-value-card">
                            <div class="au-value-icon"><i class="{{ $v[0] }}"></i></div>
                            <h4 class="au-value-title">{{ $v[1] }}</h4>
                            <p class="au-value-text">{{ $v[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ PROPERTY SPLIT ═══ --}}
    <div class="au-property-split">
        <div class="au-property-image wow fadeInLeft" data-wow-delay=".2s">
            <img src="{{ $iUrl($s('property_image'), 'assets/images/about/22.jpeg') }}" alt="Mahua House property">
        </div>
        <div class="au-property-content wow fadeInRight" data-wow-delay=".3s">
            <span class="au-label au-label-light">{{ $s('property_label', 'The Property') }}</span>
            <h2 class="au-heading au-heading-light" style="margin-bottom:8px;">{!! $s('property_heading', '3.5 Acres of <em>Living Forest</em>') !!}</h2>
            <div class="au-divider" style="margin-bottom:24px;"><span></span><i class="fa-solid fa-tree"></i><span></span></div>
            <p class="au-body au-body-light mb-4">{{ $s('property_text', "Our property borders the Samardha Reserved Forest — one of Madhya Pradesh's protected green corridors. From your cottage window you might spot a peacock, hear the call of a shikra, or watch fireflies light the tree line at dusk.") }}</p>
            @foreach($propStats as $ps)
            <div class="au-prop-stat">
                <div class="icon"><i class="{{ $ps['icon'] }}"></i></div>
                <div class="info">
                    <span class="val">{{ $ps['val'] }}</span>
                    <span class="lbl">{{ $ps['lbl'] }}</span>
                </div>
            </div>
            @endforeach
            <div style="margin-top:32px;">
                <a href="{{ route('booking') }}" class="au-btn au-btn-gold">{{ $s('property_cta', 'Reserve Your Room') }}</a>
            </div>
        </div>
    </div>

    {{-- ═══ EXPERIENCES ═══ --}}
    <section class="au-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="au-label wow fadeInUp" data-wow-delay=".1s">{{ $s('exp_label', "While You're Here") }}</span>
                    <h2 class="au-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('exp_heading', 'Experiences That <em>Stay With You</em>') !!}</h2>
                    <div class="au-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @if($aboutExperiences->count())
                    @foreach($aboutExperiences as $i => $exp)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+($i%3)*.1,1) }}s">
                        <div class="au-exp-card">
                            <img src="{{ $iUrl($exp->image_url, 'assets/images/about/35.jpeg') }}" alt="{{ $exp->title }}">
                            <div class="au-exp-overlay">
                                <div class="au-exp-icon"><i class="{{ $exp->icon ?: 'fa-solid fa-star' }}"></i></div>
                                <h4 class="au-exp-title">{{ $exp->title }}</h4>
                                <p class="au-exp-desc">{{ $exp->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach($defaultExps as $i => $exp)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+($i%3)*.1,1) }}s">
                        <div class="au-exp-card">
                            <img src="{{ asset($exp['img']) }}" alt="{{ $exp['title'] }}">
                            <div class="au-exp-overlay">
                                <div class="au-exp-icon"><i class="{{ $exp['icon'] }}"></i></div>
                                <h4 class="au-exp-title">{{ $exp['title'] }}</h4>
                                <p class="au-exp-desc">{{ $exp['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ PHOTO STRIP ═══ --}}
    <section class="au-section au-section-cream" style="padding-top:0;padding-bottom:90px;">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="au-label wow fadeInUp" data-wow-delay=".1s">{{ $s('photo_label', 'Through the Lens') }}</span>
                    <h2 class="au-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('photo_heading', 'A Glimpse of <em>Mahua House</em>') !!}</h2>
                </div>
                <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('gallery') }}" class="au-btn au-btn-primary">{{ $s('photo_cta', 'Full Gallery') }}</a>
                </div>
            </div>
            <div class="au-photo-strip wow fadeInUp" data-wow-delay=".3s">
                @if($galleryItems->count())
                    @foreach($galleryItems->take(7) as $i => $item)
                    <div class="ph {{ $i === 0 ? 'ph-large' : '' }}">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title ?: 'Mahua House' }}">
                        <div class="ph-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                    </div>
                    @endforeach
                @else
                    @foreach($defaultPhotos as $i => $n)
                    <div class="ph {{ $i === 0 ? 'ph-large' : '' }}">
                        <img src="{{ asset('assets/images/about/'.$n.'.jpeg') }}" alt="Mahua House">
                        <div class="ph-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ TESTIMONIALS ═══ --}}
    <section class="au-section au-section-alt">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="au-label wow fadeInUp" data-wow-delay=".1s">{{ $s('testi_label', 'Guest Stories') }}</span>
                    <h2 class="au-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('testi_heading', 'What Our <em>Guests Say</em>') !!}</h2>
                    <div class="au-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @if($testimonials->count())
                    @foreach($testimonials as $i => $testi)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ '.'.($i+2).'s' }}">
                        <div class="au-testi-card">
                            <div class="au-testi-quote">"</div>
                            <div class="au-testi-stars">
                                @for($st = 1; $st <= 5; $st++)
                                    @if($st <= $testi->rating)<i class="fa-solid fa-star"></i>
                                    @elseif($st - 0.5 <= $testi->rating)<i class="fa-solid fa-star-half-stroke"></i>
                                    @else<i class="fa-regular fa-star"></i>@endif
                                @endfor
                            </div>
                            <p class="au-testi-text" style="margin-top:12px;">{{ $testi->review }}</p>
                            <div class="au-testi-author">
                                @if($testi->photo_url)<img src="{{ $testi->photo_url }}" alt="{{ $testi->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">@endif
                                <div>
                                    <p class="au-testi-name">{{ $testi->name }}</p>
                                    @if($testi->location)<p class="au-testi-loc">{{ $testi->location }}</p>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach([
                        ['Sanyukta Banerjee',5,'Nestled in the lap of nature, Mahua house is a true hidden gem. From the moment you arrive, you\'re surrounded by breathtaking views, fresh air, and a sense of calm that instantly melts stress away.'],
                        ['Manish Kumar',5,'My Amazing Time at Mahua House — from the second I got there, the whole team was so nice and down-to-earth. It really did feel like a home away from home.'],
                        ['Shivani & Shukla',4.5,'It was one of the most surreal experiences! The view, the food, the staff and the surroundings are perfect for a romantic or family getaway. I recommend this to anyone who wants to stay between lush green forests.'],
                    ] as $i => $t)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ '.'.($i+2).'s' }}">
                        <div class="au-testi-card">
                            <div class="au-testi-quote">"</div>
                            <div class="au-testi-stars">
                                @for($st=1;$st<=5;$st++)<i class="fa-{{ $st <= floor($t[1]) ? 'solid' : ($st - 0.5 <= $t[1] ? 'solid fa-star-half-stroke' : 'regular') }} fa-star"></i>@endfor
                            </div>
                            <p class="au-testi-text" style="margin-top:12px;">{{ $t[2] }}</p>
                            <div class="au-testi-author"><div><p class="au-testi-name">{{ $t[0] }}</p></div></div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ HOUSE RULES & PHILOSOPHY ═══ --}}
    <section class="au-section au-section-alt" id="house-rules">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <span class="au-label wow fadeInUp" data-wow-delay=".1s">{{ $s('rules_label', 'Guidelines & Philosophy') }}</span>
                    <h2 class="au-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('rules_heading', 'Our <em>House Rules</em>') !!}</h2>
                    <div class="au-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div style="background:#fff;border-radius:18px;padding:36px;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.06);height:100%;">
                        <h4 style="color:#033631;font-weight:700;margin-bottom:20px;"><i class="fa-solid fa-scroll" style="color:#DAA520;margin-right:10px;"></i>{{ $s('rules_title', 'House Rules') }}</h4>
                        <ul style="list-style:none;padding:0;margin:0;">
                            @foreach($houseRules as $rule)
                            <li style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;font-size:15px;color:rgba(3,54,49,.7);">
                                <i class="{{ $rule['icon'] }}" style="color:#DAA520;margin-top:3px;flex-shrink:0;"></i>
                                {{ $rule['text'] }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <div style="background:#033631;border-radius:18px;padding:36px;height:100%;">
                        <h4 style="color:#DAA520;font-weight:700;margin-bottom:20px;"><i class="fa-solid fa-spa" style="color:#DAA520;margin-right:10px;"></i>{{ $s('philosophy_title', 'Our Philosophy') }}</h4>
                        <p style="color:rgba(255,255,255,.75);font-size:15px;line-height:1.8;margin-bottom:20px;">{{ $s('philosophy_text1', 'Mahua House welcomes guests who value nature, peace, family-friendly environments, and cultural and respectful gatherings.') }}</p>
                        <p style="color:rgba(255,255,255,.75);font-size:15px;line-height:1.8;margin-bottom:20px;">{{ $s('philosophy_text2', 'We promote a calm, dignified, and eco-conscious atmosphere where every visitor — whether a family on a picnic, a couple celebrating their anniversary, a corporate team, or a student on a nature tour — feels respected and at home.') }}</p>
                        @if($philosophyTags)
                        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:24px;">
                            @foreach($philosophyTags as $tag)
                            <span style="background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);color:#DAA520;border-radius:100px;padding:7px 16px;font-size:13px;font-weight:600;">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="au-section">
        <div class="container">
            <div class="au-cta-wrap wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="au-label au-label-light">{{ $s('cta_label', 'Come Visit Us') }}</span>
                    <h2 class="au-heading au-heading-light" style="margin-bottom:16px;">{!! $s('cta_heading', 'Ready to Experience <em>Mahua House?</em>') !!}</h2>
                    <p class="au-body au-body-light" style="max-width:560px;margin:0 auto 36px;">{{ $s('cta_text', "Whether you're seeking a weekend escape, a family adventure, a corporate retreat, or a destination wedding — our forest is waiting for you.") }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($facebook)<a href="{{ $facebook }}" target="_blank" rel="noopener" class="au-btn au-btn-outline"><i class="fa-brands fa-facebook-f"></i>Visit Facebook</a>@endif
                        <a href="https://maps.app.goo.gl/K2ag8CT2Nza4JZrb9" target="_blank" rel="noopener" class="au-btn au-btn-outline"><i class="fa-solid fa-star"></i>Google Reviews</a>
                        <a href="{{ route('contact') }}" class="au-btn au-btn-outline"><i class="fa-solid fa-envelope"></i>Enquire Today</a>
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="au-btn au-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp or Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url,$fb='') => $url ? (Str::startsWith($url,['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key,$default='') => optional($contact[$key] ?? null)->value ?? $default;
    $phone    = $settings['phone_primary']   ?? $contactValue('phone','+91 9425651754');
    $whatsapp = $settings['whatsapp_number'] ?? $contactValue('whatsapp','919425651754');
    $facebook = $settings['facebook_url']    ?? $contactValue('facebook','https://www.facebook.com/mahuahouse');
    $email    = $settings['email_primary']   ?? $contactValue('email','mahuahouse17@gmail.com');

    // Parse venue description: SUBTITLE---DESCRIPTION---USES
    $parseVenue = function($desc) {
        $parts = explode('---', $desc ?? '', 3);
        return [
            trim($parts[0] ?? ''),                                                        // subtitle
            trim($parts[1] ?? ''),                                                        // description
            array_filter(array_map('trim', explode("\n", $parts[2] ?? ''))),              // uses[]
        ];
    };

    // Parse amenities: icon|label per line
    $parseAmenities = function($raw) {
        return collect(array_filter(array_map('trim', explode("\n", $raw ?? ''))))->map(function($row) {
            [$icon, $label, $text] = array_pad(explode('|', $row, 3), 3, '');
            return compact('icon', 'label', 'text');
        });
    };

    // Parse stats: num|label per line
    $parseStats = function($raw) {
        return collect(array_filter(array_map('trim', explode("\n", $raw ?? ''))))->map(function($row) {
            [$num, $lbl] = array_pad(explode('|', $row, 2), 2, '');
            return compact('num', 'lbl');
        });
    };

    $stats = $parseStats($s('stats_strip', "4|Named Venues\n300+|Guest Capacity\n3.5ac|Forest Property\nMP|Tourism Accredited\n4.9★|Avg. Rating"));
    $vedikaAmenities = $parseAmenities($s('vedika_amenities', "fa-solid fa-heart|Wedding Ceremonies & Receptions\nfa-solid fa-moon|Day & Evening Events\nfa-solid fa-music|DJ / Sound System (Chargeable)\nfa-solid fa-wand-magic-sparkles|Stage & Decoration (Chargeable)\nfa-solid fa-bolt|Power Backup\nfa-solid fa-utensils|Customised Catering Available\nfa-solid fa-video|Projector Support (Chargeable)\nfa-solid fa-camera|Pre-wedding Shoot Friendly"));
    $introTags = array_filter(array_map('trim', explode("\n", $s('intro_tags', "4 Named Wedding Venues\nCorporate Meeting Space\nEvent Management Support\nStage & Decoration (Chargeable)\nDJ / Sound / Projector (Chargeable)"))));
    $includedItems = array_filter(array_map('trim', explode("\n", $s('included_items', "Dedicated event coordinator\nTable, chair and linen setup\nBasic lighting and sound\nParking for 50+ vehicles\nPower backup throughout\nOn-site hospitality team\nCatering coordination"))));
    $sidebarItems = $parseAmenities($s('sidebar_items', "fa-solid fa-phone-volume|Call Us Directly|+91 9425651754 · Available 9 AM – 8 PM, 7 days a week\nfa-brands fa-whatsapp|WhatsApp|+91 9425651754 · Quick responses for urgent enquiries\nfa-solid fa-envelope|Email|{$email} · We respond within 24 hours\nfa-solid fa-location-dot|Site Visit|We welcome venue visits by appointment. Come see the spaces in person before booking."));
@endphp

@section('title', $s('meta_title','Spaces | Mahua House'))
@section('meta_description', $s('meta_description','Explore our forest event spaces at Mahua House — grand lawns, forest clearings, pavilions and intimate venues for weddings, corporate events and private gatherings in Bhopal.'))
@section('meta_keywords', $s('meta_keywords','Event Spaces Mahua House, Forest Venue Bhopal, Outdoor Wedding Venue, Corporate Event Space'))

@section('styles')
<style>
    .sp-section{padding:90px 0}.sp-section-alt{background:#E7EEEE}.sp-section-dark{background:#033631}.sp-section-cream{background:#faf8f3}
    .sp-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .sp-label-light{color:rgba(218,165,32,.9)}
    .sp-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .sp-heading-light{color:#fff}.sp-heading em{font-style:normal;color:#DAA520}
    .sp-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.sp-divider.centered{justify-content:center}
    .sp-divider span{display:block;width:60px;height:1px;background:#DAA520}.sp-divider i{font-size:9px}
    .sp-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.sp-body-light{color:rgba(255,255,255,.62)}
    .sp-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 30px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .sp-btn-primary{background:#033631;color:#fff;border-color:#033631}.sp-btn-primary:hover{background:transparent;color:#033631}
    .sp-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.sp-btn-gold:hover{background:transparent;color:#DAA520}
    .sp-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.sp-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .sp-btn-outline-dark{background:transparent;color:#033631;border-color:#033631}.sp-btn-outline-dark:hover{background:#033631;color:#fff}
    .sp-btn-sm{padding:10px 22px;font-size:13px}
    .sp-breadcrumb{list-style:none;padding:0;margin:0 0 20px;display:flex;gap:8px;align-items:center;font-size:13px;color:rgba(255,255,255,.65)}
    .sp-breadcrumb li+li::before{content:"/";margin-right:8px;opacity:.5}.sp-breadcrumb a{color:rgba(255,255,255,.8);text-decoration:none}
    .sp-hero{position:relative;height:600px;background:linear-gradient(135deg,rgba(3,54,49,.88),rgba(3,54,49,.55) 60%,rgba(0,0,0,.3)),url('{{ $iUrl($s("hero_image"),"assets/images/about/5.jpeg") }}') center/cover no-repeat;display:flex;align-items:center}
    .sp-hero-content{position:relative;z-index:2;color:#fff}
    .sp-hero h1{font-size:clamp(36px,5vw,62px);font-weight:800;line-height:1.1;margin-bottom:18px;color:#fff}
    .sp-hero h1 em{font-style:normal;color:#DAA520}
    .sp-hero p{font-size:16px;color:rgba(255,255,255,.78);max-width:540px;margin-bottom:32px}
    .sp-hero-shape{position:absolute;bottom:-1px;left:0;right:0;z-index:3;line-height:0}.sp-hero-shape img{width:100%}
    .sp-stats-strip{background:#033631;padding:30px 0;border-bottom:2px solid rgba(218,165,32,.25)}
    .sp-stat-item{text-align:center;padding:8px 20px}
    .sp-stat-item+.sp-stat-item{border-left:1px solid rgba(255,255,255,.1)}
    .sp-stat-num{font-size:32px;font-weight:800;color:#DAA520;line-height:1;display:block;margin-bottom:4px}
    .sp-stat-lbl{font-size:12px;color:rgba(255,255,255,.6);letter-spacing:2px;text-transform:uppercase}
    .sp-intro{padding:80px 0;background:#fff}
    .sp-intro-icon-row{display:flex;flex-wrap:wrap;gap:12px;margin-top:28px}
    .sp-intro-tag{display:inline-flex;align-items:center;gap:8px;background:#E7EEEE;border-radius:100px;padding:8px 18px;font-size:13px;font-weight:600;color:#033631}
    .sp-intro-tag i{color:#DAA520;font-size:12px}
    .sp-intro-image-grid{display:grid;grid-template-columns:1fr 1fr;grid-template-rows:220px 220px;gap:12px;border-radius:20px;overflow:hidden}
    .sp-intro-image-grid img{width:100%;height:100%;object-fit:cover}
    .sp-intro-image-grid .sig-tall{grid-row:1/3}
    .sp-space-card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(3,54,49,.07);border:1px solid rgba(3,54,49,.08);transition:transform .35s,box-shadow .35s;height:100%}
    .sp-space-card:hover{transform:translateY(-8px);box-shadow:0 20px 60px rgba(3,54,49,.14)}
    .sp-space-img{position:relative;height:240px;overflow:hidden}
    .sp-space-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .sp-space-card:hover .sp-space-img img{transform:scale(1.07)}
    .sp-space-badge{position:absolute;top:14px;left:14px;background:#DAA520;color:#033631;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:5px 14px;border-radius:100px}
    .sp-space-cap{position:absolute;bottom:14px;right:14px;background:rgba(3,54,49,.85);color:#fff;font-size:12px;font-weight:600;padding:5px 12px;border-radius:100px;display:flex;align-items:center;gap:6px}
    .sp-space-cap i{color:#DAA520;font-size:11px}
    .sp-space-body{padding:26px 28px 30px}
    .sp-space-title{font-size:20px;font-weight:700;color:#033631;margin-bottom:8px}
    .sp-space-sub{font-size:13px;color:#DAA520;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:12px}
    .sp-space-desc{font-size:14px;color:rgba(3,54,49,.6);line-height:1.75;margin-bottom:18px}
    .sp-space-uses{list-style:none;padding:0;margin:0 0 22px;display:flex;flex-wrap:wrap;gap:8px}
    .sp-space-uses li{font-size:12px;color:rgba(3,54,49,.65);background:rgba(3,54,49,.05);border-radius:6px;padding:4px 10px}
    .sp-space-uses li::before{content:"✓ ";color:#DAA520;font-weight:700}
    .sp-featured{background:#033631;padding:0;overflow:hidden}
    .sp-featured-inner{display:grid;grid-template-columns:1fr 1fr;min-height:520px}
    .sp-featured-img{position:relative;overflow:hidden}
    .sp-featured-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .sp-featured-img:hover img{transform:scale(1.04)}
    .sp-featured-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,transparent 60%,#033631)}
    .sp-featured-content{padding:70px 60px;display:flex;flex-direction:column;justify-content:center}
    .sp-feat-amenities{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin:24px 0 32px}
    .sp-feat-amenity{display:flex;align-items:center;gap:10px;font-size:13px;color:rgba(255,255,255,.75);font-weight:500}
    .sp-feat-amenity i{color:#DAA520;width:16px}
    .sp-gallery{display:grid;grid-template-columns:2fr 1fr 1fr;grid-template-rows:260px 260px;gap:10px;border-radius:20px;overflow:hidden}
    .sp-gallery .sg{position:relative;overflow:hidden;cursor:pointer}
    .sp-gallery .sg img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .sp-gallery .sg:hover img{transform:scale(1.07)}
    .sp-gallery .sg-tall{grid-row:1/3}
    .sp-gallery .sg-ov{position:absolute;inset:0;background:rgba(3,54,49,.45);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .3s}
    .sp-gallery .sg:hover .sg-ov{opacity:1}.sp-gallery .sg-ov i{color:#fff;font-size:26px}
    .sp-form-wrap{background:#fff;border-radius:24px;padding:48px 44px;box-shadow:0 8px 48px rgba(3,54,49,.1)}
    .sp-form-group{margin-bottom:20px}
    .sp-form-group label{display:block;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#033631;margin-bottom:8px}
    .sp-form-group input,.sp-form-group select,.sp-form-group textarea{width:100%;padding:14px 18px;border:1.5px solid rgba(3,54,49,.15);border-radius:10px;font-size:14px;color:#033631;background:#fff;transition:border-color .25s;font-family:inherit;outline:none}
    .sp-form-group input:focus,.sp-form-group select:focus,.sp-form-group textarea:focus{border-color:#DAA520}
    .sp-form-group textarea{resize:vertical;min-height:110px}.sp-form-group select{appearance:none;cursor:pointer}
    .sp-form-submit{width:100%;padding:16px;background:#033631;color:#fff;border:none;border-radius:100px;font-size:15px;font-weight:700;cursor:pointer;transition:background .3s}
    .sp-form-submit:hover{background:#DAA520;color:#033631}
    .sp-sidebar-info{background:#033631;border-radius:20px;padding:36px 32px;color:#fff;margin-bottom:24px}
    .sp-sidebar-info h4{font-size:20px;font-weight:700;color:#DAA520;margin-bottom:18px}
    .sp-sidebar-item{display:flex;align-items:flex-start;gap:14px;margin-bottom:18px;padding-bottom:18px;border-bottom:1px solid rgba(255,255,255,.08)}
    .sp-sidebar-item:last-child{margin-bottom:0;padding-bottom:0;border-bottom:none}
    .sp-sidebar-icon{width:38px;height:38px;flex-shrink:0;background:rgba(218,165,32,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:15px}
    .sp-sidebar-item p{font-size:13px;color:rgba(255,255,255,.7);margin:0;line-height:1.6}
    .sp-sidebar-item strong{display:block;color:#fff;font-size:14px;margin-bottom:3px}
    .sp-cta-box{background:linear-gradient(135deg,#033631,#055a50);border-radius:24px;padding:70px 50px;text-align:center;position:relative;overflow:hidden}
    .sp-cta-box::before{content:'';position:absolute;top:-80px;right:-80px;width:280px;height:280px;border-radius:50%;background:rgba(218,165,32,.08)}
    .sp-cta-box::after{content:'';position:absolute;bottom:-60px;left:-60px;width:200px;height:200px;border-radius:50%;background:rgba(218,165,32,.06)}
    .sp-alert{background:rgba(25,135,84,.1);border:1px solid rgba(25,135,84,.3);border-radius:10px;padding:14px 18px;margin-bottom:20px;color:#146c43;font-weight:500;font-size:14px}
    @media(max-width:991px){.sp-featured-inner{grid-template-columns:1fr}.sp-featured-img{height:360px}.sp-featured-img::after{display:none}.sp-featured-content{padding:50px 36px}.sp-feat-amenities{grid-template-columns:1fr}.sp-gallery{grid-template-columns:1fr 1fr;grid-template-rows:200px 200px 200px}.sp-gallery .sg-tall{grid-row:auto}.sp-intro-image-grid{grid-template-rows:180px 180px}}
    @media(max-width:767px){.sp-stat-item+.sp-stat-item{border-left:none;border-top:1px solid rgba(255,255,255,.1)}.sp-gallery{grid-template-columns:1fr;grid-template-rows:repeat(5,200px)}.sp-cta-box{padding:50px 28px}.sp-form-wrap{padding:34px 24px}.sp-intro-image-grid{grid-template-columns:1fr;grid-template-rows:200px 200px 200px}.sp-intro-image-grid .sig-tall{grid-row:auto}}
    @media(max-width:575px){.sp-hero h1{font-size:32px}.sp-cta-box{padding:40px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="sp-hero">
        <div class="container sp-hero-content">
            <ul class="sp-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb','Spaces') }}</li>
            </ul>
            <span class="sp-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label','Venues & Event Spaces') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size:30px;">{!! $s('hero_heading','Every Gathering<br><em>Deserves a Forest</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text','Four distinctly named venues, each with its own character — designed for weddings, cultural ceremonies, corporate meetings, and private celebrations in a natural forest setting.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#spaces" class="sp-btn sp-btn-gold">{{ $s('hero_cta1','Explore Spaces') }}</a>
                <a href="#enquiry" class="sp-btn sp-btn-outline">{{ $s('hero_cta2','Enquire Now') }}</a>
            </div>
        </div>
        <div class="sp-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ STATS STRIP ═══ --}}
    <div class="sp-stats-strip">
        <div class="container">
            <div class="row justify-content-center text-center g-0">
                @foreach($stats as $stat)
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="sp-stat-item">
                        <span class="sp-stat-num">{{ $stat['num'] }}</span>
                        <span class="sp-stat-lbl">{{ $stat['lbl'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ INTRO ═══ --}}
    <section class="sp-intro">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <span class="sp-label">{{ $s('intro_label','Our Philosophy') }}</span>
                    <h2 class="sp-heading">{!! $s('intro_heading','Where Nature Becomes<br>Your <em>Event Venue</em>') !!}</h2>
                    <div class="sp-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    <p class="sp-body mb-4">{{ $s('intro_text1','At Mahua House, each of our four named venues has its own identity — designed for different functions, from grand wedding receptions to intimate ceremonies, cultural events to corporate meetings. Every space carries the living energy of the Samardha Reserved Forest.') }}</p>
                    <p class="sp-body mb-4">{{ $s('intro_text2',"Whether you're planning a destination wedding at Mahua Vedika, a mehendi at Chaupal-e-Mahua, a haldi at Mahua Ras Vritta, or a sangeet at the Poolside & Forest Edge — nature is your backdrop and tradition is your guide.") }}</p>
                    @if($introTags)
                    <div class="sp-intro-icon-row">
                        @foreach($introTags as $tag)
                        <span class="sp-intro-tag"><i class="fa-solid fa-check"></i> {{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <div class="sp-intro-image-grid">
                        <img src="{{ $iUrl($s('intro_img1'),'assets/images/about/8.jpeg') }}" alt="Forest Lawn" class="sig-tall">
                        <img src="{{ $iUrl($s('intro_img2'),'assets/images/about/15.jpeg') }}" alt="Pavilion">
                        <img src="{{ $iUrl($s('intro_img3'),'assets/images/about/22.jpeg') }}" alt="Forest Clearing">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ FEATURED SPACE — Mahua Vedika ═══ --}}
    <div class="sp-featured" id="spaces">
        <div class="sp-featured-inner">
            <div class="sp-featured-img">
                <img src="{{ $iUrl($s('vedika_image'),'assets/images/about/12.jpeg') }}" alt="Mahua Vedika">
            </div>
            <div class="sp-featured-content">
                <span class="sp-label sp-label-light">{{ $s('vedika_label','Signature Wedding Venue') }}</span>
                <h2 class="sp-heading sp-heading-light">{!! $s('vedika_heading','Mahua <em>Vedika</em>') !!}</h2>
                <div class="sp-divider"><span></span><i class="fa-solid fa-crown"></i><span></span></div>
                <p class="sp-body sp-body-light mb-0">{{ $s('vedika_desc','Our grandest venue — Mahua Vedika is the heart of every major celebration at Mahua House. Set in the open forest grounds, this is where wedding ceremonies, receptions, and large group events come alive under the open sky with a backdrop of ancient trees.') }}</p>
                @if($vedikaAmenities->isNotEmpty())
                <div class="sp-feat-amenities">
                    @foreach($vedikaAmenities as $amenity)
                    <div class="sp-feat-amenity"><i class="{{ $amenity['icon'] }}"></i> {{ $amenity['label'] }}</div>
                    @endforeach
                </div>
                @endif
                <a href="#enquiry" class="sp-btn sp-btn-gold">{{ $s('vedika_cta','Enquire About This Venue') }}</a>
            </div>
        </div>
    </div>

    {{-- ═══ SPACES GRID ═══ --}}
    @if($venues->isNotEmpty())
    <section class="sp-section sp-section-cream">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="sp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('grid_label','All Venues') }}</span>
                    <h2 class="sp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('grid_heading','Find Your <em>Perfect Space</em>') !!}</h2>
                    <div class="sp-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="sp-body wow fadeInUp" data-wow-delay=".35s">{{ $s('grid_text','Four named venues — each with its own character — plus dedicated corporate space and full-property exclusive option.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($venues as $i => $venue)
                @php [$sub, $desc, $uses] = $parseVenue($venue->description); @endphp
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+($i%3)*.1,1) }}s">
                    <div class="sp-space-card {{ $venue->is_featured ? 'border-2' : '' }}" style="{{ $venue->is_featured ? 'background:linear-gradient(135deg,#033631,#055a50);border-color:#DAA520;' : '' }}">
                        <div class="sp-space-img">
                            <img src="{{ $iUrl($venue->image_url,'assets/images/about/20.jpeg') }}" alt="{{ $venue->title }}">
                            <span class="sp-space-badge">{{ $venue->link ?: 'Venue' }}</span>
                            <div class="sp-space-cap"><i class="{{ $venue->icon ?: 'fa-solid fa-leaf' }}"></i> {{ $sub ?: $venue->link }}</div>
                        </div>
                        <div class="sp-space-body">
                            <p class="sp-space-sub" style="{{ $venue->is_featured ? 'color:#DAA520;' : '' }}">{{ $sub }}</p>
                            <h3 class="sp-space-title" style="{{ $venue->is_featured ? 'color:#fff;' : '' }}">{!! $venue->is_featured ? '<span style="color:#fff;">'.e($venue->title).'</span>' : e($venue->title) !!}</h3>
                            <p class="sp-space-desc" style="{{ $venue->is_featured ? 'color:rgba(255,255,255,.65);' : '' }}">{{ $desc }}</p>
                            @if($uses)
                            <ul class="sp-space-uses">
                                @foreach($uses as $use)
                                <li style="{{ $venue->is_featured ? 'background:rgba(255,255,255,.08);color:rgba(255,255,255,.7);' : '' }}">{{ $use }}</li>
                                @endforeach
                            </ul>
                            @endif
                            <a href="#enquiry" class="sp-btn {{ $venue->is_featured ? 'sp-btn-gold' : 'sp-btn-outline-dark' }} sp-btn-sm">Enquire</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ GALLERY ═══ --}}
    @if($galleryItems->isNotEmpty())
    <section class="sp-section sp-section-alt">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="sp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('gallery_label','Space Gallery') }}</span>
                    <h2 class="sp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('gallery_heading','Our <em>Venues</em> in Pictures') !!}</h2>
                </div>
                <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                    <a href="#enquiry" class="sp-btn sp-btn-primary">{{ $s('gallery_cta','Book a Space') }}</a>
                </div>
            </div>
            <div class="sp-gallery wow fadeInUp" data-wow-delay=".3s">
                @foreach($galleryItems as $i => $item)
                <div class="sg {{ $i === 0 ? 'sg-tall' : '' }}">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                    <div class="sg-ov"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ ENQUIRY FORM ═══ --}}
    <section class="sp-section sp-section-cream" id="enquiry">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6 text-center">
                    <span class="sp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('form_label','Get in Touch') }}</span>
                    <h2 class="sp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('form_heading','Enquire About a <em>Space</em>') !!}</h2>
                    <div class="sp-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-envelope"></i><span></span></div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-7 wow fadeInLeft" data-wow-delay=".2s">
                    <div class="sp-form-wrap">
                        @if(session('enquiry_success'))<div class="sp-alert"><i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}</div>@endif
                        <form method="POST" action="{{ route('enquiry.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="spaces">
                            <div class="row g-3">
                                <div class="col-md-6"><div class="sp-form-group"><label>Your Name *</label><input type="text" name="name" placeholder="e.g. Priya Sharma" value="{{ old('name') }}" required></div></div>
                                <div class="col-md-6"><div class="sp-form-group"><label>Phone Number *</label><input type="tel" name="phone" placeholder="+91 XXXXX XXXXX" value="{{ old('phone') }}" required></div></div>
                                <div class="col-md-6"><div class="sp-form-group"><label>Email Address</label><input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}"></div></div>
                                <div class="col-md-6"><div class="sp-form-group"><label>Event Date</label><input type="date" name="check_in" value="{{ old('check_in') }}"></div></div>
                                <div class="col-md-6">
                                    <div class="sp-form-group">
                                        <label>Preferred Venue</label>
                                        <select name="subject">
                                            <option value="">Select a venue</option>
                                            @if($venues->isNotEmpty())
                                                @foreach($venues as $v)<option @selected(old('subject')===$v->title)>{{ $v->title }}</option>@endforeach
                                            @else
                                                <option>Mahua Vedika</option>
                                                <option>Chaupal-e-Mahua</option>
                                                <option>Mahua Ras Vritta</option>
                                                <option>Poolside & Forest Edge</option>
                                                <option>Corporate Meeting Space</option>
                                                <option>Full Property Exclusive</option>
                                            @endif
                                            <option @selected(old('subject')==='Not Sure Yet')>Not Sure Yet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="sp-form-group">
                                        <label>Event Type</label>
                                        <select name="room_type">
                                            <option value="">Type of event</option>
                                            <option @selected(old('room_type')==='Wedding / Sangeet / Mehendi')>Wedding / Sangeet / Mehendi</option>
                                            <option @selected(old('room_type')==='Corporate Retreat / Offsite')>Corporate Retreat / Offsite</option>
                                            <option @selected(old('room_type')==='Birthday Party')>Birthday Party</option>
                                            <option @selected(old('room_type')==='Anniversary Celebration')>Anniversary Celebration</option>
                                            <option @selected(old('room_type')==='Family Reunion')>Family Reunion</option>
                                            <option @selected(old('room_type')==='Other')>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="sp-form-group">
                                        <label>Expected Guests</label>
                                        <select name="guests">
                                            <option @selected(old('guests')==='Under 25')>Under 25</option>
                                            <option @selected(old('guests')==='25-50')>25 – 50</option>
                                            <option @selected(old('guests')==='50-100')>50 – 100</option>
                                            <option @selected(old('guests')==='100-200')>100 – 200</option>
                                            <option @selected(old('guests')==='200-300')>200 – 300</option>
                                            <option @selected(old('guests')==='300+')>300+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="sp-form-group">
                                        <label>Catering Required?</label>
                                        <select>
                                            <option>Yes — in-house catering</option>
                                            <option>No — external caterer</option>
                                            <option>Partial catering needed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12"><div class="sp-form-group"><label>Tell us about your event</label><textarea name="message" placeholder="Describe your vision, special requirements, décor ideas, or any questions you have...">{{ old('message') }}</textarea></div></div>
                                <div class="col-12"><button type="submit" class="sp-form-submit">Send Enquiry →</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 wow fadeInRight" data-wow-delay=".3s">
                    <div class="sp-sidebar-info">
                        <h4>{{ $s('sidebar_title',"We'll Get Back to You") }}</h4>
                        @foreach($sidebarItems as $item)
                        <div class="sp-sidebar-item">
                            <div class="sp-sidebar-icon"><i class="{{ $item['icon'] }}"></i></div>
                            <div>
                                <strong>{{ $item['label'] }}</strong>
                                <p>{{ $item['text'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($includedItems)
                    <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid rgba(3,54,49,.1);">
                        <h5 style="font-size:16px;font-weight:700;color:#033631;margin-bottom:16px;"><i class="fa-solid fa-circle-check" style="color:#DAA520;"></i>&nbsp; {{ $s('included_title',"What's Included with Every Booking") }}</h5>
                        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                            @foreach($includedItems as $item)
                            <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:rgba(3,54,49,.7);"><i class="fa-solid fa-check" style="color:#DAA520;width:16px;"></i> {{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="sp-section">
        <div class="container">
            <div class="sp-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="sp-label sp-label-light">{{ $s('cta_label','Ready to Book?') }}</span>
                    <h2 class="sp-heading sp-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading','Your Forest Venue is <em>Available</em>') !!}</h2>
                    <p class="sp-body sp-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text','Our venues are available for weddings, corporate events, educational tours and film shoots. Reach out to plan your perfect event at Mahua House.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($facebook)<a href="{{ $facebook }}" target="_blank" rel="noopener" class="sp-btn sp-btn-outline"><i class="fa-brands fa-facebook-f"></i>Facebook</a>@endif
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="sp-btn sp-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        <a href="{{ route('contact') }}" class="sp-btn sp-btn-outline">Enquire Today</a>
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/','',$phone) }}" class="sp-btn sp-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

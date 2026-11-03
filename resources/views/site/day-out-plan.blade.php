@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url,$fb='') => $url ? (Str::startsWith($url,['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key,$default='') => optional($contact[$key] ?? null)->value ?? $default;
    $phone    = $settings['phone_primary']   ?? $contactValue('phone','+91 9425651754');
    $whatsapp = $settings['whatsapp_number'] ?? $contactValue('whatsapp','919425651754');
    $email    = $settings['email_primary']   ?? $contactValue('email','mahuahouse17@gmail.com');
@endphp

@section('title', $s('meta_title','Day Out Plan | Mahua House'))
@section('meta_description', $s('meta_description',"Spend a perfect day at Mahua House — forest walks, pool access, farm dining and sunset campfires. Bhopal's best day-out experience."))
@section('meta_keywords', $s('meta_keywords','Day Out Plan Bhopal, Forest Day Trip, Day Visit Mahua House, One Day Forest Experience'))

@section('styles')
<style>
    .dp-section{padding:90px 0}.dp-section-alt{background:#E7EEEE}.dp-section-dark{background:#033631}.dp-section-cream{background:#faf8f3}
    .dp-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .dp-label-light{color:rgba(218,165,32,.9)}
    .dp-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .dp-heading-light{color:#fff}.dp-heading em{font-style:normal;color:#DAA520}
    .dp-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.dp-divider.centered{justify-content:center}
    .dp-divider span{display:block;width:60px;height:1px;background:#DAA520}.dp-divider i{font-size:9px}
    .dp-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.dp-body-light{color:rgba(255,255,255,.62)}
    .dp-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 30px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .dp-btn-primary{background:#033631;color:#fff;border-color:#033631}.dp-btn-primary:hover{background:transparent;color:#033631}
    .dp-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.dp-btn-gold:hover{background:transparent;color:#DAA520}
    .dp-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.dp-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .dp-btn-sm{padding:10px 22px;font-size:13px}
    .dp-breadcrumb{list-style:none;padding:0;margin:0 0 20px;display:flex;gap:8px;align-items:center;font-size:13px;color:rgba(255,255,255,.65)}
    .dp-breadcrumb li+li::before{content:"/";margin-right:8px;opacity:.5}.dp-breadcrumb a{color:rgba(255,255,255,.8);text-decoration:none}
    .dp-hero{position:relative;height:620px;background:linear-gradient(135deg,rgba(3,54,49,.82),rgba(3,54,49,.45) 60%,rgba(0,0,0,.25)),url('{{ $iUrl($s("hero_image"),"assets/images/about/3.jpeg") }}') center/cover no-repeat;display:flex;align-items:center}
    .dp-hero-content{position:relative;z-index:2;color:#fff}
    .dp-hero h1{font-size:clamp(36px,5vw,64px);font-weight:800;line-height:1.1;margin-bottom:18px;color:#fff}
    .dp-hero h1 em{font-style:normal;color:#DAA520}
    .dp-hero p{font-size:16px;color:rgba(255,255,255,.78);max-width:560px;margin-bottom:32px}
    .dp-hero-shape{position:absolute;bottom:-1px;left:0;right:0;z-index:3;line-height:0}.dp-hero-shape img{width:100%}
    .dp-hero-pills{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:32px}
    .dp-hero-pill{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.1);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.2);border-radius:100px;padding:8px 18px;font-size:13px;font-weight:600;color:#fff}
    .dp-hero-pill i{color:#DAA520}
    .dp-include-card{background:#fff;border-radius:20px;padding:36px 28px;text-align:center;height:100%;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 24px rgba(3,54,49,.06);transition:transform .35s,box-shadow .35s}
    .dp-include-card:hover{transform:translateY(-8px);box-shadow:0 20px 56px rgba(3,54,49,.13)}
    .dp-include-icon{width:70px;height:70px;border-radius:50%;background:rgba(3,54,49,.07);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;transition:background .3s}
    .dp-include-icon i{font-size:26px;color:#033631;transition:color .3s}
    .dp-include-card:hover .dp-include-icon{background:#033631}.dp-include-card:hover .dp-include-icon i{color:#DAA520}
    .dp-include-title{font-size:17px;font-weight:700;color:#033631;margin-bottom:10px}
    .dp-include-text{font-size:14px;color:rgba(3,54,49,.6);line-height:1.7;margin:0}
    .dp-activity-card{position:relative;border-radius:20px;overflow:hidden;height:280px;cursor:pointer}
    .dp-activity-card img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .dp-activity-card:hover img{transform:scale(1.07)}
    .dp-activity-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(3,54,49,.88),rgba(3,54,49,.1) 60%);display:flex;flex-direction:column;justify-content:flex-end;padding:24px 22px;transition:background .3s}
    .dp-activity-card:hover .dp-activity-overlay{background:linear-gradient(to top,rgba(3,54,49,.92),rgba(3,54,49,.3) 60%)}
    .dp-activity-icon{width:46px;height:46px;border-radius:12px;background:rgba(218,165,32,.2);display:flex;align-items:center;justify-content:center;margin-bottom:12px;font-size:18px;color:#DAA520}
    .dp-activity-title{font-size:18px;font-weight:700;color:#fff;margin-bottom:6px}
    .dp-activity-text{font-size:13px;color:rgba(255,255,255,.7);line-height:1.6;max-height:0;overflow:hidden;transition:max-height .4s}
    .dp-activity-card:hover .dp-activity-text{max-height:100px}
    .dp-pkg-card{background:#fff;border-radius:24px;overflow:hidden;border:1px solid rgba(3,54,49,.1);box-shadow:0 4px 24px rgba(3,54,49,.07);transition:transform .35s,box-shadow .35s;height:100%;display:flex;flex-direction:column}
    .dp-pkg-card:hover{transform:translateY(-8px);box-shadow:0 24px 60px rgba(3,54,49,.14)}
    .dp-pkg-card.featured{border-color:#DAA520;box-shadow:0 8px 40px rgba(218,165,32,.2)}
    .dp-pkg-header{padding:32px 32px 28px;background:#033631;position:relative}
    .dp-pkg-header.gold{background:linear-gradient(135deg,#b8860b,#DAA520)}
    .dp-pkg-badge{position:absolute;top:16px;right:20px;background:#DAA520;color:#033631;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;padding:5px 14px;border-radius:100px}
    .dp-pkg-badge.white{background:#fff;color:#033631}
    .dp-pkg-name{font-size:22px;font-weight:700;color:#fff;margin-bottom:6px}
    .dp-pkg-tagline{font-size:13px;color:rgba(255,255,255,.65);margin:0}
    .dp-pkg-price{font-size:38px;font-weight:800;color:#DAA520;line-height:1;margin-top:18px}
    .dp-pkg-price.white-price{color:#fff}.dp-pkg-price span{font-size:14px;font-weight:400;color:rgba(255,255,255,.6)}
    .dp-pkg-body{padding:32px;flex:1;display:flex;flex-direction:column}
    .dp-pkg-list{list-style:none;padding:0;margin:0 0 28px;flex:1;display:flex;flex-direction:column;gap:12px}
    .dp-pkg-list li{display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(3,54,49,.7);line-height:1.5}
    .dp-pkg-list li i{color:#DAA520;margin-top:2px;font-size:12px;flex-shrink:0}
    .dp-pkg-list li.muted{opacity:.4}.dp-pkg-list li.muted i{color:rgba(3,54,49,.3)}
    .dp-gallery{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;grid-template-rows:220px 220px;gap:10px;border-radius:20px;overflow:hidden}
    .dp-gallery .dg{position:relative;overflow:hidden}.dp-gallery .dg img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .dp-gallery .dg:hover img{transform:scale(1.07)}.dp-gallery .dg-wide{grid-column:span 2}.dp-gallery .dg-tall{grid-row:span 2}
    .dp-faq-item{border-bottom:1px solid rgba(3,54,49,.1);overflow:hidden}
    .dp-faq-q{width:100%;background:none;border:none;text-align:left;padding:20px 0;display:flex;align-items:center;justify-content:space-between;gap:16px;cursor:pointer;font-size:16px;font-weight:600;color:#033631;font-family:inherit}
    .dp-faq-q .dp-faq-icon{width:32px;height:32px;border-radius:50%;flex-shrink:0;background:#E7EEEE;display:flex;align-items:center;justify-content:center;transition:background .3s,transform .3s}
    .dp-faq-q .dp-faq-icon i{font-size:12px;color:#033631}
    .dp-faq-q.active .dp-faq-icon{background:#DAA520;transform:rotate(45deg)}
    .dp-faq-a{max-height:0;overflow:hidden;transition:max-height .4s,padding .3s}
    .dp-faq-a.open{max-height:200px}.dp-faq-a p{font-size:14px;color:rgba(3,54,49,.65);line-height:1.8;padding-bottom:18px;margin:0}
    .dp-cta-box{background:linear-gradient(135deg,#033631,#055a50);border-radius:24px;padding:70px 50px;text-align:center;position:relative;overflow:hidden}
    .dp-cta-box::before{content:'';position:absolute;top:-80px;right:-80px;width:280px;height:280px;border-radius:50%;background:rgba(218,165,32,.08)}
    .dp-cta-box::after{content:'';position:absolute;bottom:-60px;left:-60px;width:200px;height:200px;border-radius:50%;background:rgba(218,165,32,.06)}
    @media(max-width:991px){.dp-gallery{grid-template-columns:1fr 1fr;grid-template-rows:repeat(3,180px)}.dp-gallery .dg-wide{grid-column:span 1}.dp-gallery .dg-tall{grid-row:span 1}}
    @media(max-width:767px){.dp-gallery{grid-template-columns:1fr;grid-template-rows:repeat(6,180px)}.dp-cta-box{padding:50px 28px}}
    @media(max-width:575px){.dp-hero h1{font-size:32px}.dp-cta-box{padding:40px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="dp-hero">
        <div class="container dp-hero-content">
            <ul class="dp-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb','Day Out Plan') }}</li>
            </ul>
            <span class="dp-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label','Forest Day Experience') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size:30px;">{!! $s('hero_heading',"One Day.<br><em>A Forest Full</em> of Memories.") !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text',"You don't need to stay overnight to experience the magic of Mahua House. Our Day Out Plans give you a full day of forest immersion — farm dining, guided nature trails, and a campfire sunset.") }}</p>
            <div class="dp-hero-pills wow fadeInUp" data-wow-delay=".45s">
                @foreach(array_filter(array_map('trim', explode("\n", $s('hero_pills',"fa-solid fa-sun|8 AM – 8 PM\nfa-solid fa-users|Individuals & Groups\nfa-solid fa-utensils|Meals Included\nfa-solid fa-person-swimming|Pool Access")))) as $pill)
                    @php [$icon, $label] = array_pad(explode('|',$pill,2),2,''); @endphp
                    <span class="dp-hero-pill"><i class="{{ $icon }}"></i> {{ $label }}</span>
                @endforeach
            </div>
        </div>
        <div class="dp-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ WHAT'S INCLUDED ═══ --}}
    @if($includes->isNotEmpty())
    <section class="dp-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="dp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('inc_label','The Experience') }}</span>
                    <h2 class="dp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('inc_heading',"Everything Your Day <em>Includes</em>") !!}</h2>
                    <div class="dp-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="dp-body wow fadeInUp" data-wow-delay=".35s">{{ $s('inc_text','Every Day Out Plan at Mahua House is carefully curated for maximum immersion and minimum stress — just show up and let the forest do the rest.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($includes as $i => $inc)
                <div class="col-xl-3 col-lg-3 col-md-4 col-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+$i*.05,2) }}s">
                    <div class="dp-include-card">
                        <div class="dp-include-icon"><i class="{{ $inc->icon ?: 'fa-solid fa-star' }}"></i></div>
                        <h5 class="dp-include-title">{{ $inc->title }}</h5>
                        <p class="dp-include-text">{{ $inc->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ ACTIVITIES SHOWCASE ═══ --}}
    @if($activities->isNotEmpty())
    <section class="dp-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="dp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('act_label','Activities') }}</span>
                    <h2 class="dp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('act_heading','What You Can <em>Do Here</em>') !!}</h2>
                    <div class="dp-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($activities as $i => $act)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+$i*.1,1) }}s">
                    <div class="dp-activity-card">
                        <img src="{{ $iUrl($act->image_url,'assets/images/about/10.jpeg') }}" alt="{{ $act->title }}">
                        <div class="dp-activity-overlay">
                            <div class="dp-activity-icon"><i class="{{ $act->icon ?: 'fa-solid fa-leaf' }}"></i></div>
                            <h4 class="dp-activity-title">{{ $act->title }}</h4>
                            <p class="dp-activity-text">{{ $act->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ PACKAGES ═══ --}}
    @if($offers->isNotEmpty())
    <section class="dp-section dp-section-cream" id="packages">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="dp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('pkg_label','Day Out Plans') }}</span>
                    <h2 class="dp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('pkg_heading','Choose Your <em>Day</em>') !!}</h2>
                    <div class="dp-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="dp-body wow fadeInUp" data-wow-delay=".35s">{{ $s('pkg_text','Tailored day experiences — all prices per person.') }}</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($offers as $i => $offer)
                @php
                    $isFeatured = $offer->is_featured;
                    $inclusions = is_array($offer->inclusions) ? $offer->inclusions : (json_decode($offer->inclusions, true) ?? []);
                @endphp
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+$i*.1,1) }}s">
                    <div class="dp-pkg-card {{ $isFeatured ? 'featured' : '' }}">
                        <div class="dp-pkg-header {{ $isFeatured ? 'gold' : '' }}">
                            @if($offer->badge_text)<span class="dp-pkg-badge {{ $isFeatured ? 'white' : '' }}">{{ $offer->badge_text }}</span>@endif
                            <h3 class="dp-pkg-name">{{ $offer->title }}</h3>
                            <p class="dp-pkg-tagline">{{ $offer->description }}</p>
                            <div class="dp-pkg-price {{ $isFeatured ? 'white-price' : '' }}">
                                &#8377;{{ number_format($offer->price, 0) }} <span>/ person</span>
                            </div>
                        </div>
                        <div class="dp-pkg-body">
                            <ul class="dp-pkg-list">
                                @foreach($inclusions as $item)
                                @php $isCrossed = Str::startsWith($item,'[x]'); $label = ltrim($item,'[x] '); @endphp
                                <li class="{{ $isCrossed ? 'muted' : '' }}">
                                    <i class="fa-solid {{ $isCrossed ? 'fa-xmark' : 'fa-check' }}"></i> {{ $label }}
                                </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('contact') }}" class="dp-btn {{ $isFeatured ? 'dp-btn-gold' : 'dp-btn-primary' }}" style="width:100%;text-align:center;justify-content:center;">Book This Plan</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($s('group_text'))
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <div style="background:#033631;border-radius:16px;padding:28px 36px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;" class="wow fadeInUp" data-wow-delay=".4s">
                        <div style="font-size:32px;color:#DAA520;"><i class="{{ $s('group_icon','fa-solid fa-users') }}"></i></div>
                        <div>
                            <p style="color:#fff;font-weight:700;font-size:16px;margin-bottom:4px;">{{ $s('group_title','Group & Corporate Bookings') }}</p>
                            <p style="color:rgba(255,255,255,0.65);font-size:14px;margin:0;">{{ $s('group_text') }}</p>
                        </div>
                        <a href="{{ route('contact') }}" class="dp-btn dp-btn-gold dp-btn-sm" style="margin-left:auto;flex-shrink:0;">{{ $s('group_cta','Get Group Quote') }}</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ═══ GALLERY ═══ --}}
    @if($galleryItems->isNotEmpty())
    <section class="dp-section dp-section-alt">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="dp-label wow fadeInUp" data-wow-delay=".1s">{{ $s('gallery_label','Photo Gallery') }}</span>
                    <h2 class="dp-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('gallery_heading','A Day <em>Through the Lens</em>') !!}</h2>
                </div>
                <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('contact') }}" class="dp-btn dp-btn-primary">{{ $s('gallery_cta','Book Your Day') }}</a>
                </div>
            </div>
            <div class="dp-gallery wow fadeInUp" data-wow-delay=".3s">
                @foreach($galleryItems as $i => $item)
                <div class="dg {{ $i === 0 ? 'dg-tall' : ($i === 1 ? 'dg-wide' : '') }}">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ FAQ ═══ --}}
    <section class="dp-section">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                    <span class="dp-label">{{ $s('faq_label','Common Questions') }}</span>
                    <h2 class="dp-heading">{!! $s('faq_heading','Day Out <em>FAQs</em>') !!}</h2>
                    <div class="dp-divider"><span></span><i class="fa-solid fa-circle-question"></i><span></span></div>
                    <p class="dp-body mb-4">{{ $s('faq_text','Have a question about visiting Mahua House for the day? Find quick answers below or reach out to our team directly.') }}</p>
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        @if($phone)
                        <a href="tel:{{ preg_replace('/\D+/','',$phone) }}" style="display:flex;align-items:center;gap:12px;text-decoration:none;color:#033631;font-weight:600;font-size:14px;">
                            <span style="width:40px;height:40px;background:#E7EEEE;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:16px;flex-shrink:0;"><i class="fa-solid fa-phone-volume"></i></span>
                            {{ $phone }}
                        </a>
                        @endif
                        @if($email)
                        <a href="mailto:{{ $email }}" style="display:flex;align-items:center;gap:12px;text-decoration:none;color:#033631;font-weight:600;font-size:14px;">
                            <span style="width:40px;height:40px;background:#E7EEEE;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:16px;flex-shrink:0;"><i class="fa-solid fa-envelope"></i></span>
                            {{ $email }}
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                    <div id="dp-faq">
                        @forelse($faqs as $faq)
                        <div class="dp-faq-item">
                            <button class="dp-faq-q">
                                {{ $faq->question }}
                                <span class="dp-faq-icon"><i class="fa-solid fa-plus"></i></span>
                            </button>
                            <div class="dp-faq-a"><p>{{ $faq->answer }}</p></div>
                        </div>
                        @empty
                        <div class="dp-faq-item">
                            <button class="dp-faq-q">Do I need to pre-book a Day Out Plan?<span class="dp-faq-icon"><i class="fa-solid fa-plus"></i></span></button>
                            <div class="dp-faq-a"><p>Yes, advance booking is strongly recommended — especially on weekends. We recommend booking at least 2–3 days in advance.</p></div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="dp-section">
        <div class="container">
            <div class="dp-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="dp-label dp-label-light">{{ $s('cta_label','Ready for Your Forest Day?') }}</span>
                    <h2 class="dp-heading dp-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading','Book Your Day Out <em>Today</em>') !!}</h2>
                    <p class="dp-body dp-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text','Escape the city for a day. Breathe the forest. Return renewed. Our Day Out Plans are available on all days — book now and secure your slot.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('contact') }}" class="dp-btn dp-btn-gold">{{ $s('cta_btn1','Book Now') }}</a>
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/','',$phone) }}" class="dp-btn dp-btn-outline"><i class="fa-solid fa-phone"></i>Call Us: {{ $phone }}</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.dp-faq-q').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var answer = this.nextElementSibling;
        var isOpen = answer.classList.contains('open');
        document.querySelectorAll('.dp-faq-a').forEach(function(a) { a.classList.remove('open'); });
        document.querySelectorAll('.dp-faq-q').forEach(function(q) { q.classList.remove('active'); });
        if (!isOpen) { answer.classList.add('open'); this.classList.add('active'); }
    });
});
</script>
@endsection

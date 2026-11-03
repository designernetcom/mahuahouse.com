@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url,$fb='') => $url ? (Str::startsWith($url,['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key,$default='') => optional($contact[$key] ?? null)->value ?? $default;
    $phone    = $settings['phone_primary']   ?? $contactValue('phone','+91 9425651754');
    $whatsapp = $settings['whatsapp_number'] ?? $contactValue('whatsapp','919425651754');
@endphp

@section('title', $s('meta_title','Educational & Experience Tours | Mahua House'))
@section('meta_description', $s('meta_description','Educational & Experience Tours at Mahua House — nature-based learning, jungle trekking, cultural exposure and supervised group programs for schools near Bhopal.'))
@section('meta_keywords', $s('meta_keywords','Educational Tour Bhopal, School Trip Forest, Nature Learning Bhopal, Jungle Trekking School'))

@section('styles')
<style>
    .et-section{padding:90px 0}.et-section-alt{background:#E7EEEE}.et-section-dark{background:#033631}.et-section-cream{background:#faf8f3}
    .et-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .et-label-light{color:rgba(218,165,32,.9)}
    .et-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .et-heading-light{color:#fff}.et-heading em{font-style:normal;color:#DAA520}
    .et-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.et-divider.centered{justify-content:center}
    .et-divider span{display:block;width:60px;height:1px;background:#DAA520}.et-divider i{font-size:9px}
    .et-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.et-body-light{color:rgba(255,255,255,.62)}
    .et-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .et-btn-primary{background:#033631;color:#fff;border-color:#033631}.et-btn-primary:hover{background:transparent;color:#033631}
    .et-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.et-btn-gold:hover{background:transparent;color:#DAA520}
    .et-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.et-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .et-hero{position:relative;height:580px;background:url('{{ $iUrl($s("hero_image"),"assets/images/about/14.jpeg") }}') center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden}
    .et-hero::before{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.25),rgba(3,54,49,.88))}
    .et-hero-content{position:relative;z-index:2;padding-bottom:80px;width:100%}
    .et-breadcrumb{list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px}
    .et-breadcrumb li{font-size:13px;color:rgba(255,255,255,.5)}.et-breadcrumb li a{color:#DAA520;text-decoration:none}
    .et-breadcrumb li+li::before{content:'/';margin-right:8px}
    .et-hero h1{font-size:clamp(32px,5vw,62px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px}
    .et-hero h1 em{font-style:italic;color:#DAA520}
    .et-hero p{font-size:16px;color:rgba(255,255,255,.75);max-width:580px;line-height:1.75;margin-bottom:30px}
    .et-hero-shape{position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0}.et-hero-shape img{width:100%}
    .et-highlight-card{background:#fff;border-radius:18px;padding:32px 26px;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.07);height:100%;text-align:center;transition:transform .35s,box-shadow .35s}
    .et-highlight-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(3,54,49,.12)}
    .et-highlight-icon{width:68px;height:68px;border-radius:50%;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:inline-flex;align-items:center;justify-content:center;color:#DAA520;font-size:26px;margin-bottom:18px}
    .et-highlight-title{font-size:17px;font-weight:700;color:#033631;margin-bottom:10px}
    .et-highlight-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.7;margin:0}
    .et-program-card{background:#fff;border-radius:18px;overflow:hidden;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.07);height:100%}
    .et-program-head{background:#033631;padding:24px 26px;display:flex;align-items:center;gap:14px}
    .et-program-icon{width:50px;height:50px;border-radius:12px;background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:20px;flex-shrink:0}
    .et-program-head-title{font-size:18px;font-weight:700;color:#fff;margin:0}.et-program-head-sub{font-size:12px;color:rgba(255,255,255,.5);margin:3px 0 0}
    .et-program-body{padding:24px 26px}
    .et-check-list{list-style:none;padding:0;margin:0}
    .et-check-list li{display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(3,54,49,.65);padding:8px 0;border-bottom:1px solid rgba(3,54,49,.06)}
    .et-check-list li:last-child{border-bottom:none}.et-check-list li i{color:#DAA520;font-size:11px;margin-top:4px;min-width:14px}
    .et-info-img{border-radius:20px;overflow:hidden;height:480px;position:relative}.et-info-img img{width:100%;height:100%;object-fit:cover}
    .et-info-badge{position:absolute;bottom:24px;left:24px;right:24px;background:rgba(3,54,49,.92);backdrop-filter:blur(8px);border-radius:14px;padding:18px 20px;display:flex;align-items:center;gap:14px}
    .et-info-badge-icon{width:44px;height:44px;border-radius:50%;background:#DAA520;display:flex;align-items:center;justify-content:center;font-size:18px;color:#033631;flex-shrink:0}
    .et-safety-strip{background:linear-gradient(135deg,#033631,#07554D);border-radius:20px;padding:36px 40px;display:flex;align-items:center;gap:24px;flex-wrap:wrap}
    .et-safety-strip-icon{width:64px;height:64px;border-radius:50%;background:rgba(218,165,32,.15);border:2px solid rgba(218,165,32,.3);display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:26px;flex-shrink:0}
    .et-cta-box{background:linear-gradient(135deg,#033631,#07554D);border-radius:24px;padding:70px 60px;text-align:center;position:relative;overflow:hidden}
    .et-cta-box::before{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:rgba(218,165,32,.08)}
    .et-cta-box::after{content:'';position:absolute;bottom:-80px;left:-80px;width:260px;height:260px;border-radius:50%;background:rgba(218,165,32,.06)}
    .et-form-control{border:1px solid rgba(3,54,49,.15);border-radius:10px;padding:13px 16px;font-size:14px;color:#033631;background:#fafafa;width:100%}
    .et-form-control:focus{outline:none;border-color:#DAA520}
    .et-form-label{font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#033631;margin-bottom:7px;display:block}
    .et-alert{background:rgba(25,135,84,.1);border:1px solid rgba(25,135,84,.3);border-radius:12px;padding:16px 20px;margin-bottom:24px;color:#146c43;font-weight:500;font-size:14px}
    @media(max-width:991px){.et-hero{height:460px}.et-section{padding:70px 0}.et-cta-box{padding:50px 30px}.et-safety-strip{padding:28px 24px}}
    @media(max-width:575px){.et-hero h1{font-size:30px}.et-cta-box{padding:40px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="et-hero">
        <div class="container et-hero-content">
            <ul class="et-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb','Educational & Experience Tours') }}</li>
            </ul>
            <span class="et-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label','Schools & Institutions') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $s('hero_heading','Learn in the <em>Living Forest</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text','Structured, supervised and deeply enriching — our educational tours blend nature-based learning, jungle trekking, cultural exposure and group activities in the Samardha Reserved Forest.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#enquire" class="et-btn et-btn-gold">{{ $s('hero_cta1','Plan a School Visit') }}</a>
                @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="et-btn et-btn-outline"><i class="fa-brands fa-whatsapp"></i>{{ $s('hero_cta2','WhatsApp Us') }}</a>@endif
            </div>
        </div>
        <div class="et-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ HIGHLIGHTS ═══ --}}
    @if($highlights->isNotEmpty())
    <section class="et-section" style="padding-top:110px;">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="et-label wow fadeInUp" data-wow-delay=".1s">{{ $s('hl_label','Why Mahua House') }}</span>
                    <h2 class="et-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('hl_heading','A Classroom Like <em>No Other</em>') !!}</h2>
                    <div class="et-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="et-body wow fadeInUp" data-wow-delay=".4s">{{ $s('hl_text','Nestled in 3.5 acres adjoining the Samardha Reserved Forest, Mahua House offers a safe, structured and unforgettable outdoor learning environment.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($highlights as $i => $h)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    <div class="et-highlight-card">
                        <div class="et-highlight-icon"><i class="{{ $h->icon ?: 'fa-solid fa-leaf' }}"></i></div>
                        <h4 class="et-highlight-title">{{ $h->title }}</h4>
                        <p class="et-highlight-text">{{ $h->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ PROGRAMS + IMAGE SPLIT ═══ --}}
    <section class="et-section et-section-alt">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <span class="et-label">{{ $s('split_label','Designed for Institutions') }}</span>
                    <h2 class="et-heading">{!! $s('split_heading','Structured <em>Programs</em><br>for Every Age Group') !!}</h2>
                    <div class="et-divider"><span></span><i class="fa-solid fa-graduation-cap"></i><span></span></div>
                    <p class="et-body mb-4">{{ $s('split_text','Whether it\'s a school trip for primary students or a college field study, our programs are tailored to the curriculum and age group — always supervised, always safe.') }}</p>
                    <div class="row g-3 mb-4">
                        @foreach([
                            [$s('mini1_icon','fa-solid fa-seedling'),  $s('mini1_title','Eco-Awareness Camp'),    $s('mini1_desc','Forest biodiversity, conservation & sustainability')],
                            [$s('mini2_icon','fa-solid fa-tractor'),   $s('mini2_title','Farm & Rural Experience'),$s('mini2_desc','Hands-on farming & rural community interaction')],
                            [$s('mini3_icon','fa-solid fa-magnifying-glass'),$s('mini3_title','Forest Exploration'),$s('mini3_desc','Samardha Reserved Forest guided discovery walks')],
                            [$s('mini4_icon','fa-solid fa-masks-theater'),$s('mini4_title','Cultural Immersion'), $s('mini4_desc','Folk arts, heritage crafts & local traditions')],
                        ] as [$icon,$title,$desc])
                        <div class="col-sm-6">
                            <div style="background:#fff;border-radius:14px;padding:20px;border:1px solid rgba(3,54,49,.08);box-shadow:0 2px 12px rgba(3,54,49,.06);">
                                <i class="{{ $icon }}" style="color:#DAA520;font-size:22px;margin-bottom:10px;display:block;"></i>
                                <p style="font-size:15px;font-weight:700;color:#033631;margin:0 0 4px;">{{ $title }}</p>
                                <p style="font-size:13px;color:rgba(3,54,49,.55);margin:0;">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="et-btn et-btn-primary"><i class="fa-brands fa-whatsapp"></i>{{ $s('split_cta','Enquire for School Group') }}</a>@endif
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <div class="et-info-img">
                        <img src="{{ $iUrl($s('split_image'),'assets/images/about/22.jpeg') }}" alt="Educational Tour at Mahua House">
                        <div class="et-info-badge">
                            <div class="et-info-badge-icon"><i class="{{ $s('split_badge_icon','fa-solid fa-graduation-cap') }}"></i></div>
                            <div>
                                <p style="font-size:15px;font-weight:700;color:#fff;margin:0;">{{ $s('split_badge_title','Schools & Colleges Welcome') }}</p>
                                <p style="font-size:13px;color:rgba(255,255,255,.55);margin:4px 0 0;">{{ $s('split_badge_sub','Customised day & overnight programs available') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ PROGRAM CARDS ═══ --}}
    @if($programs->isNotEmpty())
    <section class="et-section et-section-dark">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="et-label et-label-light wow fadeInUp" data-wow-delay=".1s">{{ $s('prog_label','Program Menu') }}</span>
                    <h2 class="et-heading et-heading-light wow fadeInUp" data-wow-delay=".2s">{!! $s('prog_heading',"What's <em>Included</em>") !!}</h2>
                    <div class="et-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="et-body et-body-light wow fadeInUp" data-wow-delay=".4s">{{ $s('prog_text','Choose from a range of structured modules or let us curate a full-day or multi-day program for your group.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($programs as $i => $prog)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ number_format(.1+$i*.1,1) }}s">
                    <div class="et-program-card">
                        <div class="et-program-head">
                            <div class="et-program-icon"><i class="{{ $prog->icon ?: 'fa-solid fa-tree' }}"></i></div>
                            <div>
                                <h4 class="et-program-head-title">{{ $prog->title }}</h4>
                                <p class="et-program-head-sub">{{ $prog->link }}</p>
                            </div>
                        </div>
                        <div class="et-program-body">
                            <ul class="et-check-list">
                                @foreach(array_filter(array_map('trim', explode("\n", $prog->description ?? ''))) as $item)
                                <li><i class="fa-solid fa-check"></i> {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ SAFETY STRIP ═══ --}}
    <section class="et-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="et-label wow fadeInUp" data-wow-delay=".1s">{{ $s('safety_label','Safety First') }}</span>
                    <h2 class="et-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('safety_heading','Safe, Supervised &amp; <em>Structured</em>') !!}</h2>
                    <div class="et-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                </div>
            </div>
            <div class="et-safety-strip wow fadeInUp" data-wow-delay=".3s">
                <div class="et-safety-strip-icon"><i class="{{ $s('safety_icon','fa-solid fa-shield-halved') }}"></i></div>
                <div style="flex:1;">
                    <p style="font-size:17px;font-weight:700;color:#fff;margin:0 0 8px;">{{ $s('safety_title','Every program at Mahua House is fully supervised and structured.') }}</p>
                    <p style="font-size:14px;color:rgba(255,255,255,.6);margin:0;">{{ $s('safety_text','All activities are led by experienced guides and staff. The property is fully enclosed, secure and monitored — giving teachers and parents complete peace of mind. First aid is always available on-site.') }}</p>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    @foreach(array_filter(array_map('trim', explode("\n", $s('safety_badges',"Trained Staff\nFirst Aid On-Site\nMP Tourism Accredited")))) as $badge)
                    <span style="background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);border-radius:100px;padding:8px 18px;font-size:13px;font-weight:600;color:#DAA520;"><i class="fa-solid fa-check me-2"></i>{{ $badge }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ ENQUIRY FORM ═══ --}}
    <section class="et-section et-section-alt" id="enquire">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="et-label wow fadeInUp" data-wow-delay=".1s">{{ $s('form_label','Get In Touch') }}</span>
                    <h2 class="et-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('form_heading','Plan Your <em>School Visit</em>') !!}</h2>
                    <div class="et-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="et-body wow fadeInUp" data-wow-delay=".4s">{{ $s('form_text','Tell us about your institution and group size and we\'ll put together a custom program proposal for you.') }}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 wow fadeInUp" data-wow-delay=".3s">
                    <div style="background:#fff;border-radius:20px;padding:48px 44px;box-shadow:0 8px 40px rgba(3,54,49,.1);border:1px solid rgba(3,54,49,.08);">
                        @if(session('enquiry_success'))<div class="et-alert"><i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}</div>@endif
                        <form method="POST" action="{{ route('enquiry.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="educational-tour">
                            <div class="row g-4">
                                <div class="col-md-4"><label class="et-form-label">Institution Name *</label><input type="text" name="name" class="et-form-control" placeholder="School / College name" value="{{ old('name') }}" required></div>
                                <div class="col-md-4"><label class="et-form-label">Phone Number *</label><input type="tel" name="phone" class="et-form-control" placeholder="+91 00000 00000" value="{{ old('phone') }}" required></div>
                                <div class="col-md-4"><label class="et-form-label">Email Address</label><input type="email" name="email" class="et-form-control" placeholder="your@email.com" value="{{ old('email') }}"></div>
                                <div class="col-md-4">
                                    <label class="et-form-label">Student Age Group</label>
                                    <select name="room_type" class="et-form-control" style="appearance:none;">
                                        <option value="">Select age group</option>
                                        <option @selected(old('room_type')=='Primary (6–10 years)')>Primary (6–10 years)</option>
                                        <option @selected(old('room_type')=='Middle School (11–14 years)')>Middle School (11–14 years)</option>
                                        <option @selected(old('room_type')=='High School (15–18 years)')>High School (15–18 years)</option>
                                        <option @selected(old('room_type')=='College / University')>College / University</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="et-form-label">Group Size</label>
                                    <select name="guests" class="et-form-control" style="appearance:none;">
                                        <option value="">Select size</option>
                                        <option @selected(old('guests')=='Up to 30')>Up to 30 students</option>
                                        <option @selected(old('guests')=='31-60')>31 – 60 students</option>
                                        <option @selected(old('guests')=='61-100')>61 – 100 students</option>
                                        <option @selected(old('guests')=='100+')>100+ students</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><label class="et-form-label">Preferred Visit Date</label><input type="date" name="check_in" class="et-form-control" value="{{ old('check_in') }}"></div>
                                <div class="col-12"><label class="et-form-label">Special Requirements</label><textarea name="message" class="et-form-control" rows="4" placeholder="Program goals, dietary needs, overnight stay requirements..." style="resize:none;">{{ old('message') }}</textarea></div>
                                <div class="col-12"><button type="submit" style="background:#033631;color:#fff;border:2px solid #033631;border-radius:12px;padding:16px;font-size:15px;font-weight:700;width:100%;cursor:pointer;transition:all .3s;"><i class="fa-solid fa-paper-plane me-2"></i>Send Enquiry</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="et-section">
        <div class="container">
            <div class="et-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="et-label et-label-light">{{ $s('cta_label',"Let's Plan Together") }}</span>
                    <h2 class="et-heading et-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading',"Give Your Students an Experience <em>They'll Never Forget</em>") !!}</h2>
                    <p class="et-body et-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text','Contact us at Mahua House to plan your school or institutional tour in a stunning forest setting.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="et-btn et-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/','',$phone) }}" class="et-btn et-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                        <a href="{{ route('contact') }}" class="et-btn et-btn-outline">Enquire Today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

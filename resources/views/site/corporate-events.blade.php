@extends('layouts.app')

@php
    $s   = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl= fn($url,$fb='') => $url ? (Str::startsWith($url,['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');
    $contactValue = fn($key,$default='') => optional($contact[$key] ?? null)->value ?? $default;
    $phone    = $settings['phone_primary']    ?? $contactValue('phone','+91 9425651754');
    $whatsapp = $settings['whatsapp_number']  ?? $contactValue('whatsapp','919425651754');
    $facebook = $settings['facebook_url']     ?? $contactValue('facebook','https://www.facebook.com/mahuahouse');
@endphp

@section('title', $s('meta_title','Corporate Events & Group Retreats | Mahua House'))
@section('meta_description', $s('meta_description','Corporate retreats, team-building workshops, educational tours and film shoots at Mahua House — MP Tourism accredited nature retreat near Bhopal.'))
@section('meta_keywords', $s('meta_keywords','Corporate Retreat Bhopal, Team Building Forest Bhopal, Educational Tour Forest, Film Shoot Location Bhopal'))

@section('styles')
<style>
    .ce-section{padding:90px 0}.ce-section-alt{background:#E7EEEE}.ce-section-dark{background:#033631}.ce-section-cream{background:#faf8f3}
    .ce-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .ce-label-light{color:rgba(218,165,32,.9)}
    .ce-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .ce-heading-light{color:#fff}.ce-heading em{font-style:normal;color:#DAA520}
    .ce-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.ce-divider.centered{justify-content:center}
    .ce-divider span{display:block;width:60px;height:1px;background:#DAA520}.ce-divider i{font-size:9px}
    .ce-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.ce-body-light{color:rgba(255,255,255,.62)}
    .ce-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .ce-btn-primary{background:#033631;color:#fff;border-color:#033631}.ce-btn-primary:hover{background:transparent;color:#033631}
    .ce-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.ce-btn-gold:hover{background:transparent;color:#DAA520}
    .ce-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.ce-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .ce-hero{position:relative;height:580px;background:url('{{ $iUrl($s("hero_image"),"assets/images/about/7.jpeg") }}') center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden}
    .ce-hero::before{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.28),rgba(3,54,49,.85))}
    .ce-hero-content{position:relative;z-index:2;padding-bottom:80px;width:100%}
    .ce-breadcrumb{list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px}
    .ce-breadcrumb li{font-size:13px;color:rgba(255,255,255,.5)}.ce-breadcrumb li a{color:#DAA520;text-decoration:none}
    .ce-breadcrumb li+li::before{content:'/';margin-right:8px}
    .ce-hero h1{font-size:clamp(34px,5vw,64px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px}
    .ce-hero h1 em{font-style:italic;color:#DAA520}
    .ce-hero p{font-size:16px;color:rgba(255,255,255,.75);max-width:580px;line-height:1.75;margin-bottom:30px}
    .ce-hero-shape{position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0}.ce-hero-shape img{width:100%}
    .ce-cat-card{border-radius:20px;overflow:hidden;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 24px rgba(3,54,49,.07);height:100%;display:flex;flex-direction:column}
    .ce-cat-head{background:#033631;padding:30px 28px;display:flex;align-items:center;gap:16px}
    .ce-cat-icon{width:56px;height:56px;border-radius:14px;background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);display:flex;align-items:center;justify-content:center;color:#DAA520;font-size:22px;flex-shrink:0}
    .ce-cat-head-title{font-size:20px;font-weight:700;color:#fff;margin:0}.ce-cat-head-sub{font-size:12px;color:rgba(255,255,255,.5);margin:4px 0 0}
    .ce-cat-body{padding:26px 28px;background:#fff;flex:1}
    .ce-cat-list{list-style:none;padding:0;margin:0}.ce-cat-list li{display:flex;align-items:flex-start;gap:10px;font-size:14px;color:rgba(3,54,49,.65);padding:8px 0;border-bottom:1px solid rgba(3,54,49,.06)}
    .ce-cat-list li:last-child{border-bottom:none}.ce-cat-list li i{color:#DAA520;font-size:11px;margin-top:4px;min-width:14px}
    .ce-feature-item{display:flex;align-items:flex-start;gap:18px;padding:22px 0;border-bottom:1px solid rgba(3,54,49,.08)}
    .ce-feature-item:first-child{padding-top:0}.ce-feature-item:last-child{border-bottom:none;padding-bottom:0}
    .ce-feature-icon{width:52px;height:52px;min-width:52px;border-radius:14px;background:rgba(3,54,49,.07);border:1px solid rgba(3,54,49,.12);display:flex;align-items:center;justify-content:center;color:#033631;font-size:20px;flex-shrink:0;transition:background .3s,color .3s}
    .ce-feature-item:hover .ce-feature-icon{background:#DAA520;color:#033631;border-color:#DAA520}
    .ce-feature-title{font-size:16px;font-weight:700;color:#033631;margin-bottom:5px}.ce-feature-text{font-size:14px;color:rgba(3,54,49,.55);line-height:1.7;margin:0}
    .ce-act-card{background:#fff;border-radius:16px;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 16px rgba(3,54,49,.06);padding:28px 22px;text-align:center;height:100%;transition:transform .35s,box-shadow .35s,background .35s}
    .ce-act-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(3,54,49,.12);background:#033631}
    .ce-act-icon{width:62px;height:62px;border-radius:50%;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:inline-flex;align-items:center;justify-content:center;color:#DAA520;font-size:24px;margin-bottom:16px;transition:background .35s}
    .ce-act-card:hover .ce-act-icon{background:#DAA520;color:#033631;border-color:#DAA520}
    .ce-act-title{font-size:16px;font-weight:700;color:#033631;margin-bottom:8px;transition:color .35s}.ce-act-card:hover .ce-act-title{color:#DAA520}
    .ce-act-text{font-size:13px;color:rgba(3,54,49,.55);line-height:1.65;margin:0;transition:color .35s}.ce-act-card:hover .ce-act-text{color:rgba(255,255,255,.6)}
    .ce-info-img{border-radius:20px;overflow:hidden;height:480px;position:relative}.ce-info-img img{width:100%;height:100%;object-fit:cover}
    .ce-info-badge{position:absolute;bottom:24px;left:24px;right:24px;background:rgba(3,54,49,.92);backdrop-filter:blur(8px);border-radius:14px;padding:18px 20px;display:flex;align-items:center;gap:14px}
    .ce-info-badge-icon{width:44px;height:44px;border-radius:50%;background:#DAA520;display:flex;align-items:center;justify-content:center;font-size:18px;color:#033631;flex-shrink:0}
    .ce-cta-box{background:linear-gradient(135deg,#033631,#07554D);border-radius:24px;padding:70px 60px;text-align:center;position:relative;overflow:hidden}
    .ce-cta-box::before{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:rgba(218,165,32,.08)}
    .ce-cta-box::after{content:'';position:absolute;bottom:-80px;left:-80px;width:260px;height:260px;border-radius:50%;background:rgba(218,165,32,.06)}
    .ce-form-wrap{background:#fff;border-radius:20px;padding:48px 44px;box-shadow:0 8px 40px rgba(3,54,49,.1);border:1px solid rgba(3,54,49,.08)}
    .ce-form-label{font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#033631;margin-bottom:7px;display:block}
    .ce-form-control{border:1px solid rgba(3,54,49,.15);border-radius:10px;padding:13px 16px;font-size:14px;color:#033631;background:#fafafa;width:100%}
    .ce-form-control:focus{outline:none;border-color:#DAA520}
    .ce-alert{background:rgba(25,135,84,.1);border:1px solid rgba(25,135,84,.3);border-radius:12px;padding:16px 20px;margin-bottom:24px;color:#146c43;font-weight:500;font-size:14px}
    @media(max-width:991px){.ce-hero{height:460px}.ce-section{padding:70px 0}.ce-cta-box{padding:50px 30px}}
    @media(max-width:575px){.ce-hero h1{font-size:32px}.ce-cta-box,.ce-form-wrap{padding:34px 20px}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="ce-hero">
        <div class="container ce-hero-content">
            <ul class="ce-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb','Corporate & Group Events') }}</li>
            </ul>
            <span class="ce-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label','Groups & Corporates') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size:30px;">{!! $s('hero_heading','Retreats, Workshops &amp;<br><em>Experiences</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text','Team-building retreats, educational tours, film shoots and group outings — Mahua House offers a complete nature-based experience for every kind of group.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#enquire" class="ce-btn ce-btn-gold">{{ $s('hero_cta1','Plan Your Retreat') }}</a>
                @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="ce-btn ce-btn-outline"><i class="fa-brands fa-whatsapp"></i>{{ $s('hero_cta2','WhatsApp Us') }}</a>@endif
            </div>
        </div>
        <div class="ce-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ CATEGORY CARDS ═══ --}}
    <section class="ce-section" style="padding-top:110px;">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ce-label wow fadeInUp" data-wow-delay=".1s">{{ $s('cats_label','What We Offer') }}</span>
                    <h2 class="ce-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('cats_heading','Three Distinct <em>Group Experiences</em>') !!}</h2>
                    <div class="ce-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="ce-body wow fadeInUp" data-wow-delay=".4s">{{ $s('cats_text','From corporate team-building to school field trips to film shoots — a forest experience for every group.') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach([
                    ['icon'=>$s('cat1_icon','fa-solid fa-briefcase'),'title'=>$s('cat1_title','Corporate & Group Events'),'sub'=>$s('cat1_subtitle','Team Retreats & Workshops'),'items'=>$s('cat1_items','Team-building retreats'."\n".'Strategic workshops & meetings'."\n".'Club & group outings'."\n".'Training programs'."\n".'Projector & sound support'."\n".'Group activities included'."\n".'Customised meal plans (₹1,000/head)')],
                    ['icon'=>$s('cat2_icon','fa-solid fa-graduation-cap'),'title'=>$s('cat2_title','Educational & Institutional Tours'),'sub'=>$s('cat2_subtitle','School, College & Institution Groups'),'items'=>$s('cat2_items','School & college group visits'."\n".'Nature walks & forest education'."\n".'Eco-awareness camps'."\n".'Hands-on farming experiences'."\n".'Rural culture & heritage discovery'."\n".'Samardha Reserved Forest exploration'."\n".'Supervised activities for students')],
                    ['icon'=>$s('cat3_icon','fa-solid fa-video'),'title'=>$s('cat3_title','Film & Media Productions'),'sub'=>$s('cat3_subtitle','Shoots, Documentaries & Photography'),'items'=>$s('cat3_items','Natural forest backdrop — no fake sets'."\n".'TV commercials & brand films'."\n".'Documentaries & short films'."\n".'Music videos & cultural productions'."\n".'Pre-wedding & portfolio shoots'."\n".'Editorial & fashion photography'."\n".'Crew accommodation on-site')],
                ] as $i => $cat)
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="{{ number_format(.2+$i*.1,1) }}s">
                    <div class="ce-cat-card">
                        <div class="ce-cat-head">
                            <div class="ce-cat-icon"><i class="{{ $cat['icon'] }}"></i></div>
                            <div>
                                <h4 class="ce-cat-head-title">{{ $cat['title'] }}</h4>
                                <p class="ce-cat-head-sub">{{ $cat['sub'] }}</p>
                            </div>
                        </div>
                        <div class="ce-cat-body">
                            <ul class="ce-cat-list">
                                @foreach(array_filter(array_map('trim', explode("\n", $cat['items']))) as $item)
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

    {{-- ═══ WHY CHOOSE ═══ --}}
    @if($whyFeatures->isNotEmpty())
    <section class="ce-section ce-section-alt">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".2s">
                    <div class="ce-info-img">
                        <img src="{{ $iUrl($s('why_image'),'assets/images/about/20.jpeg') }}" alt="Corporate Retreat at Mahua House">
                        <div class="ce-info-badge">
                            <div class="ce-info-badge-icon"><i class="{{ $s('why_badge_icon','fa-solid fa-leaf') }}"></i></div>
                            <div>
                                <p style="font-size:15px;font-weight:700;color:#fff;margin:0;line-height:1.2;">{{ $s('why_badge_title','MP Tourism Accredited') }}</p>
                                <p style="font-size:12px;color:rgba(255,255,255,.5);margin:0;">{{ $s('why_badge_sub','Trusted nature retreat on Raisen Road, Bhopal') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay=".3s">
                    <span class="ce-label">{{ $s('why_label','Why Choose Mahua House') }}</span>
                    <h2 class="ce-heading">{!! $s('why_heading','Corporate Retreats in a<br><em>Real Forest</em>') !!}</h2>
                    <div class="ce-divider"><span></span><i class="fa-solid fa-star"></i><span></span></div>
                    @foreach($whyFeatures as $f)
                    <div class="ce-feature-item">
                        <div class="ce-feature-icon"><i class="{{ $f->icon ?: 'fa-solid fa-check' }}"></i></div>
                        <div>
                            <h5 class="ce-feature-title">{{ $f->title }}</h5>
                            <p class="ce-feature-text">{{ $f->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ ACTIVITIES GRID ═══ --}}
    @if($activities->isNotEmpty())
    <section class="ce-section ce-section-cream">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ce-label wow fadeInUp" data-wow-delay=".1s">{{ $s('act_label','Group Activities') }}</span>
                    <h2 class="ce-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('act_heading','Activities for Your <em>Team or Group</em>') !!}</h2>
                    <div class="ce-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="ce-body wow fadeInUp" data-wow-delay=".4s">{{ $s('act_text',"From adventure to relaxation — there's something for every group member.") }}</p>
                </div>
            </div>
            <div class="row g-4">
                @foreach($activities as $i => $act)
                <div class="col-lg-2 col-md-4 col-6 wow fadeInUp" data-wow-delay="{{ number_format(.2+$i*.05,2) }}s">
                    <div class="ce-act-card">
                        <div class="ce-act-icon"><i class="{{ $act->icon ?: 'fa-solid fa-star' }}"></i></div>
                        <h5 class="ce-act-title">{{ $act->title }}</h5>
                        <p class="ce-act-text">{{ $act->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ EDUCATIONAL SECTION ═══ --}}
    <section class="ce-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <span class="ce-label">{{ $s('edu_label','For Schools & Colleges') }}</span>
                    <h2 class="ce-heading">{!! $s('edu_heading','Educational &amp;<br><em>Institutional Tours</em>') !!}</h2>
                    <div class="ce-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>
                    <p class="ce-body mb-4">{{ $s('edu_text','Mahua House welcomes school, college, and institutional groups for meaningful nature-based learning experiences. Adjoining the Samardha Reserved Forest, we provide a living classroom unlike any other.') }}</p>
                    <ul style="list-style:none;padding:0;margin:0 0 28px;">
                        @foreach(array_filter(array_map('trim', explode("\n", $s('edu_items',"Guided nature walks & forest education programs\nEco-awareness camps & environmental education\nHands-on farming & rural culture experiences\nDiscover the Samardha Reserved Forest ecosystem\nSafe, supervised activities in a managed environment")))) as $item)
                        <li style="display:flex;align-items:flex-start;gap:12px;padding:9px 0;border-bottom:1px solid rgba(3,54,49,.08);font-size:14px;color:rgba(3,54,49,.65);">
                            <i class="fa-solid fa-seedling" style="color:#DAA520;margin-top:3px;min-width:16px;"></i> {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                    @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="ce-btn ce-btn-primary"><i class="fa-brands fa-whatsapp"></i>{{ $s('edu_cta','Enquire for Group Tour') }}</a>@endif
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <div style="position:relative;border-radius:20px;overflow:hidden;height:460px;">
                        <img src="{{ $iUrl($s('edu_image'),'assets/images/about/14.jpeg') }}" alt="Educational Tour" style="width:100%;height:100%;object-fit:cover;">
                        <div style="position:absolute;top:20px;left:20px;">
                            <span style="background:#DAA520;color:#033631;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;padding:6px 16px;border-radius:100px;">{{ $s('edu_badge','Schools & Colleges Welcome') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ FILM SHOOTS SECTION ═══ --}}
    <section class="ce-section ce-section-dark">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay=".2s">
                    <div style="position:relative;border-radius:20px;overflow:hidden;height:460px;">
                        <img src="{{ $iUrl($s('film_image'),'assets/images/about/18.jpeg') }}" alt="Film Shoot at Mahua House" style="width:100%;height:100%;object-fit:cover;">
                        <div style="position:absolute;top:20px;right:20px;">
                            <span style="background:#DAA520;color:#033631;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;padding:6px 16px;border-radius:100px;">{{ $s('film_badge','Media Friendly') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
                    <span class="ce-label ce-label-light">{{ $s('film_label','Media & Productions') }}</span>
                    <h2 class="ce-heading ce-heading-light">{!! $s('film_heading','Film &amp; Media<br><em>Shoots</em>') !!}</h2>
                    <div class="ce-divider"><span></span><i class="fa-solid fa-video"></i><span></span></div>
                    <p class="ce-body ce-body-light mb-4">{{ $s('film_text',"Mahua House offers one of Bhopal's most striking natural shoot locations — the living forest of Samardha Reserve as your backdrop. No artificial sets, no filters — just authentic forest beauty.") }}</p>
                    <div class="row g-3">
                        @foreach([
                            [$s('film_c1_icon','fa-solid fa-tv'),$s('film_c1_title','TV Commercials'),$s('film_c1_sub','Brand & product films')],
                            [$s('film_c2_icon','fa-solid fa-film'),$s('film_c2_title','Short Films'),$s('film_c2_sub','Indie & documentary films')],
                            [$s('film_c3_icon','fa-solid fa-music'),$s('film_c3_title','Music Videos'),$s('film_c3_sub','Cultural & folk productions')],
                            [$s('film_c4_icon','fa-solid fa-camera'),$s('film_c4_title','Photography'),$s('film_c4_sub','Pre-wedding & editorial')],
                        ] as [$icon,$title,$sub])
                        <div class="col-6">
                            <div style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:14px;padding:18px 16px;">
                                <i class="{{ $icon }}" style="color:#DAA520;font-size:20px;margin-bottom:10px;display:block;"></i>
                                <p style="font-size:14px;font-weight:600;color:#fff;margin:0 0 4px;">{{ $title }}</p>
                                <p style="font-size:12px;color:rgba(255,255,255,.45);margin:0;">{{ $sub }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top:30px;">
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="ce-btn ce-btn-gold"><i class="fa-brands fa-whatsapp"></i>{{ $s('film_cta','Enquire for Media Shoot') }}</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ ENQUIRY FORM ═══ --}}
    <section class="ce-section ce-section-alt" id="enquire">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="ce-label wow fadeInUp" data-wow-delay=".1s">{{ $s('form_label','Get In Touch') }}</span>
                    <h2 class="ce-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('form_heading','Plan Your Group <em>Experience</em>') !!}</h2>
                    <div class="ce-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    <p class="ce-body wow fadeInUp" data-wow-delay=".4s">{{ $s('form_text',"Fill in your details and we'll get back to you quickly with availability and a tailored proposal.") }}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10 wow fadeInUp" data-wow-delay=".3s">
                    <div class="ce-form-wrap">
                        @if(session('enquiry_success'))
                        <div class="ce-alert"><i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('enquiry.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="corporate">
                            <div class="row g-4">
                                <div class="col-md-4"><label class="ce-form-label">Full Name *</label><input type="text" name="name" class="ce-form-control" placeholder="Your name" value="{{ old('name') }}" required></div>
                                <div class="col-md-4"><label class="ce-form-label">Phone Number *</label><input type="tel" name="phone" class="ce-form-control" placeholder="+91 00000 00000" value="{{ old('phone') }}" required></div>
                                <div class="col-md-4"><label class="ce-form-label">Email Address</label><input type="email" name="email" class="ce-form-control" placeholder="your@email.com" value="{{ old('email') }}"></div>
                                <div class="col-md-4">
                                    <label class="ce-form-label">Group Type</label>
                                    <select name="room_type" class="ce-form-control" style="appearance:none;">
                                        <option value="">Select type</option>
                                        <option @selected(old('room_type')=='Corporate Retreat / Team Building')>Corporate Retreat / Team Building</option>
                                        <option @selected(old('room_type')=='Workshop / Meeting')>Workshop / Meeting</option>
                                        <option @selected(old('room_type')=='Educational / Institutional Tour')>Educational / Institutional Tour</option>
                                        <option @selected(old('room_type')=='Film / Media Shoot')>Film / Media Shoot</option>
                                        <option @selected(old('room_type')=='Club / Group Outing')>Club / Group Outing</option>
                                        <option @selected(old('room_type')=='Other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><label class="ce-form-label">Preferred Date</label><input type="date" name="check_in" class="ce-form-control" value="{{ old('check_in') }}"></div>
                                <div class="col-md-4">
                                    <label class="ce-form-label">Group Size</label>
                                    <select name="guests" class="ce-form-control" style="appearance:none;">
                                        <option value="">Select size</option>
                                        <option @selected(old('guests')=='10-20')>10 – 20 people</option>
                                        <option @selected(old('guests')=='21-50')>21 – 50 people</option>
                                        <option @selected(old('guests')=='51-100')>51 – 100 people</option>
                                        <option @selected(old('guests')=='100+')>100+ people</option>
                                    </select>
                                </div>
                                <div class="col-12"><label class="ce-form-label">Tell Us About Your Plan</label><textarea name="message" class="ce-form-control" rows="4" placeholder="Describe your group, event goals, special requirements..." style="resize:none;">{{ old('message') }}</textarea></div>
                                <div class="col-12"><button type="submit" class="ce-btn ce-btn-primary w-100" style="font-size:15px;border-radius:12px;padding:16px;"><i class="fa-solid fa-paper-plane me-2"></i>Send Group Enquiry</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="ce-section">
        <div class="container">
            <div class="ce-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="ce-label ce-label-light">{{ $s('cta_label',"Let's Plan Together") }}</span>
                    <h2 class="ce-heading ce-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading','Your Forest Group Experience is <em>One Call Away</em>') !!}</h2>
                    <p class="ce-body ce-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text','Contact us at Mahua House to plan your corporate retreat, educational tour, or film shoot.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($facebook)<a href="{{ $facebook }}" target="_blank" rel="noopener" class="ce-btn ce-btn-outline"><i class="fa-brands fa-facebook-f"></i>Facebook</a>@endif
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/','',$whatsapp) }}" target="_blank" rel="noopener" class="ce-btn ce-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp</a>@endif
                        <a href="{{ route('contact') }}" class="ce-btn ce-btn-outline">Enquire Today</a>
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/','',$phone) }}" class="ce-btn ce-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

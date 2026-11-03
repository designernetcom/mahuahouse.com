@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url, $fb='') => $url ? (Str::startsWith($url, ['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');

    $heroImage = $iUrl($s('hero_image'), 'assets/images/about/3.jpeg');
    $ctaBgImage = $iUrl($s('cta_bg_image'), 'assets/images/about/2.jpeg');

    // Human-readable labels for each category slug
    $catLabels = [
        'general'    => 'General',
        'property'   => 'Property',
        'nature'     => 'Nature & Forest',
        'rooms'      => 'Rooms & Stay',
        'events'     => 'Weddings & Events',
        'wedding'    => 'Weddings & Events',
        'weddings'   => 'Weddings & Events',
        'activities' => 'Activities',
        'dining'     => 'Dining',
        'corporate'  => 'Corporate Events',
        'spaces'     => 'Spaces & Venues',
        'day-out'    => 'Day Out',
        'educational'=> 'Educational Tours',
    ];

    // Parse stats: "num|label" one per line
    $parseStats = fn($raw) => collect(array_filter(array_map('trim', explode("\n", $raw))))->map(function($row) {
        [$num, $lbl] = array_pad(explode('|', $row, 2), 2, '');
        return compact('num', 'lbl');
    });
    $stats = $parseStats($s('stats_strip', "3.5|Acres of Forest\n4|Named Venues\n3|Room Types\nMP|Tourism Accredited"));
@endphp

@section('title', $s('meta_title', 'Gallery | Mahua House'))
@section('meta_description', $s('meta_description', 'Explore the Mahua House photo gallery — forests, events, rooms, weddings, activities and more from our eco retreat near Bhopal.'))
@section('meta_keywords', $s('meta_keywords', 'Mahua House Gallery, Forest Resort Photos, Bhopal Eco Resort, Wedding Venue Photos'))

@section('styles')
<style>
    .gl-section{padding:90px 0}.gl-section-cream{background:#faf8f3}
    .gl-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}
    .gl-label-light{color:rgba(218,165,32,.9)}
    .gl-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}
    .gl-heading-light{color:#fff}.gl-heading em{font-style:normal;color:#DAA520}
    .gl-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}
    .gl-divider.centered{justify-content:center}.gl-divider span{display:block;width:60px;height:1px;background:#DAA520}.gl-divider i{font-size:9px}
    .gl-body{font-size:15px;color:rgba(3,54,49,.6);line-height:1.85;margin-bottom:0}.gl-body-light{color:rgba(255,255,255,.65)}
    .gl-btn{display:inline-flex;align-items:center;gap:8px;padding:13px 32px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent;cursor:pointer}
    .gl-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.gl-btn-gold:hover{background:transparent;color:#DAA520}
    .gl-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.5)}.gl-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .gl-hero{position:relative;height:560px;background:url('{{ $heroImage }}') center/cover no-repeat;display:flex;align-items:flex-end;overflow:hidden}
    .gl-hero::before{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(3,54,49,.2),rgba(3,54,49,.85))}
    .gl-hero-content{position:relative;z-index:2;padding-bottom:90px;width:100%}
    .gl-breadcrumb{list-style:none;padding:0;margin:0 0 14px;display:flex;align-items:center;gap:8px}
    .gl-breadcrumb li{font-size:13px;color:rgba(255,255,255,.5)}.gl-breadcrumb li a{color:#DAA520;text-decoration:none}.gl-breadcrumb li+li::before{content:'/';margin-right:8px}
    .gl-hero h1{font-size:clamp(36px,5vw,68px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:18px}
    .gl-hero h1 em{font-style:italic;color:#DAA520}.gl-hero p{font-size:16px;color:rgba(255,255,255,.75);max-width:500px;line-height:1.75;margin-bottom:0}
    .gl-hero-shape{position:absolute;bottom:0;left:0;right:0;z-index:2;line-height:0}.gl-hero-shape img{width:100%}
    .gl-stats-strip{background:#033631;padding:50px 0}
    .gl-stat-item{text-align:center}.gl-stat-num{font-size:42px;font-weight:800;color:#DAA520;line-height:1;margin-bottom:8px}
    .gl-stat-label{font-size:13px;color:rgba(255,255,255,.65);letter-spacing:1px;text-transform:uppercase}
    .gl-filter-tabs{display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:50px}
    .gl-filter-tab{padding:10px 24px;border-radius:100px;font-size:13px;font-weight:600;cursor:pointer;border:1.5px solid rgba(3,54,49,.2);background:transparent;color:rgba(3,54,49,.65);transition:all .25s ease}
    .gl-filter-tab:hover,.gl-filter-tab.active{background:#033631;color:#fff;border-color:#033631}
    .gl-grid{columns:4;column-gap:14px}
    .gl-item{break-inside:avoid;margin-bottom:14px;display:block;position:relative;overflow:hidden;border-radius:10px;cursor:pointer}
    .gl-item img{width:100%;display:block;transition:transform .45s ease}.gl-item:hover img{transform:scale(1.06)}
    .gl-item-overlay{position:absolute;inset:0;background:rgba(3,54,49,.55);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .3s}
    .gl-item:hover .gl-item-overlay{opacity:1}.gl-item-overlay i{font-size:26px;color:#fff}
    .gl-item.hidden{display:none}
    .gl-cta-box{background:linear-gradient(135deg,#033631,#045e55);border-radius:24px;padding:70px 40px;text-align:center;position:relative;overflow:hidden}
    .gl-cta-box::before{content:'';position:absolute;inset:0;background:url('{{ $ctaBgImage }}') center/cover no-repeat;opacity:.08}
    @media(max-width:1199px){.gl-grid{columns:3}}
    @media(max-width:767px){.gl-grid{columns:2}.gl-hero{height:460px}}
    @media(max-width:480px){.gl-grid{columns:1}}
</style>
@endsection

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="gl-hero">
        <div class="container gl-hero-content">
            <ul class="gl-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>{{ $s('breadcrumb', 'Gallery') }}</li>
            </ul>
            <span class="gl-label wow fadeInUp" data-wow-delay=".2s">{{ $s('hero_label', 'Visual Journey') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $s('hero_heading', 'Mahua House<br><em>Through the Lens</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $s('hero_text', 'Forests, celebrations, moments of stillness — every photograph is a window into life at Mahua House.') }}</p>
        </div>
        <div class="gl-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    {{-- ═══ STATS STRIP ═══ --}}
    <div class="gl-stats-strip">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach($stats as $i => $stat)
                <div class="col-6 col-md-3">
                    <div class="gl-stat-item wow fadeInUp" data-wow-delay="{{ number_format(.1 + $i * .1, 1) }}s">
                        <div class="gl-stat-num">{{ $stat['num'] }}</div>
                        <div class="gl-stat-label">{{ $stat['lbl'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ GALLERY ═══ --}}
    <section class="gl-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="gl-label wow fadeInUp" data-wow-delay=".1s">{{ $s('gallery_label', 'Our Collection') }}</span>
                    <h2 class="gl-heading wow fadeInUp" data-wow-delay=".2s">{!! $s('gallery_heading', 'Explore <em>Mahua House</em>') !!}</h2>
                    <div class="gl-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-camera"></i><span></span></div>
                    <p class="gl-body wow fadeInUp" data-wow-delay=".4s">{{ $s('gallery_text', 'Filter by category to explore weddings and events, forest nature, our rooms and cottages, or activities and experiences.') }}</p>
                </div>
            </div>

            {{-- Filter Tabs — built from DB categories --}}
            @php
                $useDbItems = $galleryItems->isNotEmpty();
                $dbCategories = $galleryItems->pluck('category')->unique()->filter()->values();
            @endphp

            <div class="gl-filter-tabs wow fadeInUp" data-wow-delay=".2s">
                <button class="gl-filter-tab active" data-filter="all">All Photos</button>
                @if($useDbItems)
                    @foreach($dbCategories as $cat)
                    <button class="gl-filter-tab" data-filter="{{ $cat }}">
                        {{ $catLabels[$cat] ?? ucwords(str_replace(['-','_'], ' ', $cat)) }}
                    </button>
                    @endforeach
                @else
                    <button class="gl-filter-tab" data-filter="weddings">Weddings &amp; Events</button>
                    <button class="gl-filter-tab" data-filter="nature">Nature &amp; Forest</button>
                    <button class="gl-filter-tab" data-filter="rooms">Rooms &amp; Stay</button>
                    <button class="gl-filter-tab" data-filter="activities">Activities</button>
                    <button class="gl-filter-tab" data-filter="dining">Dining</button>
                @endif
            </div>

            {{-- Masonry Grid --}}
            <div class="gl-grid" id="gl-masonry">
                @if($useDbItems)
                    @foreach($galleryItems as $item)
                    <a class="gl-item mfp-image" data-category="{{ $item->category }}" href="{{ $item->image_url }}">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title ?: 'Mahua House' }}" loading="lazy">
                        <div class="gl-item-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                    </a>
                    @endforeach
                @else
                    {{-- Fallback hardcoded images when DB is empty --}}
                    @php
                    $fallback = [
                        ['cat'=>'weddings','files'=>[1,2,6,7,8,9,40,41],'label'=>['Celebration','Event','Wedding Venue','Celebration','Event Setup','Forest Wedding','Event','Corporate Event']],
                        ['cat'=>'nature',  'files'=>[3,4,5,10,11,12,60,61],'label'=>['Samardha Forest','Forest','Green Woodland','Nature','Forest Path','Woodland View','Forest Landscape','Nature Walk']],
                        ['cat'=>'rooms',   'files'=>[13,14,15,16,17,18,19,20],'label'=>['Room','Cottage Interior','Forest Cottage','Room View','Deluxe AC Room','Cottage','Stay','Forest Room']],
                        ['cat'=>'activities','files'=>[21,22,23,24,25,26,27,28],'label'=>['Swimming Pool','Rain Dance','Activities','Forest Trek','Bonfire','Camping','Sports Zone','Outdoor Activities']],
                        ['cat'=>'dining',  'files'=>[29,30,31,32,33],'label'=>['Dining','Traditional Meals','Restaurant','Dining Experience','Forest Dining']],
                    ];
                    @endphp
                    @foreach($fallback as $group)
                        @foreach($group['files'] as $k => $n)
                        <a class="gl-item mfp-image" data-category="{{ $group['cat'] }}" href="{{ asset('assets/images/about/'.$n.'.jpeg') }}">
                            <img src="{{ asset('assets/images/about/'.$n.'.jpeg') }}" alt="{{ $group['label'][$k] ?? 'Mahua House' }}" loading="lazy">
                            <div class="gl-item-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
                        </a>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    @php
        $phone    = $settings['phone_primary']   ?? '+91 9425651754';
        $whatsapp = $settings['whatsapp_number'] ?? '919425651754';
        $facebook = $settings['facebook_url']    ?? 'https://www.facebook.com/mahuahouse';
    @endphp
    <section class="gl-section gl-section-cream">
        <div class="container">
            <div class="gl-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="gl-label gl-label-light">{{ $s('cta_label', 'Come and See for Yourself') }}</span>
                    <h2 class="gl-heading gl-heading-light" style="margin-bottom:14px;">{!! $s('cta_heading', 'Experience Mahua House <em>in Person</em>') !!}</h2>
                    <p class="gl-body gl-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $s('cta_text', 'Every photograph only hints at what it feels like to be here. Book your stay or event and let the forest do the rest.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @if($facebook)<a href="{{ $facebook }}" target="_blank" rel="noopener" class="gl-btn gl-btn-outline"><i class="fa-brands fa-facebook-f"></i>Visit Facebook</a>@endif
                        @if($whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/', '', $whatsapp) }}" target="_blank" rel="noopener" class="gl-btn gl-btn-gold"><i class="fa-brands fa-whatsapp"></i>WhatsApp Enquiry</a>@endif
                        <a href="{{ route('contact') }}" class="gl-btn gl-btn-outline">Enquire Today</a>
                        @if($phone)<a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="gl-btn gl-btn-outline"><i class="fa-solid fa-phone"></i>Call Now</a>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.gl-filter-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.gl-filter-tab').forEach(function(t) { t.classList.remove('active'); });
        this.classList.add('active');
        var filter = this.dataset.filter;
        document.querySelectorAll('.gl-item').forEach(function(item) {
            if (filter === 'all' || item.dataset.category === filter) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
        // Re-init magnific popup for visible items
        initPopup();
    });
});

function initPopup() {
    if (typeof $.fn.magnificPopup !== 'undefined') {
        $('.gl-item.mfp-image:not(.hidden)').magnificPopup({
            type: 'image',
            gallery: { enabled: true },
            delegate: false
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ !== 'undefined' && typeof $.fn.magnificPopup !== 'undefined') {
        $(document).on('click', '.gl-item.mfp-image:not(.hidden)', function(e) {
            e.preventDefault();
            var visibleItems = $('.gl-item.mfp-image:not(.hidden)');
            var index = visibleItems.index(this);
            $.magnificPopup.open({
                items: visibleItems.map(function() {
                    return { src: $(this).attr('href'), type: 'image' };
                }).get(),
                gallery: { enabled: true },
                type: 'image',
                index: index
            });
        });
    }
});
</script>
@endsection

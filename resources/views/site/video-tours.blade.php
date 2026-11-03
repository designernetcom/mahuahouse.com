@extends('layouts.app')

@php
    $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
    $section = fn ($key, $default = '') => $sections[$key] ?? $setting('video_tours_' . $key, $default);
    $videoId = function ($url) {
        $url = trim((string) $url);
        if (preg_match('/^[A-Za-z0-9_-]{6,}$/', $url) && !str_contains($url, '/')) return $url;
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]+)/', $url, $m)) return $m[1];
        parse_str(parse_url($url, PHP_URL_QUERY) ?: '', $query);
        return $query['v'] ?? '';
    };
    $imageUrl = function ($url, $fallback = '') {
        $url = $url ?: $fallback;
        if (!$url) return '';
        return \Illuminate\Support\Str::startsWith($url, ['http://', 'https://', '/']) ? $url : asset($url);
    };

    $videoItems = $videos->map(function ($video) use ($videoId) {
        $id = $videoId($video->link);
        return [
            'id' => $id,
            'title' => $video->title,
            'description' => $video->description,
            'tag' => $video->icon ?: 'Video Tour',
            'thumb' => $video->image_url ?: ($id ? "https://img.youtube.com/vi/{$id}/maxresdefault.jpg" : ''),
        ];
    })->filter(fn ($video) => $video['id'])->values();

    if ($videoItems->isEmpty()) {
        $videoItems = collect([
            ['id' => '7uSIYukB8Rc', 'title' => 'Discover Mahua House - The Nostalgic Woods', 'description' => 'A complete walkthrough of Mahua House, our forest retreat, rooms, venues, activities and dining.', 'tag' => 'Full Property Tour', 'thumb' => 'https://img.youtube.com/vi/7uSIYukB8Rc/maxresdefault.jpg'],
            ['id' => 'rwhINypv3iA', 'title' => 'Wedding Highlight at Mahua House', 'description' => 'A beautiful wedding highlight reel from Mahua House in a stunning forest setting.', 'tag' => 'Weddings', 'thumb' => 'https://img.youtube.com/vi/rwhINypv3iA/maxresdefault.jpg'],
            ['id' => 'WrXg_3Cut5I', 'title' => 'Cottage Stay at Mahua House', 'description' => 'Step inside our cosy cottages and rooms designed for comfort in the forest.', 'tag' => 'Accommodation', 'thumb' => 'https://img.youtube.com/vi/WrXg_3Cut5I/maxresdefault.jpg'],
        ]);
    }

    $featured = $videoItems->first();
    $youtubeUrl = $setting('youtube_url', $section('youtube_url', 'https://www.youtube.com/@mahuahouse'));
@endphp

@section('title', $section('meta_title', 'Video Tours | Mahua House'))
@section('meta_description', $section('meta_description', 'Watch video tours of Mahua House and explore rooms, event spaces, nature trails and dining.'))
@section('meta_keywords', $section('meta_keywords', 'Mahua House Video Tour, Forest Resort Bhopal Video, Eco Resort Walkthrough'))

@section('styles')
<style>
    .vt-section{padding:90px 0}.vt-section-cream{background:#faf8f3}.vt-label{display:inline-block;font-size:11px;font-weight:700;letter-spacing:4px;text-transform:uppercase;color:#DAA520;margin-bottom:12px}.vt-label-light{color:rgba(218,165,32,.9)}.vt-heading{font-size:clamp(28px,3.5vw,44px);font-weight:700;color:#033631;line-height:1.2;margin-bottom:14px}.vt-heading-light{color:#fff}.vt-heading em{font-style:italic;color:#DAA520}.vt-divider{display:flex;align-items:center;gap:12px;color:#DAA520;margin-bottom:22px}.vt-divider.centered{justify-content:center}.vt-divider span{display:block;width:60px;height:1px;background:#DAA520}.vt-body{font-size:15px;color:rgba(3,54,49,.62);line-height:1.85;margin-bottom:0}.vt-body-light{color:rgba(255,255,255,.68)}.vt-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 30px;border-radius:100px;font-size:14px;font-weight:700;text-decoration:none;transition:all .3s ease;border:2px solid transparent}.vt-btn-primary{background:#033631;color:#fff;border-color:#033631}.vt-btn-primary:hover{background:transparent;color:#033631}.vt-btn-gold{background:#DAA520;color:#033631;border-color:#DAA520}.vt-btn-gold:hover{background:transparent;color:#DAA520}.vt-btn-outline{background:transparent;color:#fff;border-color:rgba(255,255,255,.45)}.vt-btn-outline:hover{background:#DAA520;color:#033631;border-color:#DAA520}
    .vt-breadcrumb{list-style:none;padding:0;margin:0 0 20px;display:flex;gap:8px;align-items:center;font-size:13px;color:rgba(255,255,255,.65)}.vt-breadcrumb li+li:before{content:"/";margin-right:8px;opacity:.5}.vt-breadcrumb a{color:rgba(255,255,255,.8);text-decoration:none}.vt-hero{position:relative;min-height:560px;background:linear-gradient(135deg,rgba(3,54,49,.92),rgba(3,54,49,.6) 55%,rgba(0,0,0,.3)),var(--vt-hero) center/cover no-repeat;display:flex;align-items:center}.vt-hero-content{position:relative;z-index:2;color:#fff}.vt-hero h1{font-size:clamp(34px,5vw,60px);font-weight:800;line-height:1.1;margin-bottom:18px;color:#fff}.vt-hero p{font-size:16px;color:rgba(255,255,255,.78);max-width:560px;margin-bottom:32px}.vt-hero-shape{position:absolute;bottom:-1px;left:0;right:0;z-index:3;line-height:0}.vt-hero-shape img{width:100%}
    .vt-player-section{padding:80px 0 60px;background:#fff}.vt-player-wrap{display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start}.vt-main-player{border-radius:20px;overflow:hidden;box-shadow:0 12px 60px rgba(3,54,49,.18);background:#000}.vt-main-player-ratio{position:relative;padding-top:56.25%}.vt-main-player-ratio iframe{position:absolute;inset:0;width:100%;height:100%;border:0}.vt-main-player-info{padding:20px 24px 24px;background:#fff;border:1px solid rgba(3,54,49,.08);border-top:0}.vt-main-player-title{font-size:18px;font-weight:700;color:#033631;margin-bottom:6px}.vt-main-player-desc{font-size:14px;color:rgba(3,54,49,.6);margin:0}.vt-now-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(218,165,32,.15);color:#a07a00;border-radius:100px;padding:4px 12px;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:10px}
    .vt-playlist{background:#033631;border-radius:20px;overflow:hidden}.vt-playlist-header{padding:18px 20px;border-bottom:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:space-between}.vt-playlist-header h4{font-size:14px;font-weight:700;color:#fff;margin:0}.vt-playlist-header span{font-size:12px;color:rgba(255,255,255,.45)}.vt-playlist-scroll{max-height:480px;overflow-y:auto}.vt-pl-item{display:flex;align-items:center;gap:12px;padding:12px 16px;cursor:pointer;border-bottom:1px solid rgba(255,255,255,.05);position:relative}.vt-pl-item:hover,.vt-pl-item.active{background:rgba(218,165,32,.12)}.vt-pl-active-bar{position:absolute;left:0;top:0;bottom:0;width:3px;background:#DAA520;display:none}.vt-pl-item.active .vt-pl-active-bar{display:block}.vt-pl-thumb{position:relative;width:80px;height:52px;border-radius:8px;overflow:hidden;flex-shrink:0}.vt-pl-thumb img{width:100%;height:100%;object-fit:cover}.vt-pl-title{font-size:13px;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:4px;display:block}.vt-pl-item.active .vt-pl-title{color:#DAA520}.vt-pl-sub{font-size:11px;color:rgba(255,255,255,.45);display:block}.vt-pl-num{font-size:12px;color:rgba(255,255,255,.35);font-weight:700;flex-shrink:0;width:20px;text-align:right}
    .vt-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}.vt-vid-card{border-radius:18px;overflow:hidden;background:#fff;border:1px solid rgba(3,54,49,.08);box-shadow:0 4px 20px rgba(3,54,49,.07);transition:.35s;cursor:pointer}.vt-vid-card:hover{transform:translateY(-6px);box-shadow:0 16px 50px rgba(3,54,49,.14)}.vt-vid-card.active-card{border-color:#DAA520;box-shadow:0 8px 40px rgba(218,165,32,.25)}.vt-vid-thumb{position:relative;padding-top:56.25%;overflow:hidden}.vt-vid-thumb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}.vt-vid-play{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(3,54,49,.35)}.vt-vid-play-btn{width:56px;height:56px;border-radius:50%;background:#DAA520;color:#033631;display:flex;align-items:center;justify-content:center;font-size:18px;padding-left:4px}.vt-vid-num{position:absolute;top:12px;left:12px;background:rgba(3,54,49,.75);color:#DAA520;font-size:11px;font-weight:700;padding:4px 10px;border-radius:6px}.vt-vid-body{padding:18px 20px 22px}.vt-vid-tag{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#DAA520;margin-bottom:6px;display:block}.vt-vid-title{font-size:15px;font-weight:700;color:#033631;margin-bottom:8px;line-height:1.4}.vt-vid-desc{font-size:13px;color:rgba(3,54,49,.58);line-height:1.65;margin:0}
    .vt-yt-strip,.vt-cta-box{background:linear-gradient(135deg,#033631,#055a50);border-radius:24px;padding:60px 50px;position:relative;overflow:hidden}.vt-yt-strip{display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap}.vt-yt-strip-icon{font-size:52px;color:red}.vt-yt-strip-text{flex:1}.vt-yt-strip-text h3{font-size:24px;font-weight:700;color:#fff;margin-bottom:8px}.vt-yt-strip-text p{font-size:14px;color:rgba(255,255,255,.68);margin:0}.vt-cta-box{text-align:center}
    @media(max-width:991px){.vt-player-wrap{grid-template-columns:1fr}.vt-playlist{display:none}.vt-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:767px){.vt-grid{grid-template-columns:1fr}.vt-yt-strip{flex-direction:column;text-align:center;padding:36px 30px}.vt-cta-box{padding:50px 28px}}@media(max-width:575px){.vt-hero h1{font-size:32px}}
</style>
@endsection

@section('content')
    <section class="vt-hero" style="--vt-hero:url('{{ $imageUrl($section('hero_image', 'assets/images/video/video-1.jpg')) }}');">
        <div class="container vt-hero-content">
            <ul class="vt-breadcrumb wow fadeInUp" data-wow-delay=".1s"><li><a href="{{ route('home') }}">Home</a></li><li>{{ $section('breadcrumb', 'Video Tours') }}</li></ul>
            <span class="vt-label wow fadeInUp" data-wow-delay=".2s">{{ $section('hero_label', 'See it Before You Visit') }}</span>
            <h1 class="wow fadeInUp" data-wow-delay=".3s">{!! $section('hero_heading', 'Tour Mahua House<br><em>From Your Screen</em>') !!}</h1>
            <p class="wow fadeInUp" data-wow-delay=".4s">{{ $section('hero_text', 'Walk through our forest rooms, event spaces, nature trails and dining before you arrive.') }}</p>
            <div class="d-flex flex-wrap gap-3 wow fadeInUp" data-wow-delay=".45s">
                <a href="#player" class="vt-btn vt-btn-gold"><i class="fa-solid fa-play"></i> Watch Tours</a>
                <a href="{{ route('booking') }}" class="vt-btn vt-btn-outline">Book a Visit</a>
            </div>
        </div>
        <div class="vt-hero-shape"><img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape"></div>
    </section>

    <section class="vt-player-section" id="player">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <span class="vt-label wow fadeInUp" data-wow-delay=".1s">{{ $section('featured_label', 'Now Playing') }}</span>
                    <h2 class="vt-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('featured_heading', 'Featured <em>Video Tour</em>') !!}</h2>
                    <div class="vt-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-play"></i><span></span></div>
                </div>
            </div>

            <div class="vt-player-wrap wow fadeInUp" data-wow-delay=".2s">
                <div>
                    <div class="vt-main-player">
                        <div class="vt-main-player-ratio">
                            <iframe id="vt-featured-iframe" src="https://www.youtube.com/embed/{{ $featured['id'] }}?rel=0&modestbranding=1" title="{{ $featured['title'] }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <div class="vt-main-player-info">
                            <div class="vt-now-badge"><i class="fa-solid fa-circle"></i> Now Playing</div>
                            <h3 class="vt-main-player-title" id="vt-featured-title">{{ $featured['title'] }}</h3>
                            <p class="vt-main-player-desc" id="vt-featured-desc">{{ $featured['description'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="vt-playlist">
                    <div class="vt-playlist-header"><h4><i class="fa-solid fa-list" style="color:#DAA520;margin-right:8px;"></i> All Videos</h4><span>{{ $videoItems->count() }} videos</span></div>
                    <div class="vt-playlist-scroll">
                        @foreach($videoItems as $video)
                            <div class="vt-pl-item {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}" data-video-id="{{ $video['id'] }}" data-title="{{ e($video['title']) }}" data-desc="{{ e($video['description']) }}">
                                <div class="vt-pl-active-bar"></div>
                                <div class="vt-pl-thumb"><img src="{{ $video['thumb'] }}" onerror="this.src='https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg'" alt="{{ $video['title'] }}"></div>
                                <div class="vt-pl-info"><span class="vt-pl-title">{{ $video['title'] }}</span><span class="vt-pl-sub">{{ $video['tag'] }}</span></div>
                                <span class="vt-pl-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vt-section vt-section-cream" id="all-videos">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-7 text-center">
                    <span class="vt-label wow fadeInUp" data-wow-delay=".1s">{{ $section('grid_label', 'All Tours') }}</span>
                    <h2 class="vt-heading wow fadeInUp" data-wow-delay=".2s">{!! $section('grid_heading', 'Browse <em>Every Video</em>') !!}</h2>
                    <div class="vt-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-brands fa-youtube"></i><span></span></div>
                    <p class="vt-body wow fadeInUp" data-wow-delay=".35s">{{ $section('grid_text', 'Click any video to load it in the featured player above.') }}</p>
                </div>
            </div>

            <div class="vt-grid">
                @foreach($videoItems as $video)
                    <div class="vt-vid-card {{ $loop->first ? 'active-card' : '' }} wow fadeInUp" data-index="{{ $loop->index }}" data-video-id="{{ $video['id'] }}" data-title="{{ e($video['title']) }}" data-desc="{{ e($video['description']) }}">
                        <div class="vt-vid-thumb">
                            <img src="{{ $video['thumb'] }}" onerror="this.src='https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg'" alt="{{ $video['title'] }}">
                            <div class="vt-vid-play"><div class="vt-vid-play-btn"><i class="fa-solid fa-play"></i></div></div>
                            <span class="vt-vid-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="vt-vid-body"><span class="vt-vid-tag">{{ $video['tag'] }}</span><h4 class="vt-vid-title">{{ $video['title'] }}</h4><p class="vt-vid-desc">{{ $video['description'] }}</p></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="vt-section">
        <div class="container">
            <div class="vt-yt-strip wow fadeInUp" data-wow-delay=".2s">
                <div class="vt-yt-strip-icon"><i class="fa-brands fa-youtube"></i></div>
                <div class="vt-yt-strip-text"><h3>{{ $section('youtube_heading', 'Subscribe to Our YouTube Channel') }}</h3><p>{{ $section('youtube_text', 'New videos, forest diaries, guest experiences and seasonal highlights from Mahua House.') }}</p></div>
                @if($youtubeUrl)<a href="{{ $youtubeUrl }}" target="_blank" rel="noopener" class="vt-btn vt-btn-gold"><i class="fa-brands fa-youtube"></i> Subscribe on YouTube</a>@endif
            </div>
        </div>
    </section>

    <section class="vt-section">
        <div class="container">
            <div class="vt-cta-box wow fadeInUp" data-wow-delay=".2s">
                <div style="position:relative;z-index:1;">
                    <span class="vt-label vt-label-light">{{ $section('cta_label', 'Ready to Experience It in Person?') }}</span>
                    <h2 class="vt-heading vt-heading-light" style="margin-bottom:14px;">{!! $section('cta_heading', "The Screen Can't Do It <em>Justice</em>") !!}</h2>
                    <p class="vt-body vt-body-light" style="max-width:520px;margin:0 auto 36px;">{{ $section('cta_text', 'The videos give you a glimpse, but Mahua House is best experienced in person.') }}</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center"><a href="{{ route('stay') }}" class="vt-btn vt-btn-gold">Book a Stay</a><a href="{{ route('day-out-plan') }}" class="vt-btn vt-btn-outline">Day Out Plan</a><a href="{{ route('contact') }}" class="vt-btn vt-btn-outline">Contact Us</a></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function play(el, shouldScroll) {
        var id = el.dataset.videoId;
        var title = el.dataset.title || '';
        var desc = el.dataset.desc || '';
        var index = Number(el.dataset.index || 0);
        document.getElementById('vt-featured-iframe').src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0&modestbranding=1';
        document.getElementById('vt-featured-title').textContent = title;
        document.getElementById('vt-featured-desc').textContent = desc;
        document.querySelectorAll('.vt-pl-item').forEach(function (item) { item.classList.toggle('active', Number(item.dataset.index) === index); });
        document.querySelectorAll('.vt-vid-card').forEach(function (card) { card.classList.toggle('active-card', Number(card.dataset.index) === index); });
        if (shouldScroll) {
            var player = document.getElementById('player');
            window.scrollTo({ top: player.getBoundingClientRect().top + window.pageYOffset - 100, behavior: 'smooth' });
        }
    }
    document.querySelectorAll('.vt-pl-item').forEach(function (item) { item.addEventListener('click', function () { play(item, false); }); });
    document.querySelectorAll('.vt-vid-card').forEach(function (card) { card.addEventListener('click', function () { play(card, true); }); });
});
</script>
@endsection

@extends('layouts.app')

@php
    $s    = fn($key, $default='') => $sections[$key] ?? $default;
    $iUrl = fn($url, $fb='') => $url ? (Str::startsWith($url, ['http://','https://','/']) ? $url : asset($url)) : ($fb ? asset($fb) : '');

    $defaultFacilities = [
        ['title'=>'Safety & Security',        'icon'=>'assets/images/facilities/icon-facilities-1.png', 'items'=>"CCTV Surveillance\nDedicated Security Staff\nPower Backup (Generator/Inverter)\nSafe & Managed Environment"],
        ['title'=>'Sports & Activities',      'icon'=>'assets/images/facilities/icon-facilities-2.png', 'items'=>"Swimming Pool\nRain Dance with Sound System\nBadminton, Basketball, Volleyball\nCricket, Table Tennis, Chess"],
        ['title'=>'Outdoor Experiences',      'icon'=>'assets/images/facilities/icon-facilities-3.png', 'items'=>"Jungle Trekking\nBonfire\nCamping Tents\nHammocks & Nature Relaxation"],
        ['title'=>'Event Support (Chargeable)','icon'=>'assets/images/facilities/icon-facilities-4.png','items'=>"Event Management Support\nStage & Decoration\nDJ, Sound & Projector\nCustomised Decorated Stage"],
        ['title'=>'Food & Dining',            'icon'=>'assets/images/facilities/icon-facilities-5.png', 'items'=>"Traditional & Local Cuisine\nMulti-Cuisine Buffet\nCustomised Menus\n₹1,000/Head (All-Inclusive)"],
        ['title'=>'Parking & Transport',      'icon'=>'assets/images/facilities/icon-facilities-6.png', 'items'=>"Valet Parking (Chargeable)\nLarge Vehicle Parking\nRope Activity\nPlaying Cards & Board Games"],
    ];
@endphp

@section('title', $s('meta_title', 'Facilities | Mahua House'))
@section('meta_description', $s('meta_description', 'Explore all facilities at Mahua House — swimming pool, sports zone, outdoor experiences, dining, event support and more at our forest eco-resort in Bhopal.'))
@section('meta_keywords', $s('meta_keywords', 'Mahua House Facilities, Forest Resort Amenities Bhopal, Eco Resort Pool, Sports Activities Bhopal'))

@section('content')

    <!-- BREADCRUMB -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-wapper" data-img-src="{{ $iUrl($s('hero_image'), 'assets/images/breadcrumb/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-content">
                            <div class="breadcrumb-title wow fadeInUp" data-wow-delay=".2s">
                                <h1>{{ $s('page_title', 'Facilities') }}</h1>
                            </div>
                            <nav aria-label="breadcrumb" class="wow fadeInUp" data-wow-delay=".3s">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $s('breadcrumb', 'Facilities') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-shape-bottom">
                <figure>
                    <img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="breadcrumb shape bottom">
                </figure>
            </div>
        </div>
    </section>

    <!-- FACILITIES SECTION -->
    <section class="facilities-section-1 pt-100 md-pt-80 pb-100 md-pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center wow fadeInUp" data-wow-delay=".2s">
                        <span class="sub-title">{{ $s('section_label', 'Our Facilities') }}</span>
                        <h2>{{ $s('section_heading', 'Mahua House Facilities') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($facilities->isNotEmpty())
                    @foreach($facilities as $i => $facility)
                    @php
                        $items = array_filter(array_map('trim', explode("\n", $facility->description ?? '')));
                        $delay = number_format(0.3 + ($i * 0.1), 1);
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="facilities-item wow fadeInUp" data-wow-delay="{{ $delay }}s">
                            <div class="facilities-icon">
                                <figure>
                                    <img src="{{ $iUrl($facility->image_url, 'assets/images/facilities/icon-facilities-1.png') }}" alt="{{ $facility->title }}">
                                </figure>
                            </div>
                            <div class="facilities-content">
                                <h3 class="facilities-title line-anime">{{ $facility->title }}</h3>
                                @if($items)
                                <ul class="facilities-list">
                                    @foreach($items as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    {{-- Fallback to hardcoded defaults when no DB entries exist --}}
                    @foreach($defaultFacilities as $i => $facility)
                    @php $delay = number_format(0.3 + ($i * 0.1), 1); @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="facilities-item wow fadeInUp" data-wow-delay="{{ $delay }}s">
                            <div class="facilities-icon">
                                <figure>
                                    <img src="{{ asset($facility['icon']) }}" alt="{{ $facility['title'] }}">
                                </figure>
                            </div>
                            <div class="facilities-content">
                                <h3 class="facilities-title line-anime">{{ $facility['title'] }}</h3>
                                <ul class="facilities-list">
                                    @foreach(array_filter(array_map('trim', explode("\n", $facility['items']))) as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

@endsection

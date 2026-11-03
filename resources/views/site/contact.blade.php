@extends('layouts.app')

@section('title', 'Contact Us | Mahua House')
@section('meta_description', 'Get in touch with Mahua House — call, WhatsApp, email, or visit us near Bhopal. Find directions, office hours, and our contact form.')
@section('meta_keywords', 'Mahua House Contact, Bhopal Eco Resort Contact, Forest Resort Bhopal, Contact Mahua House')

@section('styles')
<style>
    .cu-section      { padding: 90px 0; }
    .cu-section-alt  { background: #E7EEEE; }
    .cu-section-dark { background: #033631; }
    .cu-section-cream{ background: #faf8f3; }
    .cu-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; color: #DAA520; margin-bottom: 12px; }
    .cu-label-light { color: rgba(218,165,32,0.9); }
    .cu-heading { font-size: clamp(28px, 3.5vw, 44px); font-weight: 700; color: #033631; line-height: 1.2; margin-bottom: 14px; }
    .cu-heading-light { color: #ffffff; }
    .cu-heading em { font-style: normal; color: #DAA520; }
    .cu-divider { display: flex; align-items: center; gap: 12px; color: #DAA520; margin-bottom: 22px; }
    .cu-divider.centered { justify-content: center; }
    .cu-divider span { display: block; width: 60px; height: 1px; background: #DAA520; }
    .cu-divider i { font-size: 9px; }
    .cu-body { font-size: 15px; color: rgba(3,54,49,0.6); line-height: 1.85; margin-bottom: 0; }
    .cu-body-light { color: rgba(255,255,255,0.62); }
    .cu-btn { display: inline-block; padding: 14px 34px; border-radius: 100px; font-size: 14px; font-weight: 700; letter-spacing: 0.5px; text-decoration: none; transition: all 0.3s ease; border: 2px solid transparent; cursor: pointer; }
    .cu-btn-primary { background:#033631; color:#fff; border-color:#033631; }
    .cu-btn-primary:hover { background:transparent; color:#033631; }
    .cu-btn-gold    { background:#DAA520; color:#033631; border-color:#DAA520; }
    .cu-btn-gold:hover { background:transparent; color:#DAA520; }
    .cu-btn-outline { background:transparent; color:#fff; border-color:rgba(255,255,255,0.5); }
    .cu-btn-outline:hover { background:#DAA520; color:#033631; border-color:#DAA520; }
    .cu-hero { position: relative; height: 520px; background: url('{{ asset("assets/images/about/2.jpeg") }}') center center / cover no-repeat; display: flex; align-items: flex-end; overflow: hidden; }
    .cu-hero::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(3,54,49,0.3) 0%, rgba(3,54,49,0.82) 100%); }
    .cu-hero-content { position: relative; z-index: 2; padding-bottom: 80px; width: 100%; }
    .cu-breadcrumb { list-style: none; padding: 0; margin: 0 0 14px; display: flex; align-items: center; gap: 8px; }
    .cu-breadcrumb li { font-size: 13px; color: rgba(255,255,255,0.55); }
    .cu-breadcrumb li a { color: #DAA520; text-decoration: none; }
    .cu-breadcrumb li + li::before { content: '/'; margin-right: 8px; }
    .cu-hero h1 { font-size: clamp(36px, 5vw, 68px); font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 16px; }
    .cu-hero h1 em { font-style: italic; color: #DAA520; }
    .cu-hero p { font-size: 16px; color: rgba(255,255,255,0.75); max-width: 500px; line-height: 1.75; margin-bottom: 0; }
    .cu-hero-shape { position: absolute; bottom: 0; left: 0; right: 0; z-index: 2; line-height: 0; }
    .cu-hero-shape img { width: 100%; }
    .cu-info-cards-wrap { margin-top: -60px; position: relative; z-index: 10; padding: 0; }
    .cu-info-card { background: #ffffff; border-radius: 18px; padding: 36px 28px; text-align: center; box-shadow: 0 8px 40px rgba(3,54,49,0.14); border-bottom: 4px solid transparent; transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease; height: 100%; }
    .cu-info-card:hover { transform: translateY(-6px); border-color: #DAA520; box-shadow: 0 20px 50px rgba(3,54,49,0.16); }
    .cu-info-card-icon { width: 68px; height: 68px; border-radius: 50%; background: rgba(3,54,49,0.07); border: 1px solid rgba(3,54,49,0.12); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; transition: background 0.35s ease, border-color 0.35s ease; }
    .cu-info-card-icon i { font-size: 26px; color: #033631; transition: color 0.35s ease; }
    .cu-info-card:hover .cu-info-card-icon { background: #033631; border-color: #033631; }
    .cu-info-card:hover .cu-info-card-icon i { color: #DAA520; }
    .cu-info-card h4 { font-size: 16px; font-weight: 700; color: #033631; margin-bottom: 8px; }
    .cu-info-card p, .cu-info-card a { font-size: 14px; color: rgba(3,54,49,0.55); line-height: 1.7; margin: 0; text-decoration: none; display: block; }
    .cu-info-card a:hover { color: #DAA520; }
    .cu-info-card .cu-info-tag { display: inline-block; margin-top: 12px; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #DAA520; }
    .cu-form-wrap { background: #fff; border-radius: 20px; padding: 48px 44px; box-shadow: 0 4px 30px rgba(3,54,49,0.08); border: 1px solid rgba(3,54,49,0.08); }
    .cu-form-title { font-size: 22px; font-weight: 700; color: #033631; margin-bottom: 6px; }
    .cu-form-sub { font-size: 14px; color: rgba(3,54,49,0.5); margin-bottom: 30px; line-height: 1.6; }
    .cu-form .form-group { margin-bottom: 18px; }
    .cu-form label { font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #033631; margin-bottom: 7px; display: block; }
    .cu-form .form-control { border: 1px solid rgba(3,54,49,0.15); border-radius: 10px; padding: 13px 18px; font-size: 14px; color: #033631; background: #fafafa; width: 100%; transition: border-color 0.3s, box-shadow 0.3s; }
    .cu-form .form-control:focus { border-color: #DAA520; background: #fff; box-shadow: 0 0 0 3px rgba(218,165,32,0.15); outline: none; }
    .cu-form textarea.form-control { resize: none; }
    .cu-form select.form-control { appearance: none; cursor: pointer; }
    .cu-subject-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
    .cu-subject-tabs label { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 500; letter-spacing: 0; color: rgba(3,54,49,0.65); text-transform: none; padding: 8px 16px; border-radius: 100px; border: 1px solid rgba(3,54,49,0.15); cursor: pointer; background: #fff; transition: all 0.25s ease; }
    .cu-subject-tabs input[type="radio"] { display: none; }
    .cu-subject-tabs input[type="radio"]:checked + label, .cu-subject-tabs label:hover { background: #033631; color: #fff; border-color: #033631; }
    .cu-sidebar-block { background: #033631; border-radius: 18px; padding: 36px 30px; margin-bottom: 20px; }
    .cu-sidebar-block:last-child { margin-bottom: 0; }
    .cu-sidebar-title { font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 20px; }
    .cu-contact-item { display: flex; align-items: flex-start; gap: 14px; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .cu-contact-item:last-child { border-bottom: none; padding-bottom: 0; }
    .cu-contact-item .ci-icon { width: 40px; height: 40px; min-width: 40px; border-radius: 10px; background: rgba(218,165,32,0.2); display: flex; align-items: center; justify-content: center; color: #DAA520; font-size: 15px; }
    .cu-contact-item .ci-info .ci-label { font-size: 11px; color: rgba(255,255,255,0.4); letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 3px; }
    .cu-contact-item .ci-info .ci-value { font-size: 14px; color: #fff; font-weight: 500; line-height: 1.5; }
    .cu-contact-item .ci-info a { color: #fff; text-decoration: none; }
    .cu-contact-item .ci-info a:hover { color: #DAA520; }
    .cu-hours-table { width: 100%; }
    .cu-hours-table tr { border-bottom: 1px solid rgba(255,255,255,0.08); }
    .cu-hours-table tr:last-child { border-bottom: none; }
    .cu-hours-table td { padding: 10px 0; font-size: 13px; color: rgba(255,255,255,0.6); }
    .cu-hours-table td:last-child { text-align: right; color: #fff; font-weight: 600; }
    .cu-hours-table tr.open td { color: #DAA520; }
    .cu-hours-table tr.open td:last-child { color: #DAA520; }
    .cu-social-row { display: flex; gap: 10px; margin-top: 20px; }
    .cu-social-row a { width: 38px; height: 38px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); font-size: 14px; text-decoration: none; transition: all 0.3s ease; }
    .cu-social-row a:hover { background: #DAA520; color: #033631; border-color: #DAA520; }
    .cu-map-section { background: #E7EEEE; padding: 0; }
    .cu-map-header { padding: 70px 0 40px; }
    .cu-map-frame { width: 100%; height: 460px; border: none; display: block; border-radius: 0; filter: grayscale(15%) contrast(1.05); }
    .cu-directions-card { background: #fff; border-radius: 16px; padding: 30px 26px; border: 1px solid rgba(3,54,49,0.08); box-shadow: 0 4px 20px rgba(3,54,49,0.06); height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .cu-directions-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(3,54,49,0.12); }
    .cu-dir-icon { width: 54px; height: 54px; border-radius: 14px; background: rgba(3,54,49,0.07); display: flex; align-items: center; justify-content: center; color: #033631; font-size: 22px; margin-bottom: 18px; transition: background 0.3s ease; }
    .cu-directions-card:hover .cu-dir-icon { background: #DAA520; color: #033631; }
    .cu-dir-title { font-size: 16px; font-weight: 700; color: #033631; margin-bottom: 10px; }
    .cu-dir-text { font-size: 13px; color: rgba(3,54,49,0.55); line-height: 1.75; margin: 0; }
    .cu-faq-item { border-bottom: 1px solid rgba(3,54,49,0.1); padding: 22px 0; }
    .cu-faq-item:first-child { border-top: 1px solid rgba(3,54,49,0.1); }
    .cu-faq-q { font-size: 16px; font-weight: 600; color: #033631; display: flex; justify-content: space-between; align-items: center; cursor: pointer; gap: 16px; }
    .cu-faq-q i { color: #DAA520; font-size: 13px; flex-shrink: 0; transition: transform 0.3s ease; }
    .cu-faq-a { font-size: 14px; color: rgba(3,54,49,0.6); line-height: 1.8; margin: 14px 0 0; display: none; }
    .cu-faq-item.open .cu-faq-q i { transform: rotate(45deg); }
    .cu-faq-item.open .cu-faq-a { display: block; }
    .cu-cta-box { background: linear-gradient(135deg, #033631 0%, #07554D 100%); border-radius: 24px; padding: 70px 60px; text-align: center; position: relative; overflow: hidden; }
    .cu-cta-box::before { content: ''; position: absolute; top: -100px; right: -100px; width: 350px; height: 350px; border-radius: 50%; background: rgba(218,165,32,0.08); }
    .cu-cta-box::after { content: ''; position: absolute; bottom: -80px; left: -80px; width: 260px; height: 260px; border-radius: 50%; background: rgba(218,165,32,0.06); }
    @media (max-width: 991px) { .cu-hero { height: 440px; } .cu-section { padding: 70px 0; } .cu-form-wrap { padding: 32px 24px; } .cu-cta-box { padding: 50px 28px; } .cu-info-cards-wrap { margin-top: -40px; } }
    @media (max-width: 575px) { .cu-hero h1 { font-size: 32px; } .cu-info-cards-wrap { margin-top: 0; padding-top: 40px; } .cu-cta-box { padding: 40px 20px; } }
</style>
@endsection

@section('content')

        <!-- HERO -->
        <section class="cu-hero">
            <div class="container cu-hero-content">
                <ul class="cu-breadcrumb wow fadeInUp" data-wow-delay=".1s">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Contact Us</li>
                </ul>
                <span class="cu-label wow fadeInUp" data-wow-delay=".2s">We'd Love to Hear From You</span>
                <h1 class="wow fadeInUp" data-wow-delay=".3s" style="font-size: 30px;">
                    Get in <em>Touch</em> With Us
                </h1>
            </div>
            <div class="cu-hero-shape">
                <img src="{{ asset('assets/images/shape/shape-bottom-white.png') }}" alt="shape">
            </div>
        </section>

        <!-- INFO CARDS -->
        <div class="cu-info-cards-wrap">
            <div class="container">
                <div class="row g-4" id="cu-info-cards">

                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="cu-info-card">
                            <div class="cu-info-card-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <h4>Our Location</h4>
                            <p>Adjoining Samardha Reserved Forest Barrier, Haripura, Raisen Road, Bhopal – 462023</p>
                            <span class="cu-info-tag">Madhya Pradesh, India</span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="cu-info-card">
                            <div class="cu-info-card-icon"><i class="fa-solid fa-phone-volume"></i></div>
                            <h4>Call Us</h4>
                            <p style="font-size:12px;color:#DAA520;font-weight:600;margin:0 0 4px;">Sushma Kalambe</p>
                            <a href="tel:+919425651754">+91 94256 51754</a>
                            <span class="cu-info-tag">Daily 8am – 9pm</span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                        <div class="cu-info-card">
                            <div class="cu-info-card-icon"><i class="fa-solid fa-envelope"></i></div>
                            <h4>Email Us</h4>
                            <a href="mailto:mahuahouse17@gmail.com">mahuahouse17@gmail.com</a>
                            <a href="mailto:mahuahouse25@gmail.com" style="margin-top:4px;display:block;">mahuahouse25@gmail.com</a>
                            <span class="cu-info-tag">Reply within 24 hours</span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="cu-info-card">
                            <div class="cu-info-card-icon"><i class="fa-brands fa-whatsapp"></i></div>
                            <h4>WhatsApp</h4>
                            <a href="https://wa.me/919425651754" target="_blank" rel="noopener">+91 94256 51754</a>
                            <p style="margin-top:4px;">Quick replies for bookings &amp; enquiries</p>
                            <span class="cu-info-tag">Chat With Us</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- CONTACT FORM + SIDEBAR -->
        <section class="cu-section" style="padding-top: 70px;">
            <div class="container">
                <div class="row g-5">

                    <!-- LEFT: Form -->
                    <div class="col-lg-7 wow fadeInLeft" data-wow-delay=".2s">
                        <div class="cu-form-wrap">
                            <span class="cu-label">Send a Message</span>
                            <h2 class="cu-heading" style="font-size:28px;">How Can We <em>Help You?</em></h2>
                            <p class="cu-form-sub">Fill out the form below and our team will get back to you within 24 hours.</p>

                            <div style="margin-bottom:22px;">
                                <p style="font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:#033631;margin-bottom:10px;">I'm enquiring about</p>
                                <div class="cu-subject-tabs">
                                    <div>
                                        <input type="radio" name="subject" id="sub-stay" checked>
                                        <label for="sub-stay"><i class="fa-solid fa-bed"></i> Stay &amp; Rooms</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="subject" id="sub-wedding">
                                        <label for="sub-wedding"><i class="fa-solid fa-heart"></i> Destination Wedding</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="subject" id="sub-events">
                                        <label for="sub-events"><i class="fa-solid fa-calendar-days"></i> Events</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="subject" id="sub-other">
                                        <label for="sub-other"><i class="fa-solid fa-circle-info"></i> Other</label>
                                    </div>
                                </div>
                            </div>

                            @if(session('enquiry_success'))
                            <div style="background:rgba(25,135,84,.1);border:1px solid rgba(25,135,84,.3);border-radius:12px;padding:16px 20px;margin-bottom:24px;color:#146c43;font-weight:500;font-size:14px;">
                                <i class="fa-solid fa-circle-check me-2"></i>{{ session('enquiry_success') }}
                            </div>
                            @endif

                            <form class="cu-form" method="POST" action="{{ route('enquiry.store') }}">
                                @csrf
                                <input type="hidden" name="type" value="contact">
                                <input type="hidden" name="subject" id="selected_subject" value="Stay & Rooms">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name *</label>
                                            <input type="text" name="name" class="form-control" placeholder="Your full name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="email" name="email" class="form-control" placeholder="your@email.com" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="tel" name="phone" class="form-control" placeholder="+91 00000 00000" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Number of Guests</label>
                                            <select name="guests" class="form-control">
                                                <option value="" disabled selected>Select</option>
                                                <option {{ old('guests')=='1 – 2' ? 'selected':'' }}>1 – 2</option>
                                                <option {{ old('guests')=='3 – 5' ? 'selected':'' }}>3 – 5</option>
                                                <option {{ old('guests')=='6 – 10' ? 'selected':'' }}>6 – 10</option>
                                                <option {{ old('guests')=='11 – 25' ? 'selected':'' }}>11 – 25</option>
                                                <option {{ old('guests')=='25+' ? 'selected':'' }}>25+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Check-in Date</label>
                                            <input type="date" name="check_in" class="form-control" value="{{ old('check_in') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Check-out Date</label>
                                            <input type="date" name="check_out" class="form-control" value="{{ old('check_out') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Your Message</label>
                                            <textarea name="message" class="form-control" rows="5" placeholder="Tell us more about what you're looking for...">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="cu-btn cu-btn-primary w-100" style="font-size:15px;">
                                            <i class="fa-solid fa-paper-plane me-2"></i> Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- RIGHT: Sidebar -->
                    <div class="col-lg-5 wow fadeInRight" data-wow-delay=".3s">

                        <div class="cu-sidebar-block">
                            <h4 class="cu-sidebar-title"><i class="fa-solid fa-address-card me-2" style="color:#DAA520;"></i> Direct Contact</h4>
                            <div id="cu-sidebar-contact-items">
                                <div class="cu-contact-item">
                                    <div class="ci-icon"><i class="fa-solid fa-location-dot"></i></div>
                                    <div class="ci-info">
                                        <span class="ci-label">Address</span>
                                        <span class="ci-value">Adjoining Samardha Reserved Forest Barrier, Haripura, Raisen Road, Bhopal – 462023, MP</span>
                                    </div>
                                </div>
                                <div class="cu-contact-item">
                                    <div class="ci-icon"><i class="fa-solid fa-phone"></i></div>
                                    <div class="ci-info">
                                        <span class="ci-label">Phone</span>
                                        <a href="tel:+919425651754" class="ci-value">+91 94256 51754</a>
                                    </div>
                                </div>
                                <div class="cu-contact-item">
                                    <div class="ci-icon"><i class="fa-solid fa-envelope"></i></div>
                                    <div class="ci-info">
                                        <span class="ci-label">Email</span>
                                        <a href="mailto:mahuahouse17@gmail.com" class="ci-value">mahuahouse17@gmail.com</a>
                                    </div>
                                </div>
                                <div class="cu-contact-item">
                                    <div class="ci-icon"><i class="fa-brands fa-whatsapp"></i></div>
                                    <div class="ci-info">
                                        <span class="ci-label">WhatsApp</span>
                                        <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="ci-value">+91 94256 51754</a>
                                    </div>
                                </div>
                                <div class="cu-contact-item">
                                    <div class="ci-icon"><i class="fa-solid fa-globe"></i></div>
                                    <div class="ci-info">
                                        <span class="ci-label">Website</span>
                                        <a href="http://www.mahuahouse.com" target="_blank" rel="noopener" class="ci-value">www.mahuahouse.com</a>
                                    </div>
                                </div>
                                <div class="cu-social-row">
                                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                                    <a href="#" aria-label="Pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
                                    <a href="https://wa.me/919425651754" aria-label="WhatsApp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="cu-sidebar-block">
                            <h4 class="cu-sidebar-title"><i class="fa-solid fa-clock me-2" style="color:#DAA520;"></i> Office Hours</h4>
                            <table class="cu-hours-table">
                                <tr class="open">
                                    <td>Monday – Friday</td>
                                    <td>8:00 AM – 9:00 PM</td>
                                </tr>
                                <tr class="open">
                                    <td>Saturday</td>
                                    <td>8:00 AM – 9:00 PM</td>
                                </tr>
                                <tr class="open">
                                    <td>Sunday</td>
                                    <td>9:00 AM – 7:00 PM</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="color:rgba(255,255,255,0.35);font-size:12px;padding-top:14px;">
                                        <i class="fa-solid fa-circle-info me-1" style="color:#DAA520;"></i>
                                        On-site reception open 24 hours for staying guests.
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- MAP -->
        <div class="cu-map-section">
            <div class="cu-map-header">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7 text-center">
                            <span class="cu-label wow fadeInUp" data-wow-delay=".1s">Find Us</span>
                            <h2 class="cu-heading wow fadeInUp" data-wow-delay=".2s">We're in the <em>Heart of the Forest</em></h2>
                            <div class="cu-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-map-pin"></i><span></span></div>
                            <p class="cu-body wow fadeInUp" data-wow-delay=".4s">Mahua House is located on the Raisen Road, adjacent to the Samardha Reserved Forest, approximately 25 km from Bhopal city centre.</p>
                        </div>
                    </div>
                </div>
            </div>
            <iframe class="cu-map-frame"
                src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d58633.10842470832!2d77.53327302176538!3d23.29509543070656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sAdjoining%20Samardha%20Reserved%20Forest%20Barrier%2C%20Haripura%2C%20Raisen%20Bhopal-23!5e0!3m2!1sen!2sin!4v1772859169383!5m2!1sen!2sin"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                title="Mahua House Location Map"></iframe>
            <div style="text-align:center;padding:20px 0 10px;">
                <a href="https://maps.app.goo.gl/K2ag8CT2Nza4JZrb9?g_st=aw" target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:8px;background:#033631;color:#fff;font-size:14px;font-weight:700;padding:13px 30px;border-radius:100px;text-decoration:none;letter-spacing:0.5px;border:2px solid #033631;transition:all 0.3s ease;"
                   onmouseover="this.style.background='transparent';this.style.color='#033631';"
                   onmouseout="this.style.background='#033631';this.style.color='#fff';">
                    <i class="fa-solid fa-location-arrow"></i> Get Directions on Google Maps
                </a>
            </div>
        </div>

        <!-- HOW TO REACH -->
        <section class="cu-section cu-section-cream">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-7 text-center">
                        <span class="cu-label wow fadeInUp" data-wow-delay=".1s">Directions</span>
                        <h2 class="cu-heading wow fadeInUp" data-wow-delay=".2s">How to <em>Reach Us</em></h2>
                        <div class="cu-divider centered wow fadeInUp" data-wow-delay=".3s"><span></span><i class="fa-solid fa-diamond"></i><span></span></div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".2s">
                        <div class="cu-directions-card">
                            <div class="cu-dir-icon"><i class="fa-solid fa-car"></i></div>
                            <h5 class="cu-dir-title">By Car / Taxi</h5>
                            <p class="cu-dir-text">From Bhopal city take the Raisen Road (NH 146). After 22 km, turn left at Haripura village. Mahua House is 3 km into the forest lane. GPS: search "Mahua House Bhopal".</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                        <div class="cu-directions-card">
                            <div class="cu-dir-icon"><i class="fa-solid fa-train"></i></div>
                            <h5 class="cu-dir-title">By Train</h5>
                            <p class="cu-dir-text">Bhopal Junction (BPL) is the nearest railway station, ~28 km away. Pre-arrange a taxi or cab via OLA/Uber. Journey takes approximately 45 minutes from the station.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".4s">
                        <div class="cu-directions-card">
                            <div class="cu-dir-icon"><i class="fa-solid fa-plane-arrival"></i></div>
                            <h5 class="cu-dir-title">By Air</h5>
                            <p class="cu-dir-text">Raja Bhoj Airport (BHO) is approximately 35 km from Mahua House. Cabs are available at the airport. We can also arrange airport pickup — just let us know in advance.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".5s">
                        <div class="cu-directions-card">
                            <div class="cu-dir-icon"><i class="fa-solid fa-van-shuttle"></i></div>
                            <h5 class="cu-dir-title">Resort Pickup</h5>
                            <p class="cu-dir-text">We offer a complimentary shuttle from Bhopal railway station or airport for bookings of 3 nights or more. Contact us when booking to arrange your pickup time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="cu-section cu-section-alt">
            <div class="container">
                <div class="row align-items-start g-5">

                    <div class="col-lg-4 wow fadeInLeft" data-wow-delay=".2s">
                        <span class="cu-label">Quick Answers</span>
                        <h2 class="cu-heading">Frequently Asked <em>Questions</em></h2>
                        <div class="cu-divider"><span></span><i class="fa-solid fa-circle-question"></i><span></span></div>
                        <p class="cu-body">Can't find what you're looking for? Reach out directly — we're always happy to help.</p>
                        <a href="mailto:mahuahouse17@gmail.com" class="cu-btn cu-btn-primary" style="margin-top:24px;display:inline-block;">Email Us</a>
                    </div>

                    <div class="col-lg-8 wow fadeInRight" data-wow-delay=".3s" id="cu-faq-list">

                        @if($faqs->count())
                            @foreach($faqs as $loop_index => $faq)
                            <div class="cu-faq-item {{ $loop_index === 0 ? 'open' : '' }}">
                                <div class="cu-faq-q">
                                    {{ $faq->question }}
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                                <p class="cu-faq-a">{{ $faq->answer }}</p>
                            </div>
                            @endforeach
                        @else
                        <div class="cu-faq-item open">
                            <div class="cu-faq-q">
                                What are the check-in and check-out times?
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <p class="cu-faq-a">Standard check-in is 11:00 AM and check-out is 10:00 AM. Early check-in and late check-out can be arranged based on availability — just let us know in advance and we'll do our best to accommodate you.</p>
                        </div>
                        <div class="cu-faq-item">
                            <div class="cu-faq-q">
                                Is Mahua House suitable for families with children?
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <p class="cu-faq-a">Absolutely. Mahua House is a wonderful destination for families. Children love the nature trails, birdwatching, open lawns, and campfire evenings. We have family rooms available and can arrange child-safe activities on request.</p>
                        </div>
                        <div class="cu-faq-item">
                            <div class="cu-faq-q">
                                Do you offer vegetarian and vegan food options?
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <p class="cu-faq-a">Yes. Our kitchen caters to all dietary preferences including vegetarian, vegan, Jain, and gluten-free. Please inform us of any dietary requirements at the time of booking so we can prepare accordingly.</p>
                        </div>
                        <div class="cu-faq-item">
                            <div class="cu-faq-q">
                                What is the cancellation policy?
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <p class="cu-faq-a">Cancellations made 7 days or more before arrival receive a full refund. Cancellations within 7 days are subject to a 50% retention. No-shows are non-refundable. Special event bookings (weddings, large groups) have separate policies — please confirm at the time of booking.</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cu-section">
            <div class="container">
                <div class="cu-cta-box wow fadeInUp" data-wow-delay=".2s">
                    <div style="position:relative;z-index:1;">
                        <span class="cu-label cu-label-light">Ready to Visit?</span>
                        <h2 class="cu-heading cu-heading-light" style="margin-bottom:14px;">
                            The Forest Is <em>Waiting for You</em>
                        </h2>
                        <p class="cu-body cu-body-light" style="max-width:520px;margin:0 auto 36px;">
                            Book your stay, plan your wedding, or simply come visit and breathe some forest air. Mahua House welcomes you.
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="https://www.facebook.com/mahuahouse" target="_blank" rel="noopener" class="cu-btn cu-btn-outline"><i class="fa-brands fa-facebook-f" style="margin-right:7px;"></i>Visit Facebook</a>
                            <a href="https://maps.app.goo.gl/K2ag8CT2Nza4JZrb9" target="_blank" rel="noopener" class="cu-btn cu-btn-outline"><i class="fa-solid fa-star" style="margin-right:7px;"></i>Read Google Reviews</a>
                            <a href="mailto:mahuahouse17@gmail.com" class="cu-btn cu-btn-outline"><i class="fa-solid fa-envelope" style="margin-right:7px;"></i>Enquire Today</a>
                            <a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="cu-btn cu-btn-gold"><i class="fa-brands fa-whatsapp" style="margin-right:7px;"></i>WhatsApp or Call Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.cu-faq-q').forEach(function(q) {
    q.addEventListener('click', function() {
        var item = this.closest('.cu-faq-item');
        item.classList.toggle('open');
    });
});
document.querySelectorAll('.cu-subject-tabs input[type="radio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var label = document.querySelector('label[for="' + this.id + '"]');
        document.getElementById('selected_subject').value = label ? label.textContent.trim() : this.id;
    });
});
</script>
@endsection

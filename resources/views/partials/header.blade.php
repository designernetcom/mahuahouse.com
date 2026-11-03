    <!-- offcanvas sidebar -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvas-sidebar">
        <div class="offcanvas-header">
            <div class="offcanvas-logo">
                <figure><img src="{{ asset('assets/images/logo/Mahua-House.png') }}" alt="Mahua House logo"></figure>
            </div>
            <button type="button" class="offcanvas-close bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="mobile-menu"></div>
            <div class="offcanvas-contact">
                <div class="widget widget-contact">
                    <div class="widget-title"><h3 class="line-anime">Contact Info</h3></div>
                    <div class="widget-content">
                        <div class="offcanvas-cta-item">
                            <div class="offcanvas-cta-list">
                                <div class="offcanvas-cta-icon"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="offcanvas-cta-content"><p>Forest Barrier, Haripura, Raisen Bhopal-23</p></div>
                            </div>
                            <div class="offcanvas-cta-list">
                                <div class="offcanvas-cta-icon"><i class="fa-solid fa-envelope"></i></div>
                                <div class="offcanvas-cta-content"><a href="mailto:mahuahouse17@gmail.com">mahuahouse17@gmail.com</a></div>
                            </div>
                            <div class="offcanvas-cta-list">
                                <div class="offcanvas-cta-icon"><i class="fa-solid fa-phone-volume"></i></div>
                                <div class="offcanvas-cta-content"><a href="tel:+919425651754">+91 9425651754</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-button-wapper">
                <a href="{{ route('booking') }}" class="theme-button style-1">Book Now</a>
            </div>
            <div class="offcanvas-social">
                <div class="widget widget-social-media">
                    <div class="widget-content">
                        <ul class="social-icon">
                            <li><a href="#" aria-label="instagram"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="https://www.facebook.com/mahuahouse" aria-label="facebook" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="https://wa.me/919425651754" aria-label="whatsapp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas end -->

    <!-- ===== HEADER ===== -->
    <header class="header header-2">
        <div class="header-top d-none d-xl-block">
            <div class="container-fluid">
                <div class="row justify-content-center justify-content-lg-between align-items-center">
                    <div class="col-auto">
                        <div class="header-top-left">
                            <div class="header-contact-info">
                                <ul>
                                    <li><p><i class="fa-solid fa-location-dot"></i> Forest Barrier, Haripura, Raisen Bhopal-23</p></li>
                                    <li><p><i class="fa-solid fa-phone-volume"></i> +91 9425651754</p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-top-right">
                            <div class="header-social-icon">
                                <ul>
                                    <li><a href="#" aria-label="instagram"><i class="fa-brands fa-instagram"></i></a></li>
                                    <li><a href="https://www.facebook.com/mahuahouse" aria-label="facebook" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="https://wa.me/919425651754" aria-label="whatsapp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-lower">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-between g-0">
                    <div class="col-12">
                        <div class="header-content d-flex justify-content-between align-items-center">
                            <div class="header-left">
                                <div class="logo-box">
                                    <div class="logo">
                                        <a href="{{ route('home') }}">
                                            <figure><img src="{{ asset('assets/images/logo/Mahua-House-White-1.png') }}" alt="Mahua House"></figure>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="header-navigation d-flex align-items-center">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="menu-thumb"><a href="{{ route('home') }}">Home</a></li>
                                            <li>
                                                <a href="#">About <i class="fa-solid fa-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('about') }}">About Us</a></li>
                                                    <li><a href="{{ route('destination-wedding') }}">Destination Wedding</a></li>
                                                    <li><a href="{{ route('video-tours') }}">Video Tours</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('rooms') }}">Rooms</a></li>
                                            <li>
                                                <a href="#">Services <i class="fa-solid fa-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('events') }}">Events</a></li>
                                                    <li><a href="{{ route('corporate-events') }}">Corporate Retreats</a></li>
                                                    <li><a href="{{ route('educational-tours') }}">Educational Tours</a></li>
                                                    <li><a href="{{ route('film-shoots') }}">Film &amp; Media Shoots</a></li>
                                                    <li><a href="{{ route('accommodation') }}">Accommodation</a></li>
                                                    <li><a href="{{ route('food-dining') }}">Food &amp; Dining</a></li>
                                                    <li><a href="{{ route('stay') }}">Stay</a></li>
                                                    <li><a href="{{ route('spaces') }}">Spaces</a></li>
                                                    <li><a href="{{ route('day-out-plan') }}">Day Out Plan</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="header-right d-flex align-items-center gap-lg-4 gap-3">
                                <div class="header-sidebar">
                                    <a class="sidebar-toggler color-one" data-bs-toggle="offcanvas" href="#offcanvas-sidebar" role="button" aria-label="sidebar toggler" aria-controls="offcanvas-sidebar">
                                        <span></span><span></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ===== HEADER END ===== -->

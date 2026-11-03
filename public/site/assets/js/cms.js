
/**
 * Mahua House CMS Integration
 * Connects static HTML pages to the mahua-house-cms Laravel backend API.
 *
 * API base: /api  (when served via Laravel at port 8000)
 * Override: set window.CMS_API_BASE before this script loads.
 *
 * Strategy: each loader checks whether its target element exists, fetches data
 * from the API, and replaces static fallback content only if the API responds
 * with items. If the backend is unavailable the static HTML is preserved.
 */
(function () {
    'use strict';

    /* ── CONFIG ────────────────────────────────────────────────────────── */
    var API = window.CMS_API_BASE ||
        (window.location.port === '8000' ? '/api' : null);

    if (!API) return; // Not running through backend — static fallbacks remain.

    /* ── HELPERS ───────────────────────────────────────────────────────── */
    function get(endpoint) {
        return fetch(API + endpoint, { headers: { Accept: 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : Promise.reject(r.status); })
            .catch(function () { return null; });
    }

    function post(endpoint, data) {
        return fetch(API + endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
            body: JSON.stringify(data)
        }).then(function (r) { return r.json(); });
    }

    // Make a relative storage path absolute using the backend origin.
    function imgUrl(url) {
        if (!url) return '';
        if (/^https?:\/\//.test(url)) return url;
        return window.location.protocol + '//' + window.location.hostname +
            (window.location.port ? ':' + window.location.port : '') + url;
    }

    function stars(rating) {
        var html = '', n = Math.round(parseFloat(rating) || 5);
        for (var i = 1; i <= 5; i++) {
            html += i <= n
                ? '<i class="fa-solid fa-star"></i>'
                : '<i class="fa-regular fa-star"></i>';
        }
        return html;
    }

    function esc(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    /* ── HERO SLIDES (index.html) ──────────────────────────────────────── */
    function loadHero() {
        var heroEl = document.getElementById('hm-hero');
        if (!heroEl) return;

        get('/hero').then(function (slides) {
            if (!slides || !slides.length) return;

            // Remove existing static slides.
            heroEl.querySelectorAll('.hm-hero-slide').forEach(function (el) { el.remove(); });

            // Insert new slides before the first non-slide child.
            var anchor = heroEl.querySelector(
                '.container, .hm-hero-content, .hm-hero-scroll, .hm-hero-dots, .hm-hero-controls, .hm-hero-shape'
            );
            slides.forEach(function (s, i) {
                var div = document.createElement('div');
                div.className = 'hm-hero-slide' + (i === 0 ? ' active' : '');
                div.style.backgroundImage = "url('" + imgUrl(s.image_url) + "')";
                heroEl.insertBefore(div, anchor || null);
            });

            // Rebuild dots.
            var dotsEl = document.getElementById('hm-dots');
            if (dotsEl) {
                dotsEl.innerHTML = '';
                slides.forEach(function (s, i) {
                    var dot = document.createElement('div');
                    dot.className = 'hm-hero-dot' + (i === 0 ? ' active' : '');
                    dot.setAttribute('data-idx', i);
                    dotsEl.appendChild(dot);
                });
            }
        });
    }

    /* ── STATS BAR (index.html) ────────────────────────────────────────── */
    function loadStats() {
        var el = document.getElementById('hm-stats-inner');
        if (!el) return;

        get('/stats').then(function (stats) {
            if (!stats || !stats.length) return;
            var html = '';
            stats.forEach(function (s, i) {
                html += '<div class="col-auto wow fadeInUp" data-wow-delay=".' + (i + 1) + 's">' +
                    '<div class="hm-stat-item">' +
                    '<span class="num">' + esc(s.value) + '</span>' +
                    '<span class="lbl">' + esc(s.label) + '</span>' +
                    '</div></div>';
                if (i < stats.length - 1) {
                    html += '<div class="col-auto d-none d-md-block">' +
                        '<div class="hm-stat-divider" style="height:70px;"></div></div>';
                }
            });
            el.innerHTML = html;
        });
    }

    /* ── WHY CHOOSE (index.html) ───────────────────────────────────────── */
    function loadWhyChoose() {
        var el = document.getElementById('hm-why-grid');
        if (!el) return;

        get('/why-choose').then(function (items) {
            if (!items || !items.length) return;
            var html = '';
            items.forEach(function (item, i) {
                html += '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".' + (i + 1) + 's">' +
                    '<div class="hm-why-card">' +
                    '<div class="hm-why-icon"><i class="' + esc(item.icon || 'fa-solid fa-star') + '"></i></div>' +
                    '<h4 class="hm-why-title">' + esc(item.title) + '</h4>' +
                    '<p class="hm-why-text">' + esc(item.description) + '</p>' +
                    '</div></div>';
            });
            el.innerHTML = html;
        });
    }

    /* ── EXPERIENCES (index.html) ──────────────────────────────────────── */
    function loadExperiences() {
        var el = document.getElementById('hm-exp-grid');
        if (!el) return;

        get('/experiences').then(function (items) {
            if (!items || !items.length) return;
            var html = '';
            items.forEach(function (item, i) {
                var img = imgUrl(item.image_url) || 'assets/images/about/22.jpeg';
                html += '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".' + (i + 2) + 's">' +
                    '<div class="hm-exp-card">' +
                    '<img src="' + img + '" alt="' + esc(item.title) + '">' +
                    '<div class="hm-exp-overlay">' +
                    '<div class="hm-exp-icon"><i class="' + esc(item.icon || 'fa-solid fa-leaf') + '"></i></div>' +
                    '<h4 class="hm-exp-title">' + esc(item.title) + '</h4>' +
                    '<p class="hm-exp-desc">' + esc(item.description) + '</p>' +
                    '</div></div></div>';
            });
            el.innerHTML = html;
        });
    }

    /* ── ROOMS — card builders ─────────────────────────────────────────── */
    function buildHomeRoomCard(room) {
        var img = imgUrl(room.image_url) || 'assets/images/room/room-1.jpg';
        var amenities = (room.amenities || []).slice(0, 4).map(function (a) {
            return '<span class="hm-amenity"><i class="fa-solid fa-check"></i> ' + esc(a) + '</span>';
        }).join('');
        var badge = room.badge_text
            ? '<span class="hm-room-badge">' + esc(room.badge_text) + '</span>' : '';
        var price = room.price_per_night
            ? '<div class="hm-room-price-tag"><span class="from">From</span>' +
              '<span class="price">&#8377;' + Number(room.price_per_night).toLocaleString('en-IN') + '</span>' +
              '<span class="night">/ night</span></div>' : '';
        return '<div class="col-lg-4 col-md-6 wow fadeInUp">' +
            '<div class="hm-room-card">' +
            '<div class="hm-room-img"><img src="' + img + '" alt="' + esc(room.name) + '">' +
            badge + price + '</div>' +
            '<div class="hm-room-body">' +
            '<span class="hm-room-type">' + esc(room.room_type || '') + '</span>' +
            '<h3 class="hm-room-title">' + esc(room.name) + '</h3>' +
            '<p class="hm-room-desc">' + esc(room.description || '') + '</p>' +
            '<div class="hm-room-amenities">' + amenities + '</div>' +
            '<div class="hm-room-footer">' +
            '<span style="font-size:13px;color:rgba(3,54,49,0.5);">' +
            '<i class="fa-solid fa-user" style="color:#DAA520;margin-right:4px;"></i>' +
            (room.max_guests || 2) + ' Guests</span>' +
            '<a href="rooms.html" class="hm-btn hm-btn-primary" style="padding:9px 20px;font-size:13px;">Details</a>' +
            '</div></div></div></div>';
    }

    function buildRoomPageCard(room, idx) {
        var img = imgUrl(room.image_url) || ('assets/images/room/room-' + (idx + 1) + '.jpg');
        var amenities = (room.amenities || []).map(function (a) {
            return '<span class="rm-amenity-tag"><i class="fa-solid fa-check"></i> ' + esc(a) + '</span>';
        }).join('');
        var badgesHtml = room.badge_text
            ? '<div class="rm-card-badges"><span class="rm-badge rm-badge-gold">' +
              esc(room.badge_text) + '</span></div>' : '';
        var price = room.price_per_night
            ? '<div class="rm-card-price"><span class="from">from</span>' +
              '<span class="amount">&#8377;' + Number(room.price_per_night).toLocaleString('en-IN') + '</span>' +
              '<span class="night">/night</span></div>' : '';
        var cat = esc((room.room_type || '').toLowerCase().replace(/\s+/g, '-'));
        return '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".' + (idx + 2) + 's" data-category="' + cat + '">' +
            '<div class="rm-card">' +
            '<div class="rm-card-img"><img src="' + img + '" alt="' + esc(room.name) + '">' +
            badgesHtml + price + '</div>' +
            '<div class="rm-card-body">' +
            '<span class="rm-card-type">' + esc(room.room_type || '') + '</span>' +
            '<h4 class="rm-card-title">' + esc(room.name) + '</h4>' +
            '<p class="rm-card-desc">' + esc(room.description || '') + '</p>' +
            '<div class="rm-card-specs">' +
            '<span class="rm-spec"><i class="fa-solid fa-users"></i> ' + (room.max_guests || 2) + ' Guests</span>' +
            '<span class="rm-spec"><i class="fa-solid fa-clock"></i> CI: 11AM</span>' +
            '<span class="rm-spec"><i class="fa-solid fa-clock"></i> CO: 10AM</span>' +
            '</div>' +
            '<div class="rm-card-amenities">' + amenities + '</div>' +
            '<div class="rm-card-footer">' +
            '<span class="rm-card-capacity"><i class="fa-solid fa-user-group"></i> Double Occupancy</span>' +
            '<div class="d-flex gap-2">' +
            '<a href="contact-us.html" class="rm-btn rm-btn-outline-dark rm-btn-sm">Enquire</a>' +
            '<a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary rm-btn-sm">Book Now</a>' +
            '</div></div></div></div></div>';
    }

    /* ── ROOMS (index.html — first 3) ──────────────────────────────────── */
    function loadRoomsHome() {
        var el = document.getElementById('hm-rooms-grid');
        if (!el) return;
        get('/rooms').then(function (rooms) {
            if (!rooms || !rooms.length) return;
            el.innerHTML = rooms.slice(0, 3).map(buildHomeRoomCard).join('');
        });
    }

    /* ── ROOMS PAGE (rooms.html) — fetch once, populate all sections ──── */
    function loadRoomsPage() {
        var hasAny = document.getElementById('rm-rooms-grid') ||
            document.getElementById('rm-featured') ||
            document.getElementById('rm-detail-rows') ||
            document.getElementById('rm-compare-tbody');
        if (!hasAny) return;

        get('/rooms').then(function (rooms) {
            if (!rooms || !rooms.length) return;
            populateRoomsGrid(rooms);
            populateFeaturedRoom(rooms);
            populateRoomFilters(rooms);
            populateRoomDetailRows(rooms);
            populateRoomCompareTable(rooms);
        });
    }

    function populateRoomsGrid(rooms) {
        var el = document.getElementById('rm-rooms-grid');
        if (el) el.innerHTML = rooms.map(buildRoomPageCard).join('');
    }

    function populateFeaturedRoom(rooms) {
        var el = document.getElementById('rm-featured');
        if (!el) return;
        var room = rooms.filter(function (r) { return r.is_featured; })[0] || rooms[0];
        if (!room) return;

        var img = imgUrl(room.image_url) || 'assets/images/room/room-1.jpg';
        var badge = room.badge_text || 'Most Popular';
        var amenities = (room.amenities || []).slice(0, 8).map(function (a) {
            return '<div class="rm-amenity-item"><i class="fa-solid fa-check"></i> ' + esc(a) + '</div>';
        }).join('');

        el.innerHTML =
            '<div class="rm-featured-imgs">' +
            '<div class="rfi rfi-main"><img src="' + img + '" alt="' + esc(room.name) + '"></div>' +
            '<div class="rfi"><img src="' + img + '" alt="' + esc(room.name) + '"></div>' +
            '<div class="rfi"><img src="' + img + '" alt="' + esc(room.name) + '"></div>' +
            '</div>' +
            '<div class="rm-featured-content">' +
            '<div class="rm-featured-badge"><i class="fa-solid fa-star"></i> ' + esc(badge) + '</div>' +
            '<span class="rm-label">Best Pick</span>' +
            '<h2 class="rm-heading" style="font-size:34px;">' + esc(room.name) + '</h2>' +
            '<div class="rm-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>' +
            '<p class="rm-body mb-0">' + esc(room.description || '') + '</p>' +
            '<div class="rm-amenity-grid">' + amenities + '</div>' +
            '<div class="rm-price-tag">' +
            '<span class="curr">&#8377;</span>' +
            '<span class="amt">' + Number(room.price_per_night || 0).toLocaleString('en-IN') + '</span>' +
            '<span class="per">/ night &middot; ' + (room.max_guests || 2) + ' Guests</span>' +
            '</div>' +
            '<div class="d-flex gap-3 flex-wrap">' +
            '<a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary">WhatsApp to Book</a>' +
            '<a href="contact-us.html" class="rm-btn rm-btn-gold">Enquire Now</a>' +
            '</div></div>';
    }

    function populateRoomFilters(rooms) {
        var el = document.getElementById('rm-filter-wrap');
        if (!el) return;

        var seen = {}, types = [];
        rooms.forEach(function (r) {
            if (r.room_type && !seen[r.room_type]) {
                seen[r.room_type] = true;
                types.push({ label: r.room_type, cat: r.filter_category || r.room_type.toLowerCase().replace(/\s+/g, '-') });
            }
        });

        var html = '<a href="#" class="rm-filter-btn active" data-filter="all">All Rooms</a>';
        types.forEach(function (t) {
            html += '<a href="#" class="rm-filter-btn" data-filter="' + esc(t.cat) + '">' + esc(t.label) + '</a>';
        });
        el.innerHTML = html;

        el.querySelectorAll('.rm-filter-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                el.querySelectorAll('.rm-filter-btn').forEach(function (b) { b.classList.remove('active'); });
                this.classList.add('active');
                var filter = this.getAttribute('data-filter');
                document.querySelectorAll('#rm-rooms-grid [data-category]').forEach(function (card) {
                    var col = card.closest('[class*="col-"]') || card;
                    col.style.display = (filter === 'all' || card.getAttribute('data-category').indexOf(filter) !== -1) ? '' : 'none';
                });
            });
        });
    }

    function populateRoomDetailRows(rooms) {
        var el = document.getElementById('rm-detail-rows');
        if (!el) return;

        var html = '';
        rooms.forEach(function (room, idx) {
            var img = imgUrl(room.image_url) || 'assets/images/room/room-' + (idx + 1) + '.jpg';
            var badge = room.badge_text ? '<span class="rm-badge rm-badge-gold">' + esc(room.badge_text) + '</span>' : '';
            var price = room.price_per_night
                ? '<div class="rm-detail-img-price">' +
                  '<span class="dp-from">from</span>' +
                  '<span class="dp-amount">&#8377;' + Number(room.price_per_night).toLocaleString('en-IN') + '</span>' +
                  '<span class="dp-per">/night</span></div>' : '';
            var features = (room.amenities || []).slice(0, 6).map(function (a) {
                return '<li><i class="fa-solid fa-check"></i> ' + esc(a) + '</li>';
            }).join('');
            var rowCls = idx % 2 !== 0 ? 'rm-detail-row reverse wow fadeInUp' : 'rm-detail-row wow fadeInUp';

            html +=
                '<div class="' + rowCls + '" data-wow-delay=".2s">' +
                '<div class="rm-detail-img">' +
                '<img src="' + img + '" alt="' + esc(room.name) + '">' +
                '<div class="rm-detail-img-overlay"></div>' +
                '<div class="rm-detail-img-badge">' + badge + '</div>' +
                price +
                '</div>' +
                '<div class="rm-detail-content">' +
                '<span class="rm-label">' + esc(room.room_type || '') + '</span>' +
                '<h3 class="rm-heading" style="font-size:30px;">' + esc(room.name) + '</h3>' +
                '<div class="rm-divider"><span></span><i class="fa-solid fa-leaf"></i><span></span></div>' +
                '<p class="rm-body mb-4">' + esc(room.description || '') + '</p>' +
                '<ul class="rm-detail-features">' + features + '</ul>' +
                '<div class="rm-detail-specs">' +
                (room.max_guests ? '<span class="rm-spec"><i class="fa-solid fa-users"></i> Up to ' + room.max_guests + '</span>' : '') +
                '</div>' +
                '<div class="d-flex gap-3 flex-wrap">' +
                '<a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="rm-btn rm-btn-primary">Book This Room</a>' +
                '<a href="contact-us.html" class="rm-btn rm-btn-gold">Enquire</a>' +
                '</div></div></div>';
        });
        el.innerHTML = html;
    }

    function populateRoomCompareTable(rooms) {
        var el = document.getElementById('rm-compare-tbody');
        if (!el) return;

        function has(amenities, kw) {
            return (amenities || []).some(function (a) { return a.toLowerCase().indexOf(kw) !== -1; });
        }
        var chk = '<i class="fa-solid fa-check rc-check"></i>';
        var crs = '<i class="fa-solid fa-xmark rc-cross"></i>';

        var html = '';
        rooms.forEach(function (room) {
            var am = room.amenities || [];
            html +=
                '<tr>' +
                '<td>' + esc(room.name) + '</td>' +
                '<td>&mdash;</td>' +
                '<td>' + (room.max_guests || 2) + '</td>' +
                '<td class="rc-price">&#8377;' + Number(room.price_per_night || 0).toLocaleString('en-IN') + '</td>' +
                '<td>' + (has(am, 'ac') || has(am, 'air') ? chk : crs) + '</td>' +
                '<td>' + (has(am, 'pool') ? chk : crs) + '</td>' +
                '<td>' + (has(am, 'verandah') || has(am, 'veranda') || has(am, 'balcony') ? chk : crs) + '</td>' +
                '<td>' + (has(am, 'breakfast') || has(am, 'dining') ? chk : crs) + '</td>' +
                '</tr>';
        });
        el.innerHTML = html;
    }

    /* ── GALLERY STRIP (index.html) ────────────────────────────────────── */
    function loadGalleryStrip() {
        var el = document.getElementById('hm-gallery-strip');
        if (!el) return;
        get('/gallery').then(function (items) {
            if (!items || !items.length) return;
            var html = '<div class="gph gph-large">' +
                '<img src="' + imgUrl(items[0].image_url) + '" alt="' + esc(items[0].title || 'Mahua House') + '">' +
                '<div class="gph-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div></div>';
            items.slice(1, 7).forEach(function (item) {
                html += '<div class="gph">' +
                    '<img src="' + imgUrl(item.image_url) + '" alt="' + esc(item.title || '') + '">' +
                    '<div class="gph-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div></div>';
            });
            el.innerHTML = html;
        });
    }

    /* ── GALLERY MASONRY (gallery.html) ────────────────────────────────── */
    function loadGalleryPage() {
        var el = document.getElementById('gl-masonry');
        if (!el) return;
        get('/gallery').then(function (items) {
            if (!items || !items.length) return;
            var html = '';
            items.forEach(function (item) {
                var url = imgUrl(item.image_url);
                html += '<a class="gl-item mfp-image" data-category="' + esc(item.category || 'all') +
                    '" href="' + url + '">' +
                    '<img src="' + url + '" alt="' + esc(item.title || 'Mahua House') + '" loading="lazy">' +
                    '<div class="gl-item-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div></a>';
            });
            el.innerHTML = html;
            // Re-init magnific popup if already loaded.
            if (window.jQuery && jQuery.fn.magnificPopup) {
                jQuery('#gl-masonry .mfp-image').magnificPopup({
                    type: 'image',
                    gallery: { enabled: true }
                });
            }
        });
    }

    /* ── TESTIMONIALS (index.html) ─────────────────────────────────────── */
    function loadTestimonials() {
        var el = document.getElementById('hm-testi-grid');
        if (!el) return;
        get('/testimonials').then(function (items) {
            if (!items || !items.length) return;
            var html = '';
            items.slice(0, 3).forEach(function (t, i) {
                html += '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".' + (i + 2) + 's">' +
                    '<div class="hm-testi-card">' +
                    '<div class="hm-testi-quote">"</div>' +
                    '<div class="hm-testi-stars">' + stars(t.rating) + '</div>' +
                    '<p class="hm-testi-text">' + esc(t.review) + '</p>' +
                    '<div class="hm-testi-author"><div>' +
                    '<p class="hm-testi-name">' + esc(t.name) + '</p>' +
                    (t.location ? '<p class="hm-testi-loc">' + esc(t.location) + '</p>' : '') +
                    '</div></div></div></div>';
            });
            el.innerHTML = html;
        });
    }

    /* ── CONTACT INFO CARDS + SIDEBAR (contact-us.html) ───────────────── */
    function loadContactInfo() {
        var cardsEl  = document.getElementById('cu-info-cards');
        var sidebarEl = document.getElementById('cu-sidebar-contact-items');
        if (!cardsEl && !sidebarEl) return;

        get('/contact-info').then(function (info) {
            if (!info) return;

            var a  = info.address   || {};
            var ph = info.phone     || {};
            var em = info.email     || {};
            var wa = info.whatsapp  || {};
            var fb = info.facebook  || {};
            var ig = info.instagram || {};
            var waNum = (wa.value || '').replace(/\D/g, '');

            if (cardsEl) {
                cardsEl.innerHTML =
                    cuInfoCard('fa-solid fa-location-dot', 'Our Location',
                        '<p>' + esc(a.value || '') + '</p>',
                        'Madhya Pradesh, India', '.1s') +
                    cuInfoCard('fa-solid fa-phone-volume', 'Call Us',
                        '<a href="tel:' + esc(ph.value || '') + '">' + esc(ph.value || '') + '</a>',
                        'Daily 8am – 9pm', '.2s') +
                    cuInfoCard('fa-solid fa-envelope', 'Email Us',
                        '<a href="mailto:' + esc(em.value || '') + '">' + esc(em.value || '') + '</a>',
                        'Reply within 24 hours', '.3s') +
                    cuInfoCard('fa-brands fa-whatsapp', 'WhatsApp',
                        '<a href="https://wa.me/' + waNum + '" target="_blank" rel="noopener">+' + esc(waNum) + '</a>' +
                        '<p style="margin-top:4px;">Quick replies for bookings &amp; enquiries</p>',
                        'Chat With Us', '.4s');
            }

            if (sidebarEl) {
                var items = [
                    { icon: 'fa-solid fa-location-dot', label: 'Address',   value: a.value  || '', href: null },
                    { icon: 'fa-solid fa-phone',        label: 'Phone',     value: ph.value || '', href: 'tel:' + (ph.value || '') },
                    { icon: 'fa-solid fa-envelope',     label: 'Email',     value: em.value || '', href: 'mailto:' + (em.value || '') },
                    { icon: 'fa-brands fa-whatsapp',    label: 'WhatsApp',  value: '+' + waNum, href: 'https://wa.me/' + waNum }
                ];
                var html = items.map(function (item) {
                    var ext = item.href && item.href.indexOf('http') === 0;
                    var valHtml = item.href
                        ? '<a href="' + esc(item.href) + '" class="ci-value"' + (ext ? ' target="_blank" rel="noopener"' : '') + '>' + esc(item.value) + '</a>'
                        : '<span class="ci-value">' + esc(item.value) + '</span>';
                    return '<div class="cu-contact-item">' +
                        '<div class="ci-icon"><i class="' + item.icon + '"></i></div>' +
                        '<div class="ci-info"><span class="ci-label">' + esc(item.label) + '</span>' + valHtml + '</div></div>';
                }).join('');

                var fbUrl = fb.value || '#';
                var igUrl = ig.value || '#';
                html += '<div class="cu-social-row">' +
                    '<a href="' + esc(igUrl) + '" aria-label="Instagram"' + (igUrl !== '#' ? ' target="_blank" rel="noopener"' : '') + '><i class="fa-brands fa-instagram"></i></a>' +
                    '<a href="' + esc(fbUrl) + '" aria-label="Facebook"' + (fbUrl !== '#' ? ' target="_blank" rel="noopener"' : '') + '><i class="fa-brands fa-facebook-f"></i></a>' +
                    '<a href="https://wa.me/' + waNum + '" aria-label="WhatsApp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i></a>' +
                    '</div>';
                sidebarEl.innerHTML = html;
            }
        });
    }

    function cuInfoCard(icon, title, bodyHtml, tag, delay) {
        return '<div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="' + delay + '">' +
            '<div class="cu-info-card">' +
            '<div class="cu-info-card-icon"><i class="' + icon + '"></i></div>' +
            '<h4>' + title + '</h4>' +
            bodyHtml +
            '<span class="cu-info-tag">' + tag + '</span>' +
            '</div></div>';
    }

    /* ── FAQ (contact-us.html) ─────────────────────────────────────────── */
    function loadContactFaq() {
        var el = document.getElementById('cu-faq-list');
        if (!el) return;

        get('/faq').then(function (items) {
            if (!items || !items.length) return;

            var html = '';
            items.forEach(function (item, i) {
                html += '<div class="cu-faq-item' + (i === 0 ? ' open' : '') + '">' +
                    '<div class="cu-faq-q">' + esc(item.question) +
                    '<i class="fa-solid fa-plus"></i></div>' +
                    '<p class="cu-faq-a" style="' + (i === 0 ? 'display:block;' : '') + '">' +
                    esc(item.answer) + '</p></div>';
            });
            el.innerHTML = html;

            el.querySelectorAll('.cu-faq-q').forEach(function (q) {
                q.addEventListener('click', function () {
                    var item = this.closest('.cu-faq-item');
                    var isOpen = item.classList.contains('open');
                    el.querySelectorAll('.cu-faq-item').forEach(function (fi) {
                        fi.classList.remove('open');
                        fi.querySelector('.cu-faq-a').style.display = 'none';
                    });
                    if (!isOpen) {
                        item.classList.add('open');
                        item.querySelector('.cu-faq-a').style.display = 'block';
                    }
                });
            });
        });
    }

    /* ── CONTACT FORM (contact-us.html) ────────────────────────────────── */
    function wireContactForm() {
        var form = document.getElementById('contact-form');
        if (!form) return;

        var errBox = form.querySelector('#cu-form-error');
        if (!errBox) {
            errBox = document.createElement('div');
            errBox.id = 'cu-form-error';
            errBox.style.cssText = 'display:none;color:#c0392b;background:rgba(192,57,43,0.08);border:1px solid rgba(192,57,43,0.2);border-radius:10px;padding:12px 16px;font-size:14px;margin-bottom:16px;';
            form.insertBefore(errBox, form.firstChild);
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            errBox.style.display = 'none';

            var fv = function (id) { var el = form.querySelector(id); return el ? el.value.trim() : ''; };

            var name    = fv('#cu-name');
            var message = fv('#cu-message');
            if (!name) { showFormError('Please enter your full name.'); return; }
            if (!message) { showFormError('Please enter your message.'); return; }

            var subjectChecked = document.querySelector('input[name="subject"]:checked');
            var subjectLabel = '';
            if (subjectChecked) {
                var lbl = subjectChecked.closest('div') && subjectChecked.closest('div').querySelector('label');
                subjectLabel = lbl ? lbl.textContent.trim() : '';
            }

            var guestsRaw = fv('#cu-guests');
            var payload = {
                name:      name,
                email:     fv('#cu-email') || null,
                phone:     fv('#cu-phone') || null,
                message:   message,
                subject:   subjectLabel || null,
                check_in:  fv('#cu-checkin')  || null,
                check_out: fv('#cu-checkout') || null,
                guests:    guestsRaw ? (parseInt(guestsRaw) || null) : null,
                type:      'contact'
            };

            var btn = form.querySelector('button[type="submit"]');
            var origHTML = btn ? btn.innerHTML : '';
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Sending…'; }

            post('/inquiries', payload).then(function (data) {
                if (data && data.success) {
                    form.closest('.cu-form-wrap').innerHTML =
                        '<div style="padding:48px 24px;text-align:center;">' +
                        '<i class="fa-solid fa-circle-check" style="font-size:56px;color:#DAA520;display:block;margin-bottom:20px;"></i>' +
                        '<h4 style="color:#033631;margin-bottom:10px;">Message Sent!</h4>' +
                        '<p style="color:rgba(3,54,49,0.65);max-width:440px;margin:0 auto;">' +
                        esc(data.message) + '</p></div>';
                } else {
                    if (btn) { btn.disabled = false; btn.innerHTML = origHTML; }
                    var msg = (data && data.message) || 'Something went wrong. Please try again.';
                    if (data && data.errors) {
                        var errs = [];
                        Object.keys(data.errors).forEach(function (k) { errs = errs.concat(data.errors[k]); });
                        msg = errs.join(' ');
                    }
                    showFormError(msg);
                }
            }).catch(function () {
                if (btn) { btn.disabled = false; btn.innerHTML = origHTML; }
                showFormError('Unable to send. Please WhatsApp us at +91 94256 51754 or email mahuahouse17@gmail.com');
            });

            function showFormError(msg) {
                errBox.textContent = msg;
                errBox.style.display = 'block';
                errBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    }

    /* ── BOOKING PAGE (booking.html) — rooms + contact info ────────────── */
    function loadBookingPage() {
        var roomsEl   = document.getElementById('bk-rooms-grid');
        var contactEl = document.getElementById('bk-contact-info-items');
        var phoneEl   = document.getElementById('bk-how-phone');
        var selectEl  = document.getElementById('bk-room-select');
        if (!roomsEl && !contactEl) return;

        if (roomsEl || selectEl) {
            get('/rooms').then(function (rooms) {
                if (!rooms || !rooms.length) return;
                if (roomsEl) roomsEl.innerHTML = rooms.map(buildBookingRoomCard).join('');
                if (selectEl) {
                    var opts = '<option value="">Any / Not sure yet</option>';
                    rooms.forEach(function (r) {
                        opts += '<option value="' + esc(r.name) + '">' + esc(r.name) + '</option>';
                    });
                    selectEl.innerHTML = opts;
                }
            });
        }

        if (contactEl || phoneEl) {
            get('/contact-info').then(function (info) {
                if (!info) return;
                var ph  = info.phone     || {};
                var em  = info.email     || {};
                var wa  = info.whatsapp  || {};
                var waNum = (wa.value || '').replace(/\D/g, '') || '919425651754';
                var phVal = ph.value || ('+' + waNum);

                if (phoneEl) {
                    phoneEl.textContent = 'Call: ' + phVal;
                    phoneEl.href = 'tel:' + phVal;
                }

                if (contactEl) {
                    contactEl.innerHTML =
                        bkContactItem('fa-brands fa-whatsapp', 'WhatsApp', '+' + waNum, 'https://wa.me/' + waNum, true) +
                        bkContactItem('fa-solid fa-phone',     'Phone',    phVal,         'tel:' + phVal,             false) +
                        bkContactItem('fa-solid fa-envelope',  'Email',    em.value || '', 'mailto:' + (em.value || ''), false) +
                        bkContactItem('fa-solid fa-globe',     'Website',  'www.mahuahouse.com', 'http://www.mahuahouse.com', true) +
                        '<div class="d-flex gap-3 flex-wrap mt-4">' +
                        '<a href="https://wa.me/' + waNum + '" target="_blank" rel="noopener" class="bk-btn bk-btn-green">' +
                        '<i class="fa-brands fa-whatsapp"></i> WhatsApp Now</a>' +
                        '<a href="contact-us.html" class="bk-btn bk-btn-outline-dark">Send an Enquiry</a>' +
                        '</div>';
                }
            });
        }
    }

    function buildBookingRoomCard(room, idx) {
        var img = imgUrl(room.image_url) || 'assets/images/room/room-' + (idx + 1) + '.jpg';
        var badge = room.badge_text ? '<span class="bk-room-badge">' + esc(room.badge_text) + '</span>' : '';
        var price = room.price_per_night
            ? '<div class="bk-room-price">&#8377;' + Number(room.price_per_night).toLocaleString('en-IN') +
              ' <span class="per">/ night</span></div>' : '';
        var amenities = (room.amenities || []).map(function (a) {
            return '<li><i class="' + bkAmenityIcon(a) + '"></i> ' + esc(a) + '</li>';
        }).join('');
        var waText = encodeURIComponent('Hi, I would like to book the ' + room.name + ' at Mahua House.');
        return '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".' + (idx + 2) + 's">' +
            '<div class="bk-room-card">' +
            '<div class="bk-room-img"><img src="' + img + '" alt="' + esc(room.name) + '">' + badge + '</div>' +
            '<div class="bk-room-body">' +
            '<h3 class="bk-room-title">' + esc(room.name) + '</h3>' +
            price +
            '<p class="bk-room-occ"><i class="fa-solid fa-user-group me-1"></i> ' + (room.max_guests || 2) + ' Guests Max</p>' +
            '<ul class="bk-amenity-list">' + amenities + '</ul>' +
            '<a href="https://wa.me/919425651754?text=' + waText + '" target="_blank" rel="noopener" class="bk-btn bk-btn-green w-100 justify-content-center">' +
            '<i class="fa-brands fa-whatsapp"></i> Book via WhatsApp</a>' +
            '</div></div></div>';
    }

    function bkAmenityIcon(a) {
        var s = a.toLowerCase();
        if (/\bac\b|air.?con/.test(s)) return 'fa-solid fa-snowflake';
        if (/bed/.test(s))             return 'fa-solid fa-bed';
        if (/bath|shower/.test(s))     return 'fa-solid fa-shower';
        if (/tv|tele/.test(s))         return 'fa-solid fa-tv';
        if (/wi.?fi/.test(s))          return 'fa-solid fa-wifi';
        if (/park/.test(s))            return 'fa-solid fa-square-parking';
        if (/power|backup/.test(s))    return 'fa-solid fa-bolt';
        if (/cctv|secur/.test(s))      return 'fa-solid fa-shield-halved';
        if (/private|indep/.test(s))   return 'fa-solid fa-house-chimney';
        if (/forest|tree|view/.test(s))return 'fa-solid fa-tree';
        if (/din|food|meal/.test(s))   return 'fa-solid fa-utensils';
        return 'fa-solid fa-check';
    }

    function bkContactItem(icon, label, value, href, ext) {
        return '<div class="bk-contact-info-item">' +
            '<div class="bk-ci-icon"><i class="' + icon + '"></i></div>' +
            '<div><div class="bk-ci-label">' + esc(label) + '</div>' +
            '<a href="' + esc(href) + '"' + (ext ? ' target="_blank" rel="noopener"' : '') + ' class="bk-ci-value">' + esc(value) + '</a>' +
            '</div></div>';
    }

    /* ── BOOKING INQUIRY FORM (booking.html) ───────────────────────────── */
    function wireBookingForm() {
        var form = document.getElementById('booking-inquiry-form');
        if (!form) return;

        var errBox = document.createElement('div');
        errBox.style.cssText = 'display:none;color:#c0392b;background:rgba(192,57,43,0.08);border:1px solid rgba(192,57,43,0.2);border-radius:10px;padding:12px 16px;font-size:14px;margin-bottom:16px;';
        form.insertBefore(errBox, form.firstChild);

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            errBox.style.display = 'none';

            var f = function (name) {
                var el = form.querySelector('[name="' + name + '"]');
                return el ? el.value.trim() : '';
            };

            var name  = f('name');
            var phone = f('phone');
            if (!name)  { showBkError('Please enter your full name.'); return; }
            if (!phone) { showBkError('Please enter your phone number so we can confirm your booking.'); return; }

            var payload = {
                name:      name,
                email:     f('email')     || null,
                phone:     phone,
                message:   f('message')   || 'Booking enquiry',
                check_in:  f('check_in')  || null,
                check_out: f('check_out') || null,
                room_type: f('room_type') || null,
                type:      'booking'
            };

            var btn = form.querySelector('button[type="submit"]');
            var origHTML = btn ? btn.innerHTML : '';
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting…'; }

            post('/inquiries', payload).then(function (data) {
                if (data && data.success) {
                    form.closest('div').innerHTML =
                        '<div style="padding:40px 24px;text-align:center;">' +
                        '<i class="fa-solid fa-circle-check" style="font-size:56px;color:#DAA520;display:block;margin-bottom:20px;"></i>' +
                        '<h4 style="color:#033631;margin-bottom:10px;">Booking Request Received!</h4>' +
                        '<p style="color:rgba(3,54,49,0.65);max-width:440px;margin:0 auto 24px;">' + esc(data.message) + '</p>' +
                        '<a href="https://wa.me/919425651754" target="_blank" rel="noopener" class="bk-btn bk-btn-green">' +
                        '<i class="fa-brands fa-whatsapp"></i> Also message us on WhatsApp</a></div>';
                } else {
                    if (btn) { btn.disabled = false; btn.innerHTML = origHTML; }
                    var msg = (data && data.message) || 'Something went wrong. Please try again.';
                    if (data && data.errors) {
                        var errs = [];
                        Object.keys(data.errors).forEach(function (k) { errs = errs.concat(data.errors[k]); });
                        msg = errs.join(' ');
                    }
                    showBkError(msg);
                }
            }).catch(function () {
                if (btn) { btn.disabled = false; btn.innerHTML = origHTML; }
                showBkError('Unable to submit. Please WhatsApp us at +91 94256 51754 directly.');
            });

            function showBkError(msg) {
                errBox.textContent = msg;
                errBox.style.display = 'block';
                errBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    }

    /* ── INIT ───────────────────────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {
        loadHero();
        loadStats();
        loadWhyChoose();
        loadExperiences();
        loadRoomsHome();
        loadRoomsPage();
        loadGalleryStrip();
        loadGalleryPage();
        loadTestimonials();
        loadContactInfo();
        loadContactFaq();
        loadBookingPage();
        wireContactForm();
        wireBookingForm();
    });

})();
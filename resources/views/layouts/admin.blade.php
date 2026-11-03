<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — Mahua House Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--sidebar-w:260px;--sidebar-bg:#033631;--accent:#DAA520;--header-h:60px;--content-bg:#f0f4f0;}
*{box-sizing:border-box;}
body{font-family:'Poppins',sans-serif;background:var(--content-bg);margin:0;overflow-x:hidden;}
/* Sidebar */
.sidebar{position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;background:var(--sidebar-bg);overflow-y:auto;overflow-x:hidden;z-index:1000;transition:transform .3s ease;display:flex;flex-direction:column;}
.sidebar-brand{padding:20px 20px 14px;border-bottom:1px solid rgba(255,255,255,.08);flex-shrink:0;}
.sidebar-brand img{max-height:44px;max-width:180px;object-fit:contain;}
.sidebar-nav{flex:1;padding:12px 0 20px;}
.nav-section{padding:16px 16px 4px;font-size:9px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3);}
.sidebar a.nav-link{display:flex;align-items:center;gap:10px;padding:9px 16px;color:rgba(255,255,255,.7);text-decoration:none;font-size:13.5px;font-weight:500;transition:all .2s;border-radius:0;position:relative;}
.sidebar a.nav-link:hover,.sidebar a.nav-link.active{color:#fff;background:rgba(218,165,32,.12);}
.sidebar a.nav-link.active::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--accent);}
.sidebar a.nav-link i{font-size:15px;width:18px;text-align:center;color:var(--accent);}
.badge-new{background:var(--accent);color:#033631;font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;margin-left:auto;}
/* Main */
.main-wrapper{margin-left:var(--sidebar-w);min-height:100vh;transition:margin .3s ease;}
.topbar{background:#fff;height:var(--header-h);display:flex;align-items:center;justify-content:space-between;padding:0 24px;box-shadow:0 1px 3px rgba(0,0,0,.08);position:sticky;top:0;z-index:100;}
.topbar-left{display:flex;align-items:center;gap:14px;}
.page-title{font-size:15px;font-weight:600;color:#033631;margin:0;}
.btn-sidebar-toggle{background:none;border:none;padding:6px;cursor:pointer;color:#033631;font-size:20px;display:none;}
.topbar-right{display:flex;align-items:center;gap:12px;}
.topbar-avatar{width:34px;height:34px;border-radius:50%;background:var(--accent);color:#033631;font-weight:700;display:flex;align-items:center;justify-content:center;font-size:14px;}
.topbar-name{font-size:13px;font-weight:600;color:#033631;}
.content-area{padding:24px;}
/* Cards */
.stat-card{background:#fff;border-radius:14px;padding:22px 20px;border:none;box-shadow:0 1px 6px rgba(3,54,49,.07);}
.stat-card .stat-icon{width:48px;height:48px;border-radius:12px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;font-size:20px;color:#033631;}
.stat-card .stat-num{font-size:28px;font-weight:700;color:#033631;line-height:1;}
.stat-card .stat-lbl{font-size:12px;color:#888;font-weight:500;}
/* Table */
.table-card{background:#fff;border-radius:14px;box-shadow:0 1px 6px rgba(3,54,49,.07);overflow:hidden;}
.table-card .card-header-custom{padding:16px 20px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;}
.table-card .card-header-custom h5{margin:0;font-size:15px;font-weight:600;color:#033631;}
.table thead th{background:#f8faf8;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:#555;border-bottom:2px solid #e8ede8!important;padding:10px 16px;}
.table td{padding:12px 16px;vertical-align:middle;border-color:#f0f0f0;font-size:13.5px;}
.table-img{width:52px;height:40px;object-fit:cover;border-radius:6px;}
/* Badges */
.badge-active{background:rgba(25,135,84,.1);color:#198754;font-size:11px;padding:3px 10px;border-radius:20px;font-weight:600;}
.badge-inactive{background:rgba(220,53,69,.1);color:#dc3545;font-size:11px;padding:3px 10px;border-radius:20px;font-weight:600;}
/* Buttons */
.btn-mahua{background:#033631;color:#fff;border:none;font-size:13px;font-weight:600;padding:8px 18px;border-radius:8px;cursor:pointer;transition:all .2s;}
.btn-mahua:hover{background:#044a43;color:#fff;}
.btn-gold{background:var(--accent);color:#033631;border:none;font-size:13px;font-weight:700;padding:8px 18px;border-radius:8px;cursor:pointer;}
.btn-gold:hover{background:#c49510;color:#033631;}
/* Modal */
.modal-header{background:#033631;color:#fff;border-radius:14px 14px 0 0!important;}
.modal-header .btn-close{filter:invert(1);}
.modal-content{border-radius:14px!important;border:none!important;}
.form-label{font-size:13px;font-weight:600;color:#444;}
.form-control,.form-select{font-size:13.5px;border-color:#dde5dd;border-radius:8px;}
.form-control:focus,.form-select:focus{border-color:#033631;box-shadow:0 0 0 2px rgba(3,54,49,.1);}
/* Alert */
.alert-flash{border-radius:10px;font-size:13.5px;}
/* Image preview */
.img-preview{max-height:120px;max-width:200px;border-radius:8px;object-fit:cover;display:block;margin-top:8px;}
/* Responsive */
@media(max-width:991px){
  .sidebar{transform:translateX(-100%);}
  .sidebar.open{transform:translateX(0);}
  .main-wrapper{margin-left:0!important;}
  .btn-sidebar-toggle{display:block!important;}
}
</style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <img src="/site/assets/images/logo/Mahua-House-White-1.png" alt="Mahua House" onerror="this.style.display='none';this.nextSibling.style.display='block'">
    <span style="display:none;color:#DAA520;font-weight:700;font-size:16px;">Mahua House</span>
  </div>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section">Content</div>
    <a href="{{ route('admin.home-admin.index') }}" class="nav-link {{ request()->routeIs('admin.home-admin.*') ? 'active' : '' }}">
      <i class="bi bi-house-heart-fill"></i> Home Page
    </a>
    <a href="{{ route('admin.about-admin.index') }}" class="nav-link {{ request()->routeIs('admin.about-admin.*') ? 'active' : '' }}">
      <i class="bi bi-info-circle-fill"></i> About Us
    </a>
    <a href="{{ route('admin.hero.index') }}" class="nav-link {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
      <i class="bi bi-images"></i> Hero Slides
    </a>
    <a href="{{ route('admin.stats.index') }}" class="nav-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">
      <i class="bi bi-bar-chart-fill"></i> Stats & Numbers
    </a>
    <a href="{{ route('admin.why-choose.index') }}" class="nav-link {{ request()->routeIs('admin.why-choose.*') ? 'active' : '' }}">
      <i class="bi bi-check-circle-fill"></i> Why Choose Us
    </a>
    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
      <i class="bi bi-grid-fill"></i> Services / Experiences
    </a>

    <div class="nav-section">Accommodation</div>
    <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
      <i class="bi bi-house-door-fill"></i> Rooms
    </a>

    <div class="nav-section">Media & Reviews</div>
    <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
      <i class="bi bi-camera-fill"></i> Photo Gallery
    </a>
    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
      <i class="bi bi-chat-quote-fill"></i> Testimonials
    </a>

    <div class="nav-section">People</div>
    <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
      <i class="bi bi-people-fill"></i> Our Team
    </a>

    <div class="nav-section">Marketing</div>
    <a href="{{ route('admin.blog.index') }}" class="nav-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
      <i class="bi bi-newspaper"></i> Blog Posts
    </a>
    <a href="{{ route('admin.offers.index') }}" class="nav-link {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}">
      <i class="bi bi-tag-fill"></i> Special Offers
    </a>
    <a href="{{ route('admin.faq.index') }}" class="nav-link {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
      <i class="bi bi-question-circle-fill"></i> FAQ
    </a>

    <div class="nav-section">Inquiries</div>
    <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
      <i class="bi bi-envelope-fill"></i> All Inquiries
      @php $newCount = \App\Models\Inquiry::where('status','new')->count(); @endphp
      @if($newCount > 0) <span class="badge-new">{{ $newCount }}</span> @endif
    </a>

    <div class="nav-section">Events</div>
    <a href="{{ route('admin.events-admin.index') }}" class="nav-link {{ request()->routeIs('admin.events-admin.*') ? 'active' : '' }}">
      <i class="bi bi-calendar-event-fill"></i> Events
    </a>
    <a href="{{ route('admin.corporate-events-admin.index') }}" class="nav-link {{ request()->routeIs('admin.corporate-events-admin.*') ? 'active' : '' }}">
      <i class="bi bi-briefcase-fill"></i> Corporate Events
    </a>
    <a href="{{ route('admin.educational-tours-admin.index') }}" class="nav-link {{ request()->routeIs('admin.educational-tours-admin.*') ? 'active' : '' }}">
      <i class="bi bi-mortarboard-fill"></i> Educational Tours
    </a>
    <a href="{{ route('admin.film-shoots-admin.index') }}" class="nav-link {{ request()->routeIs('admin.film-shoots-admin.*') ? 'active' : '' }}">
      <i class="bi bi-camera-reels-fill"></i> Film Shoots
    </a>
    <a href="{{ route('admin.day-out-plan-admin.index') }}" class="nav-link {{ request()->routeIs('admin.day-out-plan-admin.*') ? 'active' : '' }}">
      <i class="bi bi-sun-fill"></i> Day Out Plan
    </a>

    <a href="{{ route('admin.food-dining-admin.index') }}" class="nav-link {{ request()->routeIs('admin.food-dining-admin.*') ? 'active' : '' }}">
      <i class="bi bi-egg-fried"></i> Food & Dining
    </a>
    <a href="{{ route('admin.spaces-admin.index') }}" class="nav-link {{ request()->routeIs('admin.spaces-admin.*') ? 'active' : '' }}">
      <i class="bi bi-layout-three-columns"></i> Spaces
    </a>
    <a href="{{ route('admin.facilities-admin.index') }}" class="nav-link {{ request()->routeIs('admin.facilities-admin.*') ? 'active' : '' }}">
      <i class="bi bi-building-check"></i> Facilities
    </a>

    <div class="nav-section">Destination Wedding</div>
    <a href="{{ route('admin.destination-wedding.index') }}" class="nav-link {{ request()->routeIs('admin.destination-wedding.*') ? 'active' : '' }}">
      <i class="bi bi-heart-fill"></i> Destination Wedding
    </a>

    <div class="nav-section">Video Tours</div>
    <a href="{{ route('admin.video-tours.index') }}" class="nav-link {{ request()->routeIs('admin.video-tours.*') ? 'active' : '' }}">
      <i class="bi bi-play-circle-fill"></i> Video Tours
    </a>

    <div class="nav-section">Pages</div>
    <a href="{{ route('admin.page-sections.index') }}" class="nav-link {{ request()->routeIs('admin.page-sections.*') ? 'active' : '' }}">
      <i class="bi bi-file-earmark-text-fill"></i> Page Content
    </a>

    <div class="nav-section">Settings</div>
    <a href="{{ route('admin.contact-info.index') }}" class="nav-link {{ request()->routeIs('admin.contact-info.*') ? 'active' : '' }}">
      <i class="bi bi-telephone-fill"></i> Contact Info
    </a>
    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
      <i class="bi bi-gear-fill"></i> Site Settings
    </a>
  </nav>
</aside>

<!-- Main Content -->
<div class="main-wrapper">
  <!-- Top Bar -->
  <div class="topbar">
    <div class="topbar-left">
      <button class="btn-sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <h5 class="page-title">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="topbar-right">
      <a href="/site/" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex align-items-center gap-1">
        <i class="bi bi-box-arrow-up-right"></i> View Site
      </a>
      <div class="dropdown">
        <button class="btn btn-sm d-flex align-items-center gap-2" data-bs-toggle="dropdown">
          <div class="topbar-avatar">{{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}</div>
          <span class="topbar-name d-none d-md-block">{{ session('admin_name', 'Admin') }}</span>
          <i class="bi bi-chevron-down" style="font-size:11px"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
          <li><span class="dropdown-item-text small text-muted">{{ session('admin_email') }}</span></li>
          <li><hr class="dropdown-divider my-1"></li>
          <li>
            <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              <i class="bi bi-key me-2"></i>Change Password
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('admin.logout') }}">
              @csrf
              <button class="dropdown-item small text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="content-area">
    @if(session('success'))
    <div class="alert alert-success alert-flash alert-dismissible fade show mb-4" role="alert">
      <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-flash alert-dismissible fade show mb-4" role="alert">
      <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger alert-flash alert-dismissible fade show mb-4" role="alert">
      <i class="bi bi-exclamation-circle me-2"></i>
      @foreach($errors->all() as $error) {{ $error }}<br> @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @yield('content')
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <form method="POST" action="{{ route('admin.change-password') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title">Change Password</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
          <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_password" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" required minlength="6"></div>
          <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="new_password_confirmation" class="form-control" required></div>
        </div>
        <div class="modal-footer"><button type="submit" class="btn-mahua btn">Update Password</button></div>
      </div>
    </form>
  </div>
</div>

<!-- Sidebar Overlay -->
<div id="sidebarOverlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:999;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
  const s = document.getElementById('sidebar');
  const o = document.getElementById('sidebarOverlay');
  s.classList.toggle('open');
  o.style.display = s.classList.contains('open') ? 'block' : 'none';
}
// Image upload helper
function uploadImage(inputEl, previewEl, targetInputEl) {
  const file = inputEl.files[0];
  if (!file) return;
  const fd = new FormData();
  fd.append('image', file);
  fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
  fetch('/admin/upload', {method:'POST', body:fd})
    .then(r => r.json())
    .then(d => {
      if (d.url) {
        targetInputEl.value = d.url;
        if (previewEl) { previewEl.src = d.url; previewEl.style.display = 'block'; }
      }
    });
}
// Auto-dismiss alerts after 4s
setTimeout(() => document.querySelectorAll('.alert-flash').forEach(a => { try { bootstrap.Alert.getOrCreateInstance(a).close(); } catch(e){} }), 4000);
</script>
@yield('scripts')
</body>
</html>

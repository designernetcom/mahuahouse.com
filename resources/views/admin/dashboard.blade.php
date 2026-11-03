@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-house-door-fill"></i></div>
        <span style="font-size:11px;color:#888;">Active</span>
      </div>
      <div class="stat-num">{{ $stats['rooms'] }}</div>
      <div class="stat-lbl">Rooms Listed</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-camera-fill" style="color:#DAA520"></i></div>
        <span style="font-size:11px;color:#888;">Active</span>
      </div>
      <div class="stat-num">{{ $stats['gallery'] }}</div>
      <div class="stat-lbl">Gallery Images</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-chat-quote-fill"></i></div>
        <span style="font-size:11px;color:#888;">Published</span>
      </div>
      <div class="stat-num">{{ $stats['testimonials'] }}</div>
      <div class="stat-lbl">Testimonials</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon" style="background:rgba(220,53,69,.08)"><i class="bi bi-envelope-fill" style="color:#dc3545"></i></div>
        <a href="{{ route('admin.inquiries.index') }}" style="font-size:11px;color:#dc3545;text-decoration:none;">View All</a>
      </div>
      <div class="stat-num" style="color:#dc3545">{{ $stats['new_inquiries'] }}</div>
      <div class="stat-lbl">New Inquiries</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-newspaper"></i></div>
        <span style="font-size:11px;color:#888;">Published</span>
      </div>
      <div class="stat-num">{{ $stats['blog_published'] }}</div>
      <div class="stat-lbl">Blog Posts</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-tag-fill" style="color:#DAA520"></i></div>
        <span style="font-size:11px;color:#888;">Active</span>
      </div>
      <div class="stat-num">{{ $stats['offers_active'] }}</div>
      <div class="stat-lbl">Active Offers</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-images"></i></div>
        <span style="font-size:11px;color:#888;">Active</span>
      </div>
      <div class="stat-num">{{ $stats['hero_slides'] }}</div>
      <div class="stat-lbl">Hero Slides</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="stat-icon"><i class="bi bi-envelope-open-fill"></i></div>
        <span style="font-size:11px;color:#888;">Total</span>
      </div>
      <div class="stat-num">{{ $stats['total_inquiries'] }}</div>
      <div class="stat-lbl">Total Inquiries</div>
    </div>
  </div>
</div>

<!-- Quick Links -->
<div class="row g-3 mb-4">
  <div class="col-12">
    <div class="table-card p-3">
      <h6 class="fw-600 text-muted mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:1px;">Quick Actions</h6>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-sm btn-mahua"><i class="bi bi-plus me-1"></i>Add Room</a>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-mahua"><i class="bi bi-plus me-1"></i>Add Gallery Image</a>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-mahua"><i class="bi bi-plus me-1"></i>Add Testimonial</a>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-mahua"><i class="bi bi-plus me-1"></i>New Blog Post</a>
        <a href="{{ route('admin.offers.index') }}" class="btn btn-sm btn-mahua"><i class="bi bi-plus me-1"></i>Add Offer</a>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-gold"><i class="bi bi-envelope me-1"></i>View Inquiries</a>
      </div>
    </div>
  </div>
</div>

<!-- Recent Inquiries -->
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-envelope-fill me-2" style="color:#DAA520"></i>Recent Inquiries</h5>
    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-mahua">View All</a>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Name</th><th>Contact</th><th>Type</th><th>Message</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
        @forelse($recentInquiries as $inq)
        <tr>
          <td><strong>{{ $inq->name }}</strong></td>
          <td style="font-size:12px;">{{ $inq->email ?: $inq->phone ?: '—' }}</td>
          <td><span class="badge bg-secondary text-capitalize" style="font-size:11px;">{{ $inq->type }}</span></td>
          <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $inq->message }}</td>
          <td>
            @if($inq->status === 'new') <span class="badge-active">New</span>
            @elseif($inq->status === 'read') <span class="badge" style="background:rgba(13,110,253,.1);color:#0d6efd;font-size:11px;padding:3px 10px;border-radius:20px;">Read</span>
            @else <span class="badge-inactive">{{ ucfirst($inq->status) }}</span>
            @endif
          </td>
          <td style="font-size:12px;">{{ $inq->created_at->format('d M, H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No inquiries yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Events — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-calendar-event-fill me-2" style="color:#DAA520;"></i>Events — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage all five content areas of the Events page from one place.</p>
  </div>
  <a href="{{ url('/events') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="evTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item">
    <a class="nav-link active" href="#tab-events" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-calendar-check me-1"></i>Event Types <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $eventTypes->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-venues" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-building me-1"></i>Venues <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $venues->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-features" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-check-circle me-1"></i>Why Host <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $features->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-gallery" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-images me-1"></i>Gallery <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $gallery->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span>
    </a>
  </li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — EVENT TYPES ════ --}}
  <div class="tab-pane fade show active" id="tab-events">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">These are the overlay cards in the <strong>"What We Host"</strong> section. Each needs an image, title, description, icon (Font Awesome), and a tag/badge label.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExpForm('event-type','Event Type',createEventTypeUrl)">
          <i class="bi bi-plus-lg me-1"></i>Add Event Type
        </button>
      </div>
      @include('admin.events._experience-table', ['items' => $eventTypes, 'updateRoute' => 'events-admin.event-types.update', 'deleteRoute' => 'events-admin.event-types.destroy', 'jsEdit' => 'editExp'])
    </div>
  </div>

  {{-- ════ TAB 2 — VENUES ════ --}}
  <div class="tab-pane fade" id="tab-venues">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">These venue cards appear in the <strong>"Choose Your Forest Setting"</strong> section. Image, title, description, icon and badge label (shown as venue type).</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExpForm('venue','Venue',createVenueUrl)">
          <i class="bi bi-plus-lg me-1"></i>Add Venue
        </button>
      </div>
      @include('admin.events._experience-table', ['items' => $venues, 'updateRoute' => 'events-admin.venues.update', 'deleteRoute' => 'events-admin.venues.destroy', 'jsEdit' => 'editExp'])
    </div>
  </div>

  {{-- ════ TAB 3 — WHY HOST ════ --}}
  <div class="tab-pane fade" id="tab-features">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Feature list items in the <strong>"Why Host Here"</strong> section. Only icon, title and description — no image needed.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExpForm('why-host','Feature',createFeatureUrl)">
          <i class="bi bi-plus-lg me-1"></i>Add Feature
        </button>
      </div>
      @include('admin.events._experience-table', ['items' => $features, 'updateRoute' => 'events-admin.features.update', 'deleteRoute' => 'events-admin.features.destroy', 'jsEdit' => 'editExp'])
    </div>
  </div>

  {{-- ════ TAB 4 — GALLERY ════ --}}
  <div class="tab-pane fade" id="tab-gallery">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Photos shown in the <strong>Event Gallery</strong> grid (6 photos). First and last photos span two columns.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetGalleryForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Photo
        </button>
      </div>
      <div class="row g-3">
        @forelse($gallery as $item)
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
          <div style="border-radius:10px;overflow:hidden;border:1px solid #e0e8e0;background:#f8faf8;">
            <div style="height:120px;overflow:hidden;position:relative;">
              <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
              @if(!$item->is_active)<div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;"><span style="color:#fff;font-size:11px;font-weight:700;background:rgba(220,53,69,.8);padding:3px 8px;border-radius:4px;">HIDDEN</span></div>@endif
            </div>
            <div style="padding:8px 10px;">
              <p style="font-size:11px;font-weight:600;color:#033631;margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->title ?: 'Untitled' }}</p>
              <p style="font-size:10px;color:#aaa;margin:0 0 6px;">Order: {{ $item->sort_order }}</p>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary flex-fill" style="font-size:11px;padding:3px;" onclick='editGallery(@json($item))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.events-admin.gallery.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete this photo?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger flex-fill" style="font-size:11px;padding:3px;"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5"><i class="bi bi-images" style="font-size:36px;color:#ccc;display:block;margin-bottom:10px;"></i>No photos yet. Click "Add Photo".</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 5 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Edit all headings, labels, body text and images. HTML tags like <code>&lt;em&gt;</code> are supported in heading fields. The <code>steps</code> key uses a special pipe format (see below).</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetSectionForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Text Field
        </button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr><th>#</th><th>Key</th><th>Label</th><th>Value</th><th>Image</th><th>Order</th><th>Active</th><th>Actions</th></tr>
          </thead>
          <tbody>
            @forelse($sections as $i => $s)
            <tr>
              <td class="text-muted" style="font-size:11px;">{{ $i+1 }}</td>
              <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $s->section_key }}</code></td>
              <td style="font-size:13px;font-weight:500;white-space:nowrap;">{{ $s->label ?: '—' }}</td>
              <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 80) }}</td>
              <td>@if($s->media_url)<img src="{{ $s->media_url }}" style="width:44px;height:34px;object-fit:cover;border-radius:4px;">@else<span style="color:#ccc;font-size:12px;">—</span>@endif</td>
              <td>{{ $s->sort_order }}</td>
              <td><span class="{{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $s->is_active ? 'Yes' : 'No' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($s))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.events-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No text sections yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top:20px;background:#f8faf8;border-radius:10px;padding:16px 20px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Available Section Keys</p>
        <div style="display:flex;flex-wrap:wrap;gap:6px;font-size:11px;margin-bottom:12px;">
          @foreach(['hero_image','hero_label','hero_heading','hero_text','why_image','types_label','types_heading','types_text','why_label','why_heading','why_text','why_badge_title','why_badge_text','venues_label','venues_heading','gallery_label','gallery_heading','steps_label','steps_heading','form_label','form_heading','form_text','cta_label','cta_heading','cta_text','steps'] as $key)
          <code style="background:#e7eeee;padding:3px 8px;border-radius:4px;color:#033631;">{{ $key }}</code>
          @endforeach
        </div>
        <p style="margin:0;font-size:12px;color:#888;"><strong style="color:#033631;">steps key format</strong> — one step per line, fields separated by <code>|</code>:<br>
        <code style="background:#e7eeee;padding:4px 8px;border-radius:4px;display:inline-block;margin-top:4px;">Initial Enquiry|Call or fill our form with your event details.|fa-solid fa-phone</code></p>
      </div>
    </div>
  </div>

</div>

{{-- ═══════════════════ SHARED EXPERIENCE MODAL ═══════════════════ --}}
<div class="modal fade" id="expModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="expForm">
      @csrf <input type="hidden" name="_method" id="exp_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="exp_title">Add Item</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">

          <div class="col-md-8">
            <label class="form-label">Title *</label>
            <input type="text" name="title" id="exp_name" class="form-control" required placeholder="e.g. Destination Weddings">
          </div>
          <div class="col-md-4">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" id="exp_order" class="form-control" value="0">
          </div>

          <div class="col-md-6">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="exp_icon" class="form-control" placeholder="fa-solid fa-heart">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="exp_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tag / Badge <small class="text-muted">(label on card)</small></label>
            <input type="text" name="link" id="exp_link" class="form-control" placeholder="e.g. Most Popular, Grand Venue">
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="exp_desc" class="form-control" rows="2" placeholder="Short description shown on the card..."></textarea>
          </div>

          <div class="col-12">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="exp_img" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload
                <input type="file" accept="image/*" style="display:none"
                  onchange="uploadImage(this, document.getElementById('exp_img_preview'), document.getElementById('exp_img'))">
              </label>
            </div>
            <img id="exp_img_preview" class="img-preview" style="display:none">
          </div>

          <div class="col-12 d-flex flex-wrap gap-4 align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="exp_active" checked><label class="form-check-label" for="exp_active">Active</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" id="exp_featured"><label class="form-check-label" for="exp_featured">Featured</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ═══════════════════ GALLERY MODAL ═══════════════════ --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="galleryForm">
      @csrf <input type="hidden" name="_method" id="g_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="g_title">Add Gallery Photo</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Photo Title</label><input type="text" name="title" id="g_name" class="form-control" placeholder="e.g. Wedding Reception"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="g_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Photo *</label>
            <div class="input-group">
              <input type="text" name="image_url" id="g_url" class="form-control" placeholder="/site/assets/images/..." required>
              <label class="btn btn-outline-secondary mb-0">Upload
                <input type="file" accept="image/*" style="display:none"
                  onchange="uploadImage(this, document.getElementById('g_preview'), document.getElementById('g_url'))">
              </label>
            </div>
            <img id="g_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="g_active" checked><label class="form-check-label" for="g_active">Active</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Photo</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- ═══════════════════ PAGE SECTION MODAL ═══════════════════ --}}
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="s_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="s_title">Add Text Field</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Section Key *</label>
            <input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_heading">
            <small class="text-muted">Lowercase with underscores.</small>
          </div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Heading"></div>
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML allowed in headings)</small></label><textarea name="value" id="s_value" class="form-control" rows="5" placeholder="Text content..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for hero_image / why_image)</small></label>
            <div class="input-group">
              <input type="text" name="media_url" id="s_media" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload
                <input type="file" accept="image/*" style="display:none"
                  onchange="uploadImage(this, document.getElementById('s_media_preview'), document.getElementById('s_media'))">
              </label>
            </div>
            <img id="s_media_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="s_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="s_active" checked><label class="form-check-label" for="s_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Text Field</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
const createEventTypeUrl = "{{ route('admin.events-admin.event-types.store') }}";
const createVenueUrl     = "{{ route('admin.events-admin.venues.store') }}";
const createFeatureUrl   = "{{ route('admin.events-admin.features.store') }}";
const createGalleryUrl   = "{{ route('admin.events-admin.gallery.store') }}";
const createSectionUrl   = "{{ route('admin.events-admin.sections.store') }}";

// ── Restore active tab from URL hash ────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) {
    const tab = document.querySelector(`[href="${hash}"]`);
    if (tab) new bootstrap.Tab(tab).show();
  }
  document.querySelectorAll('#evTabs .nav-link').forEach(link => {
    link.addEventListener('click', function () {
      history.replaceState(null, '', this.getAttribute('href'));
    });
  });
});

document.getElementById('exp_icon').addEventListener('input', function () {
  document.getElementById('exp_icon_preview').className = this.value;
});

// ── Shared Experience modal ──────────────────────────────────────────────────
function resetExpForm(type, label, createUrl) {
  document.getElementById('expForm').action = createUrl;
  document.getElementById('exp_method').value = 'POST';
  document.getElementById('exp_title').textContent = 'Add ' + label;
  ['exp_name','exp_icon','exp_link','exp_desc','exp_img'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('exp_order').value = 0;
  document.getElementById('exp_active').checked = true;
  document.getElementById('exp_featured').checked = false;
  document.getElementById('exp_img_preview').style.display = 'none';
  document.getElementById('exp_icon_preview').className = '';
}

function editExp(item, updateUrl, label) {
  document.getElementById('expForm').action = updateUrl;
  document.getElementById('exp_method').value = 'PUT';
  document.getElementById('exp_title').textContent = 'Edit ' + label;
  document.getElementById('exp_name').value = item.title || '';
  document.getElementById('exp_icon').value = item.icon || '';
  document.getElementById('exp_link').value = item.link || '';
  document.getElementById('exp_desc').value = item.description || '';
  document.getElementById('exp_img').value = item.image_url || '';
  document.getElementById('exp_order').value = item.sort_order || 0;
  document.getElementById('exp_active').checked = item.is_active == 1;
  document.getElementById('exp_featured').checked = item.is_featured == 1;
  document.getElementById('exp_icon_preview').className = item.icon || '';
  const prev = document.getElementById('exp_img_preview');
  if (item.image_url) { prev.src = item.image_url; prev.style.display = 'block'; } else { prev.style.display = 'none'; }
  new bootstrap.Modal(document.getElementById('expModal')).show();
}

// ── Gallery helpers ──────────────────────────────────────────────────────────
function resetGalleryForm() {
  document.getElementById('galleryForm').action = createGalleryUrl;
  document.getElementById('g_method').value = 'POST';
  document.getElementById('g_title').textContent = 'Add Gallery Photo';
  ['g_name','g_url'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('g_order').value = 0;
  document.getElementById('g_active').checked = true;
  document.getElementById('g_preview').style.display = 'none';
}
function editGallery(g) {
  document.getElementById('galleryForm').action = `/admin/events-admin/gallery/${g.id}`;
  document.getElementById('g_method').value = 'PUT';
  document.getElementById('g_title').textContent = 'Edit Gallery Photo';
  document.getElementById('g_name').value = g.title || '';
  document.getElementById('g_url').value = g.image_url || '';
  document.getElementById('g_order').value = g.sort_order || 0;
  document.getElementById('g_active').checked = g.is_active == 1;
  const prev = document.getElementById('g_preview');
  if (g.image_url) { prev.src = g.image_url; prev.style.display = 'block'; } else { prev.style.display = 'none'; }
  new bootstrap.Modal(document.getElementById('galleryModal')).show();
}

// ── Section helpers ──────────────────────────────────────────────────────────
function resetSectionForm() {
  document.getElementById('sectionForm').action = createSectionUrl;
  document.getElementById('s_method').value = 'POST';
  document.getElementById('s_title').textContent = 'Add Text Field';
  ['s_key','s_label','s_value','s_media'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('s_order').value = 0;
  document.getElementById('s_active').checked = true;
  document.getElementById('s_media_preview').style.display = 'none';
  document.getElementById('s_key').removeAttribute('readonly');
}
function editSection(s) {
  document.getElementById('sectionForm').action = `/admin/events-admin/sections/${s.id}`;
  document.getElementById('s_method').value = 'PUT';
  document.getElementById('s_title').textContent = 'Edit Text Field';
  document.getElementById('s_key').value = s.section_key || '';
  document.getElementById('s_key').setAttribute('readonly', true);
  document.getElementById('s_label').value = s.label || '';
  document.getElementById('s_value').value = s.value || '';
  document.getElementById('s_media').value = s.media_url || '';
  document.getElementById('s_order').value = s.sort_order || 0;
  document.getElementById('s_active').checked = s.is_active == 1;
  const prev = document.getElementById('s_media_preview');
  if (s.media_url) { prev.src = s.media_url; prev.style.display = 'block'; } else { prev.style.display = 'none'; }
  new bootstrap.Modal(document.getElementById('sectionModal')).show();
}
</script>
@endsection

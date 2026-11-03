@extends('layouts.admin')
@section('title', 'Spaces — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-layout-three-columns me-2" style="color:#DAA520;"></i>Spaces — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage venue cards, gallery photos and all page text for the Spaces page.</p>
  </div>
  <a href="{{ url('/spaces') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="spTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-venues" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-grid me-1"></i>Venues <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $venues->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-gallery" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-camera me-1"></i>Gallery <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $gallery->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — VENUES ════ --}}
  <div class="tab-pane fade show active" id="tab-venues">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Venue cards shown in the <strong>"Find Your Perfect Space"</strong> grid. Description format: <code>SUBTITLE---DESCRIPTION---USE1&lt;newline&gt;USE2</code>. Check <em>Featured</em> for the dark exclusive-style card.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#venueModal" onclick="resetVenue()"><i class="bi bi-plus-lg me-1"></i>Add Venue</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Image</th><th>Title</th><th>Badge Label</th><th>Cap Icon</th><th>Description</th><th>Order</th><th>Featured</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($venues as $v)
            <tr>
              <td>@if($v->image_url)<img src="{{ $v->image_url }}" class="table-img">@else<div style="width:52px;height:40px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>@endif</td>
              <td><strong>{{ $v->title }}</strong></td>
              <td><span class="badge bg-warning text-dark" style="font-size:11px;">{{ $v->link ?: '—' }}</span></td>
              <td><i class="{{ $v->icon ?: 'fa-solid fa-leaf' }}" style="font-size:16px;color:#DAA520;"></i></td>
              <td style="max-width:200px;font-size:12px;color:#555;">{{ Str::limit($v->description, 70) }}</td>
              <td>{{ $v->sort_order }}</td>
              <td>@if($v->is_featured)<span class="badge-active">Yes</span>@else<span style="font-size:11px;color:#aaa;">—</span>@endif</td>
              <td><span class="{{ $v->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $v->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editVenue(@json($v))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.spaces-admin.venues.destroy', $v) }}" style="display:inline" onsubmit="return confirm('Delete this venue?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center text-muted py-4">No venues yet. Add your first venue above.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top:18px;background:#f8faf8;border-radius:10px;padding:14px 18px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 6px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Description Format</p>
        <code style="font-size:11px;color:#555;">Open-Air Chaupal---A traditional open-air chaupal...---Mehendi Ceremony&lt;newline&gt;Small Family Functions&lt;newline&gt;Group Gatherings</code>
        <p style="margin:6px 0 0;font-size:11px;color:#888;">Three parts separated by <strong>---</strong>: subtitle, main description, then uses (one per line).</p>
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — GALLERY ════ --}}
  <div class="tab-pane fade" id="tab-gallery">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Photos shown in the <strong>"Our Venues in Pictures"</strong> gallery (max 5 displayed). First photo spans two rows.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetGallery()"><i class="bi bi-plus-lg me-1"></i>Add Photo</button>
      </div>
      <div class="row g-3">
        @forelse($gallery as $item)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div style="background:#f8faf8;border-radius:12px;overflow:hidden;border:1px solid #e0e8e0;">
            <div style="height:140px;overflow:hidden;">
              <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div style="padding:10px 12px;">
              <p style="margin:0 0 2px;font-size:13px;font-weight:600;color:#033631;">{{ $item->title ?: '(no title)' }}</p>
              <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px;">
                <span class="{{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                <span style="font-size:11px;color:#aaa;">Order: {{ $item->sort_order }}</span>
              </div>
              <div class="d-flex gap-2 mt-2">
                <button class="btn btn-sm btn-outline-primary flex-grow-1" onclick='editGallery(@json($item))'><i class="bi bi-pencil"></i> Edit</button>
                <form method="POST" action="{{ route('admin.spaces-admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete photo?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No gallery photos yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 3 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, labels, intro images, and text blocks. HTML allowed in heading fields.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetSection()"><i class="bi bi-plus-lg me-1"></i>Add Text Field</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>#</th><th>Key</th><th>Label</th><th>Value</th><th>Image</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($sections as $i => $s)
            <tr>
              <td class="text-muted" style="font-size:11px;">{{ $i+1 }}</td>
              <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $s->section_key }}</code></td>
              <td style="font-size:13px;font-weight:500;white-space:nowrap;">{{ $s->label ?: '—' }}</td>
              <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 80) }}</td>
              <td>@if($s->media_url)<img src="{{ $s->media_url }}" style="width:44px;height:34px;object-fit:cover;border-radius:4px;">@else<span style="color:#ccc;">—</span>@endif</td>
              <td>{{ $s->sort_order }}</td>
              <td><span class="{{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $s->is_active ? 'Yes' : 'No' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($s))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.spaces-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No text fields yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div style="margin-top:20px;background:#f8faf8;border-radius:10px;padding:16px 20px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Available Keys</p>
        <div style="display:flex;flex-wrap:wrap;gap:5px;font-size:11px;">
          @foreach(['meta_title','meta_description','meta_keywords','hero_image','hero_label','hero_heading','hero_text','hero_cta1','hero_cta2','stats_strip','intro_label','intro_heading','intro_text1','intro_text2','intro_tags','intro_img1','intro_img2','intro_img3','vedika_label','vedika_heading','vedika_image','vedika_desc','vedika_amenities','vedika_cta','grid_label','grid_heading','grid_text','gallery_label','gallery_heading','gallery_cta','form_label','form_heading','sidebar_title','sidebar_items','included_title','included_items','cta_label','cta_heading','cta_text','breadcrumb'] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Venue Modal --}}
<div class="modal fade" id="venueModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="venueForm">
      @csrf <input type="hidden" name="_method" id="v_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="v_title">Add Venue</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Venue Name *</label><input type="text" name="title" id="v_name" class="form-control" required placeholder="e.g. Chaupal-e-Mahua"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="v_order" class="form-control" value="0"></div>
          <div class="col-md-6">
            <label class="form-label">Badge Label <small class="text-muted">(shown on card)</small></label>
            <input type="text" name="link" id="v_badge" class="form-control" placeholder="e.g. Intimate, Cultural, Premium">
          </div>
          <div class="col-md-6">
            <label class="form-label">Cap Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="v_icon" class="form-control" placeholder="fa-solid fa-leaf">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="v_icon_preview" style="font-size:18px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12">
            <label class="form-label">Description <small class="text-muted">Format: SUBTITLE---DESCRIPTION---USE1&lt;newline&gt;USE2</small></label>
            <textarea name="description" id="v_desc" class="form-control" rows="5" placeholder="Open-Air Chaupal---A traditional open-air chaupal — intimate and warm...---Mehendi Ceremony&#10;Small Family Functions&#10;Group Gatherings"></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="v_img" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('v_preview'),document.getElementById('v_img'))"></label>
            </div>
            <img id="v_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex gap-4">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="v_active" checked><label class="form-check-label" for="v_active">Active</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" id="v_featured"><label class="form-check-label" for="v_featured">Featured (dark card style)</label></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Venue</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Gallery Modal --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="galleryForm">
      @csrf <input type="hidden" name="_method" id="g_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="g_title">Add Gallery Photo</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Alt Text / Title</label><input type="text" name="title" id="g_name" class="form-control" placeholder="e.g. Grand Lawn"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="g_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Image *</label>
            <div class="input-group">
              <input type="text" name="image_url" id="g_img" class="form-control" placeholder="/site/assets/images/..." required>
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('g_preview'),document.getElementById('g_img'))"></label>
            </div>
            <img id="g_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="g_active" checked><label class="form-check-label" for="g_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Photo</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Page Section Modal --}}
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="s_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="s_title">Add Text Field</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Key *</label><input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_heading"><small class="text-muted">Lowercase with underscores.</small></div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Heading"></div>
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML OK in heading fields)</small></label><textarea name="value" id="s_value" class="form-control" rows="4"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for image keys like hero_image, intro_img1)</small></label>
            <div class="input-group">
              <input type="text" name="media_url" id="s_media" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('s_prev'),document.getElementById('s_media'))"></label>
            </div>
            <img id="s_prev" class="img-preview" style="display:none">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="s_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="s_active" checked><label class="form-check-label" for="s_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
const createVenueUrl   = "{{ route('admin.spaces-admin.venues.store') }}";
const createGalleryUrl = "{{ route('admin.spaces-admin.gallery.store') }}";
const createSectionUrl = "{{ route('admin.spaces-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#spTabs .nav-link').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

document.getElementById('v_icon').addEventListener('input', function(){ document.getElementById('v_icon_preview').className = this.value; });

function resetVenue() {
  document.getElementById('venueForm').action = createVenueUrl;
  document.getElementById('v_method').value = 'POST';
  document.getElementById('v_title').textContent = 'Add Venue';
  ['v_name','v_badge','v_icon','v_desc','v_img'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('v_order').value = 0;
  document.getElementById('v_active').checked = true;
  document.getElementById('v_featured').checked = false;
  document.getElementById('v_icon_preview').className = '';
  document.getElementById('v_preview').style.display = 'none';
}
function editVenue(v) {
  document.getElementById('venueForm').action = `/admin/spaces-admin/venues/${v.id}`;
  document.getElementById('v_method').value = 'PUT';
  document.getElementById('v_title').textContent = 'Edit Venue';
  document.getElementById('v_name').value = v.title || '';
  document.getElementById('v_badge').value = v.link || '';
  document.getElementById('v_icon').value = v.icon || '';
  document.getElementById('v_desc').value = v.description || '';
  document.getElementById('v_img').value = v.image_url || '';
  document.getElementById('v_order').value = v.sort_order || 0;
  document.getElementById('v_active').checked = v.is_active == 1;
  document.getElementById('v_featured').checked = v.is_featured == 1;
  document.getElementById('v_icon_preview').className = v.icon || '';
  const p = document.getElementById('v_preview');
  if (v.image_url) { p.src = v.image_url; p.style.display = 'block'; } else p.style.display = 'none';
  new bootstrap.Modal(document.getElementById('venueModal')).show();
}

function resetGallery() {
  document.getElementById('galleryForm').action = createGalleryUrl;
  document.getElementById('g_method').value = 'POST';
  document.getElementById('g_title').textContent = 'Add Gallery Photo';
  ['g_name','g_img'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('g_order').value = 0;
  document.getElementById('g_active').checked = true;
  document.getElementById('g_preview').style.display = 'none';
}
function editGallery(item) {
  document.getElementById('galleryForm').action = `/admin/spaces-admin/gallery/${item.id}`;
  document.getElementById('g_method').value = 'PUT';
  document.getElementById('g_title').textContent = 'Edit Gallery Photo';
  document.getElementById('g_name').value = item.title || '';
  document.getElementById('g_img').value = item.image_url || '';
  document.getElementById('g_order').value = item.sort_order || 0;
  document.getElementById('g_active').checked = item.is_active == 1;
  const p = document.getElementById('g_preview');
  if (item.image_url) { p.src = item.image_url; p.style.display = 'block'; } else p.style.display = 'none';
  new bootstrap.Modal(document.getElementById('galleryModal')).show();
}

function resetSection() {
  document.getElementById('sectionForm').action = createSectionUrl;
  document.getElementById('s_method').value = 'POST';
  document.getElementById('s_title').textContent = 'Add Text Field';
  ['s_key','s_label','s_value','s_media'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('s_order').value = 0;
  document.getElementById('s_active').checked = true;
  document.getElementById('s_prev').style.display = 'none';
  document.getElementById('s_key').removeAttribute('readonly');
}
function editSection(s) {
  document.getElementById('sectionForm').action = `/admin/spaces-admin/sections/${s.id}`;
  document.getElementById('s_method').value = 'PUT';
  document.getElementById('s_title').textContent = 'Edit Text Field';
  document.getElementById('s_key').value = s.section_key || '';
  document.getElementById('s_key').setAttribute('readonly', true);
  document.getElementById('s_label').value = s.label || '';
  document.getElementById('s_value').value = s.value || '';
  document.getElementById('s_media').value = s.media_url || '';
  document.getElementById('s_order').value = s.sort_order || 0;
  document.getElementById('s_active').checked = s.is_active == 1;
  const prev = document.getElementById('s_prev');
  if (s.media_url) { prev.src = s.media_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('sectionModal')).show();
}
</script>
@endsection

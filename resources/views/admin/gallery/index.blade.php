@extends('layouts.admin')
@section('title', 'Photo Gallery — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-camera-fill me-2" style="color:#DAA520;"></i>Photo Gallery — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage gallery photos (with categories for filtering) and all page text.</p>
  </div>
  <a href="{{ url('/gallery') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="galTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-photos" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-images me-1"></i>Photos <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $items->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — PHOTOS ════ --}}
  <div class="tab-pane fade show active" id="tab-photos">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Each photo needs an image URL and a <strong>category</strong> — this powers the filter tabs on the public gallery page.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetForm()"><i class="bi bi-plus-lg me-1"></i>Add Image</button>
      </div>

      {{-- Group by category --}}
      @php $grouped = $items->groupBy('category'); @endphp
      @forelse($grouped as $cat => $catItems)
      <div style="margin-bottom:28px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
          <span style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#033631;">{{ ucwords(str_replace(['-','_'], ' ', $cat)) }}</span>
          <span class="badge bg-secondary" style="font-size:10px;">{{ $catItems->count() }}</span>
          <div style="flex:1;height:1px;background:#e8ede8;"></div>
        </div>
        <div class="row g-2">
          @foreach($catItems as $item)
          <div class="col-6 col-md-3 col-lg-2">
            <div class="position-relative" style="border-radius:10px;overflow:hidden;aspect-ratio:1;background:#f0f0f0;">
              <img src="{{ $item->image_url }}" style="width:100%;height:100%;object-fit:cover;" alt="{{ $item->title }}">
              <div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;opacity:0;transition:.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                <button class="btn btn-sm btn-light py-1 px-2" onclick='editGallery(@json($item))' style="font-size:11px;"><i class="bi bi-pencil"></i> Edit</button>
                <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Remove this image?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger py-1 px-2" style="font-size:11px;"><i class="bi bi-trash"></i> Delete</button>
                </form>
              </div>
              @if(!$item->is_active)
              <span style="position:absolute;top:4px;left:4px;background:rgba(220,53,69,.8);color:#fff;font-size:9px;padding:2px 6px;border-radius:4px;">Hidden</span>
              @endif
            </div>
            <p style="font-size:11px;color:#666;margin:4px 0 0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $item->title }}">{{ $item->title ?: 'Untitled' }}</p>
            <p style="font-size:10px;color:#aaa;margin:0;">Order: {{ $item->sort_order }}</p>
          </div>
          @endforeach
        </div>
      </div>
      @empty
      <div class="text-center text-muted py-5">No gallery images yet. Add your first photo above.</div>
      @endforelse
    </div>
  </div>

  {{-- ════ TAB 2 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Control hero text, stats strip, section headings, CTA copy and background images.</p>
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
                <form method="POST" action="{{ route('admin.gallery.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
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
          @foreach(['meta_title','meta_description','meta_keywords','hero_image','hero_label','hero_heading','hero_text','stats_strip','gallery_label','gallery_heading','gallery_text','cta_label','cta_heading','cta_text','cta_bg_image'] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
        <p style="margin:10px 0 0;font-size:11px;color:#888;"><strong>stats_strip</strong> format: <code>3.5|Acres of Forest</code> — one stat per line, number|label separated by pipe.</p>
      </div>
    </div>
  </div>

</div>

{{-- ═══ PHOTO MODAL ═══ --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="galleryForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Gallery Image</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-12">
            <label class="form-label">Image *</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" required placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('imgPreview'),document.getElementById('image_url'))"></label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none">
          </div>
          <div class="col-md-6"><label class="form-label">Title / Alt Text</label><input type="text" name="title" id="title" class="form-control" placeholder="e.g. Forest Wedding Ceremony"></div>
          <div class="col-md-6">
            <label class="form-label">Category <small class="text-muted">(controls filter tab)</small></label>
            <select name="category" id="category" class="form-select">
              <option value="general">General</option>
              <option value="nature">Nature & Forest</option>
              <option value="rooms">Rooms & Stay</option>
              <option value="events">Weddings & Events</option>
              <option value="activities">Activities</option>
              <option value="dining">Dining</option>
              <option value="corporate">Corporate</option>
              <option value="spaces">Spaces & Venues</option>
              <option value="wedding">Wedding</option>
              <option value="day-out">Day Out</option>
              <option value="property">Property</option>
            </select>
          </div>
          <div class="col-md-6"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-6 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Visible on website</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Image</button></div>
      </div>
    </form>
  </div>
</div>

{{-- ═══ PAGE SECTION MODAL ═══ --}}
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="s_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="s_title">Add Text Field</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Key *</label><input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_heading"><small class="text-muted">Lowercase with underscores.</small></div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Heading"></div>
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML allowed in heading fields; use newlines for stats_strip)</small></label><textarea name="value" id="s_value" class="form-control" rows="4"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for hero_image, cta_bg_image)</small></label>
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
const createUrl        = "{{ route('admin.gallery.store') }}";
const createSectionUrl = "{{ route('admin.gallery.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#galTabs .nav-link').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

function resetForm() {
  document.getElementById('galleryForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Gallery Image';
  document.getElementById('image_url').value = '';
  document.getElementById('title').value = '';
  document.getElementById('category').value = 'general';
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('imgPreview').style.display = 'none';
}
function editGallery(g) {
  document.getElementById('galleryForm').action = `/admin/gallery/${g.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Gallery Image';
  document.getElementById('image_url').value = g.image_url || '';
  document.getElementById('title').value = g.title || '';
  document.getElementById('category').value = g.category || 'general';
  document.getElementById('sort_order').value = g.sort_order || 0;
  document.getElementById('is_active').checked = g.is_active == 1;
  const prev = document.getElementById('imgPreview');
  if (g.image_url) { prev.src = g.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
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
  document.getElementById('sectionForm').action = `/admin/gallery/sections/${s.id}`;
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

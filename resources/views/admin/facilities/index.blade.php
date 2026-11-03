@extends('layouts.admin')
@section('title', 'Facilities — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-building-check me-2" style="color:#DAA520;"></i>Facilities — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage facility cards and page text for the Facilities page.</p>
  </div>
  <a href="{{ url('/facilities') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="facTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-facilities" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-grid me-1"></i>Facility Cards <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $facilities->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — FACILITY CARDS ════ --}}
  <div class="tab-pane fade show active" id="tab-facilities">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Each card has an icon image, a title, and a list of bullet items (one per line in the Description field).</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#facilityModal" onclick="resetFacility()"><i class="bi bi-plus-lg me-1"></i>Add Facility</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Icon</th><th>Title</th><th>Items (preview)</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($facilities as $f)
            @php $items = array_filter(array_map('trim', explode("\n", $f->description ?? ''))); @endphp
            <tr>
              <td>
                @if($f->image_url)
                  <img src="{{ $f->image_url }}" style="width:44px;height:44px;object-fit:contain;border-radius:6px;background:#f0f4f0;padding:4px;">
                @else
                  <div style="width:44px;height:44px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>
                @endif
              </td>
              <td><strong>{{ $f->title }}</strong></td>
              <td style="max-width:260px;font-size:12px;color:#555;">
                @if($items)
                  {{ implode(' · ', array_slice($items, 0, 3)) }}{{ count($items) > 3 ? ' …' : '' }}
                @else <span class="text-muted">—</span> @endif
              </td>
              <td>{{ $f->sort_order }}</td>
              <td><span class="{{ $f->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $f->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editFacility(@json($f))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.facilities-admin.facilities.destroy', $f) }}" style="display:inline" onsubmit="return confirm('Delete this facility card?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No facility cards yet. Add your first one above.<br><small>If none exist, the page falls back to the default hardcoded cards.</small></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top:18px;background:#f8faf8;border-radius:10px;padding:14px 18px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 6px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Description Format</p>
        <code style="font-size:11px;color:#555;">Swimming Pool&lt;newline&gt;Rain Dance with Sound System&lt;newline&gt;Badminton, Basketball, Volleyball</code>
        <p style="margin:6px 0 0;font-size:11px;color:#888;">One bullet-list item per line. No separator needed — just press Enter between items.</p>
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Control the page title, breadcrumb label, section heading, sub-label and hero/breadcrumb image.</p>
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
                <form method="POST" action="{{ route('admin.facilities-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
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
          @foreach(['meta_title','meta_description','meta_keywords','hero_image','page_title','breadcrumb','section_label','section_heading'] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Facility Card Modal --}}
<div class="modal fade" id="facilityModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="facilityForm">
      @csrf <input type="hidden" name="_method" id="f_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="f_title">Add Facility</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Facility Name *</label><input type="text" name="title" id="f_name" class="form-control" required placeholder="e.g. Sports & Activities"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="f_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Bullet List Items <small class="text-muted">(one item per line)</small></label>
            <textarea name="description" id="f_desc" class="form-control" rows="5" placeholder="Swimming Pool&#10;Rain Dance with Sound System&#10;Badminton, Basketball, Volleyball&#10;Cricket, Table Tennis, Chess"></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Icon Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="f_img" class="form-control" placeholder="/site/assets/images/facilities/icon-facilities-1.png">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('f_preview'),document.getElementById('f_img'))"></label>
            </div>
            <img id="f_preview" class="img-preview" style="display:none">
            <small class="text-muted">You can also type a path like <code>/site/assets/images/facilities/icon-facilities-2.png</code></small>
          </div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="f_active" checked><label class="form-check-label" for="f_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Facility</button></div>
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
          <div class="col-md-6"><label class="form-label">Key *</label><input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. section_heading"><small class="text-muted">Lowercase with underscores.</small></div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Section Heading"></div>
          <div class="col-12"><label class="form-label">Value</label><textarea name="value" id="s_value" class="form-control" rows="3"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for hero_image key)</small></label>
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
const createFacilityUrl = "{{ route('admin.facilities-admin.facilities.store') }}";
const createSectionUrl  = "{{ route('admin.facilities-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#facTabs .nav-link').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

function resetFacility() {
  document.getElementById('facilityForm').action = createFacilityUrl;
  document.getElementById('f_method').value = 'POST';
  document.getElementById('f_title').textContent = 'Add Facility';
  ['f_name','f_desc','f_img'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('f_order').value = 0;
  document.getElementById('f_active').checked = true;
  document.getElementById('f_preview').style.display = 'none';
}
function editFacility(f) {
  document.getElementById('facilityForm').action = `/admin/facilities-admin/facilities/${f.id}`;
  document.getElementById('f_method').value = 'PUT';
  document.getElementById('f_title').textContent = 'Edit Facility';
  document.getElementById('f_name').value = f.title || '';
  document.getElementById('f_desc').value = f.description || '';
  document.getElementById('f_img').value = f.image_url || '';
  document.getElementById('f_order').value = f.sort_order || 0;
  document.getElementById('f_active').checked = f.is_active == 1;
  const p = document.getElementById('f_preview');
  if (f.image_url) { p.src = f.image_url; p.style.display = 'block'; } else p.style.display = 'none';
  new bootstrap.Modal(document.getElementById('facilityModal')).show();
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
  document.getElementById('sectionForm').action = `/admin/facilities-admin/sections/${s.id}`;
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

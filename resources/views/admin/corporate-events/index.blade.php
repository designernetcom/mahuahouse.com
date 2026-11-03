@extends('layouts.admin')
@section('title', 'Corporate Events — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-briefcase-fill me-2" style="color:#DAA520;"></i>Corporate Events — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage Why-Choose features, activity cards, and all page text for the Corporate Events page.</p>
  </div>
  <a href="{{ url('/corporate-events') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="ceTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item">
    <a class="nav-link active" href="#tab-features" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-check-circle me-1"></i>Why Choose Features <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $features->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-activities" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-lightning-charge me-1"></i>Activities <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $activities->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span>
    </a>
  </li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — WHY CHOOSE FEATURES ════ --}}
  <div class="tab-pane fade show active" id="tab-features">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">These appear in the <strong>"Why Choose Mahua House"</strong> feature list. Each needs an icon, title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExp('feature', createFeatureUrl)">
          <i class="bi bi-plus-lg me-1"></i>Add Feature
        </button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($features as $f)
            <tr>
              <td>
                <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.07);display:flex;align-items:center;justify-content:center;">
                  <i class="{{ $f->icon ?: 'fa-solid fa-star' }}" style="font-size:18px;color:#033631;"></i>
                </div>
              </td>
              <td><strong>{{ $f->title }}</strong></td>
              <td style="max-width:300px;font-size:12px;color:#555;">{{ Str::limit($f->description, 90) }}</td>
              <td>{{ $f->sort_order }}</td>
              <td><span class="{{ $f->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $f->is_active ? 'Active' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editExp(@json($f),"/admin/corporate-events-admin/features/"+{{ $f->id }},"feature")'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.corporate-events-admin.features.destroy', $f) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No features yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — ACTIVITIES ════ --}}
  <div class="tab-pane fade" id="tab-activities">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">These hover cards appear in the <strong>"Activities for Your Team or Group"</strong> grid. Each needs an icon, title, and short description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExp('activity', createActivityUrl)">
          <i class="bi bi-plus-lg me-1"></i>Add Activity
        </button>
      </div>
      <div class="row g-3">
        @forelse($activities as $act)
        <div class="col-lg-4 col-md-6">
          <div style="background:#f8faf8;border:1px solid #e0e8e0;border-radius:12px;padding:18px;display:flex;gap:14px;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="{{ $act->icon ?: 'fa-solid fa-star' }}" style="font-size:20px;color:#DAA520;"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <strong style="font-size:14px;color:#033631;">{{ $act->title }}</strong>
                <span class="{{ $act->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $act->is_active ? 'On' : 'Off' }}</span>
                <span style="font-size:11px;color:#aaa;margin-left:auto;">{{ $act->sort_order }}</span>
              </div>
              <p style="font-size:12px;color:#666;margin:0 0 10px;">{{ Str::limit($act->description, 80) }}</p>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" onclick='editExp(@json($act),"/admin/corporate-events-admin/activities/"+{{ $act->id }},"activity")'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.corporate-events-admin.activities.destroy', $act) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No activities yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 3 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, labels, images, and text blocks. Category card items use newline-separated lists. HTML allowed in heading fields.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetSection()">
          <i class="bi bi-plus-lg me-1"></i>Add Text Field
        </button>
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
                <form method="POST" action="{{ route('admin.corporate-events-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">
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
        <p style="margin:0 0 8px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Available Keys</p>
        <div style="display:flex;flex-wrap:wrap;gap:5px;font-size:11px;margin-bottom:10px;">
          @foreach(['hero_image','hero_label','hero_heading','hero_text','hero_cta1','hero_cta2','cats_label','cats_heading','cats_text','cat1_icon','cat1_title','cat1_subtitle','cat1_items','cat2_icon','cat2_title','cat2_subtitle','cat2_items','cat3_icon','cat3_title','cat3_subtitle','cat3_items','why_image','why_label','why_heading','why_badge_icon','why_badge_title','why_badge_sub','act_label','act_heading','act_text','edu_label','edu_heading','edu_text','edu_image','edu_items','edu_badge','edu_cta','film_image','film_badge','film_label','film_heading','film_text','film_cta','film_c1_icon','film_c1_title','film_c1_sub','film_c2_icon','film_c2_title','film_c2_sub','film_c3_icon','film_c3_title','film_c3_sub','film_c4_icon','film_c4_title','film_c4_sub','form_label','form_heading','form_text','cta_label','cta_heading','cta_text'] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
        <p style="margin:0;font-size:12px;color:#888;"><strong style="color:#033631;">cat*_items</strong> — one item per line (e.g. <code>cat1_items</code>): each line becomes a bullet point in the category card.</p>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Shared Experience Modal --}}
<div class="modal fade" id="expModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="expForm">
      @csrf <input type="hidden" name="_method" id="e_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="e_title">Add Item</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="e_name" class="form-control" required placeholder="e.g. Adjoining Reserved Forest"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="e_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="e_icon" class="form-control" placeholder="fa-solid fa-tree">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="e_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="e_desc" class="form-control" rows="3" placeholder="Description text..."></textarea></div>
          <div class="col-12 d-flex align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="e_active" checked><label class="form-check-label" for="e_active">Active</label></div>
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

{{-- Page Section Modal --}}
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="s_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="s_title">Add Text Field</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Section Key *</label><input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_heading"><small class="text-muted">Lowercase with underscores.</small></div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Heading"></div>
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML allowed in headings; newline-separated for list items)</small></label><textarea name="value" id="s_value" class="form-control" rows="6" placeholder="Content..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for image fields)</small></label>
            <div class="input-group">
              <input type="text" name="media_url" id="s_media" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('s_prev'),document.getElementById('s_media'))"></label>
            </div>
            <img id="s_prev" class="img-preview" style="display:none">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="s_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="s_active" checked><label class="form-check-label" for="s_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
const createFeatureUrl  = "{{ route('admin.corporate-events-admin.features.store') }}";
const createActivityUrl = "{{ route('admin.corporate-events-admin.activities.store') }}";
const createSectionUrl  = "{{ route('admin.corporate-events-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#ceTabs .nav-link').forEach(l => l.addEventListener('click', function() { history.replaceState(null,'',this.getAttribute('href')); }));
});

document.getElementById('e_icon').addEventListener('input', function () { document.getElementById('e_icon_preview').className = this.value; });

function resetExp(type, url) {
  document.getElementById('expForm').action = url;
  document.getElementById('e_method').value = 'POST';
  document.getElementById('e_title').textContent = 'Add ' + (type === 'feature' ? 'Feature' : 'Activity');
  ['e_name','e_icon','e_desc'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('e_order').value = 0;
  document.getElementById('e_active').checked = true;
  document.getElementById('e_icon_preview').className = '';
}
function editExp(item, url, type) {
  document.getElementById('expForm').action = url;
  document.getElementById('e_method').value = 'PUT';
  document.getElementById('e_title').textContent = 'Edit ' + (type === 'feature' ? 'Feature' : 'Activity');
  document.getElementById('e_name').value = item.title || '';
  document.getElementById('e_icon').value = item.icon || '';
  document.getElementById('e_desc').value = item.description || '';
  document.getElementById('e_order').value = item.sort_order || 0;
  document.getElementById('e_active').checked = item.is_active == 1;
  document.getElementById('e_icon_preview').className = item.icon || '';
  new bootstrap.Modal(document.getElementById('expModal')).show();
}

function resetSection() {
  document.getElementById('sectionForm').action = createSectionUrl;
  document.getElementById('s_method').value = 'POST';
  document.getElementById('s_title').textContent = 'Add Text Field';
  ['s_key','s_label','s_value','s_media'].forEach(id => { const el = document.getElementById(id); if(el) el.value=''; });
  document.getElementById('s_order').value = 0;
  document.getElementById('s_active').checked = true;
  document.getElementById('s_prev').style.display = 'none';
  document.getElementById('s_key').removeAttribute('readonly');
}
function editSection(s) {
  document.getElementById('sectionForm').action = `/admin/corporate-events-admin/sections/${s.id}`;
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
  if (s.media_url) { prev.src = s.media_url; prev.style.display = 'block'; } else { prev.style.display = 'none'; }
  new bootstrap.Modal(document.getElementById('sectionModal')).show();
}
</script>
@endsection

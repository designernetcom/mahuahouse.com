@extends('layouts.admin')
@section('title', 'Film Shoots — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-camera-reels-fill me-2" style="color:#DAA520;"></i>Film Shoots — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage shoot type cards, location features, trust badges and all page text.</p>
  </div>
  <a href="{{ url('/film-shoots') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="fsTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-types" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-film me-1"></i>Shoot Types <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $shootTypes->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-location" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-geo-alt me-1"></i>Location Features <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $locationFeatures->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-trust" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-shield-check me-1"></i>Trust Badges <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $trustBadges->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — SHOOT TYPES ════ --}}
  <div class="tab-pane fade show active" id="tab-types">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Cards in the <strong>"Productions We Welcome"</strong> section. Each has an image, tag/badge label, icon, title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#typeModal" onclick="resetType()"><i class="bi bi-plus-lg me-1"></i>Add Type</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Image</th><th>Title</th><th>Tag/Badge</th><th>Icon</th><th>Description</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($shootTypes as $t)
            <tr>
              <td>@if($t->image_url)<img src="{{ $t->image_url }}" class="table-img">@else<div style="width:52px;height:40px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>@endif</td>
              <td><strong>{{ $t->title }}</strong></td>
              <td><span class="badge bg-secondary" style="font-size:11px;">{{ $t->link ?: '—' }}</span></td>
              <td><i class="{{ $t->icon }}" style="font-size:18px;color:#DAA520;"></i></td>
              <td style="max-width:200px;font-size:12px;color:#555;">{{ Str::limit($t->description, 60) }}</td>
              <td>{{ $t->sort_order }}</td>
              <td><span class="{{ $t->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $t->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editType(@json($t))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.film-shoots-admin.shoot-types.destroy', $t) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No shoot types yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — LOCATION FEATURES ════ --}}
  <div class="tab-pane fade" id="tab-location">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Feature list items in the <strong>"Why Mahua House is a Filmmaker's Choice"</strong> section. Each needs an icon, title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#locModal" onclick="resetLoc()"><i class="bi bi-plus-lg me-1"></i>Add Feature</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($locationFeatures as $f)
            <tr>
              <td><div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.07);display:flex;align-items:center;justify-content:center;"><i class="{{ $f->icon ?: 'fa-solid fa-check' }}" style="font-size:18px;color:#033631;"></i></div></td>
              <td><strong>{{ $f->title }}</strong></td>
              <td style="max-width:300px;font-size:12px;color:#555;">{{ Str::limit($f->description, 80) }}</td>
              <td>{{ $f->sort_order }}</td>
              <td><span class="{{ $f->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $f->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editLoc(@json($f))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.film-shoots-admin.location-features.destroy', $f) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No location features yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 3 — TRUST BADGES ════ --}}
  <div class="tab-pane fade" id="tab-trust">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Dark badge cards in the <strong>"Everything Your Production Needs"</strong> section. Each needs an icon, title, and short description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#trustModal" onclick="resetTrust()"><i class="bi bi-plus-lg me-1"></i>Add Badge</button>
      </div>
      <div class="row g-3">
        @forelse($trustBadges as $badge)
        <div class="col-lg-6">
          <div style="background:#033631;border-radius:12px;padding:18px;display:flex;gap:14px;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="{{ $badge->icon ?: 'fa-solid fa-star' }}" style="font-size:20px;color:#DAA520;"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <strong style="font-size:14px;color:#fff;">{{ $badge->title }}</strong>
                <span class="{{ $badge->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $badge->is_active ? 'On' : 'Off' }}</span>
                <span style="font-size:11px;color:rgba(255,255,255,.4);margin-left:auto;">{{ $badge->sort_order }}</span>
              </div>
              <p style="font-size:12px;color:rgba(255,255,255,.55);margin:0 0 10px;">{{ Str::limit($badge->description, 80) }}</p>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-light" onclick='editTrust(@json($badge))'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.film-shoots-admin.trust-badges.destroy', $badge) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button></form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No trust badges yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 4 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, labels, images, and text. HTML allowed in heading fields.</p>
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
                <form method="POST" action="{{ route('admin.film-shoots-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
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
        <div style="display:flex;flex-wrap:wrap;gap:5px;font-size:11px;">
          @foreach(['hero_image','hero_label','hero_heading','hero_text','hero_cta1','hero_cta2','types_label','types_heading','types_text','loc_image','loc_badge_icon','loc_badge_title','loc_badge_sub','loc_label','loc_heading','trust_label','trust_heading','form_label','form_heading','form_text','cta_label','cta_heading','cta_text'] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Shoot Type Modal --}}
<div class="modal fade" id="typeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="typeForm">
      @csrf <input type="hidden" name="_method" id="ty_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="ty_title">Add Shoot Type</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="ty_name" class="form-control" required placeholder="e.g. Film Shoots"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="ty_order" class="form-control" value="0"></div>
          <div class="col-md-6">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="ty_icon" class="form-control" placeholder="fa-solid fa-film">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="ty_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-md-6"><label class="form-label">Tag / Badge Label</label><input type="text" name="link" id="ty_link" class="form-control" placeholder="e.g. Narrative, Cultural, Photography"></div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="ty_desc" class="form-control" rows="2" placeholder="Short description..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="ty_img" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('ty_preview'),document.getElementById('ty_img'))"></label>
            </div>
            <img id="ty_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="ty_active" checked><label class="form-check-label" for="ty_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Location Feature Modal --}}
<div class="modal fade" id="locModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="locForm">
      @csrf <input type="hidden" name="_method" id="lc_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="lc_title">Add Location Feature</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="lc_name" class="form-control" required placeholder="e.g. Quiet Environment"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="lc_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="lc_icon" class="form-control" placeholder="fa-solid fa-volume-xmark">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="lc_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="lc_desc" class="form-control" rows="3" placeholder="Description..."></textarea></div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="lc_active" checked><label class="form-check-label" for="lc_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Trust Badge Modal --}}
<div class="modal fade" id="trustModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="trustForm">
      @csrf <input type="hidden" name="_method" id="tr_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="tr_title">Add Trust Badge</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="tr_name" class="form-control" required placeholder="e.g. Authentic Forest"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="tr_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="tr_icon" class="form-control" placeholder="fa-solid fa-tree">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="tr_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="tr_desc" class="form-control" rows="3" placeholder="Short description..."></textarea></div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="tr_active" checked><label class="form-check-label" for="tr_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
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
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control"></div>
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML OK in headings)</small></label><textarea name="value" id="s_value" class="form-control" rows="4"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL</label>
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
const createTypeUrl    = "{{ route('admin.film-shoots-admin.shoot-types.store') }}";
const createLocUrl     = "{{ route('admin.film-shoots-admin.location-features.store') }}";
const createTrustUrl   = "{{ route('admin.film-shoots-admin.trust-badges.store') }}";
const createSectionUrl = "{{ route('admin.film-shoots-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#fsTabs .nav-link').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

document.getElementById('ty_icon').addEventListener('input', function(){ document.getElementById('ty_icon_preview').className = this.value; });
document.getElementById('lc_icon').addEventListener('input', function(){ document.getElementById('lc_icon_preview').className = this.value; });
document.getElementById('tr_icon').addEventListener('input', function(){ document.getElementById('tr_icon_preview').className = this.value; });

function resetType() { document.getElementById('typeForm').action=createTypeUrl; document.getElementById('ty_method').value='POST'; document.getElementById('ty_title').textContent='Add Shoot Type'; ['ty_name','ty_icon','ty_link','ty_desc','ty_img'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('ty_order').value=0; document.getElementById('ty_active').checked=true; document.getElementById('ty_icon_preview').className=''; document.getElementById('ty_preview').style.display='none'; }
function editType(t) { document.getElementById('typeForm').action=`/admin/film-shoots-admin/shoot-types/${t.id}`; document.getElementById('ty_method').value='PUT'; document.getElementById('ty_title').textContent='Edit Shoot Type'; document.getElementById('ty_name').value=t.title||''; document.getElementById('ty_icon').value=t.icon||''; document.getElementById('ty_link').value=t.link||''; document.getElementById('ty_desc').value=t.description||''; document.getElementById('ty_img').value=t.image_url||''; document.getElementById('ty_order').value=t.sort_order||0; document.getElementById('ty_active').checked=t.is_active==1; document.getElementById('ty_icon_preview').className=t.icon||''; const p=document.getElementById('ty_preview'); if(t.image_url){p.src=t.image_url;p.style.display='block';}else p.style.display='none'; new bootstrap.Modal(document.getElementById('typeModal')).show(); }

function resetLoc() { document.getElementById('locForm').action=createLocUrl; document.getElementById('lc_method').value='POST'; document.getElementById('lc_title').textContent='Add Location Feature'; ['lc_name','lc_icon','lc_desc'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('lc_order').value=0; document.getElementById('lc_active').checked=true; document.getElementById('lc_icon_preview').className=''; }
function editLoc(f) { document.getElementById('locForm').action=`/admin/film-shoots-admin/location-features/${f.id}`; document.getElementById('lc_method').value='PUT'; document.getElementById('lc_title').textContent='Edit Location Feature'; document.getElementById('lc_name').value=f.title||''; document.getElementById('lc_icon').value=f.icon||''; document.getElementById('lc_desc').value=f.description||''; document.getElementById('lc_order').value=f.sort_order||0; document.getElementById('lc_active').checked=f.is_active==1; document.getElementById('lc_icon_preview').className=f.icon||''; new bootstrap.Modal(document.getElementById('locModal')).show(); }

function resetTrust() { document.getElementById('trustForm').action=createTrustUrl; document.getElementById('tr_method').value='POST'; document.getElementById('tr_title').textContent='Add Trust Badge'; ['tr_name','tr_icon','tr_desc'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('tr_order').value=0; document.getElementById('tr_active').checked=true; document.getElementById('tr_icon_preview').className=''; }
function editTrust(b) { document.getElementById('trustForm').action=`/admin/film-shoots-admin/trust-badges/${b.id}`; document.getElementById('tr_method').value='PUT'; document.getElementById('tr_title').textContent='Edit Trust Badge'; document.getElementById('tr_name').value=b.title||''; document.getElementById('tr_icon').value=b.icon||''; document.getElementById('tr_desc').value=b.description||''; document.getElementById('tr_order').value=b.sort_order||0; document.getElementById('tr_active').checked=b.is_active==1; document.getElementById('tr_icon_preview').className=b.icon||''; new bootstrap.Modal(document.getElementById('trustModal')).show(); }

function resetSection() { document.getElementById('sectionForm').action=createSectionUrl; document.getElementById('s_method').value='POST'; document.getElementById('s_title').textContent='Add Text Field'; ['s_key','s_label','s_value','s_media'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('s_order').value=0; document.getElementById('s_active').checked=true; document.getElementById('s_prev').style.display='none'; document.getElementById('s_key').removeAttribute('readonly'); }
function editSection(s) { document.getElementById('sectionForm').action=`/admin/film-shoots-admin/sections/${s.id}`; document.getElementById('s_method').value='PUT'; document.getElementById('s_title').textContent='Edit Text Field'; document.getElementById('s_key').value=s.section_key||''; document.getElementById('s_key').setAttribute('readonly',true); document.getElementById('s_label').value=s.label||''; document.getElementById('s_value').value=s.value||''; document.getElementById('s_media').value=s.media_url||''; document.getElementById('s_order').value=s.sort_order||0; document.getElementById('s_active').checked=s.is_active==1; const prev=document.getElementById('s_prev'); if(s.media_url){prev.src=s.media_url;prev.style.display='block';}else prev.style.display='none'; new bootstrap.Modal(document.getElementById('sectionModal')).show(); }
</script>
@endsection

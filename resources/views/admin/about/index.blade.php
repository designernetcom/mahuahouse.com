@extends('layouts.admin')
@section('title', 'About Us — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-info-circle-fill me-2" style="color:#DAA520;"></i>About Us — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage experience cards, page text, and links to stats/values/testimonials/gallery managers.</p>
  </div>
  <a href="{{ url('/about') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

{{-- Quick links to related admins --}}
<div style="background:#f8faf8;border-radius:12px;padding:14px 18px;margin-bottom:20px;border:1px solid #e0e8e0;display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
  <span style="font-size:12px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:1px;">Related Admins:</span>
  <a href="{{ route('admin.stats.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-bar-chart-fill me-1"></i>Stats & Numbers</a>
  <a href="{{ route('admin.why-choose.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-check-circle-fill me-1"></i>Values (Why Choose Us)</a>
  <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-chat-quote-fill me-1"></i>Testimonials</a>
  <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-camera-fill me-1"></i>Photo Strip (Gallery)</a>
</div>

<ul class="nav nav-tabs mb-0" id="aboutTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-exp" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-stars me-1"></i>Experience Cards <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $experiences->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — EXPERIENCE CARDS ════ --}}
  <div class="tab-pane fade show active" id="tab-exp">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Cards in the <strong>"Experiences That Stay With You"</strong> section. Each has an image, Font Awesome icon, title, and short description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#expModal" onclick="resetExp()"><i class="bi bi-plus-lg me-1"></i>Add Experience</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Image</th><th>Title</th><th>Icon</th><th>Description</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($experiences as $exp)
            <tr>
              <td>@if($exp->image_url)<img src="{{ $exp->image_url }}" class="table-img">@else<div style="width:52px;height:40px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>@endif</td>
              <td><strong>{{ $exp->title }}</strong></td>
              <td><i class="{{ $exp->icon ?: 'fa-solid fa-star' }}" style="font-size:18px;color:#DAA520;"></i></td>
              <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit($exp->description, 80) }}</td>
              <td>{{ $exp->sort_order }}</td>
              <td><span class="{{ $exp->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $exp->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editExp(@json($exp))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.about-admin.experiences.destroy', $exp) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No experience cards yet.<br><small>When empty, the page falls back to the original 5 hardcoded cards.</small></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, body text, images, and list content for every section of the About Us page.</p>
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
                <form method="POST" action="{{ route('admin.about-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
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
          @foreach([
            'meta_title','meta_description','meta_keywords',
            'hero_image','hero_label','hero_heading','hero_text','breadcrumb',
            'story_label','story_heading','story_text1','story_text2','story_text3',
            'story_img1','story_img2','story_img3','founded_year','founded_label',
            'story_list','story_btn1','story_btn2',
            'values_label','values_heading','values_text',
            'property_image','property_label','property_heading','property_text','property_stats','property_cta',
            'exp_label','exp_heading',
            'photo_label','photo_heading','photo_cta',
            'testi_label','testi_heading',
            'rules_label','rules_heading','rules_title','house_rules',
            'philosophy_title','philosophy_text1','philosophy_text2','philosophy_tags',
            'cta_label','cta_heading','cta_text',
          ] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
        <div style="margin-top:10px;font-size:11px;color:#888;">
          <strong>story_list</strong>: one bullet per line &nbsp;|&nbsp;
          <strong>property_stats</strong>: <code>icon|value|label</code> one per line &nbsp;|&nbsp;
          <strong>house_rules</strong>: <code>icon|text</code> one per line &nbsp;|&nbsp;
          <strong>philosophy_tags</strong>: one tag per line
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ═══ EXPERIENCE MODAL ═══ --}}
<div class="modal fade" id="expModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="expForm">
      @csrf <input type="hidden" name="_method" id="e_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="e_title">Add Experience</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="e_name" class="form-control" required placeholder="e.g. Forest Treks"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="e_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="e_icon" class="form-control" placeholder="fa-solid fa-person-hiking">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="e_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description <small class="text-muted">(shown on hover)</small></label><textarea name="description" id="e_desc" class="form-control" rows="3" placeholder="Short description visible on hover..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Card Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="e_img" class="form-control" placeholder="/site/assets/images/about/35.jpeg">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('e_preview'),document.getElementById('e_img'))"></label>
            </div>
            <img id="e_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="e_active" checked><label class="form-check-label" for="e_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Experience</button></div>
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
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML OK in headings; use newlines for list fields)</small></label><textarea name="value" id="s_value" class="form-control" rows="5"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for image keys)</small></label>
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
const createExpUrl     = "{{ route('admin.about-admin.experiences.store') }}";
const createSectionUrl = "{{ route('admin.about-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#aboutTabs .nav-link').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

document.getElementById('e_icon').addEventListener('input', function(){ document.getElementById('e_icon_preview').className = this.value; });

function resetExp() {
  document.getElementById('expForm').action = createExpUrl;
  document.getElementById('e_method').value = 'POST';
  document.getElementById('e_title').textContent = 'Add Experience';
  ['e_name','e_icon','e_desc','e_img'].forEach(id => { const el = document.getElementById(id); if(el) el.value=''; });
  document.getElementById('e_order').value = 0;
  document.getElementById('e_active').checked = true;
  document.getElementById('e_icon_preview').className = '';
  document.getElementById('e_preview').style.display = 'none';
}
function editExp(e) {
  document.getElementById('expForm').action = `/admin/about-admin/experiences/${e.id}`;
  document.getElementById('e_method').value = 'PUT';
  document.getElementById('e_title').textContent = 'Edit Experience';
  document.getElementById('e_name').value = e.title || '';
  document.getElementById('e_icon').value = e.icon || '';
  document.getElementById('e_desc').value = e.description || '';
  document.getElementById('e_img').value = e.image_url || '';
  document.getElementById('e_order').value = e.sort_order || 0;
  document.getElementById('e_active').checked = e.is_active == 1;
  document.getElementById('e_icon_preview').className = e.icon || '';
  const p = document.getElementById('e_preview');
  if (e.image_url) { p.src = e.image_url; p.style.display = 'block'; } else p.style.display = 'none';
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
  document.getElementById('sectionForm').action = `/admin/about-admin/sections/${s.id}`;
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

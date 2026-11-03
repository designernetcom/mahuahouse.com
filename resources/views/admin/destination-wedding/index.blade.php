@extends('layouts.admin')
@section('title', 'Destination Wedding — Manage Content')

@section('content')

{{-- Page header --}}
<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-heart-fill me-2" style="color:#DAA520;"></i>Destination Wedding — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage all content sections of the Destination Wedding page from one place.</p>
  </div>
  <a href="{{ url('/destination-wedding') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-0" id="dwTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item">
    <a class="nav-link {{ session('_fragment') !== 'tab-features' && session('_fragment') !== 'tab-timeline' && session('_fragment') !== 'tab-gallery' ? 'active' : '' }}"
       href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-file-earmark-text me-1"></i>Page Text
      <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ session('_fragment') === 'tab-features' ? 'active' : '' }}"
       href="#tab-features" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-grid me-1"></i>Why Choose Us
      <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $features->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ session('_fragment') === 'tab-timeline' ? 'active' : '' }}"
       href="#tab-timeline" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-list-ol me-1"></i>Planning Steps
      <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $steps->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ session('_fragment') === 'tab-gallery' ? 'active' : '' }}"
       href="#tab-gallery" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-images me-1"></i>Gallery Photos
      <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $gallery->count() }}</span>
    </a>
  </li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════════════════════════════════ TAB 1 — PAGE TEXT ══════════════════════ --}}
  <div class="tab-pane fade {{ session('_fragment') !== 'tab-features' && session('_fragment') !== 'tab-timeline' && session('_fragment') !== 'tab-gallery' ? 'show active' : '' }}" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <p style="margin:0;font-size:13px;color:#666;">Edit hero text, intro paragraphs, section labels, images, and CTA wording. HTML tags like <code>&lt;em&gt;</code> are supported in heading fields.</p>
        </div>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetSectionForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Text Field
        </button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th style="width:40px;">#</th>
              <th>Key</th>
              <th>Label</th>
              <th>Value</th>
              <th>Image</th>
              <th>Order</th>
              <th>Active</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sections as $i => $s)
            <tr>
              <td class="text-muted" style="font-size:11px;">{{ $i+1 }}</td>
              <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $s->section_key }}</code></td>
              <td style="font-size:13px;font-weight:500;white-space:nowrap;">{{ $s->label ?: '—' }}</td>
              <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 80) }}</td>
              <td>
                @if($s->media_url)
                  <img src="{{ $s->media_url }}" style="width:44px;height:34px;object-fit:cover;border-radius:4px;">
                @else
                  <span style="color:#ccc;font-size:12px;">—</span>
                @endif
              </td>
              <td>{{ $s->sort_order }}</td>
              <td><span class="{{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $s->is_active ? 'Yes' : 'No' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($s))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.destination-wedding.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete this text field?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No text sections yet. Click "Add Text Field" to create one.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Section key reference --}}
      <div style="margin-top:20px;background:#f8faf8;border-radius:10px;padding:16px 20px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Available Section Keys</p>
        <div style="display:flex;flex-wrap:wrap;gap:6px;font-size:11px;">
          @foreach([
            'hero_image','hero_label','hero_title','hero_subtitle',
            'intro_label','intro_heading','intro_description','intro_image_main','intro_image_badge','intro_years_num','intro_years_text',
            'venue_checklist',
            'why_label','why_heading',
            'gallery_label','gallery_heading','gallery_cta_text',
            'process_label','process_heading','process_description','process_cta_text',
            'cta_label','cta_heading','cta_description',
          ] as $key)
          <code style="background:#e7eeee;padding:3px 8px;border-radius:4px;color:#033631;">{{ $key }}</code>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- ════════════════════════════════ TAB 2 — FEATURES ══════════════════════ --}}
  <div class="tab-pane fade {{ session('_fragment') === 'tab-features' ? 'show active' : '' }}" id="tab-features">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">These cards appear in the <strong>"Why Mahua House"</strong> section. Use a Font Awesome class for the icon (e.g. <code>fa-solid fa-tree</code>).</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#featureModal" onclick="resetFeatureForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Card
        </button>
      </div>
      <div class="row g-3 mb-3">
        @forelse($features as $f)
        <div class="col-lg-6">
          <div style="background:#f8faf8;border:1px solid #e0e8e0;border-radius:12px;padding:18px;display:flex;gap:14px;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(3,54,49,0.07);border:1px solid rgba(3,54,49,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="{{ $f->icon ?: 'fa-solid fa-star' }}" style="font-size:20px;color:#033631;"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <strong style="font-size:14px;color:#033631;">{{ $f->title }}</strong>
                <span class="{{ $f->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $f->is_active ? 'Active' : 'Off' }}</span>
                <span style="font-size:11px;color:#aaa;margin-left:auto;">Order: {{ $f->sort_order }}</span>
              </div>
              <p style="font-size:12px;color:#666;margin:0 0 10px;">{{ Str::limit($f->description, 100) }}</p>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" onclick='editFeature(@json($f))'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.destination-wedding.features.destroy', $f) }}" style="display:inline" onsubmit="return confirm('Delete this card?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No feature cards yet. Click "Add Card" to start.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════════════════════════════════ TAB 3 — TIMELINE ══════════════════════ --}}
  <div class="tab-pane fade {{ session('_fragment') === 'tab-timeline' ? 'show active' : '' }}" id="tab-timeline">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">These steps appear in the <strong>"How It Works"</strong> planning process section. Sort order = step number shown on site.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#stepModal" onclick="resetStepForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Step
        </button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr><th style="width:60px;">Step</th><th>Title</th><th>Description</th><th>Active</th><th>Actions</th></tr>
          </thead>
          <tbody>
            @forelse($steps as $step)
            <tr>
              <td>
                <div style="width:36px;height:36px;border-radius:50%;background:#DAA520;color:#033631;font-weight:800;display:flex;align-items:center;justify-content:center;font-size:14px;">
                  {{ $step->sort_order }}
                </div>
              </td>
              <td><strong>{{ $step->title }}</strong></td>
              <td style="font-size:12px;color:#666;max-width:320px;">{{ Str::limit($step->description, 100) }}</td>
              <td><span class="{{ $step->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $step->is_active ? 'Active' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editStep(@json($step))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.destination-wedding.steps.destroy', $step) }}" style="display:inline" onsubmit="return confirm('Delete this step?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No steps yet. Click "Add Step" to create your planning process.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════════════════════════════════ TAB 4 — GALLERY ═══════════════════════ --}}
  <div class="tab-pane fade {{ session('_fragment') === 'tab-gallery' ? 'show active' : '' }}" id="tab-gallery">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Photos shown in the <strong>Wedding Gallery</strong> grid on the destination-wedding page. First 5 active photos are displayed (sorted by order).</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetGalleryForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Photo
        </button>
      </div>
      <div class="row g-3">
        @forelse($gallery as $item)
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
          <div style="border-radius:10px;overflow:hidden;border:1px solid #e0e8e0;background:#f8faf8;">
            <div style="height:130px;overflow:hidden;position:relative;">
              <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
              @if(!$item->is_active)
              <div style="position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;">
                <span style="color:#fff;font-size:11px;font-weight:700;background:rgba(220,53,69,.8);padding:3px 8px;border-radius:4px;">HIDDEN</span>
              </div>
              @endif
            </div>
            <div style="padding:8px 10px;">
              <p style="font-size:11px;font-weight:600;color:#033631;margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->title ?: 'Untitled' }}</p>
              <p style="font-size:10px;color:#aaa;margin:0 0 6px;">Order: {{ $item->sort_order }}</p>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary flex-fill" style="font-size:11px;padding:3px;" onclick='editGallery(@json($item))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.destination-wedding.gallery.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete this photo?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger flex-fill" style="font-size:11px;padding:3px;"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
          <i class="bi bi-images" style="font-size:36px;color:#ccc;display:block;margin-bottom:10px;"></i>
          No wedding photos yet. Click "Add Photo" to upload your first one.
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>{{-- /tab-content --}}


{{-- ══════════════════════════════ MODALS ══════════════════════════════════════ --}}

{{-- Modal: Page Section --}}
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="s_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="s_title">Add Text Field</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Section Key *</label>
            <input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_title">
            <small class="text-muted">Lowercase, underscores only. See key list above.</small>
          </div>
          <div class="col-md-6">
            <label class="form-label">Label <small class="text-muted">(admin display name)</small></label>
            <input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Title">
          </div>
          <div class="col-12">
            <label class="form-label">Value <small class="text-muted">(HTML allowed for headings)</small></label>
            <textarea name="value" id="s_value" class="form-control" rows="4" placeholder="The text content to display on the page..."></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for image-type fields like hero_image)</small></label>
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
          <div class="col-md-8 d-flex align-items-end">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="s_active" checked><label class="form-check-label" for="s_active">Active</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Text Field</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal: Feature Card --}}
<div class="modal fade" id="featureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="featureForm">
      @csrf <input type="hidden" name="_method" id="f_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="f_title">Add Feature Card</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8">
            <label class="form-label">Title *</label>
            <input type="text" name="title" id="f_name" class="form-control" required placeholder="e.g. Forest Setting">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="f_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="f_icon" class="form-control" placeholder="fa-solid fa-tree">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="f_icon_preview" style="font-size:22px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="f_desc" class="form-control" rows="3" placeholder="Short description shown on the card..."></textarea>
          </div>
          <div class="col-12 d-flex align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="f_active" checked><label class="form-check-label" for="f_active">Active (visible on site)</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Card</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal: Timeline Step --}}
<div class="modal fade" id="stepModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="stepForm">
      @csrf <input type="hidden" name="_method" id="t_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="t_title">Add Planning Step</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-9">
            <label class="form-label">Step Title *</label>
            <input type="text" name="title" id="t_name" class="form-control" required placeholder="e.g. Initial Inquiry & Consultation">
          </div>
          <div class="col-md-3">
            <label class="form-label">Step # <small class="text-muted">(sort order)</small></label>
            <input type="number" name="sort_order" id="t_order" class="form-control" value="1" min="1">
          </div>
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="t_desc" class="form-control" rows="3" placeholder="What happens in this step..."></textarea>
          </div>
          <div class="col-12 d-flex align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="t_active" checked><label class="form-check-label" for="t_active">Active (visible on site)</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Step</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal: Gallery Photo --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="galleryForm">
      @csrf <input type="hidden" name="_method" id="g_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="g_title">Add Gallery Photo</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8">
            <label class="form-label">Photo Title <small class="text-muted">(alt text)</small></label>
            <input type="text" name="title" id="g_name" class="form-control" placeholder="e.g. Wedding Ceremony">
          </div>
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
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="g_active" checked><label class="form-check-label" for="g_active">Active (visible on site)</label></div>
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

@endsection

@section('scripts')
<script>
const createSectionUrl  = "{{ route('admin.destination-wedding.sections.store') }}";
const createFeatureUrl  = "{{ route('admin.destination-wedding.features.store') }}";
const createStepUrl     = "{{ route('admin.destination-wedding.steps.store') }}";
const createGalleryUrl  = "{{ route('admin.destination-wedding.gallery.store') }}";

// ── Restore active tab after form submit ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) {
    const tab = document.querySelector(`[href="${hash}"]`);
    if (tab) new bootstrap.Tab(tab).show();
  }
  // Activate tab links to keep hash in URL
  document.querySelectorAll('#dwTabs .nav-link').forEach(link => {
    link.addEventListener('click', function () {
      history.replaceState(null, '', this.getAttribute('href'));
    });
  });
});

// ── Icon preview ──────────────────────────────────────────────────────────────
document.getElementById('f_icon').addEventListener('input', function () {
  document.getElementById('f_icon_preview').className = this.value;
});

// ── Page Section helpers ──────────────────────────────────────────────────────
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
  document.getElementById('sectionForm').action = `/admin/destination-wedding/sections/${s.id}`;
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

// ── Feature helpers ───────────────────────────────────────────────────────────
function resetFeatureForm() {
  document.getElementById('featureForm').action = createFeatureUrl;
  document.getElementById('f_method').value = 'POST';
  document.getElementById('f_title').textContent = 'Add Feature Card';
  ['f_name','f_icon','f_desc'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('f_order').value = 0;
  document.getElementById('f_active').checked = true;
  document.getElementById('f_icon_preview').className = '';
}
function editFeature(f) {
  document.getElementById('featureForm').action = `/admin/destination-wedding/features/${f.id}`;
  document.getElementById('f_method').value = 'PUT';
  document.getElementById('f_title').textContent = 'Edit Feature Card';
  document.getElementById('f_name').value = f.title || '';
  document.getElementById('f_icon').value = f.icon || '';
  document.getElementById('f_desc').value = f.description || '';
  document.getElementById('f_order').value = f.sort_order || 0;
  document.getElementById('f_active').checked = f.is_active == 1;
  document.getElementById('f_icon_preview').className = f.icon || '';
  new bootstrap.Modal(document.getElementById('featureModal')).show();
}

// ── Timeline helpers ──────────────────────────────────────────────────────────
function resetStepForm() {
  document.getElementById('stepForm').action = createStepUrl;
  document.getElementById('t_method').value = 'POST';
  document.getElementById('t_title').textContent = 'Add Planning Step';
  ['t_name','t_desc'].forEach(id => { const el = document.getElementById(id); if(el) el.value = ''; });
  document.getElementById('t_order').value = 1;
  document.getElementById('t_active').checked = true;
}
function editStep(s) {
  document.getElementById('stepForm').action = `/admin/destination-wedding/steps/${s.id}`;
  document.getElementById('t_method').value = 'PUT';
  document.getElementById('t_title').textContent = 'Edit Planning Step';
  document.getElementById('t_name').value = s.title || '';
  document.getElementById('t_desc').value = s.description || '';
  document.getElementById('t_order').value = s.sort_order || 1;
  document.getElementById('t_active').checked = s.is_active == 1;
  new bootstrap.Modal(document.getElementById('stepModal')).show();
}

// ── Gallery helpers ───────────────────────────────────────────────────────────
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
  document.getElementById('galleryForm').action = `/admin/destination-wedding/gallery/${g.id}`;
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
</script>
@endsection

@extends('layouts.admin')
@section('title', 'Video Tours — Manage Content')

@section('content')

{{-- Page header --}}
<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-play-circle-fill me-2" style="color:#DAA520;"></i>Video Tours — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage all videos and page text for the Video Tours page. Videos use YouTube links — paste any YouTube URL or video ID.</p>
  </div>
  <a href="{{ url('/video-tours') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-0" id="vtTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item">
    <a class="nav-link {{ session('_fragment') !== 'tab-text' ? 'active' : '' }}"
       href="#tab-videos" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-play-btn me-1"></i>Videos
      <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $videos->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ session('_fragment') === 'tab-text' ? 'active' : '' }}"
       href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-file-earmark-text me-1"></i>Page Text
      <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span>
    </a>
  </li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════════════ TAB 1 — VIDEOS ════════════ --}}
  <div class="tab-pane fade {{ session('_fragment') !== 'tab-text' ? 'show active' : '' }}" id="tab-videos">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">
          Each video needs a <strong>YouTube URL or Video ID</strong> (e.g. <code>https://youtu.be/7uSIYukB8Rc</code> or just <code>7uSIYukB8Rc</code>).
          Leave thumbnail blank to auto-load from YouTube.
        </p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#videoModal" onclick="resetVideoForm()">
          <i class="bi bi-plus-lg me-1"></i>Add Video
        </button>
      </div>

      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th style="width:90px;">Thumbnail</th>
              <th>Title</th>
              <th>YouTube URL / ID</th>
              <th>Tag / Badge</th>
              <th>Order</th>
              <th>Featured</th>
              <th>Active</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($videos as $v)
            @php
              $ytId = '';
              $url = trim($v->link ?? '');
              if (preg_match('/^[A-Za-z0-9_-]{6,}$/', $url) && !str_contains($url, '/')) {
                  $ytId = $url;
              } elseif (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]+)/', $url, $m)) {
                  $ytId = $m[1];
              }
              $thumb = $v->image_url ?: ($ytId ? "https://img.youtube.com/vi/{$ytId}/mqdefault.jpg" : '');
            @endphp
            <tr>
              <td>
                @if($thumb)
                  <img src="{{ $thumb }}" style="width:80px;height:52px;object-fit:cover;border-radius:6px;border:1px solid #e0e8e0;">
                @else
                  <div style="width:80px;height:52px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-play-circle" style="font-size:20px;color:#ccc;"></i>
                  </div>
                @endif
              </td>
              <td><strong style="font-size:13px;">{{ $v->title }}</strong></td>
              <td style="max-width:180px;">
                <code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;word-break:break-all;">
                  {{ $ytId ?: Str::limit($v->link, 30) }}
                </code>
                @if($ytId)
                  <a href="https://youtu.be/{{ $ytId }}" target="_blank" class="ms-1" title="Open on YouTube" style="color:#DAA520;font-size:12px;"><i class="bi bi-youtube"></i></a>
                @endif
              </td>
              <td>
                @if($v->icon)
                  <span class="badge bg-secondary" style="font-size:11px;">{{ $v->icon }}</span>
                @else
                  <span style="color:#ccc;">—</span>
                @endif
              </td>
              <td>{{ $v->sort_order }}</td>
              <td>
                @if($v->is_featured)
                  <span class="badge-active">Yes</span>
                @else
                  <span style="font-size:12px;color:#aaa;">No</span>
                @endif
              </td>
              <td><span class="{{ $v->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $v->is_active ? 'Active' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editVideo(@json($v))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.video-tours.videos.destroy', $v) }}" style="display:inline" onsubmit="return confirm('Delete this video?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-5">
                <i class="bi bi-play-circle" style="font-size:36px;color:#ccc;display:block;margin-bottom:10px;"></i>
                No videos yet. Click "Add Video" to get started.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top:16px;background:#f8faf8;border-radius:10px;padding:14px 18px;border:1px solid #e0e8e0;font-size:12px;color:#666;">
        <strong style="color:#033631;"><i class="bi bi-info-circle me-1"></i>How videos work:</strong>
        The <strong>YouTube URL or ID</strong> field accepts: full URL (<code>https://www.youtube.com/watch?v=...</code>), short URL (<code>https://youtu.be/...</code>), embed URL, or just the video ID (<code>7uSIYukB8Rc</code>).
        The <strong>Tag</strong> field shows the badge label on the card (e.g. "Full Property Tour", "Weddings", "Accommodation Tour").
        The <strong>Featured</strong> flag marks the first video loaded in the featured player.
        Leave <strong>Thumbnail</strong> blank — it auto-loads from YouTube.
      </div>
    </div>
  </div>

  {{-- ════════════ TAB 2 — PAGE TEXT ════════════ --}}
  <div class="tab-pane fade {{ session('_fragment') === 'tab-text' ? 'show active' : '' }}" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Edit hero text, section headings, YouTube channel link, and CTA wording. HTML tags like <code>&lt;em&gt;</code> are supported in heading fields.</p>
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
              <td style="max-width:280px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 90) }}</td>
              <td>{{ $s->sort_order }}</td>
              <td><span class="{{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $s->is_active ? 'Yes' : 'No' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($s))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.video-tours.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete this text field?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No text sections yet. Click "Add Text Field" to create one.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Key reference --}}
      <div style="margin-top:20px;background:#f8faf8;border-radius:10px;padding:16px 20px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Available Section Keys</p>
        <div style="display:flex;flex-wrap:wrap;gap:6px;font-size:11px;">
          @foreach([
            'hero_image','hero_label','hero_heading','hero_text','breadcrumb',
            'featured_label','featured_heading',
            'grid_label','grid_heading','grid_text',
            'youtube_heading','youtube_text','youtube_url',
            'cta_label','cta_heading','cta_text',
          ] as $key)
          <code style="background:#e7eeee;padding:3px 8px;border-radius:4px;color:#033631;">{{ $key }}</code>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</div>{{-- /tab-content --}}


{{-- ══════════════════ MODALS ══════════════════ --}}

{{-- Modal: Add / Edit Video --}}
<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="videoForm">
      @csrf <input type="hidden" name="_method" id="v_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="v_title">Add Video</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">

          <div class="col-12">
            <label class="form-label">Video Title *</label>
            <input type="text" name="title" id="v_name" class="form-control" required placeholder="e.g. Discover Mahua House — The Nostalgic Woods">
          </div>

          <div class="col-12">
            <label class="form-label">YouTube URL or Video ID *</label>
            <input type="text" name="link" id="v_link" class="form-control" required
              placeholder="https://www.youtube.com/watch?v=7uSIYukB8Rc  or just  7uSIYukB8Rc"
              oninput="previewYtThumb(this.value)">
            <small class="text-muted">Accepts full URL, short URL (youtu.be), or bare video ID.</small>
          </div>

          <div class="col-md-8">
            <label class="form-label">Tag / Badge Label <small class="text-muted">(shown on card)</small></label>
            <input type="text" name="icon" id="v_icon" class="form-control" placeholder="e.g. Full Property Tour, Weddings, Accommodation Tour">
          </div>
          <div class="col-md-4">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" id="v_order" class="form-control" value="0">
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="v_desc" class="form-control" rows="2" placeholder="Short description shown below the video card..."></textarea>
          </div>

          <div class="col-12">
            <label class="form-label">Custom Thumbnail <small class="text-muted">(leave blank to auto-load from YouTube)</small></label>
            <div class="input-group">
              <input type="text" name="image_url" id="v_thumb" class="form-control" placeholder="/site/assets/images/... or leave blank">
              <label class="btn btn-outline-secondary mb-0">Upload
                <input type="file" accept="image/*" style="display:none"
                  onchange="uploadImage(this, document.getElementById('v_thumb_preview'), document.getElementById('v_thumb'))">
              </label>
            </div>
            <img id="v_thumb_preview" class="img-preview" style="display:none">
          </div>

          <div class="col-12">
            <div class="d-flex gap-4 flex-wrap">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" id="v_active" checked>
                <label class="form-check-label" for="v_active">Active (visible on site)</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_featured" id="v_featured">
                <label class="form-check-label" for="v_featured">Featured (loads first in player)</label>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Video</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal: Add / Edit Page Section --}}
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
            <small class="text-muted">Lowercase with underscores. See key list above.</small>
          </div>
          <div class="col-md-6">
            <label class="form-label">Label <small class="text-muted">(admin display name)</small></label>
            <input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Heading">
          </div>
          <div class="col-12">
            <label class="form-label">Value <small class="text-muted">(HTML allowed for headings)</small></label>
            <textarea name="value" id="s_value" class="form-control" rows="4" placeholder="Text content shown on the page..."></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for hero_image field)</small></label>
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

@endsection

@section('scripts')
<script>
const createVideoUrl   = "{{ route('admin.video-tours.videos.store') }}";
const createSectionUrl = "{{ route('admin.video-tours.sections.store') }}";

// ── Restore active tab from URL hash ────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) {
    const tab = document.querySelector(`[href="${hash}"]`);
    if (tab) new bootstrap.Tab(tab).show();
  }
  document.querySelectorAll('#vtTabs .nav-link').forEach(link => {
    link.addEventListener('click', function () {
      history.replaceState(null, '', this.getAttribute('href'));
    });
  });
});

// ── YouTube ID extractor ────────────────────────────────────────────────────
function extractYtId(val) {
  val = val.trim();
  if (/^[A-Za-z0-9_-]{6,}$/.test(val) && !val.includes('/')) return val;
  const m = val.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]+)/);
  return m ? m[1] : '';
}

function previewYtThumb(val) {
  const id = extractYtId(val);
  const prev = document.getElementById('v_thumb_preview');
  const thumbInput = document.getElementById('v_thumb');
  if (id && !thumbInput.value) {
    prev.src = 'https://img.youtube.com/vi/' + id + '/mqdefault.jpg';
    prev.style.display = 'block';
  }
}

// ── Video modal helpers ─────────────────────────────────────────────────────
function resetVideoForm() {
  document.getElementById('videoForm').action = createVideoUrl;
  document.getElementById('v_method').value = 'POST';
  document.getElementById('v_title').textContent = 'Add Video';
  ['v_name','v_link','v_icon','v_desc','v_thumb'].forEach(id => {
    const el = document.getElementById(id); if (el) el.value = '';
  });
  document.getElementById('v_order').value = 0;
  document.getElementById('v_active').checked = true;
  document.getElementById('v_featured').checked = false;
  document.getElementById('v_thumb_preview').style.display = 'none';
}

function editVideo(v) {
  document.getElementById('videoForm').action = `/admin/video-tours/videos/${v.id}`;
  document.getElementById('v_method').value = 'PUT';
  document.getElementById('v_title').textContent = 'Edit Video';
  document.getElementById('v_name').value = v.title || '';
  document.getElementById('v_link').value = v.link || '';
  document.getElementById('v_icon').value = v.icon || '';
  document.getElementById('v_desc').value = v.description || '';
  document.getElementById('v_thumb').value = v.image_url || '';
  document.getElementById('v_order').value = v.sort_order || 0;
  document.getElementById('v_active').checked = v.is_active == 1;
  document.getElementById('v_featured').checked = v.is_featured == 1;
  const prev = document.getElementById('v_thumb_preview');
  const ytId = extractYtId(v.link || '');
  const thumb = v.image_url || (ytId ? 'https://img.youtube.com/vi/' + ytId + '/mqdefault.jpg' : '');
  if (thumb) { prev.src = thumb; prev.style.display = 'block'; } else { prev.style.display = 'none'; }
  new bootstrap.Modal(document.getElementById('videoModal')).show();
}

// ── Section modal helpers ───────────────────────────────────────────────────
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
  document.getElementById('sectionForm').action = `/admin/video-tours/sections/${s.id}`;
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

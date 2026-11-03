@extends('layouts.admin')
@section('title', 'Home Page — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-house-heart-fill me-2" style="color:#DAA520;"></i>Home Page — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage all text, headings and linked content sections of the Home page.</p>
  </div>
  <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="hmTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item">
    <a class="nav-link {{ session('active_tab') === 'tab-intro' ? 'active' : '' }}" href="#tab-intro" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-layout-text-sidebar me-1"></i>Intro Section
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ session('active_tab') ? '' : 'active' }}" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-overview" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-grid me-1"></i>Content Overview
    </a>
  </li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — INTRO SECTION ════ --}}
  @php
    $sv = fn($key) => $sections->firstWhere('section_key', $key)?->value ?? '';
  @endphp
  <div class="tab-pane fade {{ session('active_tab') === 'tab-intro' ? 'show active' : '' }}" id="tab-intro">
    <div style="padding:24px;">

      @if(session('success') && session('active_tab') === 'tab-intro')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <p style="margin:0 0 20px;font-size:13px;color:#666;">
        Edit the <strong>Welcome / Intro section</strong> — the two-column block with images on the left and text on the right on the Home page.
      </p>

      <form method="POST" action="{{ route('admin.home-admin.intro.store') }}">
        @csrf
        <div class="row g-4">

          {{-- Label & Heading --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Top Label <small class="text-muted fw-normal">(e.g. "Welcome to Mahua House")</small></label>
            <input type="text" name="intro_label" class="form-control" value="{{ old('intro_label', $sv('intro_label')) }}" placeholder="Welcome to Mahua House">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Section Heading <small class="text-muted fw-normal">(HTML ok — wrap italic word in &lt;em&gt;)</small></label>
            <input type="text" name="intro_heading" class="form-control" value="{{ old('intro_heading', $sv('intro_heading')) }}" placeholder="The Nostalgic &lt;em&gt;Woods&lt;/em&gt;">
            <small class="text-muted">Example: <code>The Nostalgic &lt;em&gt;Woods&lt;/em&gt;</code></small>
          </div>

          {{-- Paragraphs --}}
          <div class="col-12">
            <label class="form-label fw-semibold">First Paragraph</label>
            <textarea name="intro_text_1" class="form-control" rows="3" placeholder="Mahua House - The Nostalgic Woods is an MP Tourism accredited countryside retreat...">{{ old('intro_text_1', $sv('intro_text_1')) }}</textarea>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Second Paragraph</label>
            <textarea name="intro_text_2" class="form-control" rows="3" placeholder="Designed for those who value peace, culture, and meaningful gatherings...">{{ old('intro_text_2', $sv('intro_text_2')) }}</textarea>
          </div>

          {{-- Bullet Points --}}
          <div class="col-12">
            <label class="form-label fw-semibold">Bullet Points <small class="text-muted fw-normal">(one per line — each becomes a checkmark list item)</small></label>
            <textarea name="intro_points" class="form-control" rows="5" placeholder="MP Tourism Accredited countryside retreat&#10;Adjoining Samardha Reserved Forest, Bhopal&#10;Trusted by Doordarshan productions&#10;Ideal for weddings, events, picnics and peaceful stays">{{ old('intro_points', $sv('intro_points')) }}</textarea>
          </div>

          {{-- Year Badge --}}
          <div class="col-md-4">
            <label class="form-label fw-semibold">Year Badge</label>
            <input type="text" name="established_year" class="form-control" value="{{ old('established_year', $sv('established_year')) }}" placeholder="2014">
            <small class="text-muted">Large number shown on the photo badge</small>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Badge Label</label>
            <input type="text" name="established_label" class="form-control" value="{{ old('established_label', $sv('established_label')) }}" placeholder="Est. Year">
            <small class="text-muted">Small text below the year</small>
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <div style="background:#DAA520;border-radius:12px;padding:14px 20px;text-align:center;min-width:100px;">
              <span style="font-size:28px;font-weight:800;color:#033631;display:block;line-height:1;">{{ $sv('established_year') ?: '2014' }}</span>
              <span style="font-size:10px;font-weight:700;color:#033631;letter-spacing:2px;text-transform:uppercase;">{{ $sv('established_label') ?: 'Est. Year' }}</span>
            </div>
          </div>

          {{-- Save --}}
          <div class="col-12 d-flex gap-2 pt-2 border-top">
            <button type="submit" class="btn-mahua btn"><i class="bi bi-save me-1"></i>Save Intro Section</button>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-box-arrow-up-right me-1"></i>Preview Page</a>
          </div>

        </div>
      </form>
    </div>
  </div>

  {{-- ════ TAB 2 — PAGE TEXT ════ --}}
  <div class="tab-pane fade {{ session('active_tab') ? '' : 'show active' }}" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Edit all headings, labels and body text displayed on the Home page. HTML tags like <code>&lt;em&gt;</code> are supported in heading fields.</p>
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
              <td class="text-muted" style="font-size:11px;">{{ $i + 1 }}</td>
              <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $s->section_key }}</code></td>
              <td style="font-size:13px;font-weight:500;white-space:nowrap;">{{ $s->label ?: '—' }}</td>
              <td style="max-width:280px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 90) }}</td>
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
                <form method="POST" action="{{ route('admin.home-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete this field?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-5">
                <i class="bi bi-file-earmark-text" style="font-size:32px;color:#ccc;display:block;margin-bottom:10px;"></i>
                No text sections yet. Click <strong>Add Text Field</strong> to override default content.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Available Keys Reference --}}
      <div style="margin-top:20px;background:#f8faf8;border-radius:10px;padding:16px 20px;border:1px solid #e0e8e0;">
        <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#033631;text-transform:uppercase;letter-spacing:1px;">Available Section Keys</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:8px;font-size:12px;">
          @foreach([
            ['meta_title',          'Page browser tab title'],
            ['meta_description',    'SEO meta description'],
            ['meta_keywords',       'SEO meta keywords'],
            ['hero_label',          'Hero top label (e.g. "MP Tourism Accredited")'],
            ['established_year',    'Founded year shown on intro image badge'],
            ['established_label',   'Label under founded year (e.g. "Est. Year")'],
            ['intro_label',         'Intro section top label'],
            ['intro_heading',       'Intro section main heading (HTML ok)'],
            ['intro_text_1',        'Intro first paragraph'],
            ['intro_text_2',        'Intro second paragraph'],
            ['intro_points',        'Bullet points — one per line'],
            ['why_label',           'Why Choose Us section label'],
            ['why_heading',         'Why Choose Us heading (HTML ok)'],
            ['experiences_label',   'Experiences section label'],
            ['experiences_heading', 'Experiences section heading (HTML ok)'],
            ['experiences_text',    'Experiences section body text'],
            ['rooms_label',         'Rooms section label'],
            ['rooms_heading',       'Rooms section heading (HTML ok)'],
            ['gallery_label',       'Gallery section label'],
            ['gallery_heading',     'Gallery section heading (HTML ok)'],
            ['testimonials_label',  'Testimonials section label'],
            ['testimonials_heading','Testimonials section heading (HTML ok)'],
            ['cta_label',           'CTA section top label'],
            ['cta_heading',         'CTA section heading (HTML ok)'],
            ['cta_text',            'CTA section body text'],
          ] as [$key, $desc])
          <div style="display:flex;align-items:baseline;gap:8px;">
            <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;white-space:nowrap;flex-shrink:0;">{{ $key }}</code>
            <span style="color:#777;">{{ $desc }}</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — CONTENT OVERVIEW ════ --}}
  <div class="tab-pane fade" id="tab-overview">
    <div style="padding:20px;">
      <p style="margin:0 0 18px;font-size:13px;color:#666;">The Home page pulls live data from these sections. Click <strong>Manage</strong> to add, edit or delete items in each section.</p>

      <div class="row g-3">

        {{-- Hero Slides --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-images" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Hero Slides</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $heroCount }} active slide(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">Full-screen background images on the home hero. Each slide has a title, subtitle, description and image.</p>
            <a href="{{ route('admin.hero.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Hero Slides</a>
          </div>
        </div>

        {{-- Stats --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-bar-chart-fill" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Stats & Numbers</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $statsCount }} active stat(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">The dark bar below the intro section showing numbers like years of experience, events hosted, etc.</p>
            <a href="{{ route('admin.stats.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Stats</a>
          </div>
        </div>

        {{-- Why Choose Us --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-check-circle-fill" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Why Choose Us</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $whyCount }} active card(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">Cards in the "Why Mahua House" section. Each card has an icon, title and description.</p>
            <a href="{{ route('admin.why-choose.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Why Choose</a>
          </div>
        </div>

        {{-- Experiences --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-grid-fill" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Experiences</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $expCount }} active item(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">Image overlay cards in the "What We Offer" section. Each has an image, icon, title and description.</p>
            <a href="{{ route('admin.services.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Experiences</a>
          </div>
        </div>

        {{-- Rooms --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-house-door-fill" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Featured Rooms</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $roomsCount }} active room(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">Up to 3 "featured" rooms are shown. Mark a room as featured in Rooms admin to display it here.</p>
            <a href="{{ route('admin.rooms.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Rooms</a>
          </div>
        </div>

        {{-- Gallery --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-camera-fill" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Gallery Photos</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $galleryCount }} active photo(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">Up to 7 gallery photos are shown in a strip on the home page. The first photo spans two rows.</p>
            <a href="{{ route('admin.gallery.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Gallery</a>
          </div>
        </div>

        {{-- Testimonials --}}
        <div class="col-lg-4 col-md-6">
          <div style="border:1px solid #e0e8e0;border-radius:12px;padding:18px 20px;background:#fff;height:100%;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.06);display:flex;align-items:center;justify-content:center;"><i class="bi bi-chat-quote-fill" style="font-size:18px;color:#033631;"></i></div>
              <div>
                <p style="margin:0;font-size:14px;font-weight:700;color:#033631;">Testimonials</p>
                <p style="margin:0;font-size:11px;color:#888;">{{ $testiCount }} active review(s)</p>
              </div>
            </div>
            <p style="font-size:12px;color:#777;margin-bottom:14px;">Up to 3 testimonials shown in the "What Our Guests Say" section. Sorted by sort_order.</p>
            <a href="{{ route('admin.testimonials.index') }}" class="btn-mahua btn btn-sm w-100"><i class="bi bi-pencil-square me-1"></i>Manage Testimonials</a>
          </div>
        </div>

      </div>
    </div>
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
            <input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_label, intro_heading">
            <small class="text-muted">Lowercase with underscores. See key list in the Page Text tab.</small>
          </div>
          <div class="col-md-6">
            <label class="form-label">Label <small class="text-muted">(for your reference)</small></label>
            <input type="text" name="label" id="s_label" class="form-control" placeholder="e.g. Hero Top Label">
          </div>
          <div class="col-12">
            <label class="form-label">Value <small class="text-muted">(HTML allowed in heading fields)</small></label>
            <textarea name="value" id="s_value" class="form-control" rows="5" placeholder="Text content to display on the page..."></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Image URL <small class="text-muted">(for image fields — upload or paste URL)</small></label>
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
const createSectionUrl = "{{ route('admin.home-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const sessionTab = @json(session('active_tab'));
  const hash = window.location.hash;
  const target = sessionTab ? '#' + sessionTab : hash;
  if (target) {
    const tab = document.querySelector(`[href="${target}"]`);
    if (tab) new bootstrap.Tab(tab).show();
  }
  document.querySelectorAll('#hmTabs .nav-link').forEach(link => {
    link.addEventListener('click', function () {
      history.replaceState(null, '', this.getAttribute('href'));
    });
  });
});

function resetSectionForm() {
  document.getElementById('sectionForm').action = createSectionUrl;
  document.getElementById('s_method').value = 'POST';
  document.getElementById('s_title').textContent = 'Add Text Field';
  ['s_key', 's_label', 's_value', 's_media'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
  document.getElementById('s_order').value = 0;
  document.getElementById('s_active').checked = true;
  document.getElementById('s_media_preview').style.display = 'none';
  document.getElementById('s_key').removeAttribute('readonly');
}

function editSection(s) {
  document.getElementById('sectionForm').action = `/admin/home-admin/sections/${s.id}`;
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

@extends('layouts.admin')
@section('title', 'Educational Tours — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-mortarboard-fill me-2" style="color:#DAA520;"></i>Educational Tours — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage highlight cards, program cards (with bullet lists), and all page text.</p>
  </div>
  <a href="{{ url('/educational-tours') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="etTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item">
    <a class="nav-link active" href="#tab-highlights" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-grid me-1"></i>Highlight Cards <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $highlights->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-programs" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-card-list me-1"></i>Program Cards <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $programs->count() }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;">
      <i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span>
    </a>
  </li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — HIGHLIGHT CARDS ════ --}}
  <div class="tab-pane fade show active" id="tab-highlights">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Icon cards in the <strong>"A Classroom Like No Other"</strong> section. Each card needs an icon (Font Awesome), title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#hlModal" onclick="resetHl()">
          <i class="bi bi-plus-lg me-1"></i>Add Card
        </button>
      </div>
      <div class="row g-3">
        @forelse($highlights as $h)
        <div class="col-lg-6">
          <div style="background:#f8faf8;border:1px solid #e0e8e0;border-radius:12px;padding:18px;display:flex;gap:14px;align-items:flex-start;">
            <div style="width:52px;height:52px;border-radius:50%;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="{{ $h->icon ?: 'fa-solid fa-leaf' }}" style="font-size:22px;color:#DAA520;"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <strong style="font-size:14px;color:#033631;">{{ $h->title }}</strong>
                <span class="{{ $h->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $h->is_active ? 'On' : 'Off' }}</span>
                <span style="font-size:11px;color:#aaa;margin-left:auto;">{{ $h->sort_order }}</span>
              </div>
              <p style="font-size:12px;color:#666;margin:0 0 10px;">{{ Str::limit($h->description, 80) }}</p>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" onclick='editHl(@json($h))'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.educational-tours-admin.highlights.destroy', $h) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No highlight cards yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — PROGRAM CARDS ════ --}}
  <div class="tab-pane fade" id="tab-programs">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Dark program cards in the <strong>"What's Included"</strong> section. <strong>Description</strong> = bullet items, one per line. <strong>Tag/Badge</strong> = subtitle shown below title.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#progModal" onclick="resetProg()">
          <i class="bi bi-plus-lg me-1"></i>Add Program
        </button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Icon</th><th>Title</th><th>Subtitle</th><th>Bullet Items</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($programs as $prog)
            <tr>
              <td>
                <div style="width:42px;height:42px;border-radius:10px;background:rgba(3,54,49,.07);display:flex;align-items:center;justify-content:center;">
                  <i class="{{ $prog->icon ?: 'fa-solid fa-tree' }}" style="font-size:18px;color:#033631;"></i>
                </div>
              </td>
              <td><strong>{{ $prog->title }}</strong></td>
              <td style="font-size:12px;color:#888;">{{ $prog->link ?: '—' }}</td>
              <td style="max-width:220px;font-size:12px;color:#555;">
                @php $items = array_filter(array_map('trim', explode("\n", $prog->description ?? ''))); @endphp
                {{ count($items) }} item(s): {{ Str::limit(implode(', ', array_slice($items,0,2)), 60) }}
              </td>
              <td>{{ $prog->sort_order }}</td>
              <td><span class="{{ $prog->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $prog->is_active ? 'Active' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editProg(@json($prog))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.educational-tours-admin.programs.destroy', $prog) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No programs yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 3 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, labels, images, and text blocks. HTML allowed in heading fields. List fields use one item per line.</p>
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
                <form method="POST" action="{{ route('admin.educational-tours-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">
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
        <div style="display:flex;flex-wrap:wrap;gap:5px;font-size:11px;margin-bottom:8px;">
          @foreach(['hero_image','hero_label','hero_heading','hero_text','hero_cta1','hero_cta2','hl_label','hl_heading','hl_text','split_label','split_heading','split_text','split_image','split_cta','split_badge_icon','split_badge_title','split_badge_sub','mini1_icon','mini1_title','mini1_desc','mini2_icon','mini2_title','mini2_desc','mini3_icon','mini3_title','mini3_desc','mini4_icon','mini4_title','mini4_desc','prog_label','prog_heading','prog_text','safety_label','safety_heading','safety_icon','safety_title','safety_text','safety_badges','form_label','form_heading','form_text','cta_label','cta_heading','cta_text'] as $k)
          <code style="background:#e7eeee;padding:2px 7px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
        <p style="margin:0;font-size:12px;color:#888;"><strong style="color:#033631;">safety_badges</strong> — one badge per line (e.g. "Trained Staff"). <strong style="color:#033631;">Program descriptions</strong> — use one bullet item per line in the Programs tab.</p>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Highlight Card Modal --}}
<div class="modal fade" id="hlModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="hlForm">
      @csrf <input type="hidden" name="_method" id="hl_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="hl_title">Add Highlight Card</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="hl_name" class="form-control" required placeholder="e.g. Nature-Based Learning"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="hl_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="hl_icon" class="form-control" placeholder="fa-solid fa-leaf">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="hl_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="hl_desc" class="form-control" rows="3" placeholder="Short description shown on the card..."></textarea></div>
          <div class="col-12 d-flex align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="hl_active" checked><label class="form-check-label" for="hl_active">Active</label></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Card</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Program Card Modal --}}
<div class="modal fade" id="progModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="progForm">
      @csrf <input type="hidden" name="_method" id="pg_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="pg_title">Add Program</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Title *</label><input type="text" name="title" id="pg_name" class="form-control" required placeholder="e.g. Nature & Forest"></div>
          <div class="col-md-6"><label class="form-label">Subtitle <small class="text-muted">(shown below title)</small></label><input type="text" name="link" id="pg_link" class="form-control" placeholder="e.g. Ecology & Environment"></div>
          <div class="col-md-8">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="pg_icon" class="form-control" placeholder="fa-solid fa-tree">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="pg_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="pg_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Bullet Items <small class="text-muted">(one item per line — each becomes a checklist bullet)</small></label>
            <textarea name="description" id="pg_desc" class="form-control" rows="6" placeholder="Guided jungle trekking&#10;Bird watching & nature identification&#10;Forest conservation awareness&#10;Medicinal plant discovery"></textarea>
          </div>
          <div class="col-12 d-flex align-items-center">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="pg_active" checked><label class="form-check-label" for="pg_active">Active</label></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Program</button></div>
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
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML OK in headings; one item per line for lists)</small></label><textarea name="value" id="s_value" class="form-control" rows="5" placeholder="Content..."></textarea></div>
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
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
const createHlUrl      = "{{ route('admin.educational-tours-admin.highlights.store') }}";
const createProgUrl    = "{{ route('admin.educational-tours-admin.programs.store') }}";
const createSectionUrl = "{{ route('admin.educational-tours-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#etTabs .nav-link').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

document.getElementById('hl_icon').addEventListener('input', function(){ document.getElementById('hl_icon_preview').className = this.value; });
document.getElementById('pg_icon').addEventListener('input', function(){ document.getElementById('pg_icon_preview').className = this.value; });

function resetHl() {
  document.getElementById('hlForm').action = createHlUrl;
  document.getElementById('hl_method').value = 'POST';
  document.getElementById('hl_title').textContent = 'Add Highlight Card';
  ['hl_name','hl_icon','hl_desc'].forEach(id=>{ const el=document.getElementById(id); if(el) el.value=''; });
  document.getElementById('hl_order').value = 0;
  document.getElementById('hl_active').checked = true;
  document.getElementById('hl_icon_preview').className = '';
}
function editHl(h) {
  document.getElementById('hlForm').action = `/admin/educational-tours-admin/highlights/${h.id}`;
  document.getElementById('hl_method').value = 'PUT';
  document.getElementById('hl_title').textContent = 'Edit Highlight Card';
  document.getElementById('hl_name').value = h.title || '';
  document.getElementById('hl_icon').value = h.icon || '';
  document.getElementById('hl_desc').value = h.description || '';
  document.getElementById('hl_order').value = h.sort_order || 0;
  document.getElementById('hl_active').checked = h.is_active == 1;
  document.getElementById('hl_icon_preview').className = h.icon || '';
  new bootstrap.Modal(document.getElementById('hlModal')).show();
}

function resetProg() {
  document.getElementById('progForm').action = createProgUrl;
  document.getElementById('pg_method').value = 'POST';
  document.getElementById('pg_title').textContent = 'Add Program';
  ['pg_name','pg_icon','pg_link','pg_desc'].forEach(id=>{ const el=document.getElementById(id); if(el) el.value=''; });
  document.getElementById('pg_order').value = 0;
  document.getElementById('pg_active').checked = true;
  document.getElementById('pg_icon_preview').className = '';
}
function editProg(p) {
  document.getElementById('progForm').action = `/admin/educational-tours-admin/programs/${p.id}`;
  document.getElementById('pg_method').value = 'PUT';
  document.getElementById('pg_title').textContent = 'Edit Program';
  document.getElementById('pg_name').value = p.title || '';
  document.getElementById('pg_icon').value = p.icon || '';
  document.getElementById('pg_link').value = p.link || '';
  document.getElementById('pg_desc').value = p.description || '';
  document.getElementById('pg_order').value = p.sort_order || 0;
  document.getElementById('pg_active').checked = p.is_active == 1;
  document.getElementById('pg_icon_preview').className = p.icon || '';
  new bootstrap.Modal(document.getElementById('progModal')).show();
}

function resetSection() {
  document.getElementById('sectionForm').action = createSectionUrl;
  document.getElementById('s_method').value = 'POST';
  document.getElementById('s_title').textContent = 'Add Text Field';
  ['s_key','s_label','s_value','s_media'].forEach(id=>{ const el=document.getElementById(id); if(el) el.value=''; });
  document.getElementById('s_order').value = 0;
  document.getElementById('s_active').checked = true;
  document.getElementById('s_prev').style.display = 'none';
  document.getElementById('s_key').removeAttribute('readonly');
}
function editSection(s) {
  document.getElementById('sectionForm').action = `/admin/educational-tours-admin/sections/${s.id}`;
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

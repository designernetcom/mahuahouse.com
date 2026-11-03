@extends('layouts.admin')
@section('title', 'Page Content')

@section('content')
<div class="row g-3 mb-4">
  <div class="col-12">
    <div style="background:#fff;border-radius:14px;padding:18px 22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
      <div>
        <h6 style="margin:0;font-size:14px;font-weight:600;color:#033631;">Select Page</h6>
        <p style="margin:0;font-size:12px;color:#888;">Manage dynamic text content per page</p>
      </div>
      <form method="GET" action="{{ route('admin.page-sections.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;margin-left:auto;">
        <select name="page" class="form-select" style="font-size:13px;min-width:200px;" onchange="this.form.submit()">
          @foreach($pages as $key => $label)
            <option value="{{ $key }}" {{ $page === $key ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </form>
      <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetForm('{{ $page }}')">
        <i class="bi bi-plus-lg me-1"></i>Add Section
      </button>
    </div>
  </div>
</div>

<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-file-earmark-text-fill me-2" style="color:#DAA520"></i>
      Page Content — <span style="color:#DAA520">{{ $pages[$page] ?? $page }}</span>
    </h5>
    <span style="font-size:12px;color:#888;">{{ $sections->count() }} section(s)</span>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>Key</th>
          <th>Label</th>
          <th>Value</th>
          <th>Media</th>
          <th>Order</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sections as $i => $section)
        <tr>
          <td class="text-muted" style="font-size:12px;">{{ $i + 1 }}</td>
          <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $section->section_key }}</code></td>
          <td style="font-size:13px;font-weight:500;">{{ $section->label ?: '—' }}</td>
          <td style="max-width:280px;font-size:12px;color:#555;">{{ Str::limit($section->value, 100) }}</td>
          <td>
            @if($section->media_url)
              <img src="{{ $section->media_url }}" style="width:40px;height:32px;object-fit:cover;border-radius:4px;">
            @else
              <span style="color:#ccc;font-size:12px;">—</span>
            @endif
          </td>
          <td>{{ $section->sort_order }}</td>
          <td><span class="{{ $section->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $section->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($section))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.page-sections.destroy', $section) }}" style="display:inline" onsubmit="return confirm('Delete this section?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted py-5">
            <i class="bi bi-file-earmark-text" style="font-size:32px;color:#ccc;display:block;margin-bottom:10px;"></i>
            No content sections for this page yet.<br>
            <small>Click "Add Section" to add editable text for this page.</small>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Help Card -->
<div style="background:#fff;border-radius:14px;padding:20px 24px;box-shadow:0 1px 6px rgba(3,54,49,.07);margin-top:20px;">
  <h6 style="color:#033631;font-weight:600;margin-bottom:12px;"><i class="bi bi-info-circle-fill me-2" style="color:#DAA520;"></i>How Page Content Works</h6>
  <p style="font-size:13px;color:#666;margin-bottom:8px;">
    Each section has a <strong>Key</strong> (e.g. <code>hero_title</code>, <code>hero_description</code>) and a <strong>Value</strong> (the text to display). The site uses these keys to override default content.
  </p>
  <p style="font-size:13px;color:#666;margin:0;">
    Common keys: <code>hero_title</code>, <code>hero_subtitle</code>, <code>hero_description</code>, <code>section_heading</code>, <code>intro_text</code>
  </p>
</div>

<!-- Modal -->
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Section</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <input type="hidden" name="page" id="form_page" value="{{ $page }}">
          <div class="col-md-6">
            <label class="form-label">Section Key *</label>
            <input type="text" name="section_key" id="section_key" class="form-control" required placeholder="e.g. hero_title, hero_description">
            <small class="text-muted">Lowercase, no spaces, use underscores</small>
          </div>
          <div class="col-md-6">
            <label class="form-label">Label</label>
            <input type="text" name="label" id="label" class="form-control" placeholder="e.g. Hero Title">
          </div>
          <div class="col-12">
            <label class="form-label">Value</label>
            <textarea name="value" id="value" class="form-control" rows="4" placeholder="The text content to display on the page..."></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Media URL <small class="text-muted">(optional — for images)</small></label>
            <div class="d-flex gap-2 align-items-start">
              <input type="text" name="media_url" id="media_url" class="form-control" placeholder="https://... or upload below">
              <div>
                <input type="file" id="media_upload" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('media_preview'), document.getElementById('media_url'))">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('media_upload').click()"><i class="bi bi-upload"></i></button>
              </div>
            </div>
            <img id="media_preview" src="" alt="" style="display:none;" class="img-preview mt-2">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Section</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.page-sections.store') }}";

function resetForm(page) {
  document.getElementById('sectionForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Section';
  document.getElementById('form_page').value = page;
  ['section_key','label','value','media_url'].forEach(f => { const el = document.getElementById(f); if(el) el.value = ''; });
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('media_preview').style.display = 'none';
  const skField = document.getElementById('section_key');
  if(skField) skField.removeAttribute('readonly');
}

function editSection(s) {
  document.getElementById('sectionForm').action = `/admin/page-sections/${s.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Section';
  document.getElementById('form_page').value = s.page;
  document.getElementById('section_key').value = s.section_key || '';
  document.getElementById('section_key').setAttribute('readonly', true);
  document.getElementById('label').value = s.label || '';
  document.getElementById('value').value = s.value || '';
  document.getElementById('media_url').value = s.media_url || '';
  document.getElementById('sort_order').value = s.sort_order || 0;
  document.getElementById('is_active').checked = s.is_active == 1;
  const prev = document.getElementById('media_preview');
  if (s.media_url) { prev.src = s.media_url; prev.style.display = 'block'; } else { prev.style.display = 'none'; }
  new bootstrap.Modal(document.getElementById('sectionModal')).show();
}
</script>
@endsection

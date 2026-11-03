@extends('layouts.admin')
@section('title', 'Experiences & Services')

@section('content')

<!-- Help banner -->
<div style="background:#fff;border-radius:12px;padding:14px 20px;margin-bottom:18px;box-shadow:0 1px 6px rgba(3,54,49,.07);font-size:13px;color:#555;">
  <strong style="color:#033631;">Categories used on site pages:</strong>
  <span class="badge bg-secondary ms-1">events</span> Event Types (Events page) &nbsp;|&nbsp;
  <span class="badge bg-secondary">venue</span> Venue Cards (Events page) &nbsp;|&nbsp;
  <span class="badge bg-secondary">why-host</span> Why Host features (Events page) &nbsp;|&nbsp;
  <span class="badge bg-secondary">video-tour</span> Video Tours page &nbsp;|&nbsp;
  <span class="badge bg-secondary">corporate</span> Corporate Events &nbsp;|&nbsp;
  <span class="badge bg-secondary">adventure</span> <span class="badge bg-secondary">nature</span> <span class="badge bg-secondary">wellness</span> etc. for Home page
</div>

<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-stars me-2" style="color:#DAA520"></i>Experiences & Services</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#svcModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Experience
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Image</th><th>Title</th><th>Category</th><th>Icon</th><th>Tag / Link</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($experiences as $exp)
        <tr>
          <td>@if($exp->image_url)<img src="{{ $exp->image_url }}" class="table-img">@else<span class="text-muted">—</span>@endif</td>
          <td><strong>{{ $exp->title }}</strong></td>
          <td><span class="badge bg-secondary text-capitalize" style="font-size:11px;">{{ $exp->category ?: '—' }}</span></td>
          <td><code style="font-size:11px;background:#f0f4f0;padding:2px 5px;border-radius:4px;">{{ $exp->icon ?: '—' }}</code></td>
          <td style="font-size:12px;color:#888;max-width:120px;">{{ Str::limit($exp->link, 30) ?: '—' }}</td>
          <td style="max-width:200px;font-size:12px;color:#555;">{{ Str::limit($exp->description, 55) }}</td>
          <td>{{ $exp->sort_order }}</td>
          <td><span class="{{ $exp->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $exp->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editExp(@json($exp))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.services.destroy', $exp) }}" style="display:inline" onsubmit="return confirm('Delete this experience?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" class="text-center text-muted py-4">No experiences yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="svcModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="svcForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Experience</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">

          <div class="col-md-8">
            <label class="form-label">Title *</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Destination Weddings">
          </div>
          <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category" id="category" class="form-select">
              <option value="">— None —</option>
              <optgroup label="Events Page">
                <option value="events">events — Event Type Cards</option>
                <option value="venue">venue — Venue Cards</option>
                <option value="why-host">why-host — Why Host Features</option>
              </optgroup>
              <optgroup label="Video Tours">
                <option value="video-tour">video-tour - Video Tours Page</option>
              </optgroup>
              <optgroup label="Other Pages">
                <option value="corporate">corporate — Corporate Events</option>
                <option value="adventure">adventure</option>
                <option value="nature">nature</option>
                <option value="wellness">wellness</option>
                <option value="cultural">cultural</option>
                <option value="dining">dining</option>
                <option value="recreation">recreation</option>
              </optgroup>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="icon" class="form-control" placeholder="fa-solid fa-heart">
            <div style="margin-top:6px;font-size:12px;color:#888;">
              Preview: <i id="icon_preview" class="" style="font-size:18px;color:#DAA520;margin-left:4px;"></i>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tag / Badge Text <small class="text-muted">(shown on card)</small></label>
            <input type="text" name="link" id="link" class="form-control" placeholder="e.g. Most Popular, Grand Venue, Business">
            <small class="text-muted">For event types: tag label. For venues: badge text (e.g. "Grand Venue").</small>
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short description shown on the card..."></textarea>
          </div>

          <div class="col-12">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload
                <input type="file" accept="image/*" style="display:none"
                  onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('image_url'))">
              </label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none">
          </div>

          <div class="col-md-4">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">Active</label>
            </div>
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
              <label class="form-check-label" for="is_featured">Featured</label>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Experience</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.services.store') }}";

document.getElementById('icon').addEventListener('input', function() {
  document.getElementById('icon_preview').className = this.value;
});

function resetForm() {
  document.getElementById('svcForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Experience';
  ['title','description','image_url','icon','link'].forEach(f => { const el = document.getElementById(f); if(el) el.value = ''; });
  document.getElementById('category').value = '';
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('is_featured').checked = false;
  document.getElementById('imgPreview').style.display = 'none';
  document.getElementById('icon_preview').className = '';
}

function editExp(e) {
  document.getElementById('svcForm').action = `/admin/services/${e.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Experience';
  document.getElementById('title').value = e.title || '';
  document.getElementById('description').value = e.description || '';
  document.getElementById('image_url').value = e.image_url || '';
  document.getElementById('icon').value = e.icon || '';
  document.getElementById('link').value = e.link || '';
  document.getElementById('category').value = e.category || '';
  document.getElementById('sort_order').value = e.sort_order || 0;
  document.getElementById('is_active').checked = e.is_active == 1;
  document.getElementById('is_featured').checked = e.is_featured == 1;
  document.getElementById('icon_preview').className = e.icon || '';
  const prev = document.getElementById('imgPreview');
  if (e.image_url) { prev.src = e.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('svcModal')).show();
}
</script>
@endsection

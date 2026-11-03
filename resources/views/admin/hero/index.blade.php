@extends('layouts.admin')
@section('title', 'Hero Slides')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-images me-2" style="color:#DAA520"></i>Hero Slides</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#slideModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Slide
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Image</th><th>Title</th><th>Subtitle</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($slides as $slide)
        <tr>
          <td>@if($slide->image_url)<img src="{{ $slide->image_url }}" class="table-img">@else<span class="text-muted">—</span>@endif</td>
          <td><strong>{{ $slide->title }}</strong></td>
          <td>{{ Str::limit($slide->subtitle, 40) }}</td>
          <td>{{ $slide->sort_order }}</td>
          <td><span class="{{ $slide->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $slide->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editSlide(@json($slide))'>
              <i class="bi bi-pencil"></i>
            </button>
            <form method="POST" action="{{ route('admin.hero.destroy', $slide) }}" style="display:inline" onsubmit="return confirm('Delete this slide?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No slides yet. Add your first hero slide.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="slideModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="slideForm">
      @csrf
      <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Hero Slide</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Mahua House">
          </div>
          <div class="col-md-6">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="e.g. The Nostalgic Woods">
          </div>
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="2" placeholder="Short tagline text"></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Background Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">
                Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('image_url'))">
              </label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none">
          </div>
          <div class="col-md-4">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
          </div>
          <div class="col-md-8 d-flex align-items-end">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">Active (visible on website)</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Slide</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.hero.store') }}";
function resetForm() {
  document.getElementById('slideForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Hero Slide';
  ['title','subtitle','description','image_url'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('imgPreview').style.display = 'none';
}
function editSlide(s) {
  document.getElementById('slideForm').action = `/admin/hero/${s.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Hero Slide';
  document.getElementById('title').value = s.title || '';
  document.getElementById('subtitle').value = s.subtitle || '';
  document.getElementById('description').value = s.description || '';
  document.getElementById('image_url').value = s.image_url || '';
  document.getElementById('sort_order').value = s.sort_order || 0;
  document.getElementById('is_active').checked = s.is_active == 1;
  const prev = document.getElementById('imgPreview');
  if (s.image_url) { prev.src = s.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('slideModal')).show();
}
</script>
@endsection

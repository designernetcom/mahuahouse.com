@extends('layouts.admin')
@section('title', 'Wedding — Why Choose Us Cards')

@section('content')

<div style="background:#fff;border-radius:12px;padding:14px 20px;margin-bottom:18px;box-shadow:0 1px 6px rgba(3,54,49,.07);font-size:13px;color:#555;">
  <strong style="color:#033631;">These cards appear in the "Why Mahua House" section on the Destination Wedding page.</strong>
  Use Font Awesome class names for the icon field (e.g. <code>fa-solid fa-tree</code>).
</div>

<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-heart-fill me-2" style="color:#DAA520"></i>Why Choose Us — Wedding Features</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#featureModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Feature Card
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Icon Preview</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($features as $feature)
        <tr>
          <td>
            @if($feature->icon)
              <div style="width:42px;height:42px;border-radius:50%;background:rgba(3,54,49,0.07);display:flex;align-items:center;justify-content:center;">
                <i class="{{ $feature->icon }}" style="font-size:18px;color:#033631;"></i>
              </div>
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          <td><strong>{{ $feature->title }}</strong></td>
          <td style="max-width:280px;font-size:12px;color:#555;">{{ Str::limit($feature->description, 80) }}</td>
          <td>{{ $feature->sort_order }}</td>
          <td><span class="{{ $feature->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $feature->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editFeature(@json($feature))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.wedding-features.destroy', $feature) }}" style="display:inline" onsubmit="return confirm('Delete this feature?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No feature cards yet. Add your first one.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="featureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="featureForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modalTitle">Add Feature Card</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">

          <div class="col-md-8">
            <label class="form-label">Title *</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Forest Setting">
          </div>
          <div class="col-md-4">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
          </div>

          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome class, e.g. <code>fa-solid fa-tree</code>)</small></label>
            <input type="text" name="icon" id="icon" class="form-control" placeholder="fa-solid fa-tree">
            <div style="margin-top:6px;font-size:12px;color:#888;">
              Preview: <i id="icon_preview" class="" style="font-size:22px;color:#DAA520;margin-left:6px;"></i>
            </div>
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short description shown on the card..."></textarea>
          </div>

          <div class="col-md-4 d-flex align-items-center">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">Active (visible on site)</label>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Feature</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.wedding-features.store') }}";

document.getElementById('icon').addEventListener('input', function () {
  document.getElementById('icon_preview').className = this.value;
});

function resetForm() {
  document.getElementById('featureForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Feature Card';
  ['title', 'description', 'icon'].forEach(f => { const el = document.getElementById(f); if (el) el.value = ''; });
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('icon_preview').className = '';
}

function editFeature(f) {
  document.getElementById('featureForm').action = `/admin/wedding-features/${f.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Feature Card';
  document.getElementById('title').value = f.title || '';
  document.getElementById('description').value = f.description || '';
  document.getElementById('icon').value = f.icon || '';
  document.getElementById('sort_order').value = f.sort_order || 0;
  document.getElementById('is_active').checked = f.is_active == 1;
  document.getElementById('icon_preview').className = f.icon || '';
  new bootstrap.Modal(document.getElementById('featureModal')).show();
}
</script>
@endsection

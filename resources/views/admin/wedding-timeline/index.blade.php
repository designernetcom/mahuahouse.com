@extends('layouts.admin')
@section('title', 'Wedding — Planning Process Steps')

@section('content')

<div style="background:#fff;border-radius:12px;padding:14px 20px;margin-bottom:18px;box-shadow:0 1px 6px rgba(3,54,49,.07);font-size:13px;color:#555;">
  <strong style="color:#033631;">These steps appear in the "How It Works" / Planning Process section on the Destination Wedding page.</strong>
  Use <strong>Sort Order</strong> to control step numbering (1 = first step, 2 = second, etc.).
</div>

<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-list-ol me-2" style="color:#DAA520"></i>Planning Process Steps</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#stepModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Step
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Step #</th><th>Title</th><th>Description</th><th>Status</th><th>Actions</th>
        </tr>
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
          <td style="max-width:320px;font-size:12px;color:#555;">{{ Str::limit($step->description, 100) }}</td>
          <td><span class="{{ $step->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $step->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editStep(@json($step))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.wedding-timeline.destroy', $step) }}" style="display:inline" onsubmit="return confirm('Delete this step?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">No steps yet. Add your first planning step.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="stepModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="stepForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modalTitle">Add Planning Step</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">

          <div class="col-md-9">
            <label class="form-label">Step Title *</label>
            <input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Initial Inquiry & Consultation">
          </div>
          <div class="col-md-3">
            <label class="form-label">Step Number <small class="text-muted">(sort order)</small></label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="1" min="1">
          </div>

          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Describe what happens in this step..."></textarea>
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
          <button type="submit" class="btn-mahua btn">Save Step</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.wedding-timeline.store') }}";

function resetForm() {
  document.getElementById('stepForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Planning Step';
  ['title', 'description'].forEach(f => { const el = document.getElementById(f); if (el) el.value = ''; });
  document.getElementById('sort_order').value = 1;
  document.getElementById('is_active').checked = true;
}

function editStep(s) {
  document.getElementById('stepForm').action = `/admin/wedding-timeline/${s.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Planning Step';
  document.getElementById('title').value = s.title || '';
  document.getElementById('description').value = s.description || '';
  document.getElementById('sort_order').value = s.sort_order || 1;
  document.getElementById('is_active').checked = s.is_active == 1;
  new bootstrap.Modal(document.getElementById('stepModal')).show();
}
</script>
@endsection

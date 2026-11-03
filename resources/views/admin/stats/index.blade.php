@extends('layouts.admin')
@section('title', 'Stats')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-bar-chart-fill me-2" style="color:#DAA520"></i>Stats / Highlights</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#statModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Stat
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Icon</th><th>Value</th><th>Label</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($stats as $stat)
        <tr>
          <td><i class="{{ $stat->icon }}" style="font-size:20px;color:#DAA520;"></i></td>
          <td><strong>{{ $stat->value }}</strong></td>
          <td>{{ $stat->label }}</td>
          <td>{{ $stat->sort_order }}</td>
          <td><span class="{{ $stat->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $stat->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editStat(@json($stat))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" style="display:inline" onsubmit="return confirm('Delete this stat?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No stats yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="statModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="statForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Stat</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Value *</label><input type="text" name="value" id="value" class="form-control" required placeholder="e.g. 500+"></div>
          <div class="col-md-6"><label class="form-label">Label *</label><input type="text" name="label" id="label" class="form-control" required placeholder="e.g. Happy Guests"></div>
          <div class="col-md-8"><label class="form-label">Bootstrap Icon Class</label><input type="text" name="icon" id="icon" class="form-control" placeholder="bi-people-fill"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Stat</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.stats.store') }}";
function resetForm() {
  document.getElementById('statForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Stat';
  ['value','label','icon'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
}
function editStat(s) {
  document.getElementById('statForm').action = `/admin/stats/${s.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Stat';
  document.getElementById('value').value = s.value || '';
  document.getElementById('label').value = s.label || '';
  document.getElementById('icon').value = s.icon || '';
  document.getElementById('sort_order').value = s.sort_order || 0;
  document.getElementById('is_active').checked = s.is_active == 1;
  new bootstrap.Modal(document.getElementById('statModal')).show();
}
</script>
@endsection

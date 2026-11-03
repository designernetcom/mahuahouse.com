@extends('layouts.admin')
@section('title', 'Why Choose Us')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-check-circle-fill me-2" style="color:#DAA520"></i>Why Choose Us</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#wcModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Item
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($items as $item)
        <tr>
          <td><i class="{{ $item->icon }}" style="font-size:20px;color:#DAA520;"></i></td>
          <td><strong>{{ $item->title }}</strong></td>
          <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit($item->description, 70) }}</td>
          <td>{{ $item->sort_order }}</td>
          <td><span class="{{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editItem(@json($item))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.why-choose.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete this item?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted py-4">No items yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="wcModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="wcForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Why Choose Item</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Serene Natural Environment"></div>
          <div class="col-md-4"><label class="form-label">Bootstrap Icon</label><input type="text" name="icon" id="icon" class="form-control" placeholder="bi-tree-fill"></div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="description" class="form-control" rows="3"></textarea></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Item</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.why-choose.store') }}";
function resetForm() {
  document.getElementById('wcForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Why Choose Item';
  ['title','icon','description'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
}
function editItem(i) {
  document.getElementById('wcForm').action = `/admin/why-choose/${i.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Why Choose Item';
  document.getElementById('title').value = i.title || '';
  document.getElementById('icon').value = i.icon || '';
  document.getElementById('description').value = i.description || '';
  document.getElementById('sort_order').value = i.sort_order || 0;
  document.getElementById('is_active').checked = i.is_active == 1;
  new bootstrap.Modal(document.getElementById('wcModal')).show();
}
</script>
@endsection

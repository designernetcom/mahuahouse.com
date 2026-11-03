@extends('layouts.admin')
@section('title', 'Contact Info')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-geo-alt-fill me-2" style="color:#DAA520"></i>Contact Information</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Entry
    </button>
  </div>

  <!-- Quick Edit Form -->
  <form method="POST" action="{{ route('admin.contact-info.update') }}">
    @csrf @method('PUT')
    <div class="p-4">
      <div class="row g-3">
        @foreach($contacts as $contact)
        <div class="col-md-6">
          <label class="form-label" style="font-size:12px;font-weight:600;color:#555;">
            <i class="bi {{ $contact->icon }}" style="color:#DAA520;"></i>
            {{ ucwords(str_replace('_', ' ', $contact->key)) }}
          </label>
          <input type="hidden" name="contacts[{{ $contact->key }}][key]" value="{{ $contact->key }}">
          <div class="input-group">
            <input type="text" name="contacts[{{ $contact->key }}][value]" class="form-control" value="{{ $contact->value }}" placeholder="{{ $contact->label }}">
            <button type="button" class="btn btn-outline-secondary" onclick='editContact(@json($contact))' title="Edit details"><i class="bi bi-pencil"></i></button>
          </div>
          @if($contact->label) <small class="text-muted">{{ $contact->label }}</small> @endif
        </div>
        @endforeach
      </div>
      <div class="mt-4">
        <button type="submit" class="btn-mahua btn"><i class="bi bi-save me-1"></i>Save All Changes</button>
      </div>
    </div>
  </form>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="contactForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Contact Entry</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Key *</label><input type="text" name="key" id="key" class="form-control" required placeholder="e.g. phone_primary"></div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="clabel" class="form-control" placeholder="e.g. Main Phone"></div>
          <div class="col-12"><label class="form-label">Value *</label><input type="text" name="value" id="cvalue" class="form-control" required placeholder="e.g. +91 98765 43210"></div>
          <div class="col-md-8"><label class="form-label">Bootstrap Icon</label><input type="text" name="icon" id="icon" class="form-control" placeholder="bi-telephone-fill"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Entry</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.contact-info.store') }}";
function resetForm() {
  document.getElementById('contactForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Contact Entry';
  ['key','clabel','cvalue','icon'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
}
function editContact(c) {
  document.getElementById('contactForm').action = `/admin/contact-info/${c.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Contact Entry';
  document.getElementById('key').value = c.key || '';
  document.getElementById('clabel').value = c.label || '';
  document.getElementById('cvalue').value = c.value || '';
  document.getElementById('icon').value = c.icon || '';
  document.getElementById('sort_order').value = c.sort_order || 0;
  document.getElementById('is_active').checked = c.is_active == 1;
  new bootstrap.Modal(document.getElementById('contactModal')).show();
}
</script>
@endsection

@extends('layouts.admin')
@section('title', 'Team Members')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-people-fill me-2" style="color:#DAA520"></i>Team Members</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#teamModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Member
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Photo</th><th>Name</th><th>Role</th><th>Bio</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($members as $member)
        <tr>
          <td>@if($member->image_url)<img src="{{ $member->image_url }}" class="table-img" style="border-radius:50%;">@else<span class="text-muted">—</span>@endif</td>
          <td><strong>{{ $member->name }}</strong></td>
          <td><span style="font-size:12px;color:#666;">{{ $member->role }}</span></td>
          <td style="max-width:220px;font-size:12px;color:#555;">{{ Str::limit($member->bio, 60) }}</td>
          <td>{{ $member->sort_order }}</td>
          <td><span class="{{ $member->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editMember(@json($member))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.team.destroy', $member) }}" style="display:inline" onsubmit="return confirm('Delete this team member?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No team members yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="teamModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="teamForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Team Member</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Name *</label><input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Rajesh Patel"></div>
          <div class="col-md-6"><label class="form-label">Role *</label><input type="text" name="role" id="role" class="form-control" required placeholder="e.g. Host & Manager"></div>
          <div class="col-12"><label class="form-label">Bio</label><textarea name="bio" id="bio" class="form-control" rows="3" placeholder="Short biography..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Photo</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" placeholder="/site/assets/images/team/...">
              <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('image_url'))"></label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none;border-radius:50%;width:80px;height:80px;object-fit:cover;">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Member</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.team.store') }}";
function resetForm() {
  document.getElementById('teamForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Team Member';
  ['name','role','bio','image_url'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('imgPreview').style.display = 'none';
}
function editMember(m) {
  document.getElementById('teamForm').action = `/admin/team/${m.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Team Member';
  document.getElementById('name').value = m.name || '';
  document.getElementById('role').value = m.role || '';
  document.getElementById('bio').value = m.bio || '';
  document.getElementById('image_url').value = m.image_url || '';
  document.getElementById('sort_order').value = m.sort_order || 0;
  document.getElementById('is_active').checked = m.is_active == 1;
  const prev = document.getElementById('imgPreview');
  if (m.image_url) { prev.src = m.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('teamModal')).show();
}
</script>
@endsection

@extends('layouts.admin')
@section('title', 'Rooms')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-house-door-fill me-2" style="color:#DAA520"></i>Rooms & Accommodation</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#roomModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Room
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Image</th><th>Name</th><th>Type</th><th>Price/Night</th><th>Guests</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($rooms as $room)
        <tr>
          <td>@if($room->image_url)<img src="{{ $room->image_url }}" class="table-img">@else<span class="text-muted">—</span>@endif</td>
          <td>
            <strong>{{ $room->name }}</strong>
            @if($room->badge_text) <span class="badge ms-1" style="background:{{ $room->badge_color }};color:{{ $room->badge_color == '#ffffff' ? '#333' : '#fff' }};font-size:10px;">{{ $room->badge_text }}</span> @endif
          </td>
          <td>{{ $room->room_type ?: '—' }}</td>
          <td><strong>₹{{ number_format($room->price_per_night) }}</strong></td>
          <td>{{ $room->max_guests }}</td>
          <td><span class="{{ $room->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $room->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editRoom(@json($room))'>
              <i class="bi bi-pencil"></i>
            </button>
            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" style="display:inline" onsubmit="return confirm('Delete this room?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No rooms yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="roomModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <form method="POST" id="roomForm">
      @csrf
      <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Room</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Room Name *</label><input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Super Deluxe AC Room"></div>
          <div class="col-md-6"><label class="form-label">Room Type</label><input type="text" name="room_type" id="room_type" class="form-control" placeholder="e.g. Super Deluxe AC"></div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="description" class="form-control" rows="2"></textarea></div>
          <div class="col-md-4"><label class="form-label">Price per Night (₹) *</label><input type="number" name="price_per_night" id="price_per_night" class="form-control" min="0"></div>
          <div class="col-md-4"><label class="form-label">Max Guests</label><input type="number" name="max_guests" id="max_guests" class="form-control" value="2" min="1"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-6"><label class="form-label">Amenities (comma-separated)</label><input type="text" name="amenities" id="amenities" class="form-control" placeholder="AC, Double Bed, Bath, Power Backup"></div>
          <div class="col-md-3"><label class="form-label">Badge Text</label><input type="text" name="badge_text" id="badge_text" class="form-control" placeholder="Popular"></div>
          <div class="col-md-3"><label class="form-label">Badge Color</label><input type="color" name="badge_color" id="badge_color" class="form-control form-control-color" value="#DAA520"></div>
          <div class="col-12">
            <label class="form-label">Room Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" placeholder="/site/assets/images/room/room-1.jpg">
              <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('image_url'))"></label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex gap-4">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"><label class="form-check-label" for="is_featured">Featured on Homepage</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Room</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.rooms.store') }}";
function resetForm() {
  document.getElementById('roomForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Room';
  ['name','room_type','description','amenities','image_url','badge_text'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('price_per_night').value = '';
  document.getElementById('max_guests').value = 2;
  document.getElementById('sort_order').value = 0;
  document.getElementById('badge_color').value = '#DAA520';
  document.getElementById('is_active').checked = true;
  document.getElementById('is_featured').checked = false;
  document.getElementById('imgPreview').style.display = 'none';
}
function editRoom(r) {
  document.getElementById('roomForm').action = `/admin/rooms/${r.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Room';
  document.getElementById('name').value = r.name || '';
  document.getElementById('room_type').value = r.room_type || '';
  document.getElementById('description').value = r.description || '';
  document.getElementById('price_per_night').value = r.price_per_night || '';
  document.getElementById('max_guests').value = r.max_guests || 2;
  document.getElementById('amenities').value = Array.isArray(r.amenities) ? r.amenities.join(', ') : '';
  document.getElementById('image_url').value = r.image_url || '';
  document.getElementById('badge_text').value = r.badge_text || '';
  document.getElementById('badge_color').value = r.badge_color || '#DAA520';
  document.getElementById('sort_order').value = r.sort_order || 0;
  document.getElementById('is_active').checked = r.is_active == 1;
  document.getElementById('is_featured').checked = r.is_featured == 1;
  const prev = document.getElementById('imgPreview');
  if (r.image_url) { prev.src = r.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('roomModal')).show();
}
</script>
@endsection

@extends('layouts.admin')
@section('title', 'Testimonials')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-chat-quote-fill me-2" style="color:#DAA520"></i>Testimonials</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#testModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Testimonial
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Photo</th><th>Guest</th><th>Rating</th><th>Review</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($testimonials as $t)
        <tr>
          <td>@if($t->photo_url)<img src="{{ $t->photo_url }}" class="table-img" style="border-radius:50%;">@else<span class="text-muted">—</span>@endif</td>
          <td>
            <strong>{{ $t->name }}</strong>
            @if($t->location) <br><small class="text-muted">{{ $t->location }}</small> @endif
          </td>
          <td>
            @for($i=1;$i<=5;$i++)
              <i class="bi bi-star-fill" style="color:{{ $i <= $t->rating ? '#DAA520' : '#ddd' }};font-size:12px;"></i>
            @endfor
          </td>
          <td style="max-width:240px;font-size:12px;color:#555;">{{ Str::limit($t->review, 80) }}</td>
          <td>{{ $t->sort_order }}</td>
          <td><span class="{{ $t->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $t->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editTest(@json($t))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" style="display:inline" onsubmit="return confirm('Delete this testimonial?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No testimonials yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="testModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="testForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Testimonial</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Guest Name *</label><input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Priya Sharma"></div>
          <div class="col-md-6"><label class="form-label">Location</label><input type="text" name="location" id="location" class="form-control" placeholder="e.g. Mumbai"></div>
          <div class="col-md-4">
            <label class="form-label">Rating</label>
            <select name="rating" id="rating" class="form-select">
              @foreach([5,4,3,2,1] as $r)
              <option value="{{ $r }}">{{ $r }} Star{{ $r > 1 ? 's' : '' }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-8"><label class="form-label">Date Visited</label><input type="date" name="visit_date" id="visit_date" class="form-control"></div>
          <div class="col-12"><label class="form-label">Review *</label><textarea name="review" id="review" class="form-control" rows="4" required placeholder="Guest review text..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Guest Photo</label>
            <div class="input-group">
              <input type="text" name="photo_url" id="photo_url" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('photo_url'))"></label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none;border-radius:50%;width:60px;height:60px;object-fit:cover;">
          </div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Testimonial</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.testimonials.store') }}";
function resetForm() {
  document.getElementById('testForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Testimonial';
  ['name','location','review','photo_url','visit_date'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('rating').value = 5;
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('imgPreview').style.display = 'none';
}
function editTest(t) {
  document.getElementById('testForm').action = `/admin/testimonials/${t.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Testimonial';
  document.getElementById('name').value = t.name || '';
  document.getElementById('location').value = t.location || '';
  document.getElementById('review').value = t.review || '';
  document.getElementById('rating').value = t.rating || 5;
  document.getElementById('visit_date').value = t.visit_date || '';
  document.getElementById('photo_url').value = t.photo_url || '';
  document.getElementById('sort_order').value = t.sort_order || 0;
  document.getElementById('is_active').checked = t.is_active == 1;
  const prev = document.getElementById('imgPreview');
  if (t.photo_url) { prev.src = t.photo_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('testModal')).show();
}
</script>
@endsection

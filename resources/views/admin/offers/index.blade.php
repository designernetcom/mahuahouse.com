@extends('layouts.admin')
@section('title', 'Offers & Packages')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-tag-fill me-2" style="color:#DAA520"></i>Offers & Packages</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#offerModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Offer
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Image</th><th>Title</th><th>Price</th><th>Duration</th><th>Valid Until</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($offers as $offer)
        <tr>
          <td>@if($offer->image_url)<img src="{{ $offer->image_url }}" class="table-img">@else<span class="text-muted">—</span>@endif</td>
          <td>
            <strong>{{ $offer->title }}</strong>
            @if($offer->badge_text) <span class="badge ms-1" style="background:#DAA520;color:#fff;font-size:10px;">{{ $offer->badge_text }}</span> @endif
            <br><small class="text-muted" style="font-size:11px;">{{ Str::limit($offer->description, 50) }}</small>
          </td>
          <td>
            @if($offer->original_price) <del style="font-size:11px;color:#999;">₹{{ number_format($offer->original_price) }}</del><br> @endif
            <strong>₹{{ number_format($offer->price) }}</strong>
          </td>
          <td style="font-size:12px;">{{ $offer->duration ?: '—' }}</td>
          <td style="font-size:12px;">{{ $offer->valid_until ? \Carbon\Carbon::parse($offer->valid_until)->format('d M Y') : 'No expiry' }}</td>
          <td><span class="{{ $offer->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $offer->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editOffer(@json($offer))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.offers.destroy', $offer) }}" style="display:inline" onsubmit="return confirm('Delete this offer?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No offers yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="offerModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <form method="POST" id="offerForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Offer</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="title" class="form-control" required placeholder="e.g. Weekend Escape Package"></div>
          <div class="col-md-4"><label class="form-label">Badge Text</label><input type="text" name="badge_text" id="badge_text" class="form-control" placeholder="Best Value"></div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="description" class="form-control" rows="2" placeholder="Short description of the offer..."></textarea></div>
          <div class="col-12"><label class="form-label">Inclusions (one per line)</label><textarea name="inclusions" id="inclusions" class="form-control" rows="4" placeholder="2 nights stay&#10;Daily breakfast&#10;Nature walk&#10;Bonfire evening"></textarea></div>
          <div class="col-md-4"><label class="form-label">Price (₹) *</label><input type="number" name="price" id="price" class="form-control" min="0" required></div>
          <div class="col-md-4"><label class="form-label">Original Price (₹)</label><input type="number" name="original_price" id="original_price" class="form-control" min="0" placeholder="For strikethrough"></div>
          <div class="col-md-4"><label class="form-label">Duration</label><input type="text" name="duration" id="duration" class="form-control" placeholder="e.g. 2 Nights / 3 Days"></div>
          <div class="col-md-6"><label class="form-label">Valid Until</label><input type="date" name="valid_until" id="valid_until" class="form-control"></div>
          <div class="col-md-6"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('image_url'))"></label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex gap-4">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"><label class="form-check-label" for="is_featured">Featured</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Offer</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.offers.store') }}";
function resetForm() {
  document.getElementById('offerForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Offer';
  ['title','badge_text','description','inclusions','price','original_price','duration','valid_until','image_url'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
  document.getElementById('is_featured').checked = false;
  document.getElementById('imgPreview').style.display = 'none';
}
function editOffer(o) {
  document.getElementById('offerForm').action = `/admin/offers/${o.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Offer';
  document.getElementById('title').value = o.title || '';
  document.getElementById('badge_text').value = o.badge_text || '';
  document.getElementById('description').value = o.description || '';
  document.getElementById('inclusions').value = Array.isArray(o.inclusions) ? o.inclusions.join('\n') : (o.inclusions || '');
  document.getElementById('price').value = o.price || '';
  document.getElementById('original_price').value = o.original_price || '';
  document.getElementById('duration').value = o.duration || '';
  document.getElementById('valid_until').value = o.valid_until || '';
  document.getElementById('image_url').value = o.image_url || '';
  document.getElementById('sort_order').value = o.sort_order || 0;
  document.getElementById('is_active').checked = o.is_active == 1;
  document.getElementById('is_featured').checked = o.is_featured == 1;
  const prev = document.getElementById('imgPreview');
  if (o.image_url) { prev.src = o.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('offerModal')).show();
}
</script>
@endsection

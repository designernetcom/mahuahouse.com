@extends('layouts.admin')
@section('title', 'FAQs')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-question-circle-fill me-2" style="color:#DAA520"></i>Frequently Asked Questions</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add FAQ
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>#</th><th>Question</th><th>Category</th><th>Answer</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($faqs as $i => $faq)
        <tr>
          <td class="text-muted" style="font-size:12px;">{{ $i + 1 }}</td>
          <td><strong style="font-size:13px;">{{ $faq->question }}</strong></td>
          <td><span class="badge bg-secondary text-capitalize" style="font-size:11px;">{{ $faq->category ?: 'General' }}</span></td>
          <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit($faq->answer, 80) }}</td>
          <td>{{ $faq->sort_order }}</td>
          <td><span class="{{ $faq->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $faq->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editFaq(@json($faq))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}" style="display:inline" onsubmit="return confirm('Delete this FAQ?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No FAQs yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="faqModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="faqForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add FAQ</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Question *</label><input type="text" name="question" id="question" class="form-control" required placeholder="e.g. How far is Mahua House from the nearest city?"></div>
          <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category" id="category" class="form-select">
              <option value="general">General</option>
              <option value="booking">Booking</option>
              <option value="rooms">Rooms</option>
              <option value="activities">Activities</option>
              <option value="dining">Dining</option>
              <option value="travel">Travel & Transport</option>
            </select>
          </div>
          <div class="col-12"><label class="form-label">Answer *</label><textarea name="answer" id="answer" class="form-control" rows="5" required placeholder="Detailed answer..."></textarea></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="sort_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked><label class="form-check-label" for="is_active">Active</label></div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save FAQ</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.faq.store') }}";
function resetForm() {
  document.getElementById('faqForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add FAQ';
  ['question','answer'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('category').value = 'general';
  document.getElementById('sort_order').value = 0;
  document.getElementById('is_active').checked = true;
}
function editFaq(f) {
  document.getElementById('faqForm').action = `/admin/faq/${f.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit FAQ';
  document.getElementById('question').value = f.question || '';
  document.getElementById('answer').value = f.answer || '';
  document.getElementById('category').value = f.category || 'general';
  document.getElementById('sort_order').value = f.sort_order || 0;
  document.getElementById('is_active').checked = f.is_active == 1;
  new bootstrap.Modal(document.getElementById('faqModal')).show();
}
</script>
@endsection

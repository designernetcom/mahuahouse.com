@extends('layouts.admin')
@section('title', 'Inquiries')

@section('content')
<!-- Filter Tabs -->
<div class="d-flex gap-2 mb-3 flex-wrap">
  <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm {{ !$status ? 'btn-mahua' : 'btn-outline-secondary' }}">All ({{ $counts['all'] }})</a>
  <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" class="btn btn-sm {{ $status === 'new' ? 'btn-gold' : 'btn-outline-secondary' }}">New ({{ $counts['new'] }})</a>
  <a href="{{ route('admin.inquiries.index', ['status' => 'read']) }}" class="btn btn-sm {{ $status === 'read' ? 'btn-mahua' : 'btn-outline-secondary' }}">Read ({{ $counts['read'] }})</a>
  <a href="{{ route('admin.inquiries.index', ['status' => 'replied']) }}" class="btn btn-sm {{ $status === 'replied' ? 'btn-mahua' : 'btn-outline-secondary' }}">Replied ({{ $counts['replied'] }})</a>
</div>

<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-envelope-fill me-2" style="color:#DAA520"></i>Guest Inquiries</h5>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Name</th><th>Contact</th><th>Type</th><th>Subject / Message</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($inquiries as $inq)
        <tr style="{{ $inq->status === 'new' ? 'background:rgba(218,165,32,.04);font-weight:500;' : '' }}">
          <td>
            <strong>{{ $inq->name }}</strong>
            @if($inq->guests) <br><small class="text-muted">{{ $inq->guests }} guests</small> @endif
          </td>
          <td style="font-size:12px;">
            @if($inq->email) <div><i class="bi bi-envelope" style="color:#DAA520"></i> {{ $inq->email }}</div> @endif
            @if($inq->phone) <div><i class="bi bi-phone" style="color:#DAA520"></i> {{ $inq->phone }}</div> @endif
          </td>
          <td><span class="badge bg-secondary text-capitalize" style="font-size:11px;">{{ $inq->type }}</span>
            @if($inq->room_type) <br><small class="text-muted">{{ $inq->room_type }}</small> @endif
            @if($inq->check_in) <br><small class="text-muted">{{ $inq->check_in }} → {{ $inq->check_out }}</small> @endif
          </td>
          <td style="max-width:240px;">
            @if($inq->subject) <strong style="font-size:12px;">{{ $inq->subject }}</strong><br> @endif
            <span style="font-size:12px;color:#555;">{{ Str::limit($inq->message, 80) }}</span>
          </td>
          <td style="font-size:12px;">{{ $inq->created_at->format('d M Y') }}<br><small class="text-muted">{{ $inq->created_at->format('H:i') }}</small></td>
          <td>
            <form method="POST" action="{{ route('admin.inquiries.status', $inq) }}">
              @csrf @method('PUT')
              <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="font-size:12px;min-width:90px;">
                @foreach(['new','read','replied','closed'] as $s)
                <option value="{{ $s }}" {{ $inq->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
              </select>
            </form>
          </td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='viewInquiry(@json($inq))' title="View"><i class="bi bi-eye"></i></button>
            <form method="POST" action="{{ route('admin.inquiries.destroy', $inq) }}" style="display:inline" onsubmit="return confirm('Delete this inquiry?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-5">No inquiries found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($inquiries->hasPages())
  <div class="p-3">{{ $inquiries->links() }}</div>
  @endif
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h6 class="modal-title">Inquiry Details</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body" id="inqBody"></div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function viewInquiry(i) {
  document.getElementById('inqBody').innerHTML = `
    <div class="row g-3">
      <div class="col-md-6"><strong>Name:</strong><br>${i.name}</div>
      <div class="col-md-6"><strong>Type:</strong><br>${i.type}</div>
      ${i.email ? `<div class="col-md-6"><strong>Email:</strong><br><a href="mailto:${i.email}">${i.email}</a></div>` : ''}
      ${i.phone ? `<div class="col-md-6"><strong>Phone:</strong><br><a href="tel:${i.phone}">${i.phone}</a></div>` : ''}
      ${i.subject ? `<div class="col-12"><strong>Subject:</strong><br>${i.subject}</div>` : ''}
      <div class="col-12"><strong>Message:</strong><br><p class="p-3 rounded" style="background:#f8f9fa">${i.message || '—'}</p></div>
      ${i.room_type ? `<div class="col-md-4"><strong>Room Type:</strong><br>${i.room_type}</div>` : ''}
      ${i.check_in ? `<div class="col-md-4"><strong>Check-In:</strong><br>${i.check_in}</div>` : ''}
      ${i.check_out ? `<div class="col-md-4"><strong>Check-Out:</strong><br>${i.check_out}</div>` : ''}
      ${i.guests ? `<div class="col-md-4"><strong>Guests:</strong><br>${i.guests}</div>` : ''}
      <div class="col-12"><strong>Received:</strong> ${i.created_at}</div>
    </div>
    ${i.email ? `<div class="mt-3"><a href="mailto:${i.email}?subject=Re: ${i.subject||'Your Inquiry - Mahua House'}" class="btn-mahua btn">Reply via Email</a></div>` : ''}
  `;
  new bootstrap.Modal(document.getElementById('viewModal')).show();
}
</script>
@endsection

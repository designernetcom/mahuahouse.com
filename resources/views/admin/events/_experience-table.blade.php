<div class="table-responsive">
  <table class="table mb-0">
    <thead>
      <tr><th>Image</th><th>Title</th><th>Icon</th><th>Tag / Badge</th><th>Description</th><th>Order</th><th>Active</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($items as $item)
      <tr>
        <td>
          @if($item->image_url)
            <img src="{{ $item->image_url }}" class="table-img">
          @else
            <div style="width:52px;height:40px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>
          @endif
        </td>
        <td><strong>{{ $item->title }}</strong></td>
        <td>
          @if($item->icon)
            <i class="{{ $item->icon }}" style="font-size:18px;color:#033631;"></i>
            <br><code style="font-size:10px;color:#aaa;">{{ $item->icon }}</code>
          @else
            <span style="color:#ccc;">—</span>
          @endif
        </td>
        <td>
          @if($item->link)
            <span class="badge bg-secondary" style="font-size:11px;">{{ $item->link }}</span>
          @else
            <span style="color:#ccc;">—</span>
          @endif
        </td>
        <td style="max-width:220px;font-size:12px;color:#555;">{{ Str::limit($item->description, 70) }}</td>
        <td>{{ $item->sort_order }}</td>
        <td><span class="{{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $item->is_active ? 'Active' : 'Off' }}</span></td>
        <td style="white-space:nowrap;">
          @php
            $updateUrl = route('admin.' . $updateRoute, $item);
            $tabLabel = str_replace(['event-types','venues','features'], ['Event Type','Venue','Feature'], $updateRoute);
            $tabLabel = Str::before($tabLabel, '.update');
            $tabLabel = Str::afterLast($tabLabel, '.');
          @endphp
          <button class="btn btn-sm btn-outline-primary me-1"
            onclick='editExp(@json($item), "{{ $updateUrl }}", "{{ ucfirst($tabLabel) }}")'>
            <i class="bi bi-pencil"></i>
          </button>
          <form method="POST" action="{{ route('admin.' . $deleteRoute, $item) }}" style="display:inline" onsubmit="return confirm('Delete this item?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" class="text-center text-muted py-4">No items yet. Use the button above to add one.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

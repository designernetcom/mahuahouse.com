@extends('layouts.admin')
@section('title', 'Blog Posts')

@section('content')
<div class="table-card">
  <div class="card-header-custom">
    <h5><i class="bi bi-journal-richtext me-2" style="color:#DAA520"></i>Blog Posts</h5>
    <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#blogModal" onclick="resetForm()">
      <i class="bi bi-plus-lg me-1"></i>Add Post
    </button>
  </div>
  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>Image</th><th>Title</th><th>Author</th><th>Category</th><th>Published</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($posts as $post)
        <tr>
          <td>@if($post->image_url)<img src="{{ $post->image_url }}" class="table-img">@else<span class="text-muted">—</span>@endif</td>
          <td>
            <strong>{{ $post->title }}</strong>
            <br><small class="text-muted" style="font-size:11px;">/blog/{{ $post->slug }}</small>
          </td>
          <td style="font-size:12px;">{{ $post->author ?: '—' }}</td>
          <td><span class="badge bg-secondary text-capitalize" style="font-size:11px;">{{ $post->category ?: '—' }}</span></td>
          <td style="font-size:12px;">{{ $post->published_at ? $post->published_at->format('d M Y') : '—' }}</td>
          <td><span class="{{ $post->is_published ? 'badge-active' : 'badge-inactive' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick='editPost(@json($post))'><i class="bi bi-pencil"></i></button>
            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" style="display:inline" onsubmit="return confirm('Delete this post?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">No blog posts yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($posts->hasPages())
  <div class="p-3">{{ $posts->links() }}</div>
  @endif
</div>

<div class="modal fade" id="blogModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <form method="POST" id="blogForm">
      @csrf <input type="hidden" name="_method" id="form_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="modalTitle">Add Blog Post</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-12"><label class="form-label">Title *</label><input type="text" name="title" id="title" class="form-control" required placeholder="Post title"></div>
          <div class="col-md-6"><label class="form-label">Author</label><input type="text" name="author" id="author" class="form-control" placeholder="e.g. Mahua House Team"></div>
          <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category" id="category" class="form-select">
              <option value="">— Select —</option>
              <option value="nature">Nature</option>
              <option value="travel">Travel</option>
              <option value="food">Food & Dining</option>
              <option value="culture">Culture</option>
              <option value="wellness">Wellness</option>
              <option value="news">News</option>
            </select>
          </div>
          <div class="col-12"><label class="form-label">Excerpt</label><textarea name="excerpt" id="excerpt" class="form-control" rows="2" placeholder="Short summary shown in listing..."></textarea></div>
          <div class="col-12"><label class="form-label">Content</label><textarea name="content" id="content" class="form-control" rows="8" placeholder="Full blog post content..."></textarea></div>
          <div class="col-12">
            <label class="form-label">Featured Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="image_url" class="form-control" placeholder="/site/assets/images/blog/...">
              <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('imgPreview'), document.getElementById('image_url'))"></label>
            </div>
            <img id="imgPreview" class="img-preview" style="display:none">
          </div>
          <div class="col-md-6"><label class="form-label">Tags (comma-separated)</label><input type="text" name="tags" id="tags" class="form-control" placeholder="eco, nature, resort"></div>
          <div class="col-md-6"><label class="form-label">Read Time (mins)</label><input type="number" name="read_time" id="read_time" class="form-control" value="5" min="1"></div>
          <div class="col-12 d-flex gap-4">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_published" id="is_published"><label class="form-check-label" for="is_published">Published</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"><label class="form-check-label" for="is_featured">Featured</label></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-mahua btn">Save Post</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
const createUrl = "{{ route('admin.blog.store') }}";
function resetForm() {
  document.getElementById('blogForm').action = createUrl;
  document.getElementById('form_method').value = 'POST';
  document.getElementById('modalTitle').textContent = 'Add Blog Post';
  ['title','author','excerpt','content','image_url','tags'].forEach(f => document.getElementById(f).value = '');
  document.getElementById('category').value = '';
  document.getElementById('read_time').value = 5;
  document.getElementById('is_published').checked = false;
  document.getElementById('is_featured').checked = false;
  document.getElementById('imgPreview').style.display = 'none';
}
function editPost(p) {
  document.getElementById('blogForm').action = `/admin/blog/${p.id}`;
  document.getElementById('form_method').value = 'PUT';
  document.getElementById('modalTitle').textContent = 'Edit Blog Post';
  document.getElementById('title').value = p.title || '';
  document.getElementById('author').value = p.author || '';
  document.getElementById('excerpt').value = p.excerpt || '';
  document.getElementById('content').value = p.content || '';
  document.getElementById('image_url').value = p.image_url || '';
  document.getElementById('category').value = p.category || '';
  document.getElementById('read_time').value = p.read_time || 5;
  document.getElementById('tags').value = Array.isArray(p.tags) ? p.tags.join(', ') : (p.tags || '');
  document.getElementById('is_published').checked = p.is_published == 1;
  document.getElementById('is_featured').checked = p.is_featured == 1;
  const prev = document.getElementById('imgPreview');
  if (p.image_url) { prev.src = p.image_url; prev.style.display = 'block'; } else prev.style.display = 'none';
  new bootstrap.Modal(document.getElementById('blogModal')).show();
}
</script>
@endsection

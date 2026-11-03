@extends('layouts.admin')
@section('title', 'Day Out Plan — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-sun-fill me-2" style="color:#DAA520;"></i>Day Out Plan — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage includes cards, activity cards, gallery, and all page text. Packages → use <strong>Special Offers</strong>. FAQs → use <strong>FAQ</strong> with category <code>day-out</code>.</p>
  </div>
  <a href="{{ url('/day-out-plan') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="dpTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-includes" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-grid me-1"></i>Includes <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $includes->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-activities" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-camera me-1"></i>Activities <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $activities->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-gallery" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-images me-1"></i>Gallery <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $gallery->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="{{ route('admin.offers.index') }}" style="font-size:13px;font-weight:600;color:#DAA520;"><i class="bi bi-tag-fill me-1"></i>Packages →</a></li>
  <li class="nav-item"><a class="nav-link" href="{{ route('admin.faq.index') }}" style="font-size:13px;font-weight:600;color:#DAA520;"><i class="bi bi-question-circle-fill me-1"></i>FAQs →</a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — INCLUDES ════ --}}
  <div class="tab-pane fade show active" id="tab-includes">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Icon cards in the <strong>"Everything Your Day Includes"</strong> section. Each needs an icon (Font Awesome), title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#incModal" onclick="resetInc()"><i class="bi bi-plus-lg me-1"></i>Add Card</button>
      </div>
      <div class="row g-3">
        @forelse($includes as $inc)
        <div class="col-lg-4 col-md-6">
          <div style="background:#f8faf8;border:1px solid #e0e8e0;border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(3,54,49,.07);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="{{ $inc->icon ?: 'fa-solid fa-star' }}" style="font-size:20px;color:#033631;"></i>
            </div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;">
                <strong style="font-size:13px;color:#033631;">{{ $inc->title }}</strong>
                <span class="{{ $inc->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $inc->is_active ? 'On' : 'Off' }}</span>
                <span style="font-size:11px;color:#aaa;margin-left:auto;">{{ $inc->sort_order }}</span>
              </div>
              <p style="font-size:12px;color:#666;margin:0 0 8px;">{{ Str::limit($inc->description, 60) }}</p>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" onclick='editInc(@json($inc))'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.day-out-plan-admin.includes.destroy', $inc) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No include cards yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — ACTIVITIES ════ --}}
  <div class="tab-pane fade" id="tab-activities">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Image-overlay cards in the <strong>"What You Can Do Here"</strong> section. Each needs an image, icon, title, and description (shown on hover).</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#actModal" onclick="resetAct()"><i class="bi bi-plus-lg me-1"></i>Add Activity</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Image</th><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($activities as $act)
            <tr>
              <td>@if($act->image_url)<img src="{{ $act->image_url }}" class="table-img">@else<div style="width:52px;height:40px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>@endif</td>
              <td><i class="{{ $act->icon ?: 'fa-solid fa-leaf' }}" style="font-size:18px;color:#DAA520;"></i></td>
              <td><strong>{{ $act->title }}</strong></td>
              <td style="max-width:220px;font-size:12px;color:#555;">{{ Str::limit($act->description, 60) }}</td>
              <td>{{ $act->sort_order }}</td>
              <td><span class="{{ $act->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $act->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editAct(@json($act))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.day-out-plan-admin.activities.destroy', $act) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No activities yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 3 — GALLERY ════ --}}
  <div class="tab-pane fade" id="tab-gallery">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Photos in the <strong>gallery grid</strong> (up to 6). First photo spans tall, second spans wide.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="resetGallery()"><i class="bi bi-plus-lg me-1"></i>Add Photo</button>
      </div>
      <div class="row g-3">
        @forelse($gallery as $item)
        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
          <div style="border-radius:10px;overflow:hidden;border:1px solid #e0e8e0;background:#f8faf8;">
            <div style="height:120px;overflow:hidden;position:relative;">
              <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
              @if(!$item->is_active)<div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;"><span style="color:#fff;font-size:11px;font-weight:700;background:rgba(220,53,69,.8);padding:3px 8px;border-radius:4px;">HIDDEN</span></div>@endif
            </div>
            <div style="padding:8px 10px;">
              <p style="font-size:11px;font-weight:600;color:#033631;margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->title ?: 'Untitled' }}</p>
              <p style="font-size:10px;color:#aaa;margin:0 0 6px;">Order: {{ $item->sort_order }}</p>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary flex-fill" style="font-size:11px;padding:3px;" onclick='editGallery(@json($item))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.day-out-plan-admin.gallery.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger flex-fill" style="font-size:11px;padding:3px;"><i class="bi bi-trash"></i></button></form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No photos yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 4 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, labels, and text blocks. HTML allowed in heading fields.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetSection()"><i class="bi bi-plus-lg me-1"></i>Add Text Field</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>#</th><th>Key</th><th>Label</th><th>Value</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($sections as $i => $s)
            <tr>
              <td class="text-muted" style="font-size:11px;">{{ $i+1 }}</td>
              <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $s->section_key }}</code></td>
              <td style="font-size:13px;font-weight:500;white-space:nowrap;">{{ $s->label ?: '—' }}</td>
              <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 80) }}</td>
              <td>{{ $s->sort_order }}</td>
              <td><span class="{{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $s->is_active ? 'Yes' : 'No' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($s))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.day-out-plan-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No text sections yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div style="margin-top:20px;background:#f8faf8;border-radius:10px;padding:14px 18px;border:1px solid #e0e8e0;font-size:11px;">
        <strong style="color:#033631;">Available Keys:</strong>
        <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:6px;">
          @foreach(['hero_image','hero_label','hero_heading','hero_text','hero_pills','inc_label','inc_heading','inc_text','act_label','act_heading','pkg_label','pkg_heading','pkg_text','group_icon','group_title','group_text','group_cta','gallery_label','gallery_heading','gallery_cta','faq_label','faq_heading','faq_text','cta_label','cta_heading','cta_text','cta_btn1'] as $k)
          <code style="background:#e7eeee;padding:2px 6px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
        <p style="margin:8px 0 0;color:#888;"><strong style="color:#033631;">hero_pills</strong> format (one per line): <code>fa-solid fa-sun|8 AM – 8 PM</code></p>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Include Card Modal --}}
<div class="modal fade" id="incModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="incForm">
      @csrf <input type="hidden" name="_method" id="ic_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="ic_title">Add Include Card</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="ic_name" class="form-control" required placeholder="e.g. Swimming Pool"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="ic_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="ic_icon" class="form-control" placeholder="fa-solid fa-person-swimming">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="ic_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="ic_desc" class="form-control" rows="2" placeholder="Short description..."></textarea></div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="ic_active" checked><label class="form-check-label" for="ic_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Activity Modal --}}
<div class="modal fade" id="actModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="actForm">
      @csrf <input type="hidden" name="_method" id="ac_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="ac_title">Add Activity</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="ac_name" class="form-control" required placeholder="e.g. Birdwatching"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="ac_order" class="form-control" value="0"></div>
          <div class="col-md-6">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="ac_icon" class="form-control" placeholder="fa-solid fa-binoculars">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="ac_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="ac_img" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('ac_preview'),document.getElementById('ac_img'))"></label>
            </div>
            <img id="ac_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12"><label class="form-label">Description <small class="text-muted">(shown on hover)</small></label><textarea name="description" id="ac_desc" class="form-control" rows="2" placeholder="Description shown when hovering over the card..."></textarea></div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="ac_active" checked><label class="form-check-label" for="ac_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Gallery Modal --}}
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="galleryForm">
      @csrf <input type="hidden" name="_method" id="g_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="g_title">Add Gallery Photo</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Photo Title</label><input type="text" name="title" id="g_name" class="form-control" placeholder="e.g. Forest Walk"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="g_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Photo *</label>
            <div class="input-group">
              <input type="text" name="image_url" id="g_url" class="form-control" placeholder="/site/assets/images/..." required>
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('g_preview'),document.getElementById('g_url'))"></label>
            </div>
            <img id="g_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12 d-flex align-items-center"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="g_active" checked><label class="form-check-label" for="g_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save Photo</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Page Section Modal --}}
<div class="modal fade" id="sectionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="sectionForm">
      @csrf <input type="hidden" name="_method" id="s_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="s_title">Add Text Field</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Key *</label><input type="text" name="section_key" id="s_key" class="form-control" required placeholder="e.g. hero_heading"><small class="text-muted">Lowercase with underscores.</small></div>
          <div class="col-md-6"><label class="form-label">Label</label><input type="text" name="label" id="s_label" class="form-control"></div>
          <div class="col-12"><label class="form-label">Value <small class="text-muted">(HTML OK in headings)</small></label><textarea name="value" id="s_value" class="form-control" rows="5"></textarea></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="s_order" class="form-control" value="0"></div>
          <div class="col-md-8 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="s_active" checked><label class="form-check-label" for="s_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
const createIncUrl     = "{{ route('admin.day-out-plan-admin.includes.store') }}";
const createActUrl     = "{{ route('admin.day-out-plan-admin.activities.store') }}";
const createGalleryUrl = "{{ route('admin.day-out-plan-admin.gallery.store') }}";
const createSectionUrl = "{{ route('admin.day-out-plan-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#dpTabs .nav-link[data-bs-toggle="tab"]').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

document.getElementById('ic_icon').addEventListener('input', function(){ document.getElementById('ic_icon_preview').className = this.value; });
document.getElementById('ac_icon').addEventListener('input', function(){ document.getElementById('ac_icon_preview').className = this.value; });

function resetInc() { document.getElementById('incForm').action=createIncUrl; document.getElementById('ic_method').value='POST'; document.getElementById('ic_title').textContent='Add Include Card'; ['ic_name','ic_icon','ic_desc'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('ic_order').value=0; document.getElementById('ic_active').checked=true; document.getElementById('ic_icon_preview').className=''; }
function editInc(item) { document.getElementById('incForm').action=`/admin/day-out-plan-admin/includes/${item.id}`; document.getElementById('ic_method').value='PUT'; document.getElementById('ic_title').textContent='Edit Include Card'; document.getElementById('ic_name').value=item.title||''; document.getElementById('ic_icon').value=item.icon||''; document.getElementById('ic_desc').value=item.description||''; document.getElementById('ic_order').value=item.sort_order||0; document.getElementById('ic_active').checked=item.is_active==1; document.getElementById('ic_icon_preview').className=item.icon||''; new bootstrap.Modal(document.getElementById('incModal')).show(); }

function resetAct() { document.getElementById('actForm').action=createActUrl; document.getElementById('ac_method').value='POST'; document.getElementById('ac_title').textContent='Add Activity'; ['ac_name','ac_icon','ac_desc','ac_img'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('ac_order').value=0; document.getElementById('ac_active').checked=true; document.getElementById('ac_icon_preview').className=''; document.getElementById('ac_preview').style.display='none'; }
function editAct(act) { document.getElementById('actForm').action=`/admin/day-out-plan-admin/activities/${act.id}`; document.getElementById('ac_method').value='PUT'; document.getElementById('ac_title').textContent='Edit Activity'; document.getElementById('ac_name').value=act.title||''; document.getElementById('ac_icon').value=act.icon||''; document.getElementById('ac_desc').value=act.description||''; document.getElementById('ac_img').value=act.image_url||''; document.getElementById('ac_order').value=act.sort_order||0; document.getElementById('ac_active').checked=act.is_active==1; document.getElementById('ac_icon_preview').className=act.icon||''; const p=document.getElementById('ac_preview'); if(act.image_url){p.src=act.image_url;p.style.display='block';}else p.style.display='none'; new bootstrap.Modal(document.getElementById('actModal')).show(); }

function resetGallery() { document.getElementById('galleryForm').action=createGalleryUrl; document.getElementById('g_method').value='POST'; document.getElementById('g_title').textContent='Add Gallery Photo'; ['g_name','g_url'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('g_order').value=0; document.getElementById('g_active').checked=true; document.getElementById('g_preview').style.display='none'; }
function editGallery(g) { document.getElementById('galleryForm').action=`/admin/day-out-plan-admin/gallery/${g.id}`; document.getElementById('g_method').value='PUT'; document.getElementById('g_title').textContent='Edit Gallery Photo'; document.getElementById('g_name').value=g.title||''; document.getElementById('g_url').value=g.image_url||''; document.getElementById('g_order').value=g.sort_order||0; document.getElementById('g_active').checked=g.is_active==1; const prev=document.getElementById('g_preview'); if(g.image_url){prev.src=g.image_url;prev.style.display='block';}else prev.style.display='none'; new bootstrap.Modal(document.getElementById('galleryModal')).show(); }

function resetSection() { document.getElementById('sectionForm').action=createSectionUrl; document.getElementById('s_method').value='POST'; document.getElementById('s_title').textContent='Add Text Field'; ['s_key','s_label','s_value'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('s_order').value=0; document.getElementById('s_active').checked=true; document.getElementById('s_key').removeAttribute('readonly'); }
function editSection(s) { document.getElementById('sectionForm').action=`/admin/day-out-plan-admin/sections/${s.id}`; document.getElementById('s_method').value='PUT'; document.getElementById('s_title').textContent='Edit Text Field'; document.getElementById('s_key').value=s.section_key||''; document.getElementById('s_key').setAttribute('readonly',true); document.getElementById('s_label').value=s.label||''; document.getElementById('s_value').value=s.value||''; document.getElementById('s_order').value=s.sort_order||0; document.getElementById('s_active').checked=s.is_active==1; new bootstrap.Modal(document.getElementById('sectionModal')).show(); }
</script>
@endsection

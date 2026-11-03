@extends('layouts.admin')
@section('title', 'Food & Dining — Manage Content')

@section('content')

<div style="background:#fff;border-radius:14px;padding:18px 24px;margin-bottom:22px;box-shadow:0 1px 6px rgba(3,54,49,.07);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div>
    <h5 style="margin:0;font-size:16px;font-weight:700;color:#033631;"><i class="bi bi-egg-fried me-2" style="color:#DAA520;"></i>Food & Dining — Content Manager</h5>
    <p style="margin:4px 0 0;font-size:12px;color:#888;">Manage dining option cards, meal schedule cards, quality cards, and all page text.</p>
  </div>
  <a href="{{ url('/food-dining') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
    <i class="bi bi-box-arrow-up-right"></i> Preview Page
  </a>
</div>

<ul class="nav nav-tabs mb-0" id="fdTabs" style="border-bottom:2px solid #e8ede8;">
  <li class="nav-item"><a class="nav-link active" href="#tab-options" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-grid me-1"></i>Dining Options <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $diningOptions->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-meals" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-clock me-1"></i>Meal Schedule <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $mealCards->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-quality" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-shield-check me-1"></i>Quality Cards <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $qualityCards->count() }}</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#tab-text" data-bs-toggle="tab" style="font-size:13px;font-weight:600;"><i class="bi bi-file-earmark-text me-1"></i>Page Text <span class="badge bg-secondary ms-1" style="font-size:10px;">{{ $sections->count() }}</span></a></li>
</ul>

<div class="tab-content" style="background:#fff;border-radius:0 0 14px 14px;box-shadow:0 1px 6px rgba(3,54,49,.07);">

  {{-- ════ TAB 1 — DINING OPTIONS ════ --}}
  <div class="tab-pane fade show active" id="tab-options">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Hover cards in the <strong>"Three Ways to Dine With Us"</strong> section. Icon, title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#optModal" onclick="resetOpt()"><i class="bi bi-plus-lg me-1"></i>Add Option</button>
      </div>
      <div class="row g-3">
        @forelse($diningOptions as $opt)
        <div class="col-lg-4">
          <div style="background:#f8faf8;border:1px solid #e0e8e0;border-radius:12px;padding:18px;display:flex;gap:12px;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(218,165,32,.1);border:1px solid rgba(218,165,32,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="{{ $opt->icon ?: 'fa-solid fa-utensils' }}" style="font-size:20px;color:#DAA520;"></i></div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;"><strong style="font-size:13px;color:#033631;">{{ $opt->title }}</strong><span class="{{ $opt->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $opt->is_active ? 'On' : 'Off' }}</span><span style="font-size:11px;color:#aaa;margin-left:auto;">{{ $opt->sort_order }}</span></div>
              <p style="font-size:12px;color:#666;margin:0 0 8px;">{{ Str::limit($opt->description, 70) }}</p>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary" onclick='editOpt(@json($opt))'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.food-dining-admin.dining-options.destroy', $opt) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-4">No dining options yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 2 — MEAL SCHEDULE ════ --}}
  <div class="tab-pane fade" id="tab-meals">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div style="font-size:13px;color:#666;max-width:600px;">
          Cards in the <strong>"From Sunrise to Sunset"</strong> section. <strong>Time Period</strong> = label shown on badge (e.g. "Early Morning"). <strong>Icon</strong> = icon on badge.<br>
          <strong>Description field format</strong>: paragraph text, then <code>---</code> on its own line, then items one per line.
        </div>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#mealModal" onclick="resetMeal()"><i class="bi bi-plus-lg me-1"></i>Add Meal</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Image</th><th>Title</th><th>Time / Icon</th><th>Description + Items</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($mealCards as $meal)
            @php
              $parts = explode('---', $meal->description ?? '', 2);
              $para  = trim($parts[0] ?? '');
              $items = array_filter(array_map('trim', explode("\n", $parts[1] ?? '')));
            @endphp
            <tr>
              <td>@if($meal->image_url)<img src="{{ $meal->image_url }}" class="table-img">@else<div style="width:52px;height:40px;border-radius:6px;background:#f0f4f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image" style="color:#ccc;"></i></div>@endif</td>
              <td><strong>{{ $meal->title }}</strong></td>
              <td style="font-size:12px;white-space:nowrap;"><i class="{{ $meal->icon }}" style="color:#DAA520;margin-right:4px;"></i>{{ $meal->link }}</td>
              <td style="max-width:220px;font-size:11px;color:#555;">{{ Str::limit($para, 50) }}<br><em style="color:#aaa;">{{ count($items) }} item(s)</em></td>
              <td>{{ $meal->sort_order }}</td>
              <td><span class="{{ $meal->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $meal->is_active ? 'On' : 'Off' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editMeal(@json($meal))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.food-dining-admin.meal-cards.destroy', $meal) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No meal cards yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ════ TAB 3 — QUALITY CARDS ════ --}}
  <div class="tab-pane fade" id="tab-quality">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">Dark cards in the <strong>"Fresh, Hygienic & Locally Inspired"</strong> section. Icon, title, and description.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#qualModal" onclick="resetQual()"><i class="bi bi-plus-lg me-1"></i>Add Card</button>
      </div>
      <div class="row g-3">
        @forelse($qualityCards as $q)
        <div class="col-lg-6">
          <div style="background:#033631;border-radius:12px;padding:18px;display:flex;gap:12px;align-items:flex-start;">
            <div style="width:48px;height:48px;border-radius:50%;background:rgba(218,165,32,.15);border:1px solid rgba(218,165,32,.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="{{ $q->icon ?: 'fa-solid fa-star' }}" style="font-size:20px;color:#DAA520;"></i></div>
            <div style="flex:1;min-width:0;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;"><strong style="font-size:14px;color:#fff;">{{ $q->title }}</strong><span class="{{ $q->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $q->is_active ? 'On' : 'Off' }}</span><span style="font-size:11px;color:rgba(255,255,255,.4);margin-left:auto;">{{ $q->sort_order }}</span></div>
              <p style="font-size:12px;color:rgba(255,255,255,.55);margin:0 0 10px;">{{ Str::limit($q->description, 70) }}</p>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-light" onclick='editQual(@json($q))'><i class="bi bi-pencil me-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin.food-dining-admin.quality-cards.destroy', $q) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Delete</button></form>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">No quality cards yet.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ════ TAB 4 — PAGE TEXT ════ --}}
  <div class="tab-pane fade" id="tab-text">
    <div style="padding:20px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p style="margin:0;font-size:13px;color:#666;">All headings, labels, pricing banner text, and images. HTML allowed in headings.</p>
        <button class="btn-mahua btn" data-bs-toggle="modal" data-bs-target="#sectionModal" onclick="resetSection()"><i class="bi bi-plus-lg me-1"></i>Add Text Field</button>
      </div>
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>#</th><th>Key</th><th>Label</th><th>Value</th><th>Image</th><th>Order</th><th>Active</th><th>Actions</th></tr></thead>
          <tbody>
            @forelse($sections as $i => $s)
            <tr>
              <td class="text-muted" style="font-size:11px;">{{ $i+1 }}</td>
              <td><code style="font-size:11px;background:#f0f4f0;padding:2px 6px;border-radius:4px;">{{ $s->section_key }}</code></td>
              <td style="font-size:13px;font-weight:500;white-space:nowrap;">{{ $s->label ?: '—' }}</td>
              <td style="max-width:260px;font-size:12px;color:#555;">{{ Str::limit(strip_tags($s->value), 80) }}</td>
              <td>@if($s->media_url)<img src="{{ $s->media_url }}" style="width:44px;height:34px;object-fit:cover;border-radius:4px;">@else<span style="color:#ccc;">—</span>@endif</td>
              <td>{{ $s->sort_order }}</td>
              <td><span class="{{ $s->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $s->is_active ? 'Yes' : 'No' }}</span></td>
              <td style="white-space:nowrap;">
                <button class="btn btn-sm btn-outline-primary me-1" onclick='editSection(@json($s))'><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.food-dining-admin.sections.destroy', $s) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No text sections yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div style="margin-top:18px;background:#f8faf8;border-radius:10px;padding:14px 18px;border:1px solid #e0e8e0;font-size:11px;">
        <strong style="color:#033631;">Keys:</strong>
        <div style="display:flex;flex-wrap:wrap;gap:4px;margin-top:6px;">
          @foreach(['hero_image','hero_label','hero_heading','hero_text','hero_cta1','hero_cta2','price_label','price_value','price_unit','price_includes','price_pills','opt_label','opt_heading','opt_text','meal_label','meal_heading','meal_text','custom_image','custom_badge_icon','custom_badge_title','custom_badge_sub','custom_label','custom_heading','custom_text','custom_cta','mini1_icon','mini1_title','mini1_desc','mini2_icon','mini2_title','mini2_desc','mini3_icon','mini3_title','mini3_desc','mini4_icon','mini4_title','mini4_desc','quality_label','quality_heading','cta_label','cta_heading','cta_text'] as $k)
          <code style="background:#e7eeee;padding:2px 6px;border-radius:4px;color:#033631;">{{ $k }}</code>
          @endforeach
        </div>
        <p style="margin:8px 0 0;color:#888;"><strong style="color:#033631;">price_pills</strong>: one label per line. <strong style="color:#033631;">Meal card description</strong>: paragraph, then <code>---</code>, then items (one per line).</p>
      </div>
    </div>
  </div>

</div>

{{-- ═══ MODALS ═══ --}}

{{-- Dining Option Modal --}}
<div class="modal fade" id="optModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="optForm">
      @csrf <input type="hidden" name="_method" id="op_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="op_title">Add Dining Option</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="op_name" class="form-control" required placeholder="e.g. Traditional Meals"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="op_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="op_icon" class="form-control" placeholder="fa-solid fa-bowl-rice">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="op_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="op_desc" class="form-control" rows="3" placeholder="Description shown on the card..."></textarea></div>
          <div class="col-12 d-flex"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="op_active" checked><label class="form-check-label" for="op_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Meal Card Modal --}}
<div class="modal fade" id="mealModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="mealForm">
      @csrf <input type="hidden" name="_method" id="ml_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="ml_title">Add Meal Card</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-6"><label class="form-label">Meal Title *</label><input type="text" name="title" id="ml_name" class="form-control" required placeholder="e.g. Bed Tea"></div>
          <div class="col-md-3"><label class="form-label">Time Period <small class="text-muted">(badge text)</small></label><input type="text" name="link" id="ml_link" class="form-control" placeholder="e.g. Early Morning"></div>
          <div class="col-md-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="ml_order" class="form-control" value="0"></div>
          <div class="col-md-6">
            <label class="form-label">Icon <small class="text-muted">(badge icon)</small></label>
            <input type="text" name="icon" id="ml_icon" class="form-control" placeholder="fa-solid fa-mug-hot">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="ml_icon_preview" style="font-size:18px;color:#DAA520;margin-left:4px;"></i></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Image</label>
            <div class="input-group">
              <input type="text" name="image_url" id="ml_img" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('ml_preview'),document.getElementById('ml_img'))"></label>
            </div>
            <img id="ml_preview" class="img-preview" style="display:none">
          </div>
          <div class="col-12">
            <label class="form-label">Description + Items <small class="text-muted">(paragraph, then <code>---</code> on its own line, then items one per line)</small></label>
            <textarea name="description" id="ml_desc" class="form-control" rows="7" placeholder="A warm cup of chai served to your room as the forest wakes around you.&#10;---&#10;Fresh masala chai / green tea&#10;Light biscuits or dry snack&#10;Served at your room / cottage"></textarea>
          </div>
          <div class="col-12 d-flex"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="ml_active" checked><label class="form-check-label" for="ml_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
      </div>
    </form>
  </div>
</div>

{{-- Quality Card Modal --}}
<div class="modal fade" id="qualModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="qualForm">
      @csrf <input type="hidden" name="_method" id="ql_method" value="POST">
      <div class="modal-content">
        <div class="modal-header"><h6 class="modal-title" id="ql_title">Add Quality Card</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body row g-3">
          <div class="col-md-8"><label class="form-label">Title *</label><input type="text" name="title" id="ql_name" class="form-control" required placeholder="e.g. Fresh Ingredients"></div>
          <div class="col-md-4"><label class="form-label">Sort Order</label><input type="number" name="sort_order" id="ql_order" class="form-control" value="0"></div>
          <div class="col-12">
            <label class="form-label">Icon <small class="text-muted">(Font Awesome)</small></label>
            <input type="text" name="icon" id="ql_icon" class="form-control" placeholder="fa-solid fa-carrot">
            <div style="margin-top:6px;font-size:12px;color:#888;">Preview: <i id="ql_icon_preview" style="font-size:20px;color:#DAA520;margin-left:6px;"></i></div>
          </div>
          <div class="col-12"><label class="form-label">Description</label><textarea name="description" id="ql_desc" class="form-control" rows="3"></textarea></div>
          <div class="col-12 d-flex"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" id="ql_active" checked><label class="form-check-label" for="ql_active">Active</label></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn-mahua btn">Save</button></div>
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
          <div class="col-12"><label class="form-label">Value</label><textarea name="value" id="s_value" class="form-control" rows="4"></textarea></div>
          <div class="col-12">
            <label class="form-label">Image URL</label>
            <div class="input-group">
              <input type="text" name="media_url" id="s_media" class="form-control" placeholder="/site/assets/images/...">
              <label class="btn btn-outline-secondary mb-0">Upload<input type="file" accept="image/*" style="display:none" onchange="uploadImage(this,document.getElementById('s_prev'),document.getElementById('s_media'))"></label>
            </div>
            <img id="s_prev" class="img-preview" style="display:none">
          </div>
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
const createOptUrl     = "{{ route('admin.food-dining-admin.dining-options.store') }}";
const createMealUrl    = "{{ route('admin.food-dining-admin.meal-cards.store') }}";
const createQualUrl    = "{{ route('admin.food-dining-admin.quality-cards.store') }}";
const createSectionUrl = "{{ route('admin.food-dining-admin.sections.store') }}";

document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash;
  if (hash) { const t = document.querySelector(`[href="${hash}"]`); if(t) new bootstrap.Tab(t).show(); }
  document.querySelectorAll('#fdTabs .nav-link[data-bs-toggle="tab"]').forEach(l => l.addEventListener('click', function(){ history.replaceState(null,'',this.getAttribute('href')); }));
});

['op_icon','ml_icon','ql_icon'].forEach(id => {
  const el = document.getElementById(id);
  if (el) el.addEventListener('input', function() { document.getElementById(id+'_preview').className = this.value; });
});

function resetOpt() { document.getElementById('optForm').action=createOptUrl; document.getElementById('op_method').value='POST'; document.getElementById('op_title').textContent='Add Dining Option'; ['op_name','op_icon','op_desc'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('op_order').value=0; document.getElementById('op_active').checked=true; document.getElementById('op_icon_preview').className=''; }
function editOpt(o) { document.getElementById('optForm').action=`/admin/food-dining-admin/dining-options/${o.id}`; document.getElementById('op_method').value='PUT'; document.getElementById('op_title').textContent='Edit Dining Option'; document.getElementById('op_name').value=o.title||''; document.getElementById('op_icon').value=o.icon||''; document.getElementById('op_desc').value=o.description||''; document.getElementById('op_order').value=o.sort_order||0; document.getElementById('op_active').checked=o.is_active==1; document.getElementById('op_icon_preview').className=o.icon||''; new bootstrap.Modal(document.getElementById('optModal')).show(); }

function resetMeal() { document.getElementById('mealForm').action=createMealUrl; document.getElementById('ml_method').value='POST'; document.getElementById('ml_title').textContent='Add Meal Card'; ['ml_name','ml_link','ml_icon','ml_desc','ml_img'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('ml_order').value=0; document.getElementById('ml_active').checked=true; document.getElementById('ml_icon_preview').className=''; document.getElementById('ml_preview').style.display='none'; }
function editMeal(m) { document.getElementById('mealForm').action=`/admin/food-dining-admin/meal-cards/${m.id}`; document.getElementById('ml_method').value='PUT'; document.getElementById('ml_title').textContent='Edit Meal Card'; document.getElementById('ml_name').value=m.title||''; document.getElementById('ml_link').value=m.link||''; document.getElementById('ml_icon').value=m.icon||''; document.getElementById('ml_desc').value=m.description||''; document.getElementById('ml_img').value=m.image_url||''; document.getElementById('ml_order').value=m.sort_order||0; document.getElementById('ml_active').checked=m.is_active==1; document.getElementById('ml_icon_preview').className=m.icon||''; const p=document.getElementById('ml_preview'); if(m.image_url){p.src=m.image_url;p.style.display='block';}else p.style.display='none'; new bootstrap.Modal(document.getElementById('mealModal')).show(); }

function resetQual() { document.getElementById('qualForm').action=createQualUrl; document.getElementById('ql_method').value='POST'; document.getElementById('ql_title').textContent='Add Quality Card'; ['ql_name','ql_icon','ql_desc'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('ql_order').value=0; document.getElementById('ql_active').checked=true; document.getElementById('ql_icon_preview').className=''; }
function editQual(q) { document.getElementById('qualForm').action=`/admin/food-dining-admin/quality-cards/${q.id}`; document.getElementById('ql_method').value='PUT'; document.getElementById('ql_title').textContent='Edit Quality Card'; document.getElementById('ql_name').value=q.title||''; document.getElementById('ql_icon').value=q.icon||''; document.getElementById('ql_desc').value=q.description||''; document.getElementById('ql_order').value=q.sort_order||0; document.getElementById('ql_active').checked=q.is_active==1; document.getElementById('ql_icon_preview').className=q.icon||''; new bootstrap.Modal(document.getElementById('qualModal')).show(); }

function resetSection() { document.getElementById('sectionForm').action=createSectionUrl; document.getElementById('s_method').value='POST'; document.getElementById('s_title').textContent='Add Text Field'; ['s_key','s_label','s_value','s_media'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); document.getElementById('s_order').value=0; document.getElementById('s_active').checked=true; document.getElementById('s_prev').style.display='none'; document.getElementById('s_key').removeAttribute('readonly'); }
function editSection(s) { document.getElementById('sectionForm').action=`/admin/food-dining-admin/sections/${s.id}`; document.getElementById('s_method').value='PUT'; document.getElementById('s_title').textContent='Edit Text Field'; document.getElementById('s_key').value=s.section_key||''; document.getElementById('s_key').setAttribute('readonly',true); document.getElementById('s_label').value=s.label||''; document.getElementById('s_value').value=s.value||''; document.getElementById('s_media').value=s.media_url||''; document.getElementById('s_order').value=s.sort_order||0; document.getElementById('s_active').checked=s.is_active==1; const prev=document.getElementById('s_prev'); if(s.media_url){prev.src=s.media_url;prev.style.display='block';}else prev.style.display='none'; new bootstrap.Modal(document.getElementById('sectionModal')).show(); }
</script>
@endsection

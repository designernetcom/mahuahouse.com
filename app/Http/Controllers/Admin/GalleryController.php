<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\PageSection;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $items      = GalleryItem::orderBy('sort_order')->get();
        $categories = GalleryItem::select('category')->distinct()->pluck('category');
        $sections   = PageSection::where('page', 'gallery')->orderBy('sort_order')->get();
        return view('admin.gallery.index', compact('items', 'categories', 'sections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'nullable|string|max:255', 'image_url' => 'required|string', 'category' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        GalleryItem::create($data);
        return back()->with('success', 'Image added to gallery.')->withFragment('tab-photos');
    }

    public function update(Request $request, GalleryItem $galleryItem)
    {
        $data = $request->validate(['title' => 'nullable|string|max:255', 'image_url' => 'required|string', 'category' => 'nullable|string|max:100', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        $galleryItem->update($data);
        return back()->with('success', 'Gallery item updated.')->withFragment('tab-photos');
    }

    public function destroy(GalleryItem $galleryItem)
    {
        $galleryItem->delete();
        return back()->with('success', 'Image removed from gallery.')->withFragment('tab-photos');
    }

    // ── Page Sections ──────────────────────────────────────────────────────────

    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'section_key' => 'required|string|max:100',
            'label'       => 'nullable|string|max:255',
            'value'       => 'nullable|string',
            'media_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['page']      = 'gallery';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'gallery', 'section_key' => $data['section_key']],
            $data
        );
        return back()->with('success', 'Text field saved.')->withFragment('tab-text');
    }

    public function updateSection(Request $request, PageSection $pageSection)
    {
        $data = $request->validate([
            'label'      => 'nullable|string|max:255',
            'value'      => 'nullable|string',
            'media_url'  => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $pageSection->update($data);
        return back()->with('success', 'Text field updated.')->withFragment('tab-text');
    }

    public function destroySection(PageSection $pageSection)
    {
        $pageSection->delete();
        return back()->with('success', 'Text field deleted.')->withFragment('tab-text');
    }
}

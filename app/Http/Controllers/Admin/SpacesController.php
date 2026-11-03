<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\PageSection;
use Illuminate\Http\Request;

class SpacesController extends Controller
{
    public function index()
    {
        return view('admin.spaces.index', [
            'venues'   => Experience::where('category', 'space-venue')->orderBy('sort_order')->get(),
            'gallery'  => GalleryItem::where('category', 'spaces')->orderBy('sort_order')->get(),
            'sections' => PageSection::where('page', 'spaces')->orderBy('sort_order')->get(),
        ]);
    }

    // ── Venues ─────────────────────────────────────────────────────────────────

    public function storeVenue(Request $request)
    {
        $data = $this->validateVenue($request);
        Experience::create(array_merge($data, ['category' => 'space-venue']));
        return back()->with('success', 'Venue added.')->withFragment('tab-venues');
    }

    public function updateVenue(Request $request, Experience $experience)
    {
        $data = $this->validateVenue($request);
        $experience->update(array_merge($data, ['category' => 'space-venue']));
        return back()->with('success', 'Venue updated.')->withFragment('tab-venues');
    }

    public function destroyVenue(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Venue deleted.')->withFragment('tab-venues');
    }

    private function validateVenue(Request $request): array
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'link'        => 'nullable|string|max:255',
            'image_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        return $data;
    }

    // ── Gallery ────────────────────────────────────────────────────────────────

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:255',
            'image_url'  => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);
        $data['category']  = 'spaces';
        $data['is_active'] = $request->has('is_active');
        GalleryItem::create($data);
        return back()->with('success', 'Gallery photo added.')->withFragment('tab-gallery');
    }

    public function updateGallery(Request $request, GalleryItem $galleryItem)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:255',
            'image_url'  => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $galleryItem->update($data);
        return back()->with('success', 'Gallery photo updated.')->withFragment('tab-gallery');
    }

    public function destroyGallery(GalleryItem $galleryItem)
    {
        $galleryItem->delete();
        return back()->with('success', 'Gallery photo deleted.')->withFragment('tab-gallery');
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
        $data['page']      = 'spaces';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'spaces', 'section_key' => $data['section_key']],
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

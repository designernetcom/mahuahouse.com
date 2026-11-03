<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\PageSection;
use App\Models\WeddingFeature;
use App\Models\WeddingTimeline;
use Illuminate\Http\Request;

class DestinationWeddingController extends Controller
{
    public function index()
    {
        return view('admin.destination-wedding.index', [
            'sections'  => PageSection::where('page', 'destination-wedding')->orderBy('sort_order')->get(),
            'features'  => WeddingFeature::orderBy('sort_order')->get(),
            'steps'     => WeddingTimeline::orderBy('sort_order')->get(),
            'gallery'   => GalleryItem::where('category', 'wedding')->orderBy('sort_order')->get(),
        ]);
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
        $data['is_active'] = $request->has('is_active');
        $data['page']      = 'destination-wedding';
        PageSection::updateOrCreate(
            ['page' => 'destination-wedding', 'section_key' => $data['section_key']],
            $data
        );
        return back()->with('success', 'Page text saved.')->withFragment('tab-text');
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
        return back()->with('success', 'Page text updated.')->withFragment('tab-text');
    }

    public function destroySection(PageSection $pageSection)
    {
        $pageSection->delete();
        return back()->with('success', 'Section deleted.')->withFragment('tab-text');
    }

    // ── Wedding Features ───────────────────────────────────────────────────────

    public function storeFeature(Request $request)
    {
        $data = $request->validate([
            'icon'        => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        WeddingFeature::create($data);
        return back()->with('success', 'Feature card added.')->withFragment('tab-features');
    }

    public function updateFeature(Request $request, WeddingFeature $weddingFeature)
    {
        $data = $request->validate([
            'icon'        => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $weddingFeature->update($data);
        return back()->with('success', 'Feature card updated.')->withFragment('tab-features');
    }

    public function destroyFeature(WeddingFeature $weddingFeature)
    {
        $weddingFeature->delete();
        return back()->with('success', 'Feature card deleted.')->withFragment('tab-features');
    }

    // ── Wedding Timeline ───────────────────────────────────────────────────────

    public function storeStep(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        WeddingTimeline::create($data);
        return back()->with('success', 'Step added.')->withFragment('tab-timeline');
    }

    public function updateStep(Request $request, WeddingTimeline $weddingTimeline)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $weddingTimeline->update($data);
        return back()->with('success', 'Step updated.')->withFragment('tab-timeline');
    }

    public function destroyStep(WeddingTimeline $weddingTimeline)
    {
        $weddingTimeline->delete();
        return back()->with('success', 'Step deleted.')->withFragment('tab-timeline');
    }

    // ── Gallery ────────────────────────────────────────────────────────────────

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'title'     => 'nullable|string|max:255',
            'image_url' => 'required|string|max:500',
            'sort_order'=> 'nullable|integer',
        ]);
        $data['category']  = 'wedding';
        $data['is_active'] = $request->has('is_active');
        GalleryItem::create($data);
        return back()->with('success', 'Gallery photo added.')->withFragment('tab-gallery');
    }

    public function updateGallery(Request $request, GalleryItem $galleryItem)
    {
        $data = $request->validate([
            'title'     => 'nullable|string|max:255',
            'image_url' => 'required|string|max:500',
            'sort_order'=> 'nullable|integer',
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
}

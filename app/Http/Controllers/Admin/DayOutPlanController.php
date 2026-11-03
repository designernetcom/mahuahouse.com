<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\PageSection;
use Illuminate\Http\Request;

class DayOutPlanController extends Controller
{
    public function index()
    {
        return view('admin.day-out-plan.index', [
            'includes'   => Experience::where('category', 'day-include')->orderBy('sort_order')->get(),
            'activities' => Experience::where('category', 'day-activity')->orderBy('sort_order')->get(),
            'gallery'    => GalleryItem::where('category', 'day-out')->orderBy('sort_order')->get(),
            'sections'   => PageSection::where('page', 'day-out-plan')->orderBy('sort_order')->get(),
        ]);
    }

    private function validateExp(Request $request, bool $withImage = false): array
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ];
        if ($withImage) $rules['image_url'] = 'nullable|string|max:500';
        $data = $request->validate($rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    // ── Includes ───────────────────────────────────────────────────────────────

    public function storeInclude(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'day-include']));
        return back()->with('success', 'Include card added.')->withFragment('tab-includes');
    }

    public function updateInclude(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'day-include']));
        return back()->with('success', 'Include card updated.')->withFragment('tab-includes');
    }

    public function destroyInclude(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Include card deleted.')->withFragment('tab-includes');
    }

    // ── Activities ─────────────────────────────────────────────────────────────

    public function storeActivity(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request, true), ['category' => 'day-activity']));
        return back()->with('success', 'Activity added.')->withFragment('tab-activities');
    }

    public function updateActivity(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request, true), ['category' => 'day-activity']));
        return back()->with('success', 'Activity updated.')->withFragment('tab-activities');
    }

    public function destroyActivity(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Activity deleted.')->withFragment('tab-activities');
    }

    // ── Gallery ────────────────────────────────────────────────────────────────

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'title'      => 'nullable|string|max:255',
            'image_url'  => 'required|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);
        $data['category']  = 'day-out';
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
        $data['page']      = 'day-out-plan';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'day-out-plan', 'section_key' => $data['section_key']],
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

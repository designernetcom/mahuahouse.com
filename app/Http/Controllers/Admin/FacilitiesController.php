<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class FacilitiesController extends Controller
{
    public function index()
    {
        return view('admin.facilities.index', [
            'facilities' => Experience::where('category', 'facility')->orderBy('sort_order')->get(),
            'sections'   => PageSection::where('page', 'facilities')->orderBy('sort_order')->get(),
        ]);
    }

    // ── Facility Cards ──────────────────────────────────────────────────────────

    public function storeFacility(Request $request)
    {
        $data = $this->validateFacility($request);
        Experience::create(array_merge($data, ['category' => 'facility']));
        return back()->with('success', 'Facility added.')->withFragment('tab-facilities');
    }

    public function updateFacility(Request $request, Experience $experience)
    {
        $data = $this->validateFacility($request);
        $experience->update(array_merge($data, ['category' => 'facility']));
        return back()->with('success', 'Facility updated.')->withFragment('tab-facilities');
    }

    public function destroyFacility(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Facility deleted.')->withFragment('tab-facilities');
    }

    private function validateFacility(Request $request): array
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        return $data;
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
        $data['page']      = 'facilities';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'facilities', 'section_key' => $data['section_key']],
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

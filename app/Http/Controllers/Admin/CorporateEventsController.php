<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class CorporateEventsController extends Controller
{
    public function index()
    {
        return view('admin.corporate-events.index', [
            'features'   => Experience::where('category', 'corporate-why')->orderBy('sort_order')->get(),
            'activities' => Experience::where('category', 'corporate-activity')->orderBy('sort_order')->get(),
            'sections'   => PageSection::where('page', 'corporate-events')->orderBy('sort_order')->get(),
        ]);
    }

    private function validateExp(Request $request): array
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    // ── Why-Choose Features ────────────────────────────────────────────────────

    public function storeFeature(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'corporate-why']));
        return back()->with('success', 'Feature added.')->withFragment('tab-features');
    }

    public function updateFeature(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'corporate-why']));
        return back()->with('success', 'Feature updated.')->withFragment('tab-features');
    }

    public function destroyFeature(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Feature deleted.')->withFragment('tab-features');
    }

    // ── Activities ─────────────────────────────────────────────────────────────

    public function storeActivity(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'corporate-activity']));
        return back()->with('success', 'Activity added.')->withFragment('tab-activities');
    }

    public function updateActivity(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'corporate-activity']));
        return back()->with('success', 'Activity updated.')->withFragment('tab-activities');
    }

    public function destroyActivity(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Activity deleted.')->withFragment('tab-activities');
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
        $data['page']      = 'corporate-events';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'corporate-events', 'section_key' => $data['section_key']],
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

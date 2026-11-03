<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('admin.about.index', [
            'experiences' => Experience::where('category', 'about-experience')->orderBy('sort_order')->get(),
            'sections'    => PageSection::where('page', 'about')->orderBy('sort_order')->get(),
        ]);
    }

    // ── Experience Cards ────────────────────────────────────────────────────────

    public function storeExperience(Request $request)
    {
        $data = $this->validateExp($request);
        Experience::create(array_merge($data, ['category' => 'about-experience']));
        return back()->with('success', 'Experience added.')->withFragment('tab-exp');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        $data = $this->validateExp($request);
        $experience->update(array_merge($data, ['category' => 'about-experience']));
        return back()->with('success', 'Experience updated.')->withFragment('tab-exp');
    }

    public function destroyExperience(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Experience deleted.')->withFragment('tab-exp');
    }

    private function validateExp(Request $request): array
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
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
        $data['page']      = 'about';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'about', 'section_key' => $data['section_key']],
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class EducationalToursController extends Controller
{
    public function index()
    {
        return view('admin.educational-tours.index', [
            'highlights' => Experience::where('category', 'edu-highlight')->orderBy('sort_order')->get(),
            'programs'   => Experience::where('category', 'edu-program')->orderBy('sort_order')->get(),
            'sections'   => PageSection::where('page', 'educational-tours')->orderBy('sort_order')->get(),
        ]);
    }

    private function validateExp(Request $request, bool $withLink = false): array
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ];
        if ($withLink) $rules['link'] = 'nullable|string|max:255';
        $data = $request->validate($rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    // ── Highlights ─────────────────────────────────────────────────────────────

    public function storeHighlight(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'edu-highlight']));
        return back()->with('success', 'Highlight card added.')->withFragment('tab-highlights');
    }

    public function updateHighlight(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'edu-highlight']));
        return back()->with('success', 'Highlight card updated.')->withFragment('tab-highlights');
    }

    public function destroyHighlight(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Highlight card deleted.')->withFragment('tab-highlights');
    }

    // ── Programs ───────────────────────────────────────────────────────────────

    public function storeProgram(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request, true), ['category' => 'edu-program']));
        return back()->with('success', 'Program added.')->withFragment('tab-programs');
    }

    public function updateProgram(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request, true), ['category' => 'edu-program']));
        return back()->with('success', 'Program updated.')->withFragment('tab-programs');
    }

    public function destroyProgram(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Program deleted.')->withFragment('tab-programs');
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
        $data['page']      = 'educational-tours';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'educational-tours', 'section_key' => $data['section_key']],
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

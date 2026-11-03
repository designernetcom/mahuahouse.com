<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class FilmShootsController extends Controller
{
    public function index()
    {
        return view('admin.film-shoots.index', [
            'shootTypes'       => Experience::where('category', 'film-type')->orderBy('sort_order')->get(),
            'locationFeatures' => Experience::where('category', 'film-location')->orderBy('sort_order')->get(),
            'trustBadges'      => Experience::where('category', 'film-trust')->orderBy('sort_order')->get(),
            'sections'         => PageSection::where('page', 'film-shoots')->orderBy('sort_order')->get(),
        ]);
    }

    private function validateExp(Request $request, bool $withImage = false): array
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'link'        => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer',
        ];
        if ($withImage) $rules['image_url'] = 'nullable|string|max:500';
        $data = $request->validate($rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    // ── Shoot Types ────────────────────────────────────────────────────────────

    public function storeShootType(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request, true), ['category' => 'film-type']));
        return back()->with('success', 'Shoot type added.')->withFragment('tab-types');
    }

    public function updateShootType(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request, true), ['category' => 'film-type']));
        return back()->with('success', 'Shoot type updated.')->withFragment('tab-types');
    }

    public function destroyShootType(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Shoot type deleted.')->withFragment('tab-types');
    }

    // ── Location Features ──────────────────────────────────────────────────────

    public function storeLocationFeature(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'film-location']));
        return back()->with('success', 'Location feature added.')->withFragment('tab-location');
    }

    public function updateLocationFeature(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'film-location']));
        return back()->with('success', 'Location feature updated.')->withFragment('tab-location');
    }

    public function destroyLocationFeature(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Location feature deleted.')->withFragment('tab-location');
    }

    // ── Trust Badges ───────────────────────────────────────────────────────────

    public function storeTrustBadge(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'film-trust']));
        return back()->with('success', 'Trust badge added.')->withFragment('tab-trust');
    }

    public function updateTrustBadge(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'film-trust']));
        return back()->with('success', 'Trust badge updated.')->withFragment('tab-trust');
    }

    public function destroyTrustBadge(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Trust badge deleted.')->withFragment('tab-trust');
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
        $data['page']      = 'film-shoots';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'film-shoots', 'section_key' => $data['section_key']],
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class FoodDiningController extends Controller
{
    public function index()
    {
        return view('admin.food-dining.index', [
            'diningOptions' => Experience::where('category', 'dining-option')->orderBy('sort_order')->get(),
            'mealCards'     => Experience::where('category', 'dining-meal')->orderBy('sort_order')->get(),
            'qualityCards'  => Experience::where('category', 'dining-quality')->orderBy('sort_order')->get(),
            'sections'      => PageSection::where('page', 'food-dining')->orderBy('sort_order')->get(),
        ]);
    }

    private function validateExp(Request $request, bool $withImage = false, bool $withLink = false): array
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ];
        if ($withImage) $rules['image_url'] = 'nullable|string|max:500';
        if ($withLink)  $rules['link']      = 'nullable|string|max:255';
        $data = $request->validate($rules);
        $data['is_active'] = $request->has('is_active');
        return $data;
    }

    // ── Dining Options ─────────────────────────────────────────────────────────

    public function storeDiningOption(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'dining-option']));
        return back()->with('success', 'Dining option added.')->withFragment('tab-options');
    }

    public function updateDiningOption(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'dining-option']));
        return back()->with('success', 'Dining option updated.')->withFragment('tab-options');
    }

    public function destroyDiningOption(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Dining option deleted.')->withFragment('tab-options');
    }

    // ── Meal Cards ─────────────────────────────────────────────────────────────

    public function storeMealCard(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request, true, true), ['category' => 'dining-meal']));
        return back()->with('success', 'Meal card added.')->withFragment('tab-meals');
    }

    public function updateMealCard(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request, true, true), ['category' => 'dining-meal']));
        return back()->with('success', 'Meal card updated.')->withFragment('tab-meals');
    }

    public function destroyMealCard(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Meal card deleted.')->withFragment('tab-meals');
    }

    // ── Quality Cards ──────────────────────────────────────────────────────────

    public function storeQualityCard(Request $request)
    {
        Experience::create(array_merge($this->validateExp($request), ['category' => 'dining-quality']));
        return back()->with('success', 'Quality card added.')->withFragment('tab-quality');
    }

    public function updateQualityCard(Request $request, Experience $experience)
    {
        $experience->update(array_merge($this->validateExp($request), ['category' => 'dining-quality']));
        return back()->with('success', 'Quality card updated.')->withFragment('tab-quality');
    }

    public function destroyQualityCard(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Quality card deleted.')->withFragment('tab-quality');
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
        $data['page']      = 'food-dining';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'food-dining', 'section_key' => $data['section_key']],
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

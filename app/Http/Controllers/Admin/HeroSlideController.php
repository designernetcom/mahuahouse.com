<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.hero.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        HeroSlide::create($data);
        return back()->with('success', 'Hero slide added successfully.');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $heroSlide->update($data);
        return back()->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $heroSlide->delete();
        return back()->with('success', 'Hero slide deleted.');
    }
}

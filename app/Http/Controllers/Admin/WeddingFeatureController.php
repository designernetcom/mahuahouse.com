<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeddingFeature;
use Illuminate\Http\Request;

class WeddingFeatureController extends Controller
{
    public function index()
    {
        $features = WeddingFeature::orderBy('sort_order')->get();
        return view('admin.wedding-features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon'        => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        WeddingFeature::create($data);
        return back()->with('success', 'Feature added successfully.');
    }

    public function update(Request $request, WeddingFeature $weddingFeature)
    {
        $data = $request->validate([
            'icon'        => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $weddingFeature->update($data);
        return back()->with('success', 'Feature updated successfully.');
    }

    public function destroy(WeddingFeature $weddingFeature)
    {
        $weddingFeature->delete();
        return back()->with('success', 'Feature deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')->get();
        return view('admin.services.index', compact('experiences'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string', 'icon' => 'nullable|string', 'image_url' => 'nullable|string', 'category' => 'nullable|string|max:100', 'link' => 'nullable|string', 'sort_order' => 'nullable|integer']);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        Experience::create($data);
        return back()->with('success', 'Experience added successfully.');
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string', 'icon' => 'nullable|string', 'image_url' => 'nullable|string', 'category' => 'nullable|string|max:100', 'link' => 'nullable|string', 'sort_order' => 'nullable|integer']);
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $experience->update($data);
        return back()->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Experience deleted.');
    }
}

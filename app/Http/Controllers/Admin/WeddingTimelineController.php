<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeddingTimeline;
use Illuminate\Http\Request;

class WeddingTimelineController extends Controller
{
    public function index()
    {
        $steps = WeddingTimeline::orderBy('sort_order')->get();
        return view('admin.wedding-timeline.index', compact('steps'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        WeddingTimeline::create($data);
        return back()->with('success', 'Step added successfully.');
    }

    public function update(Request $request, WeddingTimeline $weddingTimeline)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $weddingTimeline->update($data);
        return back()->with('success', 'Step updated successfully.');
    }

    public function destroy(WeddingTimeline $weddingTimeline)
    {
        $weddingTimeline->delete();
        return back()->with('success', 'Step deleted.');
    }
}

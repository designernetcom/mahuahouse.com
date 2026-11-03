<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\PageSection;
use Illuminate\Http\Request;

class VideoTourController extends Controller
{
    public function index()
    {
        return view('admin.video-tours.index', [
            'videos'   => Experience::where('category', 'video-tour')->orderBy('sort_order')->get(),
            'sections' => PageSection::where('page', 'video-tours')->orderBy('sort_order')->get(),
        ]);
    }

    // ── Videos (Experience rows with category = video-tour) ────────────────────

    public function storeVideo(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'link'        => 'required|string|max:500',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['category']    = 'video-tour';
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        Experience::create($data);
        return back()->with('success', 'Video added.')->withFragment('tab-videos');
    }

    public function updateVideo(Request $request, Experience $experience)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'link'        => 'required|string|max:500',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['category']    = 'video-tour';
        $data['is_active']   = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $experience->update($data);
        return back()->with('success', 'Video updated.')->withFragment('tab-videos');
    }

    public function destroyVideo(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Video deleted.')->withFragment('tab-videos');
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
        $data['page']      = 'video-tours';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'video-tours', 'section_key' => $data['section_key']],
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

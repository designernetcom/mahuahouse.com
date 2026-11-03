<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionController extends Controller
{
    private array $pages = [
        'home'                => 'Home',
        'about'               => 'About Us',
        'contact'             => 'Contact',
        'events'              => 'Events',
        'spaces'              => 'Spaces / Venues',
        'stay'                => 'Stay',
        'accommodation'       => 'Accommodation',
        'rooms'               => 'Rooms',
        'gallery'             => 'Gallery',
        'destination-wedding' => 'Destination Wedding',
        'corporate-events'    => 'Corporate Events',
        'educational-tours'   => 'Educational Tours',
        'film-shoots'         => 'Film Shoots',
        'day-out-plan'        => 'Day Out Plan',
        'facilities'          => 'Facilities',
        'food-dining'         => 'Food & Dining',
        'video-tours'         => 'Video Tours',
    ];

    public function index(Request $request)
    {
        $page     = $request->get('page', 'home');
        $sections = PageSection::where('page', $page)->orderBy('sort_order')->get();
        $pages    = $this->pages;
        return view('admin.page-sections.index', compact('sections', 'page', 'pages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page'        => 'required|string|max:100',
            'section_key' => 'required|string|max:100',
            'label'       => 'nullable|string|max:255',
            'value'       => 'nullable|string',
            'media_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => $data['page'], 'section_key' => $data['section_key']],
            $data
        );
        return back()->with('success', 'Section saved successfully.');
    }

    public function update(Request $request, PageSection $pageSection)
    {
        $data = $request->validate([
            'label'      => 'nullable|string|max:255',
            'value'      => 'nullable|string',
            'media_url'  => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $pageSection->update($data);
        return back()->with('success', 'Section updated.');
    }

    public function destroy(PageSection $pageSection)
    {
        $pageSection->delete();
        return back()->with('success', 'Section deleted.');
    }
}

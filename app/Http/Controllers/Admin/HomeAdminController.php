<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\PageSection;
use App\Models\Room;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\WhyChoose;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function index()
    {
        return view('admin.home.index', [
            'sections'     => PageSection::where('page', 'home')->orderBy('sort_order')->get(),
            'heroCount'    => HeroSlide::where('is_active', true)->count(),
            'statsCount'   => Stat::where('is_active', true)->count(),
            'whyCount'     => WhyChoose::where('is_active', true)->count(),
            'expCount'     => Experience::where('is_active', true)->count(),
            'roomsCount'   => Room::active()->count(),
            'galleryCount' => GalleryItem::where('is_active', true)->count(),
            'testiCount'   => Testimonial::where('is_active', true)->count(),
        ]);
    }

    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'section_key' => 'required|string|max:100',
            'label'       => 'nullable|string|max:255',
            'value'       => 'nullable|string',
            'media_url'   => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['page']      = 'home';
        $data['is_active'] = $request->has('is_active');
        PageSection::updateOrCreate(
            ['page' => 'home', 'section_key' => $data['section_key']],
            $data
        );
        return back()->with('success', 'Text field saved.');
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
        return back()->with('success', 'Text field updated.');
    }

    public function destroySection(PageSection $pageSection)
    {
        $pageSection->delete();
        return back()->with('success', 'Text field deleted.');
    }

    public function storeIntroSection(Request $request)
    {
        $data = $request->validate([
            'intro_label'       => 'nullable|string|max:255',
            'intro_heading'     => 'nullable|string|max:500',
            'intro_text_1'      => 'nullable|string|max:3000',
            'intro_text_2'      => 'nullable|string|max:3000',
            'intro_points'      => 'nullable|string|max:3000',
            'established_year'  => 'nullable|string|max:10',
            'established_label' => 'nullable|string|max:100',
        ]);

        foreach ($data as $key => $value) {
            PageSection::updateOrCreate(
                ['page' => 'home', 'section_key' => $key],
                ['value' => $value ?? '', 'is_active' => true, 'label' => ucwords(str_replace('_', ' ', $key))]
            );
        }

        return back()->with('success', 'Intro section saved successfully.')->with('active_tab', 'tab-intro');
    }
}

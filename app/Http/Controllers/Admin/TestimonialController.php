<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'location' => 'nullable|string|max:255', 'photo_url' => 'nullable|string', 'review' => 'required|string', 'rating' => 'required|integer|min:1|max:5', 'visit_date' => 'nullable|date', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        Testimonial::create($data);
        return back()->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'location' => 'nullable|string|max:255', 'photo_url' => 'nullable|string', 'review' => 'required|string', 'rating' => 'required|integer|min:1|max:5', 'visit_date' => 'nullable|date', 'sort_order' => 'nullable|integer']);
        $data['is_active'] = $request->has('is_active');
        $testimonial->update($data);
        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\{HeroSlide, Stat, WhyChoose, Experience, Room, GalleryItem, Testimonial, TeamMember, BlogPost, Offer, Faq, ContactInfo, SiteSetting, Inquiry};
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function hero()       { return response()->json(HeroSlide::where('is_active', true)->orderBy('sort_order')->get()); }
    public function stats()      { return response()->json(Stat::orderBy('sort_order')->get()); }
    public function whyChoose()  { return response()->json(WhyChoose::where('is_active', true)->orderBy('sort_order')->get()); }
    public function experiences(){ return response()->json(Experience::where('is_active', true)->orderBy('sort_order')->get()); }
    public function team()       { return response()->json(TeamMember::where('is_active', true)->orderBy('sort_order')->get()); }
    public function offers()     { return response()->json(Offer::where('is_active', true)->orderBy('sort_order')->get()); }
    public function faq()        { return response()->json(Faq::where('is_active', true)->orderBy('sort_order')->get()); }

    public function rooms()
    {
        $rooms = Room::active()->orderBy('sort_order')->get();
        return response()->json($rooms->map(fn($room) => (new RoomResource($room))->toArray(request()))->values());
    }

    public function room($id)
    {
        $room = Room::active()->findOrFail($id);
        return response()->json((new RoomResource($room))->toArray(request()));
    }

    public function gallery(Request $request)
    {
        $query = GalleryItem::where('is_active', true)->orderBy('sort_order');
        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        return response()->json($query->get());
    }

    public function testimonials()
    {
        return response()->json(Testimonial::where('is_active', true)->orderBy('sort_order')->get());
    }

    public function blog(Request $request)
    {
        $posts = BlogPost::where('is_published', true)->latest('published_at')->paginate($request->per_page ?? 10);
        return response()->json($posts);
    }

    public function blogPost($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return response()->json($post);
    }

    public function contactInfo()
    {
        $info = ContactInfo::all()->keyBy('key')->map(fn($c) => ['label' => $c->label, 'value' => $c->value, 'icon' => $c->icon]);
        return response()->json($info);
    }

    public function settings()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function about()
    {
        $settings = SiteSetting::where('group_name', 'About')->get()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function submitInquiry(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'phone'     => 'nullable|string|max:20',
            'subject'   => 'nullable|string|max:255',
            'message'   => 'required|string',
            'type'      => 'nullable|string|in:contact,booking',
            'check_in'  => 'nullable|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'guests'    => 'nullable|integer|min:1',
            'room_type' => 'nullable|string|max:255',
        ]);
        $inquiry = Inquiry::create($data);
        return response()->json(['success' => true, 'id' => $inquiry->id, 'message' => 'Your inquiry has been received. We will contact you soon.']);
    }
}

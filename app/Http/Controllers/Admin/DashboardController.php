<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Room, GalleryItem, Testimonial, Inquiry, BlogPost, Offer, HeroSlide};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'rooms'          => Room::where('is_active', true)->count(),
            'gallery'        => GalleryItem::where('is_active', true)->count(),
            'testimonials'   => Testimonial::where('is_active', true)->count(),
            'blog_published' => BlogPost::where('is_published', true)->count(),
            'offers_active'  => Offer::where('is_active', true)->count(),
            'hero_slides'    => HeroSlide::where('is_active', true)->count(),
            'new_inquiries'  => Inquiry::where('status', 'new')->count(),
            'total_inquiries'=> Inquiry::count(),
        ];

        $recentInquiries = Inquiry::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries'));
    }
}

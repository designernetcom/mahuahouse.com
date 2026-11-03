<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\Experience;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\Inquiry;
use App\Models\Offer;
use App\Models\PageSection;
use App\Models\Room;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\WeddingFeature;
use App\Models\WeddingTimeline;
use App\Models\WhyChoose;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    private function base(): array
    {
        return [
            'settings' => SiteSetting::all()->pluck('value', 'key'),
            'contact'  => ContactInfo::where('is_active', true)->orderBy('sort_order')->get()->keyBy('key'),
        ];
    }

    public function home()
    {
        return view('site.home', array_merge($this->base(), [
            'heroSlides'    => HeroSlide::where('is_active', true)->orderBy('sort_order')->get(),
            'stats'         => Stat::where('is_active', true)->orderBy('sort_order')->get(),
            'whyChooseItems'=> WhyChoose::where('is_active', true)->orderBy('sort_order')->get(),
            'experiences'   => Experience::where('is_active', true)->orderBy('sort_order')->take(6)->get(),
            'featuredRooms' => Room::active()->featured()->orderBy('sort_order')->take(3)->get(),
            'galleryItems'  => GalleryItem::where('is_active', true)->orderBy('sort_order')->take(7)->get(),
            'testimonials'  => Testimonial::where('is_active', true)->orderBy('sort_order')->take(3)->get(),
            'sections'      => PageSection::getPage('home'),
        ]));
    }

    public function about()
    {
        return view('site.about', array_merge($this->base(), [
            'stats'            => Stat::where('is_active', true)->orderBy('sort_order')->get(),
            'whyChooseItems'   => WhyChoose::where('is_active', true)->orderBy('sort_order')->get(),
            'testimonials'     => Testimonial::where('is_active', true)->orderBy('sort_order')->take(3)->get(),
            'team'             => TeamMember::where('is_active', true)->orderBy('sort_order')->get(),
            'galleryItems'     => GalleryItem::where('is_active', true)->orderBy('sort_order')->take(7)->get(),
            'aboutExperiences' => Experience::where('is_active', true)->where('category', 'about-experience')->orderBy('sort_order')->get(),
            'sections'         => PageSection::getPage('about'),
        ]));
    }

    public function rooms()
    {
        return view('site.rooms', array_merge($this->base(), [
            'rooms'       => Room::active()->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)->where('category', 'rooms')->orderBy('sort_order')->get(),
            'sections'    => PageSection::getPage('rooms'),
        ]));
    }

    public function accommodation()
    {
        return view('site.accommodation', array_merge($this->base(), [
            'rooms'       => Room::active()->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('accommodation'),
        ]));
    }

    public function stay()
    {
        return view('site.stay', array_merge($this->base(), [
            'rooms'       => Room::active()->orderBy('sort_order')->get(),
            'featuredRoom'=> Room::active()->featured()->orderBy('sort_order')->first(),
            'galleryItems'=> GalleryItem::where('is_active', true)->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('stay'),
        ]));
    }

    public function gallery()
    {
        return view('site.gallery', array_merge($this->base(), [
            'galleryItems'    => GalleryItem::where('is_active', true)->orderBy('sort_order')->get(),
            'galleryCategories'=> GalleryItem::where('is_active', true)->distinct()->pluck('category'),
            'sections'        => PageSection::getPage('gallery'),
        ]));
    }

    public function contact()
    {
        return view('site.contact', array_merge($this->base(), [
            'faqs'    => Faq::where('is_active', true)->where('category', 'general')->orderBy('sort_order')->get(),
            'sections'=> PageSection::getPage('contact'),
        ]));
    }

    public function booking()
    {
        return view('site.booking', array_merge($this->base(), [
            'rooms'       => Room::active()->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)->orderBy('sort_order')->take(2)->get(),
        ]));
    }

    public function storeBooking(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:255',
            'room_type'  => 'nullable|string|max:255',
            'check_in'   => 'nullable|date',
            'check_out'  => 'nullable|date|after_or_equal:check_in',
            'guests'     => 'nullable|integer|min:1|max:50',
            'message'    => 'nullable|string|max:2000',
        ]);

        Inquiry::create([
            ...$data,
            'type'    => 'booking',
            'subject' => 'Booking Request',
            'message' => $data['message'] ?? 'Booking request from website.',
            'status'  => 'new',
        ]);

        return back()->with('booking_success', 'Your booking request has been received. We will contact you soon.');
    }

    public function storeEnquiry(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|max:255',
            'subject'   => 'nullable|string|max:500',
            'message'   => 'nullable|string|max:3000',
            'type'      => 'nullable|string|max:100',
            'check_in'  => 'nullable|date',
            'check_out' => 'nullable|date',
            'guests'    => 'nullable|string|max:100',
            'room_type' => 'nullable|string|max:255',
        ]);

        Inquiry::create([
            'type'      => $data['type'] ?? 'enquiry',
            'name'      => $data['name'],
            'email'     => $data['email'] ?? null,
            'phone'     => $data['phone'],
            'subject'   => $data['subject'] ?? 'General Enquiry',
            'message'   => $data['message'] ?? null,
            'check_in'  => $data['check_in'] ?? null,
            'check_out' => $data['check_out'] ?? null,
            'guests'    => null,
            'room_type' => $data['room_type'] ?? null,
            'status'    => 'new',
        ]);

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been received. Our team will respond within 24 hours.');
    }

    public function destinationWedding()
    {
        return view('site.destination-wedding', array_merge($this->base(), [
            'weddingFeatures' => WeddingFeature::where('is_active', true)->orderBy('sort_order')->get(),
            'weddingTimeline' => WeddingTimeline::where('is_active', true)->orderBy('sort_order')->get(),
            'galleryItems'    => GalleryItem::where('is_active', true)
                ->where(fn($q) => $q->where('category', 'wedding')->orWhere('category', 'general'))
                ->orderBy('sort_order')->take(5)->get(),
            'testimonials'    => Testimonial::where('is_active', true)->orderBy('sort_order')->take(3)->get(),
            'sections'        => PageSection::getPage('destination-wedding'),
        ]));
    }

    public function videoTours()
    {
        return view('site.video-tours', array_merge($this->base(), [
            'videos'      => Experience::where('is_active', true)
                ->where('category', 'video-tour')
                ->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('video-tours'),
        ]));
    }

    public function events()
    {
        return view('site.events', array_merge($this->base(), [
            'eventTypes' => Experience::where('is_active', true)
                ->where('category', 'events')
                ->orderBy('sort_order')->get(),
            'venueItems' => Experience::where('is_active', true)
                ->where('category', 'venue')
                ->orderBy('sort_order')->get(),
            'whyHostItems' => Experience::where('is_active', true)
                ->where('category', 'why-host')
                ->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)
                ->where(fn($q) => $q->where('category', 'events')->orWhere('category', 'general'))
                ->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('events'),
        ]));
    }

    public function corporateEvents()
    {
        return view('site.corporate-events', array_merge($this->base(), [
            'whyFeatures' => Experience::where('is_active', true)->where('category', 'corporate-why')->orderBy('sort_order')->get(),
            'activities'  => Experience::where('is_active', true)->where('category', 'corporate-activity')->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)
                ->where(fn($q) => $q->where('category', 'corporate')->orWhere('category', 'general'))
                ->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('corporate-events'),
        ]));
    }

    public function educationalTours()
    {
        return view('site.educational-tours', array_merge($this->base(), [
            'highlights' => Experience::where('is_active', true)->where('category', 'edu-highlight')->orderBy('sort_order')->get(),
            'programs'   => Experience::where('is_active', true)->where('category', 'edu-program')->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)
                ->where(fn($q) => $q->where('category', 'educational')->orWhere('category', 'general'))
                ->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('educational-tours'),
        ]));
    }

    public function filmShoots()
    {
        return view('site.film-shoots', array_merge($this->base(), [
            'shootTypes'      => Experience::where('is_active', true)->where('category', 'film-type')->orderBy('sort_order')->get(),
            'locationFeatures'=> Experience::where('is_active', true)->where('category', 'film-location')->orderBy('sort_order')->get(),
            'trustBadges'     => Experience::where('is_active', true)->where('category', 'film-trust')->orderBy('sort_order')->get(),
            'sections'        => PageSection::getPage('film-shoots'),
        ]));
    }

    public function foodDining()
    {
        return view('site.food-dining', array_merge($this->base(), [
            'diningOptions'  => Experience::where('is_active', true)->where('category', 'dining-option')->orderBy('sort_order')->get(),
            'mealCards'      => Experience::where('is_active', true)->where('category', 'dining-meal')->orderBy('sort_order')->get(),
            'qualityCards'   => Experience::where('is_active', true)->where('category', 'dining-quality')->orderBy('sort_order')->get(),
            'sections'       => PageSection::getPage('food-dining'),
        ]));
    }

    public function spaces()
    {
        return view('site.spaces', array_merge($this->base(), [
            'venues'      => Experience::where('is_active', true)->where('category', 'space-venue')->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)->where('category', 'spaces')->orderBy('sort_order')->take(5)->get(),
            'sections'    => PageSection::getPage('spaces'),
        ]));
    }

    public function dayOutPlan()
    {
        return view('site.day-out-plan', array_merge($this->base(), [
            'includes'    => Experience::where('is_active', true)->where('category', 'day-include')->orderBy('sort_order')->get(),
            'activities'  => Experience::where('is_active', true)->where('category', 'day-activity')->orderBy('sort_order')->get(),
            'offers'      => Offer::where('is_active', true)->orderBy('sort_order')->get(),
            'faqs'        => Faq::where('is_active', true)->where('category', 'day-out')->orderBy('sort_order')->get(),
            'galleryItems'=> GalleryItem::where('is_active', true)->where('category','day-out')->orderBy('sort_order')->take(6)->get(),
            'sections'    => PageSection::getPage('day-out-plan'),
        ]));
    }

    public function facilities()
    {
        return view('site.facilities', array_merge($this->base(), [
            'facilities' => Experience::where('is_active', true)->where('category', 'facility')->orderBy('sort_order')->get(),
            'sections'   => PageSection::getPage('facilities'),
        ]));
    }
}

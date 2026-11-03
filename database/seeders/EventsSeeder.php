<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\PageSection;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Event Types (category = events) ────────────────────────────────────
        foreach ([
            ['sort_order' => 1, 'title' => 'Destination Weddings',    'icon' => 'fa-solid fa-heart',           'link' => 'Most Popular', 'description' => 'Ceremonies, receptions, mehendi and sangeet in a stunning forest setting.',          'image_url' => '/site/assets/images/about/12.jpeg'],
            ['sort_order' => 2, 'title' => 'Corporate Retreats',       'icon' => 'fa-solid fa-briefcase',       'link' => 'Business',     'description' => 'Team building, offsites, workshops and leadership programs.',                            'image_url' => '/site/assets/images/about/20.jpeg'],
            ['sort_order' => 3, 'title' => 'Picnic & Day Outings',     'icon' => 'fa-solid fa-sun',             'link' => 'Day Out',      'description' => 'A full day of nature, activities, food and fresh air for groups.',                      'image_url' => '/site/assets/images/about/30.jpeg'],
            ['sort_order' => 4, 'title' => 'Birthday Celebrations',    'icon' => 'fa-solid fa-cake-candles',    'link' => 'Celebrations', 'description' => 'Make your birthday unforgettable with a forest party, bonfire and outdoor activities.',  'image_url' => '/site/assets/images/about/38.jpeg'],
            ['sort_order' => 5, 'title' => 'Educational Tours',        'icon' => 'fa-solid fa-graduation-cap', 'link' => 'Educational',  'description' => 'Nature-based learning trips for schools and colleges in a live forest ecosystem.',        'image_url' => '/site/assets/images/about/56.jpeg'],
            ['sort_order' => 6, 'title' => 'Film & Media Shoots',      'icon' => 'fa-solid fa-clapperboard',   'link' => 'Media',        'description' => 'Natural backdrops, quiet environment and permit guidance for productions.',              'image_url' => '/site/assets/images/about/80.jpeg'],
        ] as $e) {
            Experience::firstOrCreate(['category' => 'events', 'title' => $e['title']], array_merge($e, ['category' => 'events', 'is_active' => true]));
        }

        // ── Venues (category = venue) ───────────────────────────────────────────
        foreach ([
            ['sort_order' => 1, 'title' => 'Mahua Vedika',            'icon' => 'fa-solid fa-users',       'link' => 'Grand Venue', 'description' => 'Spacious outdoor setting for weddings, receptions and large celebrations.',             'image_url' => '/site/assets/images/about/70.jpeg'],
            ['sort_order' => 2, 'title' => 'Chaupal-e-Mahua',         'icon' => 'fa-solid fa-people-roof', 'link' => 'Intimate',    'description' => 'Warm gathering space for rituals, family events and intimate celebrations.',            'image_url' => '/site/assets/images/about/75.jpeg'],
            ['sort_order' => 3, 'title' => 'Full Property Exclusive',  'icon' => 'fa-solid fa-lock',        'link' => 'Exclusive',   'description' => 'Book the entire property for multi-day weddings, retreats and private events.',         'image_url' => '/site/assets/images/about/85.jpeg'],
        ] as $v) {
            Experience::firstOrCreate(['category' => 'venue', 'title' => $v['title']], array_merge($v, ['category' => 'venue', 'is_active' => true]));
        }

        // ── Why Host Features (category = why-host) ─────────────────────────────
        foreach ([
            ['sort_order' => 1, 'title' => 'Forest Backdrop',   'icon' => 'fa-solid fa-tree',              'description' => 'Natural scenery, open skies and quiet surroundings for memorable gatherings.'],
            ['sort_order' => 2, 'title' => 'Event Support',      'icon' => 'fa-solid fa-handshake-angle',   'description' => 'Coordination support for decor, food, sound, seating and guest flow.'],
            ['sort_order' => 3, 'title' => 'Stay & Dining',      'icon' => 'fa-solid fa-utensils',          'description' => 'Rooms, cottages and meal plans can be combined with your event package.'],
        ] as $f) {
            Experience::firstOrCreate(['category' => 'why-host', 'title' => $f['title']], array_merge($f, ['category' => 'why-host', 'is_active' => true]));
        }

        // ── Gallery (category = events) ─────────────────────────────────────────
        foreach ([
            ['sort_order' => 1, 'title' => 'Forest Event',       'image_url' => '/site/assets/images/about/16.jpeg'],
            ['sort_order' => 2, 'title' => 'Wedding Setup',      'image_url' => '/site/assets/images/about/22.jpeg'],
            ['sort_order' => 3, 'title' => 'Outdoor Gathering',  'image_url' => '/site/assets/images/about/28.jpeg'],
            ['sort_order' => 4, 'title' => 'Corporate Retreat',  'image_url' => '/site/assets/images/about/32.jpeg'],
            ['sort_order' => 5, 'title' => 'Celebration',        'image_url' => '/site/assets/images/about/38.jpeg'],
            ['sort_order' => 6, 'title' => 'Nature Event',       'image_url' => '/site/assets/images/about/42.jpeg'],
        ] as $g) {
            GalleryItem::firstOrCreate(['category' => 'events', 'image_url' => $g['image_url']], array_merge($g, ['category' => 'events', 'is_active' => true]));
        }

        // ── Page Sections ───────────────────────────────────────────────────────
        $sections = [
            ['section_key' => 'hero_label',      'label' => 'Hero — Label',                  'value' => 'Celebrate in the Forest',                                                                      'sort_order' => 1],
            ['section_key' => 'hero_heading',    'label' => 'Hero — Heading (HTML)',          'value' => "Unforgettable <em>Events</em><br>in Nature's Embrace",                                         'sort_order' => 2],
            ['section_key' => 'hero_text',       'label' => 'Hero — Subtitle',               'value' => 'From intimate gatherings to grand celebrations, Mahua House provides a one-of-a-kind forest setting for every occasion that matters.', 'sort_order' => 3],
            ['section_key' => 'hero_image',      'label' => 'Hero — Background Image URL',   'value' => '/site/assets/images/about/7.jpeg',                                                             'sort_order' => 4],
            ['section_key' => 'types_label',     'label' => 'Event Types — Label',           'value' => 'What We Host',                                                                                 'sort_order' => 5],
            ['section_key' => 'types_heading',   'label' => 'Event Types — Heading (HTML)',  'value' => 'Events for <em>Every Occasion</em>',                                                           'sort_order' => 6],
            ['section_key' => 'types_text',      'label' => 'Event Types — Description',     'value' => 'Whatever the celebration, our forest provides a backdrop that no banquet hall ever could.',     'sort_order' => 7],
            ['section_key' => 'why_label',       'label' => 'Why Host — Label',              'value' => 'Why Host Here',                                                                                'sort_order' => 8],
            ['section_key' => 'why_heading',     'label' => 'Why Host — Heading (HTML)',     'value' => 'A Venue That Feels <em>Alive</em>',                                                            'sort_order' => 9],
            ['section_key' => 'why_text',        'label' => 'Why Host — Description',        'value' => 'Mahua House combines a forest setting with practical event support, making celebrations beautiful, grounded and easy to manage.', 'sort_order' => 10],
            ['section_key' => 'why_image',       'label' => 'Why Host — Side Image URL',     'value' => '/site/assets/images/about/25.jpeg',                                                            'sort_order' => 11],
            ['section_key' => 'why_badge_title', 'label' => 'Why Host — Badge Title',        'value' => 'MP Tourism Accredited',                                                                        'sort_order' => 12],
            ['section_key' => 'why_badge_text',  'label' => 'Why Host — Badge Subtitle',     'value' => 'Trusted nature retreat on Raisen Road, Bhopal',                                                'sort_order' => 13],
            ['section_key' => 'venues_label',    'label' => 'Venues — Label',                'value' => 'Spaces & Venues',                                                                              'sort_order' => 14],
            ['section_key' => 'venues_heading',  'label' => 'Venues — Heading (HTML)',       'value' => 'Choose Your <em>Forest Setting</em>',                                                          'sort_order' => 15],
            ['section_key' => 'gallery_label',   'label' => 'Gallery — Label',               'value' => 'Event Gallery',                                                                                'sort_order' => 16],
            ['section_key' => 'gallery_heading', 'label' => 'Gallery — Heading (HTML)',      'value' => 'Moments from Our <em>Forest Events</em>',                                                      'sort_order' => 17],
            ['section_key' => 'steps_label',     'label' => 'Steps — Label',                 'value' => 'How It Works',                                                                                 'sort_order' => 18],
            ['section_key' => 'steps_heading',   'label' => 'Steps — Heading (HTML)',        'value' => 'Your Event in <em>4 Easy Steps</em>',                                                          'sort_order' => 19],
            ['section_key' => 'steps',           'label' => 'Planning Steps (pipe format)',  'value' => "Initial Enquiry|Call, email, or fill our enquiry form with your event type, date and guest count.|fa-solid fa-phone\nSite Visit & Planning|Explore the venue and shape your event plan with our team.|fa-solid fa-map-location-dot\nCustomise & Confirm|Finalise decor, menus, entertainment and timeline.|fa-solid fa-palette\nYour Perfect Event|Arrive, relax and celebrate while our team manages the day.|fa-solid fa-star", 'sort_order' => 20],
            ['section_key' => 'form_label',      'label' => 'Enquiry Form — Label',         'value' => 'Get In Touch',                                                                                  'sort_order' => 21],
            ['section_key' => 'form_heading',    'label' => 'Enquiry Form — Heading (HTML)', 'value' => 'Start Planning Your <em>Event Today</em>',                                                     'sort_order' => 22],
            ['section_key' => 'form_text',       'label' => 'Enquiry Form — Description',   'value' => 'Fill in your details and our events team will respond with availability and a tailored proposal.', 'sort_order' => 23],
            ['section_key' => 'cta_label',       'label' => 'CTA — Label',                  'value' => "Let's Create Something",                                                                        'sort_order' => 24],
            ['section_key' => 'cta_heading',     'label' => 'CTA — Heading (HTML)',         'value' => 'Your Forest Event is <em>One Call Away</em>',                                                   'sort_order' => 25],
            ['section_key' => 'cta_text',        'label' => 'CTA — Description',            'value' => "From the first conversation to the final farewell, we're with you every step.",                 'sort_order' => 26],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => 'events', 'section_key' => $s['section_key']],
                array_merge($s, ['page' => 'events', 'is_active' => true])
            );
        }
    }
}

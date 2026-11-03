<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\PageSection;

class SpacesSeeder extends Seeder
{
    public function run(): void
    {
        // ── Venue Cards (category = space-venue) ──────────────────────────────────
        // description format: SUBTITLE---DESCRIPTION---USE1\nUSE2\nUSE3
        foreach ([
            [
                'sort_order' => 1, 'link' => 'Intimate', 'icon' => 'fa-solid fa-leaf',
                'title'      => 'Chaupal-e-Mahua',
                'image_url'  => '/site/assets/images/about/20.jpeg',
                'description'=> "Open-Air Chaupal---A traditional open-air chaupal space — intimate and warm, designed for mehendi ceremonies, small family functions, and relaxed group conversations in a forest setting.---Mehendi Ceremony\nSmall Family Functions\nGroup Gatherings\nPre-event Huddles",
            ],
            [
                'sort_order' => 2, 'link' => 'Cultural', 'icon' => 'fa-solid fa-circle-dot',
                'title'      => 'Mahua Ras Vritta',
                'image_url'  => '/site/assets/images/about/30.jpeg',
                'description'=> "Circular Cultural Space---A uniquely shaped circular venue perfect for haldi ceremonies, folk performances, and cultural evenings — celebrating the spirit of tradition amid natural surroundings.---Haldi Ceremony\nFolk Performances\nCultural Events\nBonfire Evenings",
            ],
            [
                'sort_order' => 3, 'link' => 'Premium', 'icon' => 'fa-solid fa-water',
                'title'      => 'Poolside & Forest Edge',
                'image_url'  => '/site/assets/images/about/35.jpeg',
                'description'=> "Poolside Venue---A stunning poolside setting bordered by the forest — ideal for sangeet functions, pre-wedding photography, corporate networking events, and outdoor celebrations.---Sangeet Function\nPre-wedding Shoots\nCorporate Networking\nOutdoor Photography",
            ],
            [
                'sort_order' => 4, 'link' => 'Corporate', 'icon' => 'fa-solid fa-briefcase',
                'title'      => 'Corporate Meeting Space',
                'image_url'  => '/site/assets/images/about/40.jpeg',
                'description'=> "Indoor / Covered---Equipped open & covered meeting areas with projector, sound system, and AV support — ideal for team-building retreats, strategic workshops, institutional visits, and training programs.---Team-building Retreats\nStrategic Workshops\nInstitutional Visits\nTraining Programs",
            ],
            [
                'sort_order' => 5, 'link' => 'Exclusive', 'icon' => 'fa-solid fa-lock',
                'title'      => 'Full Property Exclusive',
                'image_url'  => '/site/assets/images/about/50.jpeg',
                'is_featured'=> true,
                'description'=> "Exclusive Hire---Book all venues and all rooms exclusively for your group — the entire Mahua House property, ideal for multi-day weddings, corporate retreats, large family gatherings, and film productions.---Destination Weddings\nCorporate Retreats\nFilm / Media Shoots\nLarge Family Gatherings",
            ],
        ] as $v) {
            Experience::firstOrCreate(
                ['category' => 'space-venue', 'title' => $v['title']],
                array_merge(['category' => 'space-venue', 'is_active' => true, 'is_featured' => false], $v)
            );
        }

        // ── Gallery Photos (category = spaces) ───────────────────────────────────
        foreach ([
            ['title'=>'Grand Forest Lawn',    'image_url'=>'/site/assets/images/about/25.jpeg', 'sort_order'=>1],
            ['title'=>'Forest Clearing',      'image_url'=>'/site/assets/images/about/32.jpeg', 'sort_order'=>2],
            ['title'=>'Forest Pavilion',      'image_url'=>'/site/assets/images/about/38.jpeg', 'sort_order'=>3],
            ['title'=>'Poolside Deck',        'image_url'=>'/site/assets/images/services/swimming-pool.jpg', 'sort_order'=>4],
            ['title'=>'Campfire Amphitheatre','image_url'=>'/site/assets/images/about/45.jpeg', 'sort_order'=>5],
        ] as $g) {
            GalleryItem::firstOrCreate(
                ['category' => 'spaces', 'image_url' => $g['image_url']],
                array_merge($g, ['category' => 'spaces', 'is_active' => true])
            );
        }

        // ── Page Sections (page = spaces) ─────────────────────────────────────────
        $sections = [
            // Meta
            ['section_key'=>'meta_title',       'label'=>'Meta — Page Title',             'value'=>'Spaces | Mahua House',                                                        'sort_order'=>1],
            ['section_key'=>'meta_description', 'label'=>'Meta — Description',            'value'=>'Explore our forest event spaces at Mahua House — grand lawns, forest clearings, pavilions and intimate venues for weddings, corporate events and private gatherings in Bhopal.', 'sort_order'=>2],
            ['section_key'=>'meta_keywords',    'label'=>'Meta — Keywords',               'value'=>'Event Spaces Mahua House, Forest Venue Bhopal, Outdoor Wedding Venue, Corporate Event Space', 'sort_order'=>3],

            // Hero
            ['section_key'=>'hero_image',       'label'=>'Hero — Background Image',       'value'=>'', 'media_url'=>'/site/assets/images/about/5.jpeg', 'sort_order'=>4],
            ['section_key'=>'hero_label',       'label'=>'Hero — Label',                  'value'=>'Venues & Event Spaces',                                                       'sort_order'=>5],
            ['section_key'=>'hero_heading',     'label'=>'Hero — Heading (HTML OK)',       'value'=>'Every Gathering<br><em>Deserves a Forest</em>',                               'sort_order'=>6],
            ['section_key'=>'hero_text',        'label'=>'Hero — Subtext',                'value'=>'Four distinctly named venues, each with its own character — designed for weddings, cultural ceremonies, corporate meetings, and private celebrations in a natural forest setting.', 'sort_order'=>7],
            ['section_key'=>'hero_cta1',        'label'=>'Hero — Button 1',               'value'=>'Explore Spaces',                                                              'sort_order'=>8],
            ['section_key'=>'hero_cta2',        'label'=>'Hero — Button 2',               'value'=>'Enquire Now',                                                                 'sort_order'=>9],
            ['section_key'=>'breadcrumb',       'label'=>'Breadcrumb Label',              'value'=>'Spaces',                                                                      'sort_order'=>10],

            // Stats strip: num|label per line
            ['section_key'=>'stats_strip',      'label'=>'Stats Strip (num|label per line)', 'value'=>"4|Named Venues\n300+|Guest Capacity\n3.5ac|Forest Property\nMP|Tourism Accredited\n4.9★|Avg. Rating", 'sort_order'=>11],

            // Intro
            ['section_key'=>'intro_label',      'label'=>'Intro — Label',                 'value'=>'Our Philosophy',                                                              'sort_order'=>12],
            ['section_key'=>'intro_heading',    'label'=>'Intro — Heading (HTML OK)',     'value'=>'Where Nature Becomes<br>Your <em>Event Venue</em>',                           'sort_order'=>13],
            ['section_key'=>'intro_text1',      'label'=>'Intro — Paragraph 1',          'value'=>"At Mahua House, each of our four named venues has its own identity — designed for different functions, from grand wedding receptions to intimate ceremonies, cultural events to corporate meetings. Every space carries the living energy of the Samardha Reserved Forest.", 'sort_order'=>14],
            ['section_key'=>'intro_text2',      'label'=>'Intro — Paragraph 2',          'value'=>"Whether you're planning a destination wedding at Mahua Vedika, a mehendi at Chaupal-e-Mahua, a haldi at Mahua Ras Vritta, or a sangeet at the Poolside & Forest Edge — nature is your backdrop and tradition is your guide.", 'sort_order'=>15],
            ['section_key'=>'intro_tags',       'label'=>'Intro — Feature Tags (one/line)','value'=>"4 Named Wedding Venues\nCorporate Meeting Space\nEvent Management Support\nStage & Decoration (Chargeable)\nDJ / Sound / Projector (Chargeable)", 'sort_order'=>16],
            ['section_key'=>'intro_img1',       'label'=>'Intro — Grid Image 1 (tall)',   'value'=>'', 'media_url'=>'/site/assets/images/about/8.jpeg',  'sort_order'=>17],
            ['section_key'=>'intro_img2',       'label'=>'Intro — Grid Image 2',          'value'=>'', 'media_url'=>'/site/assets/images/about/15.jpeg', 'sort_order'=>18],
            ['section_key'=>'intro_img3',       'label'=>'Intro — Grid Image 3',          'value'=>'', 'media_url'=>'/site/assets/images/about/22.jpeg', 'sort_order'=>19],

            // Mahua Vedika (featured venue)
            ['section_key'=>'vedika_image',     'label'=>'Vedika — Image',                'value'=>'', 'media_url'=>'/site/assets/images/about/12.jpeg', 'sort_order'=>20],
            ['section_key'=>'vedika_label',     'label'=>'Vedika — Label',                'value'=>'Signature Wedding Venue',                                                     'sort_order'=>21],
            ['section_key'=>'vedika_heading',   'label'=>'Vedika — Heading (HTML OK)',    'value'=>'Mahua <em>Vedika</em>',                                                       'sort_order'=>22],
            ['section_key'=>'vedika_desc',      'label'=>'Vedika — Description',          'value'=>'Our grandest venue — Mahua Vedika is the heart of every major celebration at Mahua House. Set in the open forest grounds adjoining the Samardha Reserved Forest, this is where wedding ceremonies, receptions, and large group events come alive under the open sky with a backdrop of ancient trees.', 'sort_order'=>23],
            ['section_key'=>'vedika_amenities', 'label'=>'Vedika — Amenities (icon|label per line)', 'value'=>"fa-solid fa-heart|Wedding Ceremonies & Receptions\nfa-solid fa-moon|Day & Evening Events\nfa-solid fa-music|DJ / Sound System (Chargeable)\nfa-solid fa-wand-magic-sparkles|Stage & Decoration (Chargeable)\nfa-solid fa-bolt|Power Backup\nfa-solid fa-utensils|Customised Catering Available\nfa-solid fa-video|Projector Support (Chargeable)\nfa-solid fa-camera|Pre-wedding Shoot Friendly", 'sort_order'=>24],
            ['section_key'=>'vedika_cta',       'label'=>'Vedika — CTA Button',           'value'=>'Enquire About This Venue',                                                    'sort_order'=>25],

            // Grid
            ['section_key'=>'grid_label',       'label'=>'Grid — Label',                  'value'=>'All Venues',                                                                  'sort_order'=>26],
            ['section_key'=>'grid_heading',     'label'=>'Grid — Heading (HTML OK)',      'value'=>'Find Your <em>Perfect Space</em>',                                            'sort_order'=>27],
            ['section_key'=>'grid_text',        'label'=>'Grid — Description',            'value'=>'Four named venues — each with its own character — plus dedicated corporate space and full-property exclusive option.', 'sort_order'=>28],

            // Gallery
            ['section_key'=>'gallery_label',    'label'=>'Gallery — Label',               'value'=>'Space Gallery',                                                               'sort_order'=>29],
            ['section_key'=>'gallery_heading',  'label'=>'Gallery — Heading (HTML OK)',   'value'=>'Our <em>Venues</em> in Pictures',                                             'sort_order'=>30],
            ['section_key'=>'gallery_cta',      'label'=>'Gallery — CTA Button',          'value'=>'Book a Space',                                                                'sort_order'=>31],

            // Enquiry form
            ['section_key'=>'form_label',       'label'=>'Form — Label',                  'value'=>'Get in Touch',                                                                'sort_order'=>32],
            ['section_key'=>'form_heading',     'label'=>'Form — Heading (HTML OK)',      'value'=>'Enquire About a <em>Space</em>',                                              'sort_order'=>33],
            ['section_key'=>'sidebar_title',    'label'=>'Sidebar — Title',               'value'=>"We'll Get Back to You",                                                       'sort_order'=>34],
            ['section_key'=>'included_title',   'label'=>'Included — Title',              'value'=>"What's Included with Every Booking",                                          'sort_order'=>35],
            ['section_key'=>'included_items',   'label'=>'Included — Items (one/line)',   'value'=>"Dedicated event coordinator\nTable, chair and linen setup\nBasic lighting and sound\nParking for 50+ vehicles\nPower backup throughout\nOn-site hospitality team\nCatering coordination", 'sort_order'=>36],

            // CTA
            ['section_key'=>'cta_label',        'label'=>'CTA — Label',                   'value'=>'Ready to Book?',                                                              'sort_order'=>37],
            ['section_key'=>'cta_heading',      'label'=>'CTA — Heading (HTML OK)',       'value'=>'Your Forest Venue is <em>Available</em>',                                     'sort_order'=>38],
            ['section_key'=>'cta_text',         'label'=>'CTA — Description',             'value'=>'Our venues are available for weddings, corporate events, educational tours and film shoots. Reach out to plan your perfect event at Mahua House.', 'sort_order'=>39],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => 'spaces', 'section_key' => $s['section_key']],
                array_merge($s, ['page' => 'spaces', 'is_active' => true])
            );
        }
    }
}

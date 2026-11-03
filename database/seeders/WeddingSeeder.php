<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeddingFeature;
use App\Models\WeddingTimeline;
use App\Models\PageSection;

class WeddingSeeder extends Seeder
{
    public function run(): void
    {
        // Why Choose Us cards
        foreach ([
            ['icon' => 'fa-solid fa-tree',                 'title' => 'Forest Setting',    'description' => 'Exchange vows beneath ancient trees in a 3.5-acre natural forest reserve — a backdrop unlike any banquet hall.',                              'sort_order' => 1],
            ['icon' => 'fa-solid fa-utensils',             'title' => 'Exquisite Cuisine', 'description' => 'Farm-to-table menus crafted by our in-house chefs — from traditional Indian feasts to contemporary fusion spreads.',                          'sort_order' => 2],
            ['icon' => 'fa-solid fa-bed',                  'title' => 'Exclusive Stay',    'description' => 'Block the entire resort for your wedding party. Boutique rooms and cottages ensure every guest sleeps in comfort.',                             'sort_order' => 3],
            ['icon' => 'fa-solid fa-wand-magic-sparkles',  'title' => 'Full Planning',     'description' => "A dedicated wedding coordinator manages your decor, music, catering and timeline — so you don't have to.",                                    'sort_order' => 4],
        ] as $f) WeddingFeature::firstOrCreate(['title' => $f['title']], $f);

        // Planning process steps
        foreach ([
            ['sort_order' => 1, 'title' => 'Initial Inquiry & Consultation',  'description' => "Fill out our enquiry form or call us. We'll schedule a free consultation to understand your vision, guest count, and dates."],
            ['sort_order' => 2, 'title' => 'Site Visit & Package Selection',   'description' => 'Visit Mahua House to walk the spaces, meet the team, and select the package that fits your dream and budget.'],
            ['sort_order' => 3, 'title' => 'Planning & Customisation',         'description' => 'Work with our coordinator to customise decor, menus, entertainment, and timelines. We handle every vendor and detail.'],
            ['sort_order' => 4, 'title' => 'Your Perfect Wedding Day',         'description' => 'Arrive, relax, and be present. Our team takes care of everything from set-up to the last goodbye — you just celebrate.'],
        ] as $s) WeddingTimeline::firstOrCreate(['title' => $s['title']], $s);

        // Page section text content for destination-wedding
        $sections = [
            ['page' => 'destination-wedding', 'section_key' => 'hero_label',         'label' => 'Hero — Label',                    'value' => 'Your Dream Awaits',                                             'sort_order' => 1],
            ['page' => 'destination-wedding', 'section_key' => 'hero_title',         'label' => 'Hero — Heading (HTML allowed)',    'value' => 'A <em>Forest Wedding</em> Like No Other',                       'sort_order' => 2],
            ['page' => 'destination-wedding', 'section_key' => 'hero_subtitle',      'label' => 'Hero — Subtitle text',            'value' => "Say \"I do\" beneath a canopy of ancient Mahua trees at Bhopal's most enchanting eco-retreat.", 'sort_order' => 3],
            ['page' => 'destination-wedding', 'section_key' => 'hero_image',         'label' => 'Hero — Background Image URL',     'value' => '/site/assets/images/about/1.jpeg',                              'sort_order' => 4],
            ['page' => 'destination-wedding', 'section_key' => 'intro_label',        'label' => 'Intro — Label',                   'value' => 'Complete Destination Wedding Experience',                        'sort_order' => 5],
            ['page' => 'destination-wedding', 'section_key' => 'intro_heading',      'label' => 'Intro — Heading (HTML allowed)',  'value' => 'Create Unforgettable Memories <em>Amidst Nature</em>',          'sort_order' => 6],
            ['page' => 'destination-wedding', 'section_key' => 'intro_description',  'label' => 'Intro — Description paragraph',  'value' => 'Mahua House offers a complete destination wedding experience with multiple themed spaces. From grand reception halls to intimate ceremony gardens — every function finds its perfect setting here.', 'sort_order' => 7],
            ['page' => 'destination-wedding', 'section_key' => 'intro_image_main',   'label' => 'Intro — Main image URL',          'value' => '/site/assets/images/about/5.jpeg',                              'sort_order' => 8],
            ['page' => 'destination-wedding', 'section_key' => 'intro_image_badge',  'label' => 'Intro — Badge (corner) image URL','value' => '/site/assets/images/about/8.jpeg',                              'sort_order' => 9],
            ['page' => 'destination-wedding', 'section_key' => 'intro_years_num',    'label' => 'Intro — Years badge number',      'value' => '10+',                                                           'sort_order' => 10],
            ['page' => 'destination-wedding', 'section_key' => 'intro_years_text',   'label' => 'Intro — Years badge text',        'value' => "Years of\nWeddings",                                            'sort_order' => 11],
            ['page' => 'destination-wedding', 'section_key' => 'venue_checklist',    'label' => 'Intro — Venue checklist (one per line, HTML allowed)', 'value' => "<strong>Mahua Vedika</strong> — Grand wedding & reception venue\n<strong>Chaupal-e-Mahua</strong> — Mehendi & intimate functions\n<strong>Mahua Ras Vritta</strong> — Haldi ceremonies\n<strong>Poolside & Forest Edge</strong> — Sangeet & photography\nPre-wedding shoots in natural forest settings\nStay + Food + Decoration + Event Support packages", 'sort_order' => 12],
            ['page' => 'destination-wedding', 'section_key' => 'why_label',          'label' => 'Why Choose — Label',              'value' => 'Why Mahua House',                                               'sort_order' => 13],
            ['page' => 'destination-wedding', 'section_key' => 'why_heading',        'label' => 'Why Choose — Heading (HTML)',     'value' => 'Everything You Need for a <em>Perfect Day</em>',                'sort_order' => 14],
            ['page' => 'destination-wedding', 'section_key' => 'gallery_label',      'label' => 'Gallery — Label',                 'value' => 'Wedding Gallery',                                               'sort_order' => 15],
            ['page' => 'destination-wedding', 'section_key' => 'gallery_heading',    'label' => 'Gallery — Heading (HTML)',        'value' => 'Moments Captured in Our <em>Forest</em>',                       'sort_order' => 16],
            ['page' => 'destination-wedding', 'section_key' => 'process_label',      'label' => 'Process — Label',                 'value' => 'How It Works',                                                  'sort_order' => 17],
            ['page' => 'destination-wedding', 'section_key' => 'process_heading',    'label' => 'Process — Heading (HTML)',        'value' => 'From First Call to <em>First Dance</em>',                       'sort_order' => 18],
            ['page' => 'destination-wedding', 'section_key' => 'process_description','label' => 'Process — Description paragraph','value' => 'We believe planning your wedding should feel as magical as the day itself. Our streamlined process keeps everything stress-free and transparent.', 'sort_order' => 19],
            ['page' => 'destination-wedding', 'section_key' => 'cta_label',          'label' => 'CTA — Label',                    'value' => 'Get In Touch',                                                  'sort_order' => 20],
            ['page' => 'destination-wedding', 'section_key' => 'cta_heading',        'label' => 'CTA — Heading (HTML)',           'value' => 'Start Planning Your <em>Dream Wedding</em>',                    'sort_order' => 21],
            ['page' => 'destination-wedding', 'section_key' => 'cta_description',    'label' => 'CTA — Description paragraph',    'value' => 'Tell us about your dream day. Our wedding team will get back to you within 24 hours with availability and a tailored quote.', 'sort_order' => 22],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => $s['page'], 'section_key' => $s['section_key']],
                array_merge($s, ['is_active' => true])
            );
        }
    }
}

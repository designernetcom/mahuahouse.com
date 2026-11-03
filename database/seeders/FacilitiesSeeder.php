<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class FacilitiesSeeder extends Seeder
{
    public function run(): void
    {
        // ── Facility Cards (category = facility) ──────────────────────────────────
        // description: newline-separated bullet list items
        foreach ([
            [
                'sort_order' => 1,
                'title'      => 'Safety & Security',
                'image_url'  => '/site/assets/images/facilities/icon-facilities-1.png',
                'description'=> "CCTV Surveillance\nDedicated Security Staff\nPower Backup (Generator/Inverter)\nSafe & Managed Environment",
            ],
            [
                'sort_order' => 2,
                'title'      => 'Sports & Activities',
                'image_url'  => '/site/assets/images/facilities/icon-facilities-2.png',
                'description'=> "Swimming Pool\nRain Dance with Sound System\nBadminton, Basketball, Volleyball\nCricket, Table Tennis, Chess",
            ],
            [
                'sort_order' => 3,
                'title'      => 'Outdoor Experiences',
                'image_url'  => '/site/assets/images/facilities/icon-facilities-3.png',
                'description'=> "Jungle Trekking\nBonfire\nCamping Tents\nHammocks & Nature Relaxation",
            ],
            [
                'sort_order' => 4,
                'title'      => 'Event Support (Chargeable)',
                'image_url'  => '/site/assets/images/facilities/icon-facilities-4.png',
                'description'=> "Event Management Support\nStage & Decoration\nDJ, Sound & Projector\nCustomised Decorated Stage",
            ],
            [
                'sort_order' => 5,
                'title'      => 'Food & Dining',
                'image_url'  => '/site/assets/images/facilities/icon-facilities-5.png',
                'description'=> "Traditional & Local Cuisine\nMulti-Cuisine Buffet\nCustomised Menus\n₹1,000/Head (All-Inclusive)",
            ],
            [
                'sort_order' => 6,
                'title'      => 'Parking & Transport',
                'image_url'  => '/site/assets/images/facilities/icon-facilities-6.png',
                'description'=> "Valet Parking (Chargeable)\nLarge Vehicle Parking\nRope Activity\nPlaying Cards & Board Games",
            ],
        ] as $f) {
            Experience::firstOrCreate(
                ['category' => 'facility', 'title' => $f['title']],
                array_merge($f, ['category' => 'facility', 'is_active' => true])
            );
        }

        // ── Page Sections (page = facilities) ────────────────────────────────────
        $sections = [
            ['section_key'=>'meta_title',       'label'=>'Meta — Page Title',          'value'=>'Facilities | Mahua House',                                                      'sort_order'=>1],
            ['section_key'=>'meta_description', 'label'=>'Meta — Description',         'value'=>'Explore all facilities at Mahua House — swimming pool, sports zone, outdoor experiences, dining, event support and more at our forest eco-resort in Bhopal.', 'sort_order'=>2],
            ['section_key'=>'meta_keywords',    'label'=>'Meta — Keywords',            'value'=>'Mahua House Facilities, Forest Resort Amenities Bhopal, Eco Resort Pool, Sports Activities Bhopal', 'sort_order'=>3],
            ['section_key'=>'hero_image',       'label'=>'Hero — Breadcrumb Image',    'value'=>'', 'media_url'=>'/site/assets/images/breadcrumb/breadcrumb.jpg', 'sort_order'=>4],
            ['section_key'=>'page_title',       'label'=>'Hero — Page Title (H1)',     'value'=>'Facilities',                                                                    'sort_order'=>5],
            ['section_key'=>'breadcrumb',       'label'=>'Breadcrumb Label',           'value'=>'Facilities',                                                                    'sort_order'=>6],
            ['section_key'=>'section_label',    'label'=>'Section — Sub-Label',        'value'=>'Our Facilities',                                                                'sort_order'=>7],
            ['section_key'=>'section_heading',  'label'=>'Section — Heading',          'value'=>'Mahua House Facilities',                                                        'sort_order'=>8],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => 'facilities', 'section_key' => $s['section_key']],
                array_merge($s, ['page' => 'facilities', 'is_active' => true])
            );
        }
    }
}

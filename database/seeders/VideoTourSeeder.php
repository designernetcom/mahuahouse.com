<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class VideoTourSeeder extends Seeder
{
    public function run(): void
    {
        // Default video items (mirrors the 6 videos in the static HTML)
        foreach ([
            ['sort_order' => 1, 'title' => 'Discover Mahua House — The Nostalgic Woods',   'link' => '7uSIYukB8Rc', 'icon' => 'Full Property Tour',          'description' => 'A complete walkthrough of Mahua House — forest retreat, rooms, venues, activities and dining.', 'is_featured' => true],
            ['sort_order' => 2, 'title' => 'Wedding Highlight at Mahua House',              'link' => 'rwhINypv3iA', 'icon' => 'Weddings & Celebrations',     'description' => 'A beautiful wedding highlight reel from Mahua House in a stunning forest setting.'],
            ['sort_order' => 3, 'title' => 'Cottage Stay at Mahua House',                   'link' => 'WrXg_3Cut5I', 'icon' => 'Accommodation Tour',          'description' => 'Step inside our cosy cottages and rooms designed for comfort in the forest.'],
            ['sort_order' => 4, 'title' => 'Activities Video at Mahua House',               'link' => 'SA82LSz298s', 'icon' => 'Sports & Experiences',        'description' => 'Swimming pool, rain dance, jungle trekking, bonfire, badminton, cricket — every activity captured.'],
            ['sort_order' => 5, 'title' => 'Corporate Event at Mahua House',                'link' => 'IRPjxyezpRM', 'icon' => 'Team Retreats & Workshops',   'description' => 'Team-building retreats, workshops and institutional visits at Mahua House.'],
            ['sort_order' => 6, 'title' => 'Cultural Event at Mahua House',                 'link' => 'c3Yvjs8Pcik', 'icon' => 'Cultural & Media Productions','description' => 'Folk performances, cultural festivals, TV shoots and documentaries at Mahua House.'],
        ] as $v) {
            Experience::firstOrCreate(
                ['category' => 'video-tour', 'link' => $v['link']],
                array_merge($v, ['category' => 'video-tour', 'is_active' => true, 'is_featured' => $v['is_featured'] ?? false])
            );
        }

        // Default page section text content
        $sections = [
            ['section_key' => 'hero_label',        'label' => 'Hero — Label',                   'value' => 'See it Before You Visit',                                                          'sort_order' => 1],
            ['section_key' => 'hero_heading',       'label' => 'Hero — Heading (HTML allowed)',  'value' => 'Tour Mahua House<br><em>From Your Screen</em>',                                    'sort_order' => 2],
            ['section_key' => 'hero_text',          'label' => 'Hero — Subtitle text',           'value' => 'Walk through our forest rooms, event spaces, nature trails and dining before you arrive.', 'sort_order' => 3],
            ['section_key' => 'hero_image',         'label' => 'Hero — Background Image URL',   'value' => '/site/assets/images/about/65.jpeg',                                                'sort_order' => 4],
            ['section_key' => 'featured_label',     'label' => 'Featured Player — Label',        'value' => 'Now Playing',                                                                     'sort_order' => 5],
            ['section_key' => 'featured_heading',   'label' => 'Featured Player — Heading (HTML)', 'value' => 'Featured <em>Video Tour</em>',                                                  'sort_order' => 6],
            ['section_key' => 'grid_label',         'label' => 'Video Grid — Label',             'value' => 'All Tours',                                                                        'sort_order' => 7],
            ['section_key' => 'grid_heading',       'label' => 'Video Grid — Heading (HTML)',    'value' => 'Browse <em>Every Video</em>',                                                      'sort_order' => 8],
            ['section_key' => 'grid_text',          'label' => 'Video Grid — Description',       'value' => 'Click any video to load it in the featured player above.',                         'sort_order' => 9],
            ['section_key' => 'youtube_heading',    'label' => 'YouTube Strip — Heading',        'value' => 'Subscribe to Our YouTube Channel',                                                 'sort_order' => 10],
            ['section_key' => 'youtube_text',       'label' => 'YouTube Strip — Description',    'value' => 'New videos, forest diaries, guest experiences and seasonal highlights from Mahua House.', 'sort_order' => 11],
            ['section_key' => 'youtube_url',        'label' => 'YouTube Channel URL',            'value' => 'https://www.youtube.com/@mahuahouse',                                              'sort_order' => 12],
            ['section_key' => 'cta_label',          'label' => 'CTA — Label',                   'value' => 'Ready to Experience It in Person?',                                                'sort_order' => 13],
            ['section_key' => 'cta_heading',        'label' => 'CTA — Heading (HTML)',           'value' => "The Screen Can't Do It <em>Justice</em>",                                         'sort_order' => 14],
            ['section_key' => 'cta_text',           'label' => 'CTA — Description',             'value' => 'The videos give you a glimpse, but Mahua House is best experienced in person.',    'sort_order' => 15],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => 'video-tours', 'section_key' => $s['section_key']],
                array_merge($s, ['page' => 'video-tours', 'is_active' => true])
            );
        }
    }
}

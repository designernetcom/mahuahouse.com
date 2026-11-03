<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryItem;
use App\Models\PageSection;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // ── Gallery Photos ────────────────────────────────────────────────────────
        foreach ([
            // Weddings & Events
            ['title'=>'Mahua House Celebration',  'image_url'=>'/site/assets/images/about/1.jpeg',  'category'=>'events',      'sort_order'=>1],
            ['title'=>'Mahua House Event',         'image_url'=>'/site/assets/images/about/2.jpeg',  'category'=>'events',      'sort_order'=>2],
            ['title'=>'Wedding Venue',             'image_url'=>'/site/assets/images/about/6.jpeg',  'category'=>'events',      'sort_order'=>3],
            ['title'=>'Forest Wedding',            'image_url'=>'/site/assets/images/about/9.jpeg',  'category'=>'events',      'sort_order'=>4],
            ['title'=>'Corporate Event',           'image_url'=>'/site/assets/images/about/41.jpeg', 'category'=>'events',      'sort_order'=>5],
            // Nature & Forest
            ['title'=>'Samardha Forest',           'image_url'=>'/site/assets/images/about/3.jpeg',  'category'=>'nature',      'sort_order'=>6],
            ['title'=>'Forest at Mahua House',     'image_url'=>'/site/assets/images/about/4.jpeg',  'category'=>'nature',      'sort_order'=>7],
            ['title'=>'Green Woodland',            'image_url'=>'/site/assets/images/about/5.jpeg',  'category'=>'nature',      'sort_order'=>8],
            ['title'=>'Nature at Mahua House',     'image_url'=>'/site/assets/images/about/10.jpeg', 'category'=>'nature',      'sort_order'=>9],
            ['title'=>'Forest Landscape',          'image_url'=>'/site/assets/images/about/60.jpeg', 'category'=>'nature',      'sort_order'=>10],
            // Rooms & Stay
            ['title'=>'Room at Mahua House',       'image_url'=>'/site/assets/images/about/13.jpeg', 'category'=>'rooms',       'sort_order'=>11],
            ['title'=>'Cottage Interior',          'image_url'=>'/site/assets/images/about/14.jpeg', 'category'=>'rooms',       'sort_order'=>12],
            ['title'=>'Forest Cottage',            'image_url'=>'/site/assets/images/about/15.jpeg', 'category'=>'rooms',       'sort_order'=>13],
            ['title'=>'Deluxe AC Room',            'image_url'=>'/site/assets/images/about/17.jpeg', 'category'=>'rooms',       'sort_order'=>14],
            ['title'=>'Forest Room',               'image_url'=>'/site/assets/images/about/20.jpeg', 'category'=>'rooms',       'sort_order'=>15],
            // Activities
            ['title'=>'Swimming Pool',             'image_url'=>'/site/assets/images/about/21.jpeg', 'category'=>'activities',  'sort_order'=>16],
            ['title'=>'Rain Dance',                'image_url'=>'/site/assets/images/about/22.jpeg', 'category'=>'activities',  'sort_order'=>17],
            ['title'=>'Forest Trek',               'image_url'=>'/site/assets/images/about/24.jpeg', 'category'=>'activities',  'sort_order'=>18],
            ['title'=>'Bonfire',                   'image_url'=>'/site/assets/images/about/25.jpeg', 'category'=>'activities',  'sort_order'=>19],
            ['title'=>'Sports Zone',               'image_url'=>'/site/assets/images/about/27.jpeg', 'category'=>'activities',  'sort_order'=>20],
            // Dining
            ['title'=>'Dining at Mahua House',     'image_url'=>'/site/assets/images/about/29.jpeg', 'category'=>'dining',      'sort_order'=>21],
            ['title'=>'Traditional Meals',         'image_url'=>'/site/assets/images/about/30.jpeg', 'category'=>'dining',      'sort_order'=>22],
            ['title'=>'Forest Dining',             'image_url'=>'/site/assets/images/about/33.jpeg', 'category'=>'dining',      'sort_order'=>23],
        ] as $g) {
            GalleryItem::firstOrCreate(
                ['image_url' => $g['image_url']],
                array_merge($g, ['is_active' => true])
            );
        }

        // ── Page Sections (page = gallery) ────────────────────────────────────────
        $sections = [
            ['section_key'=>'meta_title',       'label'=>'Meta — Page Title',             'value'=>'Gallery | Mahua House',                                                        'sort_order'=>1],
            ['section_key'=>'meta_description', 'label'=>'Meta — Description',            'value'=>'Explore the Mahua House photo gallery — forests, events, rooms, weddings, activities and more from our eco retreat near Bhopal.', 'sort_order'=>2],
            ['section_key'=>'meta_keywords',    'label'=>'Meta — Keywords',               'value'=>'Mahua House Gallery, Forest Resort Photos, Bhopal Eco Resort, Wedding Venue Photos', 'sort_order'=>3],
            ['section_key'=>'hero_image',       'label'=>'Hero — Background Image',       'value'=>'', 'media_url'=>'/site/assets/images/about/3.jpeg',  'sort_order'=>4],
            ['section_key'=>'hero_label',       'label'=>'Hero — Label',                  'value'=>'Visual Journey',                                                               'sort_order'=>5],
            ['section_key'=>'hero_heading',     'label'=>'Hero — Heading (HTML OK)',       'value'=>'Mahua House<br><em>Through the Lens</em>',                                     'sort_order'=>6],
            ['section_key'=>'hero_text',        'label'=>'Hero — Subtext',                'value'=>'Forests, celebrations, moments of stillness — every photograph is a window into life at Mahua House.', 'sort_order'=>7],
            ['section_key'=>'breadcrumb',       'label'=>'Breadcrumb Label',              'value'=>'Gallery',                                                                      'sort_order'=>8],
            // Stats strip: num|label per line
            ['section_key'=>'stats_strip',      'label'=>'Stats Strip (num|label per line)', 'value'=>"3.5|Acres of Forest\n4|Named Venues\n3|Room Types\nMP|Tourism Accredited",  'sort_order'=>9],
            // Gallery section
            ['section_key'=>'gallery_label',    'label'=>'Gallery — Label',               'value'=>'Our Collection',                                                               'sort_order'=>10],
            ['section_key'=>'gallery_heading',  'label'=>'Gallery — Heading (HTML OK)',   'value'=>'Explore <em>Mahua House</em>',                                                 'sort_order'=>11],
            ['section_key'=>'gallery_text',     'label'=>'Gallery — Description',         'value'=>'Filter by category to explore weddings and events, forest nature, our rooms and cottages, or activities and experiences.', 'sort_order'=>12],
            // CTA
            ['section_key'=>'cta_label',        'label'=>'CTA — Label',                   'value'=>'Come and See for Yourself',                                                    'sort_order'=>13],
            ['section_key'=>'cta_heading',      'label'=>'CTA — Heading (HTML OK)',       'value'=>'Experience Mahua House <em>in Person</em>',                                    'sort_order'=>14],
            ['section_key'=>'cta_text',         'label'=>'CTA — Description',             'value'=>'Every photograph only hints at what it feels like to be here. Book your stay or event and let the forest do the rest.', 'sort_order'=>15],
            ['section_key'=>'cta_bg_image',     'label'=>'CTA — Background Overlay Image','value'=>'', 'media_url'=>'/site/assets/images/about/2.jpeg',  'sort_order'=>16],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => 'gallery', 'section_key' => $s['section_key']],
                array_merge($s, ['page' => 'gallery', 'is_active' => true])
            );
        }
    }
}

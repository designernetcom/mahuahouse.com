<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\GalleryItem;
use App\Models\PageSection;

class DayOutPlanSeeder extends Seeder
{
    public function run(): void
    {
        // ── Includes (category = day-include) ───────────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-person-swimming',          'title'=>'Swimming Pool',         'description'=>'Full access to our swimming pool — perfect for families and groups.'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-cloud-rain',               'title'=>'Rain Dance',             'description'=>'Rain Dance with Sound System — the most popular activity for groups!'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-person-hiking',            'title'=>'Jungle Trekking',        'description'=>'Guided trekking through Samardha forest — discover wildlife, flora, and stunning views.'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-fire-flame-curved',        'title'=>'Bonfire',                'description'=>'Evening bonfire under the stars — perfect for stories, music, and connection.'],
            ['sort_order'=>5,'icon'=>'fa-solid fa-campground',               'title'=>'Camping Tents',          'description'=>'Stay overnight in camping tents amidst nature — a unique forest experience.'],
            ['sort_order'=>6,'icon'=>'fa-solid fa-futbol',                   'title'=>'Sports Zone',            'description'=>'Badminton, Basketball, Volleyball, Cricket, Table Tennis and more!'],
            ['sort_order'=>7,'icon'=>'fa-solid fa-hammock',                  'title'=>'Hammocks & Relaxation',  'description'=>'Unwind in hammocks strung between ancient trees — total nature relaxation.'],
            ['sort_order'=>8,'icon'=>'fa-solid fa-utensils',                 'title'=>'Authentic Dining',       'description'=>'Traditional & local cuisine experience. Day packages customised for groups.'],
        ] as $inc) {
            Experience::firstOrCreate(['category'=>'day-include','title'=>$inc['title']], array_merge($inc, ['category'=>'day-include','is_active'=>true]));
        }

        // ── Activities (category = day-activity) ────────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-binoculars',    'title'=>'Birdwatching',   'description'=>'150+ bird species recorded. Early morning guided sessions with binoculars provided by our resident naturalist.',                   'image_url'=>'/site/assets/images/about/10.jpeg'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-person-hiking', 'title'=>'Nature Trails',   'description'=>'Guided walks through the Samardha Reserved Forest. Learn about flora, fauna, medicinal plants and forest ecology.',               'image_url'=>'/site/assets/images/about/18.jpeg'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-person-swimming','title'=>'Forest Pool',    'description'=>'A stunning natural-edge pool surrounded by teak trees. Open to day guests between 1 PM and 5 PM.',                               'image_url'=>'/site/assets/images/services/swimming-pool.jpg'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-utensils',      'title'=>'Farm Dining',     'description'=>'Breakfast, lunch, and evening snacks prepared with seasonal, locally sourced produce. Dining under the forest canopy.',            'image_url'=>'/site/assets/images/about/28.jpeg'],
            ['sort_order'=>5,'icon'=>'fa-solid fa-fire-flame-curved','title'=>'Campfire Evening','description'=>'Folk music, chai and stories around the forest campfire. The most memorable part of every visit to Mahua House.',             'image_url'=>'/site/assets/images/about/45.jpeg'],
        ] as $act) {
            Experience::firstOrCreate(['category'=>'day-activity','title'=>$act['title']], array_merge($act, ['category'=>'day-activity','is_active'=>true]));
        }

        // ── Gallery (category = day-out) ─────────────────────────────────────────
        foreach ([
            ['sort_order'=>1,'title'=>'Forest Walk',   'image_url'=>'/site/assets/images/about/14.jpeg'],
            ['sort_order'=>2,'title'=>'Campfire',      'image_url'=>'/site/assets/images/about/22.jpeg'],
            ['sort_order'=>3,'title'=>'Pool',          'image_url'=>'/site/assets/images/services/swimming-pool.jpg'],
            ['sort_order'=>4,'title'=>'Dining',        'image_url'=>'/site/assets/images/about/30.jpeg'],
            ['sort_order'=>5,'title'=>'Restaurant',    'image_url'=>'/site/assets/images/services/restaurant-bar.jpg'],
            ['sort_order'=>6,'title'=>'Nature',        'image_url'=>'/site/assets/images/about/38.jpeg'],
        ] as $g) {
            GalleryItem::firstOrCreate(['category'=>'day-out','image_url'=>$g['image_url']], array_merge($g, ['category'=>'day-out','is_active'=>true]));
        }

        // ── Page Sections ───────────────────────────────────────────────────────
        $sections = [
            ['section_key'=>'hero_label',     'label'=>'Hero — Label',                  'value'=>'Forest Day Experience',                                                                                                            'sort_order'=>1],
            ['section_key'=>'hero_heading',   'label'=>'Hero — Heading (HTML)',         'value'=>"One Day.<br><em>A Forest Full</em> of Memories.",                                                                                 'sort_order'=>2],
            ['section_key'=>'hero_text',      'label'=>'Hero — Subtitle',               'value'=>"You don't need to stay overnight to experience the magic of Mahua House. Our Day Out Plans give you a full day of forest immersion — farm dining, guided nature trails, and a campfire sunset.", 'sort_order'=>3],
            ['section_key'=>'hero_image',     'label'=>'Hero — Background Image URL',   'value'=>'/site/assets/images/about/3.jpeg',                                                                                                'sort_order'=>4],
            ['section_key'=>'hero_pills',     'label'=>'Hero — Pills (icon|label, 1/line)','value'=>"fa-solid fa-sun|8 AM – 8 PM\nfa-solid fa-users|Individuals & Groups\nfa-solid fa-utensils|Meals Included\nfa-solid fa-person-swimming|Pool Access", 'sort_order'=>5],
            ['section_key'=>'inc_label',      'label'=>'Includes — Label',              'value'=>'The Experience',                                                                                                                   'sort_order'=>6],
            ['section_key'=>'inc_heading',    'label'=>'Includes — Heading (HTML)',     'value'=>"Everything Your Day <em>Includes</em>",                                                                                           'sort_order'=>7],
            ['section_key'=>'inc_text',       'label'=>'Includes — Description',        'value'=>'Every Day Out Plan at Mahua House is carefully curated for maximum immersion and minimum stress — just show up and let the forest do the rest.', 'sort_order'=>8],
            ['section_key'=>'act_label',      'label'=>'Activities — Label',            'value'=>'Activities',                                                                                                                       'sort_order'=>9],
            ['section_key'=>'act_heading',    'label'=>'Activities — Heading (HTML)',   'value'=>'What You Can <em>Do Here</em>',                                                                                                   'sort_order'=>10],
            ['section_key'=>'pkg_label',      'label'=>'Packages — Label',              'value'=>'Day Out Plans',                                                                                                                    'sort_order'=>11],
            ['section_key'=>'pkg_heading',    'label'=>'Packages — Heading (HTML)',     'value'=>'Choose Your <em>Day</em>',                                                                                                        'sort_order'=>12],
            ['section_key'=>'pkg_text',       'label'=>'Packages — Description',        'value'=>'Tailored day experiences — all prices per person.',                                                                               'sort_order'=>13],
            ['section_key'=>'group_icon',     'label'=>'Group Strip — Icon',            'value'=>'fa-solid fa-users',                                                                                                               'sort_order'=>14],
            ['section_key'=>'group_title',    'label'=>'Group Strip — Title',           'value'=>'Group & Corporate Bookings',                                                                                                       'sort_order'=>15],
            ['section_key'=>'group_text',     'label'=>'Group Strip — Description',     'value'=>'Groups of 10+ get 15% off all plans. Corporate day retreats with team-building activities and dedicated coordinator. Contact us for custom group pricing.', 'sort_order'=>16],
            ['section_key'=>'group_cta',      'label'=>'Group Strip — CTA Button',      'value'=>'Get Group Quote',                                                                                                                  'sort_order'=>17],
            ['section_key'=>'gallery_label',  'label'=>'Gallery — Label',               'value'=>'Photo Gallery',                                                                                                                    'sort_order'=>18],
            ['section_key'=>'gallery_heading','label'=>'Gallery — Heading (HTML)',      'value'=>'A Day <em>Through the Lens</em>',                                                                                                 'sort_order'=>19],
            ['section_key'=>'gallery_cta',    'label'=>'Gallery — CTA Button',          'value'=>'Book Your Day',                                                                                                                    'sort_order'=>20],
            ['section_key'=>'faq_label',      'label'=>'FAQ — Label',                   'value'=>'Common Questions',                                                                                                                 'sort_order'=>21],
            ['section_key'=>'faq_heading',    'label'=>'FAQ — Heading (HTML)',          'value'=>'Day Out <em>FAQs</em>',                                                                                                           'sort_order'=>22],
            ['section_key'=>'faq_text',       'label'=>'FAQ — Description',             'value'=>'Have a question about visiting Mahua House for the day? Find quick answers below or reach out to our team directly.',             'sort_order'=>23],
            ['section_key'=>'cta_label',      'label'=>'CTA — Label',                   'value'=>'Ready for Your Forest Day?',                                                                                                       'sort_order'=>24],
            ['section_key'=>'cta_heading',    'label'=>'CTA — Heading (HTML)',          'value'=>'Book Your Day Out <em>Today</em>',                                                                                                 'sort_order'=>25],
            ['section_key'=>'cta_text',       'label'=>'CTA — Description',             'value'=>'Escape the city for a day. Breathe the forest. Return renewed. Our Day Out Plans are available on all days — book now and secure your slot.', 'sort_order'=>26],
            ['section_key'=>'cta_btn1',       'label'=>'CTA — Book Button Text',        'value'=>'Book Now',                                                                                                                         'sort_order'=>27],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page'=>'day-out-plan','section_key'=>$s['section_key']],
                array_merge($s, ['page'=>'day-out-plan','is_active'=>true])
            );
        }
    }
}

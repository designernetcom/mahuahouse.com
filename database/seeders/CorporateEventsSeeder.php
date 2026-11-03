<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class CorporateEventsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Why Choose Features (category = corporate-why) ──────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-tree',              'title'=>'Adjoining Reserved Forest',         'description'=>'Mahua House sits adjoining Samardha Reserved Forest on Raisen Road, Bhopal — a natural, undistracted environment that boosts creativity, focus, and team bonding.'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-chalkboard-user',   'title'=>'Meeting Spaces with Full AV',        'description'=>'Open and covered meeting areas equipped with projector, sound system, and whiteboards — perfect for strategy sessions, presentations, and workshops.'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-person-running',    'title'=>'Team Activities Built In',           'description'=>'Swimming pool, rain dance, jungle trekking, bonfire, badminton, cricket, volleyball, table tennis and more — activities that build teams naturally.'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-utensils',          'title'=>'Customised Dining (₹1,000/Head)',   'description'=>'Traditional home-style food, multi-cuisine buffet, and customised menus for groups — Bed Tea, Breakfast, Lunch, Hi Tea, and Dinner available at ₹1,000 per head.'],
            ['sort_order'=>5,'icon'=>'fa-solid fa-moon',              'title'=>'Stay On-site',                      'description'=>'Super Deluxe AC, Deluxe AC, and Independent Cottage options from ₹2,500/night (double occupancy). Check-in 11AM, Check-out 10AM.'],
        ] as $f) {
            Experience::firstOrCreate(['category'=>'corporate-why','title'=>$f['title']], array_merge($f, ['category'=>'corporate-why','is_active'=>true]));
        }

        // ── Activities (category = corporate-activity) ──────────────────────────
        foreach ([
            ['sort_order'=>1, 'icon'=>'fa-solid fa-person-swimming',          'title'=>'Swimming Pool',   'description'=>'Refreshing pool access for all group members'],
            ['sort_order'=>2, 'icon'=>'fa-solid fa-cloud-rain',               'title'=>'Rain Dance',      'description'=>'Fun rain dance activity for team bonding'],
            ['sort_order'=>3, 'icon'=>'fa-solid fa-person-hiking',            'title'=>'Jungle Trekking', 'description'=>'Guided treks through the Samardha forest'],
            ['sort_order'=>4, 'icon'=>'fa-solid fa-fire-flame-curved',        'title'=>'Bonfire',         'description'=>'Evening bonfire for storytelling and team time'],
            ['sort_order'=>5, 'icon'=>'fa-solid fa-tent',                     'title'=>'Camping',         'description'=>'Camping tents for overnight forest stays'],
            ['sort_order'=>6, 'icon'=>'fa-solid fa-table-tennis-paddle-ball', 'title'=>'Sports Zone',     'description'=>'Badminton, cricket, volleyball, table tennis, chess'],
        ] as $a) {
            Experience::firstOrCreate(['category'=>'corporate-activity','title'=>$a['title']], array_merge($a, ['category'=>'corporate-activity','is_active'=>true]));
        }

        // ── Page Sections ───────────────────────────────────────────────────────
        $sections = [
            ['section_key'=>'hero_label',    'label'=>'Hero — Label',                    'value'=>'Groups & Corporates',                                                                                     'sort_order'=>1],
            ['section_key'=>'hero_heading',  'label'=>'Hero — Heading (HTML)',           'value'=>'Retreats, Workshops &amp;<br><em>Experiences</em>',                                                       'sort_order'=>2],
            ['section_key'=>'hero_text',     'label'=>'Hero — Subtitle',                 'value'=>'Team-building retreats, educational tours, film shoots and group outings — a complete nature-based experience for every kind of group.', 'sort_order'=>3],
            ['section_key'=>'hero_image',    'label'=>'Hero — Background Image URL',     'value'=>'/site/assets/images/about/7.jpeg',                                                                        'sort_order'=>4],
            ['section_key'=>'hero_cta1',     'label'=>'Hero — CTA Button 1',             'value'=>'Plan Your Retreat',                                                                                       'sort_order'=>5],
            ['section_key'=>'hero_cta2',     'label'=>'Hero — CTA Button 2 (WhatsApp)',  'value'=>'WhatsApp Us',                                                                                             'sort_order'=>6],
            ['section_key'=>'cats_label',    'label'=>'Categories — Label',              'value'=>'What We Offer',                                                                                           'sort_order'=>7],
            ['section_key'=>'cats_heading',  'label'=>'Categories — Heading (HTML)',     'value'=>'Three Distinct <em>Group Experiences</em>',                                                               'sort_order'=>8],
            ['section_key'=>'cats_text',     'label'=>'Categories — Description',        'value'=>'From corporate team-building to school field trips to film shoots — a forest experience for every group.','sort_order'=>9],
            ['section_key'=>'cat1_icon',     'label'=>'Card 1 — Icon',                   'value'=>'fa-solid fa-briefcase',                                                                                   'sort_order'=>10],
            ['section_key'=>'cat1_title',    'label'=>'Card 1 — Title',                  'value'=>'Corporate & Group Events',                                                                                'sort_order'=>11],
            ['section_key'=>'cat1_subtitle', 'label'=>'Card 1 — Subtitle',               'value'=>'Team Retreats & Workshops',                                                                               'sort_order'=>12],
            ['section_key'=>'cat1_items',    'label'=>'Card 1 — Bullet Items (1 per line)','value'=>"Team-building retreats\nStrategic workshops & meetings\nClub & group outings\nTraining programs\nProjector & sound support\nGroup activities included\nCustomised meal plans (₹1,000/head)",'sort_order'=>13],
            ['section_key'=>'cat2_icon',     'label'=>'Card 2 — Icon',                   'value'=>'fa-solid fa-graduation-cap',                                                                             'sort_order'=>14],
            ['section_key'=>'cat2_title',    'label'=>'Card 2 — Title',                  'value'=>'Educational & Institutional Tours',                                                                       'sort_order'=>15],
            ['section_key'=>'cat2_subtitle', 'label'=>'Card 2 — Subtitle',               'value'=>'School, College & Institution Groups',                                                                    'sort_order'=>16],
            ['section_key'=>'cat2_items',    'label'=>'Card 2 — Bullet Items (1 per line)','value'=>"School & college group visits\nNature walks & forest education\nEco-awareness camps\nHands-on farming experiences\nRural culture & heritage discovery\nSamardha Reserved Forest exploration\nSupervised activities for students",'sort_order'=>17],
            ['section_key'=>'cat3_icon',     'label'=>'Card 3 — Icon',                   'value'=>'fa-solid fa-video',                                                                                      'sort_order'=>18],
            ['section_key'=>'cat3_title',    'label'=>'Card 3 — Title',                  'value'=>'Film & Media Productions',                                                                               'sort_order'=>19],
            ['section_key'=>'cat3_subtitle', 'label'=>'Card 3 — Subtitle',               'value'=>'Shoots, Documentaries & Photography',                                                                    'sort_order'=>20],
            ['section_key'=>'cat3_items',    'label'=>'Card 3 — Bullet Items (1 per line)','value'=>"Natural forest backdrop — no fake sets\nTV commercials & brand films\nDocumentaries & short films\nMusic videos & cultural productions\nPre-wedding & portfolio shoots\nEditorial & fashion photography\nCrew accommodation on-site",'sort_order'=>21],
            ['section_key'=>'why_label',     'label'=>'Why Choose — Label',              'value'=>'Why Choose Mahua House',                                                                                  'sort_order'=>22],
            ['section_key'=>'why_heading',   'label'=>'Why Choose — Heading (HTML)',     'value'=>'Corporate Retreats in a<br><em>Real Forest</em>',                                                         'sort_order'=>23],
            ['section_key'=>'why_image',     'label'=>'Why Choose — Image URL',          'value'=>'/site/assets/images/about/20.jpeg',                                                                       'sort_order'=>24],
            ['section_key'=>'why_badge_icon','label'=>'Why Choose — Badge Icon',         'value'=>'fa-solid fa-leaf',                                                                                        'sort_order'=>25],
            ['section_key'=>'why_badge_title','label'=>'Why Choose — Badge Title',       'value'=>'MP Tourism Accredited',                                                                                   'sort_order'=>26],
            ['section_key'=>'why_badge_sub', 'label'=>'Why Choose — Badge Subtitle',     'value'=>'Trusted nature retreat on Raisen Road, Bhopal',                                                          'sort_order'=>27],
            ['section_key'=>'act_label',     'label'=>'Activities — Label',              'value'=>'Group Activities',                                                                                        'sort_order'=>28],
            ['section_key'=>'act_heading',   'label'=>'Activities — Heading (HTML)',     'value'=>'Activities for Your <em>Team or Group</em>',                                                              'sort_order'=>29],
            ['section_key'=>'act_text',      'label'=>'Activities — Description',        'value'=>"From adventure to relaxation — there's something for every group member.",                               'sort_order'=>30],
            ['section_key'=>'edu_label',     'label'=>'Educational — Label',             'value'=>'For Schools & Colleges',                                                                                  'sort_order'=>31],
            ['section_key'=>'edu_heading',   'label'=>'Educational — Heading (HTML)',    'value'=>'Educational &amp;<br><em>Institutional Tours</em>',                                                       'sort_order'=>32],
            ['section_key'=>'edu_text',      'label'=>'Educational — Description',       'value'=>'Mahua House welcomes school, college, and institutional groups for meaningful nature-based learning experiences. Adjoining the Samardha Reserved Forest, we provide a living classroom unlike any other.', 'sort_order'=>33],
            ['section_key'=>'edu_image',     'label'=>'Educational — Image URL',         'value'=>'/site/assets/images/about/14.jpeg',                                                                       'sort_order'=>34],
            ['section_key'=>'edu_badge',     'label'=>'Educational — Image Badge Text',  'value'=>'Schools & Colleges Welcome',                                                                              'sort_order'=>35],
            ['section_key'=>'edu_items',     'label'=>'Educational — List Items (1/line)','value'=>"Guided nature walks & forest education programs\nEco-awareness camps & environmental education\nHands-on farming & rural culture experiences\nDiscover the Samardha Reserved Forest ecosystem\nSafe, supervised activities in a managed environment",'sort_order'=>36],
            ['section_key'=>'edu_cta',       'label'=>'Educational — CTA Button',        'value'=>'Enquire for Group Tour',                                                                                  'sort_order'=>37],
            ['section_key'=>'film_label',    'label'=>'Film — Label',                    'value'=>'Media & Productions',                                                                                     'sort_order'=>38],
            ['section_key'=>'film_heading',  'label'=>'Film — Heading (HTML)',            'value'=>'Film &amp; Media<br><em>Shoots</em>',                                                                    'sort_order'=>39],
            ['section_key'=>'film_text',     'label'=>'Film — Description',              'value'=>"Mahua House offers one of Bhopal's most striking natural shoot locations — the living forest of Samardha Reserve as your backdrop.", 'sort_order'=>40],
            ['section_key'=>'film_image',    'label'=>'Film — Image URL',                'value'=>'/site/assets/images/about/18.jpeg',                                                                       'sort_order'=>41],
            ['section_key'=>'film_badge',    'label'=>'Film — Image Badge Text',         'value'=>'Media Friendly',                                                                                          'sort_order'=>42],
            ['section_key'=>'film_cta',      'label'=>'Film — CTA Button',               'value'=>'Enquire for Media Shoot',                                                                                 'sort_order'=>43],
            ['section_key'=>'film_c1_icon',  'label'=>'Film Mini-Card 1 — Icon',         'value'=>'fa-solid fa-tv',                                                                                          'sort_order'=>44],
            ['section_key'=>'film_c1_title', 'label'=>'Film Mini-Card 1 — Title',        'value'=>'TV Commercials',                                                                                          'sort_order'=>45],
            ['section_key'=>'film_c1_sub',   'label'=>'Film Mini-Card 1 — Subtitle',     'value'=>'Brand & product films',                                                                                   'sort_order'=>46],
            ['section_key'=>'film_c2_icon',  'label'=>'Film Mini-Card 2 — Icon',         'value'=>'fa-solid fa-film',                                                                                        'sort_order'=>47],
            ['section_key'=>'film_c2_title', 'label'=>'Film Mini-Card 2 — Title',        'value'=>'Short Films',                                                                                             'sort_order'=>48],
            ['section_key'=>'film_c2_sub',   'label'=>'Film Mini-Card 2 — Subtitle',     'value'=>'Indie & documentary films',                                                                               'sort_order'=>49],
            ['section_key'=>'film_c3_icon',  'label'=>'Film Mini-Card 3 — Icon',         'value'=>'fa-solid fa-music',                                                                                       'sort_order'=>50],
            ['section_key'=>'film_c3_title', 'label'=>'Film Mini-Card 3 — Title',        'value'=>'Music Videos',                                                                                            'sort_order'=>51],
            ['section_key'=>'film_c3_sub',   'label'=>'Film Mini-Card 3 — Subtitle',     'value'=>'Cultural & folk productions',                                                                             'sort_order'=>52],
            ['section_key'=>'film_c4_icon',  'label'=>'Film Mini-Card 4 — Icon',         'value'=>'fa-solid fa-camera',                                                                                      'sort_order'=>53],
            ['section_key'=>'film_c4_title', 'label'=>'Film Mini-Card 4 — Title',        'value'=>'Photography',                                                                                             'sort_order'=>54],
            ['section_key'=>'film_c4_sub',   'label'=>'Film Mini-Card 4 — Subtitle',     'value'=>'Pre-wedding & editorial',                                                                                 'sort_order'=>55],
            ['section_key'=>'form_label',    'label'=>'Enquiry Form — Label',            'value'=>'Get In Touch',                                                                                            'sort_order'=>56],
            ['section_key'=>'form_heading',  'label'=>'Enquiry Form — Heading (HTML)',   'value'=>'Plan Your Group <em>Experience</em>',                                                                     'sort_order'=>57],
            ['section_key'=>'form_text',     'label'=>'Enquiry Form — Description',      'value'=>"Fill in your details and we'll get back to you quickly with availability and a tailored proposal.",      'sort_order'=>58],
            ['section_key'=>'cta_label',     'label'=>'CTA — Label',                    'value'=>"Let's Plan Together",                                                                                      'sort_order'=>59],
            ['section_key'=>'cta_heading',   'label'=>'CTA — Heading (HTML)',            'value'=>'Your Forest Group Experience is <em>One Call Away</em>',                                                  'sort_order'=>60],
            ['section_key'=>'cta_text',      'label'=>'CTA — Description',              'value'=>'Contact us at Mahua House to plan your corporate retreat, educational tour, or film shoot.',               'sort_order'=>61],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page'=>'corporate-events','section_key'=>$s['section_key']],
                array_merge($s, ['page'=>'corporate-events','is_active'=>true])
            );
        }
    }
}

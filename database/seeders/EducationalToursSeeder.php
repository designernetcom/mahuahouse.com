<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class EducationalToursSeeder extends Seeder
{
    public function run(): void
    {
        // ── Highlights (category = edu-highlight) ───────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-leaf',          'title'=>'Nature-Based Learning','description'=>'Hands-on ecology, botany and forest science in a real forest environment — not a classroom.'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-person-hiking',  'title'=>'Jungle Trekking',      'description'=>'Guided nature walks and jungle treks through the Samardha Reserved Forest with experienced naturalists.'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-people-group',   'title'=>'Group Activities',     'description'=>'Team sports, discipline-based programs and collaborative outdoor challenges for student groups.'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-landmark',       'title'=>'Cultural Exposure',    'description'=>"Experience rural heritage, folk traditions and the cultural fabric of Madhya Pradesh's forest communities."],
        ] as $h) {
            Experience::firstOrCreate(['category'=>'edu-highlight','title'=>$h['title']], array_merge($h, ['category'=>'edu-highlight','is_active'=>true]));
        }

        // ── Programs (category = edu-program) ───────────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-tree',         'title'=>'Nature & Forest',      'link'=>'Ecology & Environment',    'description'=>"Guided jungle trekking\nBird watching & nature identification\nForest conservation awareness\nMedicinal plant discovery\nNight nature experience (overnight groups)"],
            ['sort_order'=>2,'icon'=>'fa-solid fa-person-running','title'=>'Activities & Sports',  'link'=>'Discipline & Teamwork',    'description'=>"Outdoor group sports\nTeam-building games\nObstacle & adventure challenges\nLeadership & discipline exercises\nMorning yoga & meditation sessions"],
            ['sort_order'=>3,'icon'=>'fa-solid fa-palette',       'title'=>'Culture & Heritage',   'link'=>'Folk & Rural Experience',  'description'=>"Rural community interaction\nTraditional craft workshops\nLocal food & cooking exposure\nFolk music & cultural performances\nMP tribal heritage discovery"],
        ] as $p) {
            Experience::firstOrCreate(['category'=>'edu-program','title'=>$p['title']], array_merge($p, ['category'=>'edu-program','is_active'=>true]));
        }

        // ── Page Sections ───────────────────────────────────────────────────────
        $sections = [
            ['section_key'=>'hero_label',       'label'=>'Hero — Label',                      'value'=>'Schools & Institutions',                                                                                       'sort_order'=>1],
            ['section_key'=>'hero_heading',     'label'=>'Hero — Heading (HTML)',             'value'=>'Learn in the <em>Living Forest</em>',                                                                         'sort_order'=>2],
            ['section_key'=>'hero_text',        'label'=>'Hero — Subtitle',                   'value'=>'Structured, supervised and deeply enriching — our educational tours blend nature-based learning, jungle trekking, cultural exposure and group activities in the Samardha Reserved Forest.', 'sort_order'=>3],
            ['section_key'=>'hero_image',       'label'=>'Hero — Background Image URL',       'value'=>'/site/assets/images/about/14.jpeg',                                                                           'sort_order'=>4],
            ['section_key'=>'hero_cta1',        'label'=>'Hero — CTA Button 1',               'value'=>'Plan a School Visit',                                                                                         'sort_order'=>5],
            ['section_key'=>'hero_cta2',        'label'=>'Hero — CTA Button 2 (WhatsApp)',    'value'=>'WhatsApp Us',                                                                                                  'sort_order'=>6],
            ['section_key'=>'hl_label',         'label'=>'Highlights — Label',                'value'=>'Why Mahua House',                                                                                             'sort_order'=>7],
            ['section_key'=>'hl_heading',       'label'=>'Highlights — Heading (HTML)',       'value'=>'A Classroom Like <em>No Other</em>',                                                                          'sort_order'=>8],
            ['section_key'=>'hl_text',          'label'=>'Highlights — Description',          'value'=>'Nestled in 3.5 acres adjoining the Samardha Reserved Forest, Mahua House offers a safe, structured and unforgettable outdoor learning environment.', 'sort_order'=>9],
            ['section_key'=>'split_label',      'label'=>'Programs Split — Label',            'value'=>'Designed for Institutions',                                                                                   'sort_order'=>10],
            ['section_key'=>'split_heading',    'label'=>'Programs Split — Heading (HTML)',   'value'=>'Structured <em>Programs</em><br>for Every Age Group',                                                         'sort_order'=>11],
            ['section_key'=>'split_text',       'label'=>'Programs Split — Description',      'value'=>"Whether it's a school trip for primary students or a college field study, our programs are tailored to the curriculum and age group — always supervised, always safe.", 'sort_order'=>12],
            ['section_key'=>'split_image',      'label'=>'Programs Split — Image URL',        'value'=>'/site/assets/images/about/22.jpeg',                                                                           'sort_order'=>13],
            ['section_key'=>'split_cta',        'label'=>'Programs Split — CTA Button',       'value'=>'Enquire for School Group',                                                                                    'sort_order'=>14],
            ['section_key'=>'split_badge_icon', 'label'=>'Programs Split — Badge Icon',       'value'=>'fa-solid fa-graduation-cap',                                                                                  'sort_order'=>15],
            ['section_key'=>'split_badge_title','label'=>'Programs Split — Badge Title',      'value'=>'Schools & Colleges Welcome',                                                                                  'sort_order'=>16],
            ['section_key'=>'split_badge_sub',  'label'=>'Programs Split — Badge Subtitle',   'value'=>'Customised day & overnight programs available',                                                               'sort_order'=>17],
            ['section_key'=>'mini1_icon',       'label'=>'Mini Card 1 — Icon',                'value'=>'fa-solid fa-seedling',                                                                                        'sort_order'=>18],
            ['section_key'=>'mini1_title',      'label'=>'Mini Card 1 — Title',               'value'=>'Eco-Awareness Camp',                                                                                          'sort_order'=>19],
            ['section_key'=>'mini1_desc',       'label'=>'Mini Card 1 — Description',         'value'=>'Forest biodiversity, conservation & sustainability',                                                          'sort_order'=>20],
            ['section_key'=>'mini2_icon',       'label'=>'Mini Card 2 — Icon',                'value'=>'fa-solid fa-tractor',                                                                                         'sort_order'=>21],
            ['section_key'=>'mini2_title',      'label'=>'Mini Card 2 — Title',               'value'=>'Farm & Rural Experience',                                                                                     'sort_order'=>22],
            ['section_key'=>'mini2_desc',       'label'=>'Mini Card 2 — Description',         'value'=>'Hands-on farming & rural community interaction',                                                              'sort_order'=>23],
            ['section_key'=>'mini3_icon',       'label'=>'Mini Card 3 — Icon',                'value'=>'fa-solid fa-magnifying-glass',                                                                               'sort_order'=>24],
            ['section_key'=>'mini3_title',      'label'=>'Mini Card 3 — Title',               'value'=>'Forest Exploration',                                                                                          'sort_order'=>25],
            ['section_key'=>'mini3_desc',       'label'=>'Mini Card 3 — Description',         'value'=>'Samardha Reserved Forest guided discovery walks',                                                             'sort_order'=>26],
            ['section_key'=>'mini4_icon',       'label'=>'Mini Card 4 — Icon',                'value'=>'fa-solid fa-masks-theater',                                                                                   'sort_order'=>27],
            ['section_key'=>'mini4_title',      'label'=>'Mini Card 4 — Title',               'value'=>'Cultural Immersion',                                                                                          'sort_order'=>28],
            ['section_key'=>'mini4_desc',       'label'=>'Mini Card 4 — Description',         'value'=>'Folk arts, heritage crafts & local traditions',                                                               'sort_order'=>29],
            ['section_key'=>'prog_label',       'label'=>'Programs Dark — Label',             'value'=>'Program Menu',                                                                                               'sort_order'=>30],
            ['section_key'=>'prog_heading',     'label'=>'Programs Dark — Heading (HTML)',    'value'=>"What's <em>Included</em>",                                                                                    'sort_order'=>31],
            ['section_key'=>'prog_text',        'label'=>'Programs Dark — Description',       'value'=>'Choose from a range of structured modules or let us curate a full-day or multi-day program for your group.', 'sort_order'=>32],
            ['section_key'=>'safety_label',     'label'=>'Safety — Label',                    'value'=>'Safety First',                                                                                               'sort_order'=>33],
            ['section_key'=>'safety_heading',   'label'=>'Safety — Heading (HTML)',           'value'=>'Safe, Supervised &amp; <em>Structured</em>',                                                                 'sort_order'=>34],
            ['section_key'=>'safety_icon',      'label'=>'Safety — Strip Icon',               'value'=>'fa-solid fa-shield-halved',                                                                                  'sort_order'=>35],
            ['section_key'=>'safety_title',     'label'=>'Safety — Bold Title',               'value'=>'Every program at Mahua House is fully supervised and structured.',                                           'sort_order'=>36],
            ['section_key'=>'safety_text',      'label'=>'Safety — Description',              'value'=>'All activities are led by experienced guides and staff. The property is fully enclosed, secure and monitored — giving teachers and parents complete peace of mind. First aid is always available on-site.', 'sort_order'=>37],
            ['section_key'=>'safety_badges',    'label'=>'Safety — Badges (1 per line)',      'value'=>"Trained Staff\nFirst Aid On-Site\nMP Tourism Accredited",                                                     'sort_order'=>38],
            ['section_key'=>'form_label',       'label'=>'Enquiry Form — Label',             'value'=>'Get In Touch',                                                                                               'sort_order'=>39],
            ['section_key'=>'form_heading',     'label'=>'Enquiry Form — Heading (HTML)',    'value'=>'Plan Your <em>School Visit</em>',                                                                             'sort_order'=>40],
            ['section_key'=>'form_text',        'label'=>'Enquiry Form — Description',       'value'=>"Tell us about your institution and group size and we'll put together a custom program proposal for you.",   'sort_order'=>41],
            ['section_key'=>'cta_label',        'label'=>'CTA — Label',                      'value'=>"Let's Plan Together",                                                                                        'sort_order'=>42],
            ['section_key'=>'cta_heading',      'label'=>'CTA — Heading (HTML)',             'value'=>"Give Your Students an Experience <em>They'll Never Forget</em>",                                             'sort_order'=>43],
            ['section_key'=>'cta_text',         'label'=>'CTA — Description',                'value'=>'Contact us at Mahua House to plan your school or institutional tour in a stunning forest setting.',          'sort_order'=>44],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page'=>'educational-tours','section_key'=>$s['section_key']],
                array_merge($s, ['page'=>'educational-tours','is_active'=>true])
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class FilmShootsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Shoot Types (category = film-type) ─────────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-film',       'link'=>'Narrative',   'title'=>'Film Shoots',                'description'=>'Feature films, short films and indie productions using the forest as a living set.',                                 'image_url'=>'/site/assets/images/about/30.jpeg'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-microphone', 'link'=>'Non-Fiction', 'title'=>'Interviews & Documentaries', 'description'=>'Nature documentaries, heritage films and interview-based productions in an authentic setting.',                      'image_url'=>'/site/assets/images/about/31.jpeg'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-music',      'link'=>'Cultural',    'title'=>'Cultural Recordings',        'description'=>'Music videos, folk performances and cultural documentation in a serene forest environment.',                         'image_url'=>'/site/assets/images/about/32.jpeg'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-camera',     'link'=>'Photography', 'title'=>'Photography Sessions',       'description'=>'Pre-wedding shoots, editorial photography, brand photography and portfolio sessions.',                               'image_url'=>'/site/assets/images/about/33.jpeg'],
        ] as $t) {
            Experience::firstOrCreate(['category'=>'film-type','title'=>$t['title']], array_merge($t, ['category'=>'film-type','is_active'=>true]));
        }

        // ── Location Features (category = film-location) ────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-volume-xmark',   'title'=>'Quiet Environment',                'description'=>'Away from urban noise, Mahua House offers natural silence — ideal for clean audio recording and uninterrupted shoots.'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-panorama',        'title'=>'Natural Backdrops',               'description'=>'Dense forest, open lawns, rustic architecture and natural water features — multiple distinct backdrops in a single location.'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-file-shield',     'title'=>'Permit Guidance Available',        'description'=>'We assist production teams with the necessary location permits and coordination with local authorities for a hassle-free shoot.'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-house-chimney',   'title'=>'On-Site Accommodation & Catering','description'=>'Crew accommodation and customised meal plans available directly on-site — no need to travel for meals or rest.'],
        ] as $f) {
            Experience::firstOrCreate(['category'=>'film-location','title'=>$f['title']], array_merge($f, ['category'=>'film-location','is_active'=>true]));
        }

        // ── Trust Badges (category = film-trust) ────────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-tree',             'title'=>'Authentic Forest',   'description'=>'Samardha Reserved Forest as your real backdrop — no green screens, no artificial sets.'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-sun',              'title'=>'Golden Hour Light',  'description'=>'The forest canopy creates magical natural lighting conditions throughout the day.'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-map-location-dot', 'title'=>'Near Bhopal City',   'description'=>'Only 23 km from Bhopal city — easy access for cast, crew and equipment transport.'],
            ['sort_order'=>4,'icon'=>'fa-solid fa-handshake',        'title'=>'Full Support',        'description'=>'Permit guidance, accommodation, catering and on-ground coordination included.'],
        ] as $b) {
            Experience::firstOrCreate(['category'=>'film-trust','title'=>$b['title']], array_merge($b, ['category'=>'film-trust','is_active'=>true]));
        }

        // ── Page Sections ───────────────────────────────────────────────────────
        $sections = [
            ['section_key'=>'hero_label',      'label'=>'Hero — Label',                  'value'=>'Film & Media Productions',                                                                                                                              'sort_order'=>1],
            ['section_key'=>'hero_heading',    'label'=>'Hero — Heading (HTML)',         'value'=>"Bhopal's Most <em>Natural</em><br>Shoot Location",                                                                                                    'sort_order'=>2],
            ['section_key'=>'hero_text',       'label'=>'Hero — Subtitle',               'value'=>'Quiet environment, authentic forest backdrops and permit guidance — Mahua House is a preferred location for film shoots, documentaries, interviews and cultural recordings.', 'sort_order'=>3],
            ['section_key'=>'hero_image',      'label'=>'Hero — Background Image URL',   'value'=>'/site/assets/images/about/18.jpeg',                                                                                                                    'sort_order'=>4],
            ['section_key'=>'hero_cta1',       'label'=>'Hero — CTA Button 1',           'value'=>'Enquire for Shoot',                                                                                                                                    'sort_order'=>5],
            ['section_key'=>'hero_cta2',       'label'=>'Hero — CTA Button 2 (WhatsApp)','value'=>'WhatsApp Us',                                                                                                                                          'sort_order'=>6],
            ['section_key'=>'types_label',     'label'=>'Shoot Types — Label',           'value'=>'What We Host',                                                                                                                                         'sort_order'=>7],
            ['section_key'=>'types_heading',   'label'=>'Shoot Types — Heading (HTML)',  'value'=>'Productions We <em>Welcome</em>',                                                                                                                      'sort_order'=>8],
            ['section_key'=>'types_text',      'label'=>'Shoot Types — Description',     'value'=>'From television commercials to independent documentaries — the natural forest of Mahua House creates a genuinely stunning backdrop for every type of production.', 'sort_order'=>9],
            ['section_key'=>'loc_image',       'label'=>'Location Split — Image URL',    'value'=>'/site/assets/images/about/38.jpeg',                                                                                                                    'sort_order'=>10],
            ['section_key'=>'loc_badge_icon',  'label'=>'Location Split — Badge Icon',   'value'=>'fa-solid fa-video',                                                                                                                                    'sort_order'=>11],
            ['section_key'=>'loc_badge_title', 'label'=>'Location Split — Badge Title',  'value'=>'Preferred Shoot Location',                                                                                                                             'sort_order'=>12],
            ['section_key'=>'loc_badge_sub',   'label'=>'Location Split — Badge Subtitle','value'=>'Multiple natural backdrops — no artificial sets needed',                                                                                              'sort_order'=>13],
            ['section_key'=>'loc_label',       'label'=>'Location Split — Label',        'value'=>'The Location Advantage',                                                                                                                              'sort_order'=>14],
            ['section_key'=>'loc_heading',     'label'=>'Location Split — Heading (HTML)','value'=>"Why Mahua House is a <em>Filmmaker's Choice</em>",                                                                                                   'sort_order'=>15],
            ['section_key'=>'trust_label',     'label'=>'Trust Badges — Label',          'value'=>'Why Choose Us',                                                                                                                                        'sort_order'=>16],
            ['section_key'=>'trust_heading',   'label'=>'Trust Badges — Heading (HTML)', 'value'=>"Everything Your Production <em>Needs</em>",                                                                                                           'sort_order'=>17],
            ['section_key'=>'form_label',      'label'=>'Enquiry Form — Label',          'value'=>'Book a Location Visit',                                                                                                                                'sort_order'=>18],
            ['section_key'=>'form_heading',    'label'=>'Enquiry Form — Heading (HTML)', 'value'=>'Enquire for Your <em>Production</em>',                                                                                                                 'sort_order'=>19],
            ['section_key'=>'form_text',       'label'=>'Enquiry Form — Description',    'value'=>"Share your production details and we'll respond with availability, location options and pricing.",                                                    'sort_order'=>20],
            ['section_key'=>'cta_label',       'label'=>'CTA — Label',                   'value'=>'Ready to Shoot?',                                                                                                                                      'sort_order'=>21],
            ['section_key'=>'cta_heading',     'label'=>'CTA — Heading (HTML)',          'value'=>"Your Next Production's <em>Perfect Location</em> Awaits",                                                                                             'sort_order'=>22],
            ['section_key'=>'cta_text',        'label'=>'CTA — Description',             'value'=>'Contact us at Mahua House to schedule a location recce or submit your production enquiry today.',                                                     'sort_order'=>23],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page'=>'film-shoots','section_key'=>$s['section_key']],
                array_merge($s, ['page'=>'film-shoots','is_active'=>true])
            );
        }
    }
}

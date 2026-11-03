<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        // ── Experience Cards (category = about-experience) ────────────────────────
        foreach ([
            ['sort_order'=>1, 'icon'=>'fa-solid fa-person-hiking',     'title'=>'Forest Treks',         'image_url'=>'/site/assets/images/about/35.jpeg', 'description'=>'Guided morning and sunset walks through the Samardha forest corridor with our naturalist team. Spot wildlife, rare birds, and seasonal flora up close.'],
            ['sort_order'=>2, 'icon'=>'fa-solid fa-fire-flame-curved', 'title'=>'Campfire Evenings',     'image_url'=>'/site/assets/images/about/40.jpeg', 'description'=>'Gather around a crackling fire under an open sky — with folk music, stories, and forest-inspired snacks. A favourite for groups and families.'],
            ['sort_order'=>3, 'icon'=>'fa-solid fa-binoculars',        'title'=>'Birdwatching',          'image_url'=>'/site/assets/images/about/45.jpeg', 'description'=>'150+ species call our forest home. Spot Indian rollers, painted storks, and rare migrants at dawn with binoculars and expert guidance.'],
            ['sort_order'=>4, 'icon'=>'fa-solid fa-road',              'title'=>'Village Safari',        'image_url'=>'/site/assets/images/about/55.jpeg', 'description'=>'Explore nearby tribal villages, witness traditional crafts, and share a meal with local families for an authentic cultural experience.'],
            ['sort_order'=>5, 'icon'=>'fa-solid fa-utensils',          'title'=>'Farm-to-Table Dining',  'image_url'=>'/site/assets/images/about/60.jpeg', 'description'=>'Seasonal menus using ingredients from our kitchen garden and local farms — cooked over wood fire with traditional Madhya Pradesh recipes.'],
        ] as $e) {
            Experience::firstOrCreate(
                ['category' => 'about-experience', 'title' => $e['title']],
                array_merge($e, ['category' => 'about-experience', 'is_active' => true])
            );
        }

        // ── Page Sections (page = about) ─────────────────────────────────────────
        $sections = [
            // Meta
            ['section_key'=>'meta_title',       'label'=>'Meta — Page Title',             'value'=>'About Us | Mahua House',                                                      'sort_order'=>1],
            ['section_key'=>'meta_description', 'label'=>'Meta — Description',            'value'=>'Learn about Mahua House — The Nostalgic Woods, an MP Tourism accredited eco-retreat near Bhopal surrounded by Samardha Reserved Forest.', 'sort_order'=>2],
            ['section_key'=>'meta_keywords',    'label'=>'Meta — Keywords',               'value'=>'About Mahua House, Eco Retreat Bhopal, Forest Resort About, MP Tourism Accredited Resort', 'sort_order'=>3],

            // Hero
            ['section_key'=>'hero_image',       'label'=>'Hero — Background Image',       'value'=>'',                                                                            'media_url'=>'/site/assets/images/about/3.jpeg',  'sort_order'=>4],
            ['section_key'=>'hero_label',       'label'=>'Hero — Label',                  'value'=>'Our Story',                                                                   'sort_order'=>5],
            ['section_key'=>'hero_heading',     'label'=>'Hero — Heading (HTML OK)',       'value'=>'Where the Forest<br><em>Tells a Story</em>',                                  'sort_order'=>6],
            ['section_key'=>'hero_text',        'label'=>'Hero — Subtext',                'value'=>'A 3.5-acre woodland sanctuary in Bhopal — built on the belief that the best hospitality is the kind nature itself provides.', 'sort_order'=>7],
            ['section_key'=>'breadcrumb',       'label'=>'Breadcrumb Label',              'value'=>'About Us',                                                                    'sort_order'=>8],

            // Story section
            ['section_key'=>'story_img1',       'label'=>'Story — Tall Image',            'value'=>'',                                                                            'media_url'=>'/site/assets/images/about/6.jpeg',  'sort_order'=>9],
            ['section_key'=>'story_img2',       'label'=>'Story — Small Image 1',         'value'=>'',                                                                            'media_url'=>'/site/assets/images/about/10.jpeg', 'sort_order'=>10],
            ['section_key'=>'story_img3',       'label'=>'Story — Small Image 2',         'value'=>'',                                                                            'media_url'=>'/site/assets/images/about/14.jpeg', 'sort_order'=>11],
            ['section_key'=>'founded_year',     'label'=>'Story — Founded Year',          'value'=>'2014',                                                                        'sort_order'=>12],
            ['section_key'=>'founded_label',    'label'=>'Story — Founded Badge Label',   'value'=>'Est. Year',                                                                   'sort_order'=>13],
            ['section_key'=>'story_label',      'label'=>'Story — Label',                 'value'=>'Who We Are',                                                                  'sort_order'=>14],
            ['section_key'=>'story_heading',    'label'=>'Story — Heading (HTML OK)',     'value'=>'Mahua House — <em>The Nostalgic Woods</em>',                                  'sort_order'=>15],
            ['section_key'=>'story_text1',      'label'=>'Story — Paragraph 1',          'value'=>'Mahua House — The Nostalgic Woods is an MP Tourism accredited countryside retreat located on Raisen Road, Bhopal, surrounded by serene forest landscapes.', 'sort_order'=>16],
            ['section_key'=>'story_text2',      'label'=>'Story — Paragraph 2',          'value'=>'Designed for those who value peace, culture, and meaningful gatherings, Mahua House blends rustic charm with modern comfort. Whether it is a wedding celebration, corporate retreat, educational tour, or a quiet family getaway, the space offers an environment that encourages connection — with nature and with each other.', 'sort_order'=>17],
            ['section_key'=>'story_text3',      'label'=>'Story — Paragraph 3',          'value'=>'With curated experiences like traditional cuisine, jungle walks, cultural activities, and open natural spaces, Mahua House is not just a venue — it is an experience.', 'sort_order'=>18],
            ['section_key'=>'story_list',       'label'=>'Story — Bullet Points (1/line)','value'=>"MP Tourism Accredited countryside retreat\nAdjoining Samardha Reserved Forest, Raisen Road, Bhopal\nTrusted by Doordarshan productions\nIdeal for weddings, events, picnics & peaceful stays", 'sort_order'=>19],
            ['section_key'=>'story_btn1',       'label'=>'Story — Button 1 Text',         'value'=>'WhatsApp Enquiry',                                                            'sort_order'=>20],
            ['section_key'=>'story_btn2',       'label'=>'Story — Button 2 Text',         'value'=>'Contact Us',                                                                  'sort_order'=>21],

            // Values section
            ['section_key'=>'values_label',     'label'=>'Values — Label',                'value'=>'What Drives Us',                                                              'sort_order'=>22],
            ['section_key'=>'values_heading',   'label'=>'Values — Heading (HTML OK)',    'value'=>'Our <em>Values &amp; Philosophy</em>',                                        'sort_order'=>23],
            ['section_key'=>'values_text',      'label'=>'Values — Description',          'value'=>'Every decision we make — from how we build our cottages to how we serve your meals — is guided by these principles.', 'sort_order'=>24],

            // Property section
            ['section_key'=>'property_image',   'label'=>'Property — Split Image',        'value'=>'',                                                                            'media_url'=>'/site/assets/images/about/22.jpeg', 'sort_order'=>25],
            ['section_key'=>'property_label',   'label'=>'Property — Label',              'value'=>'The Property',                                                                'sort_order'=>26],
            ['section_key'=>'property_heading', 'label'=>'Property — Heading (HTML OK)',  'value'=>'3.5 Acres of <em>Living Forest</em>',                                         'sort_order'=>27],
            ['section_key'=>'property_text',    'label'=>'Property — Description',        'value'=>"Our property borders the Samardha Reserved Forest — one of Madhya Pradesh's protected green corridors. From your cottage window you might spot a peacock, hear the call of a shikra, or watch fireflies light the tree line at dusk.", 'sort_order'=>28],
            ['section_key'=>'property_stats',   'label'=>'Property — Stats (icon|val|lbl per line)', 'value'=>"fa-solid fa-tree|Ancient Mahua & Teak Groves|Centuries-old trees on the property\nfa-solid fa-person-hiking|3 Guided Trail Routes|Easy, moderate & sunrise treks\nfa-solid fa-campground|Open-air Campfire Lawn|Stargazing & evening storytelling\nfa-solid fa-binoculars|Bird & Wildlife Spotting|150+ bird species recorded on site", 'sort_order'=>29],
            ['section_key'=>'property_cta',     'label'=>'Property — CTA Button',         'value'=>'Reserve Your Room',                                                           'sort_order'=>30],

            // Experiences section
            ['section_key'=>'exp_label',        'label'=>'Experiences — Label',           'value'=>"While You're Here",                                                           'sort_order'=>31],
            ['section_key'=>'exp_heading',      'label'=>'Experiences — Heading (HTML OK)','value'=>'Experiences That <em>Stay With You</em>',                                   'sort_order'=>32],

            // Photo strip
            ['section_key'=>'photo_label',      'label'=>'Photo Strip — Label',           'value'=>'Through the Lens',                                                            'sort_order'=>33],
            ['section_key'=>'photo_heading',    'label'=>'Photo Strip — Heading (HTML OK)','value'=>'A Glimpse of <em>Mahua House</em>',                                         'sort_order'=>34],
            ['section_key'=>'photo_cta',        'label'=>'Photo Strip — CTA Button',      'value'=>'Full Gallery',                                                                'sort_order'=>35],

            // Testimonials
            ['section_key'=>'testi_label',      'label'=>'Testimonials — Label',          'value'=>'Guest Stories',                                                               'sort_order'=>36],
            ['section_key'=>'testi_heading',    'label'=>'Testimonials — Heading (HTML OK)','value'=>'What Our <em>Guests Say</em>',                                             'sort_order'=>37],

            // House rules & philosophy
            ['section_key'=>'rules_label',      'label'=>'Rules — Label',                 'value'=>'Guidelines & Philosophy',                                                     'sort_order'=>38],
            ['section_key'=>'rules_heading',    'label'=>'Rules — Heading (HTML OK)',     'value'=>'Our <em>House Rules</em>',                                                    'sort_order'=>39],
            ['section_key'=>'rules_title',      'label'=>'Rules — Panel Title',           'value'=>'House Rules',                                                                 'sort_order'=>40],
            ['section_key'=>'house_rules',      'label'=>'Rules — Rules List (icon|text per line)', 'value'=>"fa-solid fa-seedling|Respect nature — no littering on the property or forest\nfa-solid fa-volume-xmark|Maintain a peaceful environment for all guests\nfa-solid fa-ban|No illegal activities permitted on the property\nfa-solid fa-helmet-safety|All outdoor activities must be done under supervision\nfa-solid fa-wine-bottle|Alcohol Policy: Alcohol is allowed with prior permission for groups, but Mahua House is not a party-only destination.", 'sort_order'=>41],
            ['section_key'=>'philosophy_title', 'label'=>'Philosophy — Panel Title',      'value'=>'Our Philosophy',                                                              'sort_order'=>42],
            ['section_key'=>'philosophy_text1', 'label'=>'Philosophy — Paragraph 1',     'value'=>'Mahua House welcomes guests who value nature, peace, family-friendly environments, and cultural and respectful gatherings.', 'sort_order'=>43],
            ['section_key'=>'philosophy_text2', 'label'=>'Philosophy — Paragraph 2',     'value'=>'We promote a calm, dignified, and eco-conscious atmosphere where every visitor — whether a family on a picnic, a couple celebrating their anniversary, a corporate team, or a student on a nature tour — feels respected and at home.', 'sort_order'=>44],
            ['section_key'=>'philosophy_tags',  'label'=>'Philosophy — Tags (one per line)','value'=>"🌿 Nature\n🕊️ Peace\n👨‍👩‍👧 Family-Friendly\n🎭 Cultural\n🌱 Eco-Conscious",      'sort_order'=>45],

            // CTA
            ['section_key'=>'cta_label',        'label'=>'CTA — Label',                   'value'=>'Come Visit Us',                                                               'sort_order'=>46],
            ['section_key'=>'cta_heading',      'label'=>'CTA — Heading (HTML OK)',       'value'=>'Ready to Experience <em>Mahua House?</em>',                                   'sort_order'=>47],
            ['section_key'=>'cta_text',         'label'=>'CTA — Description',             'value'=>"Whether you're seeking a weekend escape, a family adventure, a corporate retreat, or a destination wedding — our forest is waiting for you.", 'sort_order'=>48],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page' => 'about', 'section_key' => $s['section_key']],
                array_merge($s, ['page' => 'about', 'is_active' => true])
            );
        }
    }
}

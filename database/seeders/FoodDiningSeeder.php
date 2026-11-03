<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;
use App\Models\PageSection;

class FoodDiningSeeder extends Seeder
{
    public function run(): void
    {
        // ── Dining Options (category = dining-option) ────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-bowl-rice',      'title'=>'Traditional Meals',    'description'=>"Authentic home-style cooking inspired by Madhya Pradesh's rich culinary heritage — earthy, wholesome and full of flavour. Dal, sabzi, roti, rice and seasonal vegetables, prepared fresh daily."],
            ['sort_order'=>2,'icon'=>'fa-solid fa-plate-wheat',     'title'=>'Multi-Cuisine Buffet', 'description'=>'A spread of North Indian, South Indian and continental options — perfect for larger groups, corporate retreats and family stays where everyone has different tastes.'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-pen-to-square',   'title'=>'Customised Menus',     'description'=>"Planning a corporate event, wedding function or large group visit? We'll work with you to design a menu that fits your occasion, dietary requirements and preferences."],
        ] as $o) {
            Experience::firstOrCreate(['category'=>'dining-option','title'=>$o['title']], array_merge($o, ['category'=>'dining-option','is_active'=>true]));
        }

        // ── Meal Cards (category = dining-meal) ─────────────────────────────────
        // description format: paragraph\n---\nitem1\nitem2
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-mug-hot',      'link'=>'Early Morning','title'=>'Bed Tea',   'image_url'=>'/site/assets/images/about/45.jpeg','description'=>"Start your forest morning the traditional way — a warm cup of chai served to your room as the forest wakes around you.\n---\nFresh masala chai / green tea\nLight biscuits or dry snack\nServed at your room / cottage"],
            ['sort_order'=>2,'icon'=>'fa-solid fa-sun',          'link'=>'Morning',      'title'=>'Breakfast', 'image_url'=>'/site/assets/images/about/46.jpeg','description'=>"A nourishing morning spread to fuel your day of nature adventures, treks and activities.\n---\nPoha / upma / paratha options\nFresh fruit & seasonal items\nChai, coffee & fresh juice\nContinental items on request"],
            ['sort_order'=>3,'icon'=>'fa-solid fa-cloud-sun',    'link'=>'Afternoon',    'title'=>'Lunch',     'image_url'=>'/site/assets/images/about/47.jpeg','description'=>"A hearty traditional thali that brings the authentic flavours of Madhya Pradesh to your plate.\n---\nDal, sabzi, roti & rice\nSeasonal vegetable preparations\nSalad, raita & pickle\nDessert on special occasions"],
            ['sort_order'=>4,'icon'=>'fa-solid fa-leaf',         'link'=>'Evening',      'title'=>'Hi Tea',    'image_url'=>'/site/assets/images/about/48.jpeg','description'=>"Relax after a day of activities with a forest-side evening tea and light snacks as the sun dips below the canopy.\n---\nMasala chai or herbal teas\nSamosa, pakora or local snacks\nServed in the open garden area"],
            ['sort_order'=>5,'icon'=>'fa-solid fa-moon',         'link'=>'Night',        'title'=>'Dinner',    'image_url'=>'/site/assets/images/about/49.jpeg','description'=>"End your forest day with a memorable dinner — warm, freshly cooked and served under the stars with the sounds of the forest as your backdrop.\n---\nFull traditional meal spread\nRotis, rice, dal & sabzi\nSpecial non-veg options on request\nBonfire dining experience available\nGroup / buffet format for events"],
        ] as $m) {
            Experience::firstOrCreate(['category'=>'dining-meal','title'=>$m['title']], array_merge($m, ['category'=>'dining-meal','is_active'=>true]));
        }

        // ── Quality Cards (category = dining-quality) ────────────────────────────
        foreach ([
            ['sort_order'=>1,'icon'=>'fa-solid fa-carrot',              'title'=>'Fresh Ingredients', 'description'=>'Locally sourced seasonal vegetables and ingredients — no artificial additives or preservatives.'],
            ['sort_order'=>2,'icon'=>'fa-solid fa-hand-sparkles',       'title'=>'Hygienic Kitchen',  'description'=>'Our kitchen maintains the highest standards of hygiene — your health and safety is our priority.'],
            ['sort_order'=>3,'icon'=>'fa-solid fa-map-pin',             'title'=>'Locally Inspired',  'description'=>"Recipes rooted in the culinary heritage of Madhya Pradesh, prepared with traditional methods and care."],
            ['sort_order'=>4,'icon'=>'fa-solid fa-indian-rupee-sign',   'title'=>'Great Value',        'description'=>'A full day\'s meals — bed tea, breakfast, lunch, hi tea and dinner — for just ₹1,000 per person.'],
        ] as $q) {
            Experience::firstOrCreate(['category'=>'dining-quality','title'=>$q['title']], array_merge($q, ['category'=>'dining-quality','is_active'=>true]));
        }

        // ── Page Sections ───────────────────────────────────────────────────────
        $sections = [
            ['section_key'=>'hero_label',       'label'=>'Hero — Label',                  'value'=>'Authentic Flavours',                                                                                                           'sort_order'=>1],
            ['section_key'=>'hero_heading',     'label'=>'Hero — Heading (HTML)',         'value'=>'A Taste of the <em>Forest</em>',                                                                                              'sort_order'=>2],
            ['section_key'=>'hero_text',        'label'=>'Hero — Subtitle',               'value'=>'Fresh, hygienic and locally inspired — every meal at Mahua House is a celebration of flavour. From bed tea at sunrise to a hearty dinner under the stars, we make every bite memorable.', 'sort_order'=>3],
            ['section_key'=>'hero_image',       'label'=>'Hero — Background Image URL',   'value'=>'/site/assets/images/about/25.jpeg',                                                                                           'sort_order'=>4],
            ['section_key'=>'hero_cta1',        'label'=>'Hero — CTA Button 1',           'value'=>"See What's on the Menu",                                                                                                      'sort_order'=>5],
            ['section_key'=>'hero_cta2',        'label'=>'Hero — CTA Button 2 (WhatsApp)','value'=>'Custom Menu Enquiry',                                                                                                         'sort_order'=>6],
            ['section_key'=>'price_label',      'label'=>'Pricing Banner — Label',        'value'=>'All-Inclusive Meal Plan',                                                                                                     'sort_order'=>7],
            ['section_key'=>'price_value',      'label'=>'Pricing Banner — Price',        'value'=>'₹1,000',                                                                                                                      'sort_order'=>8],
            ['section_key'=>'price_unit',       'label'=>'Pricing Banner — Unit',         'value'=>'per person',                                                                                                                  'sort_order'=>9],
            ['section_key'=>'price_includes',   'label'=>'Pricing Banner — Includes text','value'=>'Includes Bed Tea, Breakfast, Lunch, Hi Tea & Dinner',                                                                        'sort_order'=>10],
            ['section_key'=>'price_pills',      'label'=>'Pricing Banner — Trust Pills (1/line)','value'=>"Fresh Ingredients\nHygienic Kitchen\nLocally Inspired\nCustomisable Menus",                                           'sort_order'=>11],
            ['section_key'=>'opt_label',        'label'=>'Dining Options — Label',        'value'=>'Dining Options',                                                                                                              'sort_order'=>12],
            ['section_key'=>'opt_heading',      'label'=>'Dining Options — Heading (HTML)','value'=>'Three Ways to <em>Dine With Us</em>',                                                                                       'sort_order'=>13],
            ['section_key'=>'opt_text',         'label'=>'Dining Options — Description',  'value'=>'Whether you prefer the comfort of tradition, the variety of a buffet, or a menu tailored precisely to your group — we have you covered.', 'sort_order'=>14],
            ['section_key'=>'meal_label',       'label'=>'Meal Schedule — Label',         'value'=>'Daily Menu',                                                                                                                  'sort_order'=>15],
            ['section_key'=>'meal_heading',     'label'=>'Meal Schedule — Heading (HTML)','value'=>'From Sunrise to <em>Sunset</em>',                                                                                            'sort_order'=>16],
            ['section_key'=>'meal_text',        'label'=>'Meal Schedule — Description',   'value'=>'A full day of authentic flavours — every meal crafted with fresh, locally sourced ingredients.',                             'sort_order'=>17],
            ['section_key'=>'custom_image',     'label'=>'Custom Menu — Image URL',       'value'=>'/site/assets/images/about/50.jpeg',                                                                                           'sort_order'=>18],
            ['section_key'=>'custom_badge_icon','label'=>'Custom Menu — Badge Icon',      'value'=>'fa-solid fa-leaf',                                                                                                            'sort_order'=>19],
            ['section_key'=>'custom_badge_title','label'=>'Custom Menu — Badge Title',    'value'=>'Fresh & Locally Inspired',                                                                                                    'sort_order'=>20],
            ['section_key'=>'custom_badge_sub', 'label'=>'Custom Menu — Badge Subtitle',  'value'=>'Farm-fresh ingredients, hygienic kitchen, authentic flavours',                                                               'sort_order'=>21],
            ['section_key'=>'custom_label',     'label'=>'Custom Menu — Label',           'value'=>'Group & Event Catering',                                                                                                      'sort_order'=>22],
            ['section_key'=>'custom_heading',   'label'=>'Custom Menu — Heading (HTML)',  'value'=>'Custom Menus for <em>Every Occasion</em>',                                                                                   'sort_order'=>23],
            ['section_key'=>'custom_text',      'label'=>'Custom Menu — Description',     'value'=>"Planning a large group visit, corporate retreat, wedding function or educational tour? Our kitchen team will design a menu tailored to your group size, dietary preferences and occasion.", 'sort_order'=>24],
            ['section_key'=>'custom_cta',       'label'=>'Custom Menu — CTA Button',      'value'=>'Enquire for Custom Menu',                                                                                                     'sort_order'=>25],
            ['section_key'=>'mini1_icon',       'label'=>'Mini Card 1 — Icon',            'value'=>'fa-solid fa-briefcase',                                                                                                       'sort_order'=>26],
            ['section_key'=>'mini1_title',      'label'=>'Mini Card 1 — Title',           'value'=>'Corporate Groups',                                                                                                            'sort_order'=>27],
            ['section_key'=>'mini1_desc',       'label'=>'Mini Card 1 — Description',     'value'=>'Buffet spreads, working lunches & tea breaks',                                                                               'sort_order'=>28],
            ['section_key'=>'mini2_icon',       'label'=>'Mini Card 2 — Icon',            'value'=>'fa-solid fa-graduation-cap',                                                                                                  'sort_order'=>29],
            ['section_key'=>'mini2_title',      'label'=>'Mini Card 2 — Title',           'value'=>'School & Institutions',                                                                                                       'sort_order'=>30],
            ['section_key'=>'mini2_desc',       'label'=>'Mini Card 2 — Description',     'value'=>'Packed meals, thali service & snack packs',                                                                                  'sort_order'=>31],
            ['section_key'=>'mini3_icon',       'label'=>'Mini Card 3 — Icon',            'value'=>'fa-solid fa-champagne-glasses',                                                                                               'sort_order'=>32],
            ['section_key'=>'mini3_title',      'label'=>'Mini Card 3 — Title',           'value'=>'Weddings & Events',                                                                                                           'sort_order'=>33],
            ['section_key'=>'mini3_desc',       'label'=>'Mini Card 3 — Description',     'value'=>'Elaborate event menus for special celebrations',                                                                             'sort_order'=>34],
            ['section_key'=>'mini4_icon',       'label'=>'Mini Card 4 — Icon',            'value'=>'fa-solid fa-seedling',                                                                                                        'sort_order'=>35],
            ['section_key'=>'mini4_title',      'label'=>'Mini Card 4 — Title',           'value'=>'Dietary Preferences',                                                                                                         'sort_order'=>36],
            ['section_key'=>'mini4_desc',       'label'=>'Mini Card 4 — Description',     'value'=>'Veg, non-veg, Jain & custom requests honoured',                                                                             'sort_order'=>37],
            ['section_key'=>'quality_label',    'label'=>'Quality — Label',               'value'=>'Our Promise',                                                                                                                 'sort_order'=>38],
            ['section_key'=>'quality_heading',  'label'=>'Quality — Heading (HTML)',      'value'=>'Fresh, Hygienic &amp; <em>Locally Inspired</em>',                                                                            'sort_order'=>39],
            ['section_key'=>'cta_label',        'label'=>'CTA — Label',                   'value'=>'Dine With Us',                                                                                                                'sort_order'=>40],
            ['section_key'=>'cta_heading',      'label'=>'CTA — Heading (HTML)',          'value'=>'Authentic Flavours in a <em>Forest Setting</em>',                                                                            'sort_order'=>41],
            ['section_key'=>'cta_text',         'label'=>'CTA — Description',             'value'=>'Contact us to arrange dining for your group, request a custom menu or ask about meal packages alongside accommodation.',     'sort_order'=>42],
        ];

        foreach ($sections as $s) {
            PageSection::updateOrCreate(
                ['page'=>'food-dining','section_key'=>$s['section_key']],
                array_merge($s, ['page'=>'food-dining','is_active'=>true])
            );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use App\Models\HeroSlide;
use App\Models\Stat;
use App\Models\WhyChoose;
use App\Models\Experience;
use App\Models\Room;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\BlogPost;
use App\Models\Offer;
use App\Models\Faq;
use App\Models\ContactInfo;
use App\Models\SiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::create(['name' => 'Admin', 'email' => 'admin@mahuahouse.com', 'password' => Hash::make('Admin@123')]);

        foreach ([
            ['title' => 'Mahua House', 'subtitle' => 'The Nostalgic Woods', 'description' => 'Where Tradition Meets Tranquility — A Nature Retreat for Weddings, Events & Peaceful Getaways in Bhopal', 'image_url' => '/site/assets/images/logo/1.jpeg', 'sort_order' => 1],
            ['title' => 'Forest Stays', 'subtitle' => 'Wake Amidst the Whispering Trees', 'description' => 'Eco-cottages and rooms nestled in 3.5 acres of Mahua and Teak forest on Raisen Road, Bhopal.', 'image_url' => '/site/assets/images/logo/2.jpeg', 'sort_order' => 2],
            ['title' => 'Unforgettable Events', 'subtitle' => 'Nature as Your Backdrop', 'description' => 'Destination weddings, corporate retreats, educational tours, and film shoots in a stunning forest setting.', 'image_url' => '/site/assets/images/about/65.jpeg', 'sort_order' => 3],
        ] as $s) HeroSlide::create($s);

        foreach ([
            ['value' => '3.5 Acres', 'label' => 'Forest Land', 'icon' => 'fa-solid fa-tree', 'sort_order' => 1],
            ['value' => '10+ Years', 'label' => 'Hospitality', 'icon' => 'fa-solid fa-award', 'sort_order' => 2],
            ['value' => '500+', 'label' => 'Happy Guests', 'icon' => 'fa-solid fa-people-group', 'sort_order' => 3],
            ['value' => '50+', 'label' => 'Events Hosted', 'icon' => 'fa-solid fa-calendar-check', 'sort_order' => 4],
            ['value' => '4.8 ★', 'label' => 'Guest Rating', 'icon' => 'fa-solid fa-star', 'sort_order' => 5],
        ] as $s) Stat::create($s);

        foreach ([
            ['title' => 'Nature-Centric Location', 'description' => 'Surrounded by forest — शांत और सुकून भरा वातावरण. Experience serene, peaceful surroundings away from city noise.', 'icon' => 'fa-solid fa-tree', 'sort_order' => 1],
            ['title' => 'Authentic Food', 'description' => 'Traditional & local cuisine. Taste the real flavours of Madhya Pradesh — fresh, hygienic, and locally inspired.', 'icon' => 'fa-solid fa-utensils', 'sort_order' => 2],
            ['title' => 'Versatile Venue', 'description' => 'Perfect for weddings, corporate events, picnics, family outings, and photo shoots in a stunning natural setting.', 'icon' => 'fa-solid fa-calendar-check', 'sort_order' => 3],
            ['title' => 'Peaceful Retreat', 'description' => 'Ideal for meditation, relaxation, and rejuvenation. Disconnect from the digital world and reconnect with yourself.', 'icon' => 'fa-solid fa-spa', 'sort_order' => 4],
            ['title' => 'Media-Friendly', 'description' => 'Trusted by Doordarshan productions. Natural backdrops, quiet environment, and permit guidance for film & media shoots.', 'icon' => 'fa-solid fa-video', 'sort_order' => 5],
            ['title' => 'Safe & Managed', 'description' => 'CCTV surveillance, dedicated security, and full event management support for your peace of mind.', 'icon' => 'fa-solid fa-shield-halved', 'sort_order' => 6],
        ] as $w) WhyChoose::create($w);

        foreach ([
            ['title' => 'Forest Stays', 'description' => 'Wake to birdsong in our eco-cottages and rooms nestled among Mahua and Teak groves.', 'icon' => 'fa-solid fa-tree', 'image_url' => '/site/assets/images/about/22.jpeg', 'category' => 'nature', 'link' => '/site/stay.html', 'sort_order' => 1],
            ['title' => 'Jungle Trekking', 'description' => 'Guided treks through Samardha Reserved Forest — spot wildlife, flora, and breathtaking views.', 'icon' => 'fa-solid fa-person-hiking', 'image_url' => '/site/assets/images/about/56.jpeg', 'category' => 'adventure', 'link' => '/site/services.html', 'sort_order' => 2],
            ['title' => 'Destination Weddings', 'description' => 'Say your vows surrounded by forest canopy — an enchanting backdrop unlike any other.', 'icon' => 'fa-solid fa-rings-wedding', 'image_url' => '/site/assets/images/about/4.jpeg', 'category' => 'cultural', 'link' => '/site/destination-wedding.html', 'sort_order' => 3],
            ['title' => 'Farm-to-Table Dining', 'description' => 'Seasonal wood-fired meals from our kitchen garden and local farms — earthy, honest, delicious.', 'icon' => 'fa-solid fa-utensils', 'image_url' => '/site/assets/images/about/60.jpeg', 'category' => 'dining', 'link' => '/site/food-dining.html', 'sort_order' => 4],
            ['title' => 'Spaces & Events', 'description' => 'Corporate retreats, team outings, and celebrations in forest clearings and open-air venues.', 'icon' => 'fa-solid fa-people-roof', 'image_url' => '/site/assets/images/about/17.jpeg', 'category' => 'recreation', 'link' => '/site/spaces.html', 'sort_order' => 5],
            ['title' => 'Day Out Plan', 'description' => 'A curated full-day forest experience — trekking, dining, bonfire, and stargazing all in one.', 'icon' => 'fa-solid fa-sun', 'image_url' => '/site/assets/images/about/80.jpeg', 'category' => 'adventure', 'link' => '/site/day_out_plan.html', 'sort_order' => 6],
        ] as $e) Experience::create($e);

        foreach ([
            ['name' => 'Super Deluxe AC Room', 'room_type' => 'Super Deluxe AC', 'description' => 'Spacious air-conditioned room with forest views. Double occupancy. Check-in 11AM · Check-out 10AM.', 'price_per_night' => 3500, 'max_guests' => 2, 'amenities' => ['AC', 'Double Bed', 'Bath', 'Power Backup'], 'image_url' => '/site/assets/images/room/room-1.jpg', 'badge_text' => 'Popular', 'badge_color' => '#DAA520', 'is_featured' => true, 'sort_order' => 1],
            ['name' => 'Deluxe AC Room', 'room_type' => 'Deluxe AC', 'description' => 'Comfortable air-conditioned room amidst nature. Double occupancy. Check-in 11AM · Check-out 10AM.', 'price_per_night' => 3000, 'max_guests' => 2, 'amenities' => ['AC', 'TV', 'Parking', 'Power Backup'], 'image_url' => '/site/assets/images/room/room-2.jpg', 'badge_text' => 'Best Value', 'badge_color' => '#033631', 'is_featured' => true, 'sort_order' => 2],
            ['name' => 'Forest Cottage', 'room_type' => 'Independent Cottage', 'description' => 'Charming private cottage nestled in nature. Double occupancy. Check-in 11AM · Check-out 10AM.', 'price_per_night' => 2500, 'max_guests' => 2, 'amenities' => ['Private', 'Double Bed', 'Bath', 'Power Backup'], 'image_url' => '/site/assets/images/room/room-3.jpg', 'badge_text' => 'Cottage', 'badge_color' => '#ffffff', 'is_featured' => true, 'sort_order' => 3],
        ] as $r) Room::create($r);

        foreach ([
            ['title' => 'Mahua House View', 'image_url' => '/site/assets/images/about/65.jpeg', 'category' => 'property', 'sort_order' => 1],
            ['title' => 'Forest View', 'image_url' => '/site/assets/images/about/70.jpeg', 'category' => 'nature', 'sort_order' => 2],
            ['title' => 'Cottage Interior', 'image_url' => '/site/assets/images/about/75.jpeg', 'category' => 'rooms', 'sort_order' => 3],
            ['title' => 'Nature Trail', 'image_url' => '/site/assets/images/about/80.jpeg', 'category' => 'nature', 'sort_order' => 4],
            ['title' => 'Resort Grounds', 'image_url' => '/site/assets/images/about/85.jpeg', 'category' => 'property', 'sort_order' => 5],
            ['title' => 'Dining Area', 'image_url' => '/site/assets/images/about/88.jpeg', 'category' => 'dining', 'sort_order' => 6],
            ['title' => 'Activities', 'image_url' => '/site/assets/images/about/91.jpeg', 'category' => 'activities', 'sort_order' => 7],
            ['title' => 'Forest Stay', 'image_url' => '/site/assets/images/about/22.jpeg', 'category' => 'rooms', 'sort_order' => 8],
            ['title' => 'Wedding Setup', 'image_url' => '/site/assets/images/about/4.jpeg', 'category' => 'events', 'sort_order' => 9],
            ['title' => 'Outdoor Dining', 'image_url' => '/site/assets/images/about/60.jpeg', 'category' => 'dining', 'sort_order' => 10],
            ['title' => 'Event Space', 'image_url' => '/site/assets/images/about/17.jpeg', 'category' => 'events', 'sort_order' => 11],
        ] as $g) GalleryItem::create($g);

        foreach ([
            ['name' => 'Sanyukta Banerjee', 'location' => 'Bhopal', 'review' => 'Nestled in the lap of nature, Mahua house is a true hidden gem. From the moment you arrive, you\'re surrounded by breathtaking views, fresh air, and a sense of calm that instantly melts stress away. The staff are warm, attentive, and genuinely caring.', 'rating' => 5, 'sort_order' => 1],
            ['name' => 'Manish Kumar', 'location' => 'Indore', 'review' => 'I honestly can\'t say enough good things about my stay at Mahua House. The whole team was so nice and down-to-earth. It really did feel like a home away from home. The vibe is so welcoming and the atmosphere makes it easy to just kick back and relax.', 'rating' => 5, 'sort_order' => 2],
            ['name' => 'Shivani & Shukla', 'location' => 'Bhopal', 'review' => 'It was one of the most surreal experiences to have stayed here! The view, the food, the staff and the surroundings are perfect for a romantic or a family getaway! I recommend this to anyone who wants to stay between lush green forests.', 'rating' => 5, 'sort_order' => 3],
        ] as $t) Testimonial::create($t);

        foreach ([
            ['name' => 'Property Manager', 'role' => 'Manager', 'image_url' => '/site/assets/images/team/team-1.jpg', 'sort_order' => 1],
            ['name' => 'Head Chef', 'role' => 'Culinary Expert', 'image_url' => '/site/assets/images/team/team-2.jpg', 'sort_order' => 2],
            ['name' => 'Events Coordinator', 'role' => 'Event Planning', 'image_url' => '/site/assets/images/team/team-3.jpg', 'sort_order' => 3],
            ['name' => 'Forest Guide', 'role' => 'Nature & Trekking', 'image_url' => '/site/assets/images/team/team-4.jpg', 'sort_order' => 4],
        ] as $t) TeamMember::create($t);

        foreach ([
            ['title' => '5 Reasons to Choose a Forest Wedding at Mahua House', 'slug' => 'forest-wedding-mahua-house', 'excerpt' => 'Discover why more couples are choosing Mahua House for their destination wedding in Bhopal.', 'content' => '<p>Mahua House offers a unique setting for your dream wedding surrounded by nature...</p>', 'image_url' => '/site/assets/images/blog/blog-1.jpg', 'category' => 'cultural', 'is_published' => true, 'published_at' => now(), 'read_time' => 5],
            ['title' => 'A Day in the Forest: Our Day Out Plan Explained', 'slug' => 'day-out-plan-guide', 'excerpt' => 'Everything you need to know about our popular Day Out Plan experience at Mahua House.', 'content' => '<p>Our Day Out Plan is a curated full-day forest experience...</p>', 'image_url' => '/site/assets/images/blog/blog-2.jpg', 'category' => 'adventure', 'is_published' => true, 'published_at' => now(), 'read_time' => 4],
            ['title' => 'Farm-to-Table: The Mahua House Dining Philosophy', 'slug' => 'farm-to-table-dining', 'excerpt' => 'Learn about our commitment to fresh, local, and authentic Madhya Pradesh cuisine.', 'content' => '<p>At Mahua House, we believe food should tell a story of the land...</p>', 'image_url' => '/site/assets/images/blog/blog-3.jpg', 'category' => 'dining', 'is_published' => true, 'published_at' => now(), 'read_time' => 3],
        ] as $p) BlogPost::create($p);

        foreach ([
            ['title' => 'Monsoon Forest Escape', 'description' => 'Experience the magic of the forest in full bloom. Special monsoon packages with bonfire and outdoor dining.', 'badge_text' => '20% Off', 'price' => 4500, 'original_price' => 5625, 'duration' => '2 Nights / 3 Days', 'inclusions' => ['2 nights accommodation', 'Daily breakfast & dinner', 'Nature walk', 'Bonfire evening'], 'image_url' => '/site/assets/images/offer/offer-1.jpg', 'sort_order' => 1, 'is_featured' => true],
            ['title' => 'Romantic Weekend Getaway', 'description' => 'Curated couples package with candlelit dinner, forest walk, and room decor.', 'badge_text' => 'Special Package', 'price' => 5500, 'duration' => '1 Night / 2 Days', 'inclusions' => ['1 night accommodation', 'Candlelit dinner', 'Couple room decor', 'Morning forest walk'], 'image_url' => '/site/assets/images/offer/offer-2.jpg', 'sort_order' => 2],
            ['title' => 'Corporate Team Outing', 'description' => 'Full-day team building experience with meals, activities, and event coordination. Min 20 people.', 'badge_text' => 'Group Rates', 'price' => 1200, 'duration' => 'Full Day', 'inclusions' => ['Lunch & snacks', 'Team activities', 'Event coordination', 'Nature walk'], 'image_url' => '/site/assets/images/offer/offer-3.jpg', 'sort_order' => 3],
        ] as $o) Offer::create($o);

        foreach ([
            ['question' => 'Where is Mahua House located?', 'answer' => 'Mahua House is located adjoining Samardha Reserved Forest Barrier, Haripura, Raisen Road, Bhopal-462023, Madhya Pradesh, India.', 'category' => 'general', 'sort_order' => 1],
            ['question' => 'What are the check-in and check-out times?', 'answer' => 'Check-in time is 11:00 AM and check-out time is 10:00 AM. Early check-in and late check-out can be arranged on request.', 'category' => 'booking', 'sort_order' => 2],
            ['question' => 'Do you accept event bookings?', 'answer' => 'Yes! We host destination weddings, corporate retreats, educational tours, film shoots, and family gatherings.', 'category' => 'general', 'sort_order' => 3],
            ['question' => 'What meals are available?', 'answer' => 'We offer farm-to-table dining featuring authentic Madhya Pradesh cuisine. We accommodate dietary restrictions with prior notice.', 'category' => 'dining', 'sort_order' => 4],
            ['question' => 'How do I make a booking?', 'answer' => 'You can book via WhatsApp (+91 9425651754), email (mahuahouse17@gmail.com), or through our online booking form.', 'category' => 'booking', 'sort_order' => 5],
            ['question' => 'Is Mahua House MP Tourism accredited?', 'answer' => 'Yes, Mahua House is an MP Tourism accredited property.', 'category' => 'general', 'sort_order' => 6],
            ['question' => 'What activities are available?', 'answer' => 'We offer jungle trekking, nature walks, birdwatching, outdoor dining, bonfire evenings, stargazing, and various event-based activities.', 'category' => 'activities', 'sort_order' => 7],
            ['question' => 'Is Mahua House pet-friendly?', 'answer' => 'For the safety of guests and animals, we do not accommodate pets. Please contact us for specific inquiries.', 'category' => 'general', 'sort_order' => 8],
        ] as $f) Faq::create($f);

        foreach ([
            ['key' => 'address', 'label' => 'Address', 'value' => 'Adjoining Samardha Reserved Forest Barrier, Haripura, Raisen Road, Bhopal-462023', 'icon' => 'bi-geo-alt-fill', 'sort_order' => 1],
            ['key' => 'email', 'label' => 'Email', 'value' => 'mahuahouse17@gmail.com', 'icon' => 'bi-envelope-fill', 'sort_order' => 2],
            ['key' => 'phone', 'label' => 'Phone', 'value' => '+91 9425651754', 'icon' => 'bi-telephone-fill', 'sort_order' => 3],
            ['key' => 'whatsapp', 'label' => 'WhatsApp Number', 'value' => '919425651754', 'icon' => 'bi-whatsapp', 'sort_order' => 4],
            ['key' => 'facebook', 'label' => 'Facebook URL', 'value' => 'https://www.facebook.com/mahuahouse', 'icon' => 'bi-facebook', 'sort_order' => 5],
            ['key' => 'google_maps', 'label' => 'Google Maps URL', 'value' => 'https://maps.app.goo.gl/K2ag8CT2Nza4JZrb9', 'icon' => 'bi-map-fill', 'sort_order' => 6],
            ['key' => 'timings', 'label' => 'Opening Hours', 'value' => 'Open 24 hours · Check-in 11AM · Check-out 10AM', 'icon' => 'bi-clock-fill', 'sort_order' => 7],
            ['key' => 'instagram', 'label' => 'Instagram URL', 'value' => '', 'icon' => 'bi-instagram', 'sort_order' => 8],
        ] as $c) ContactInfo::create($c);

        foreach ([
            ['key' => 'site_name', 'value' => 'Mahua House', 'label' => 'Site Name', 'group_name' => 'General'],
            ['key' => 'site_tagline', 'value' => 'The Nostalgic Woods', 'label' => 'Tagline', 'group_name' => 'General'],
            ['key' => 'site_description', 'value' => 'Mahua House — A serene eco-resort nestled in 3.5 acres of Bhopal forest. Experience nature, luxury, and tranquility.', 'label' => 'Site Description', 'group_name' => 'General'],
            ['key' => 'phone_primary', 'value' => '+91 9425651754', 'label' => 'Primary Phone', 'group_name' => 'Contact'],
            ['key' => 'whatsapp_number', 'value' => '919425651754', 'label' => 'WhatsApp Number', 'group_name' => 'Contact'],
            ['key' => 'email_primary', 'value' => 'mahuahouse17@gmail.com', 'label' => 'Primary Email', 'group_name' => 'Contact'],
            ['key' => 'address', 'value' => 'Adjoining Samardha Reserved Forest Barrier, Haripura, Raisen Road, Bhopal-462023', 'label' => 'Address', 'group_name' => 'Contact'],
            ['key' => 'maps_url', 'value' => 'https://maps.app.goo.gl/K2ag8CT2Nza4JZrb9', 'label' => 'Google Maps URL', 'group_name' => 'Contact'],
            ['key' => 'checkin_time', 'value' => 'Check-in: 11:00 AM', 'label' => 'Check-In Time', 'group_name' => 'Contact'],
            ['key' => 'checkout_time', 'value' => 'Check-out: 10:00 AM', 'label' => 'Check-Out Time', 'group_name' => 'Contact'],
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/mahuahouse', 'label' => 'Facebook URL', 'group_name' => 'Social'],
            ['key' => 'instagram_url', 'value' => '', 'label' => 'Instagram URL', 'group_name' => 'Social'],
            ['key' => 'youtube_url', 'value' => '', 'label' => 'YouTube URL', 'group_name' => 'Social'],
            ['key' => 'twitter_url', 'value' => '', 'label' => 'Twitter/X URL', 'group_name' => 'Social'],
            ['key' => 'tripadvisor_url', 'value' => '', 'label' => 'TripAdvisor URL', 'group_name' => 'Social'],
            ['key' => 'meta_keywords', 'value' => 'Mahua House, Eco Resort Bhopal, Forest Retreat, Nature Resort, Destination Wedding Bhopal', 'label' => 'Meta Keywords', 'group_name' => 'SEO'],
            ['key' => 'google_analytics_id', 'value' => '', 'label' => 'Google Analytics ID', 'group_name' => 'Analytics'],
            ['key' => 'logo_url', 'value' => '/site/assets/images/logo/1.jpeg', 'label' => 'Logo URL', 'group_name' => 'General'],
            ['key' => 'favicon_url', 'value' => '/site/assets/images/logo/1.jpeg', 'label' => 'Favicon URL', 'group_name' => 'General'],
            ['key' => 'og_image', 'value' => '/site/assets/images/about/65.jpeg', 'label' => 'OG Image', 'group_name' => 'SEO'],
        ] as $s) SiteSetting::create($s);

        $this->call([
            AboutSeeder::class,
            SpacesSeeder::class,
            FacilitiesSeeder::class,
            GallerySeeder::class,
            FoodDiningSeeder::class,
            DayOutPlanSeeder::class,
            FilmShootsSeeder::class,
            EducationalToursSeeder::class,
            CorporateEventsSeeder::class,
            EventsSeeder::class,
            VideoTourSeeder::class,
            WeddingSeeder::class,
        ]);
    }
}

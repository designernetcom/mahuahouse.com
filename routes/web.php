<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\SiteController;

// ─── ADMIN AUTH ──────────────────────────────────────────────────────────────
Route::get('/admin/login',  [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[Admin\AuthController::class, 'logout'])->name('admin.logout');

// ─── ADMIN PANEL (Protected) ─────────────────────────────────────────────────
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // File Upload
    Route::post('/upload', [Admin\UploadController::class, 'upload'])->name('upload');

    // Change Password
    Route::post('/change-password', [Admin\AuthController::class, 'changePassword'])->name('change-password');

    // Hero Slides
    Route::get('/hero',            [Admin\HeroSlideController::class, 'index'])->name('hero.index');
    Route::post('/hero',           [Admin\HeroSlideController::class, 'store'])->name('hero.store');
    Route::put('/hero/{heroSlide}',[Admin\HeroSlideController::class, 'update'])->name('hero.update');
    Route::delete('/hero/{heroSlide}', [Admin\HeroSlideController::class, 'destroy'])->name('hero.destroy');

    // Stats
    Route::get('/stats',       [Admin\StatController::class, 'index'])->name('stats.index');
    Route::post('/stats',      [Admin\StatController::class, 'store'])->name('stats.store');
    Route::put('/stats/{stat}',[Admin\StatController::class, 'update'])->name('stats.update');
    Route::delete('/stats/{stat}', [Admin\StatController::class, 'destroy'])->name('stats.destroy');

    // Why Choose Us
    Route::get('/why-choose',              [Admin\WhyChooseController::class, 'index'])->name('why-choose.index');
    Route::post('/why-choose',             [Admin\WhyChooseController::class, 'store'])->name('why-choose.store');
    Route::put('/why-choose/{whyChoose}',  [Admin\WhyChooseController::class, 'update'])->name('why-choose.update');
    Route::delete('/why-choose/{whyChoose}', [Admin\WhyChooseController::class, 'destroy'])->name('why-choose.destroy');

    // Services / Experiences
    Route::get('/services',               [Admin\ExperienceController::class, 'index'])->name('services.index');
    Route::post('/services',              [Admin\ExperienceController::class, 'store'])->name('services.store');
    Route::put('/services/{experience}',  [Admin\ExperienceController::class, 'update'])->name('services.update');
    Route::delete('/services/{experience}', [Admin\ExperienceController::class, 'destroy'])->name('services.destroy');

    // Rooms
    Route::get('/rooms',        [Admin\RoomController::class, 'index'])->name('rooms.index');
    Route::post('/rooms',       [Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [Admin\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [Admin\RoomController::class, 'destroy'])->name('rooms.destroy');

    // Gallery
    Route::get('/gallery',                            [Admin\GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery',                           [Admin\GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/gallery/{galleryItem}',              [Admin\GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{galleryItem}',           [Admin\GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('/gallery/sections',                  [Admin\GalleryController::class, 'storeSection'])->name('gallery.sections.store');
    Route::put('/gallery/sections/{pageSection}',     [Admin\GalleryController::class, 'updateSection'])->name('gallery.sections.update');
    Route::delete('/gallery/sections/{pageSection}',  [Admin\GalleryController::class, 'destroySection'])->name('gallery.sections.destroy');

    // Testimonials
    Route::get('/testimonials',                  [Admin\TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials',                 [Admin\TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}',    [Admin\TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [Admin\TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Team
    Route::get('/team',                  [Admin\TeamController::class, 'index'])->name('team.index');
    Route::post('/team',                 [Admin\TeamController::class, 'store'])->name('team.store');
    Route::put('/team/{teamMember}',     [Admin\TeamController::class, 'update'])->name('team.update');
    Route::delete('/team/{teamMember}',  [Admin\TeamController::class, 'destroy'])->name('team.destroy');

    // Blog
    Route::get('/blog',              [Admin\BlogController::class, 'index'])->name('blog.index');
    Route::post('/blog',             [Admin\BlogController::class, 'store'])->name('blog.store');
    Route::put('/blog/{blogPost}',   [Admin\BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{blogPost}',[Admin\BlogController::class, 'destroy'])->name('blog.destroy');

    // Offers
    Route::get('/offers',          [Admin\OfferController::class, 'index'])->name('offers.index');
    Route::post('/offers',         [Admin\OfferController::class, 'store'])->name('offers.store');
    Route::put('/offers/{offer}',  [Admin\OfferController::class, 'update'])->name('offers.update');
    Route::delete('/offers/{offer}',[Admin\OfferController::class, 'destroy'])->name('offers.destroy');

    // FAQ
    Route::get('/faq',         [Admin\FaqController::class, 'index'])->name('faq.index');
    Route::post('/faq',        [Admin\FaqController::class, 'store'])->name('faq.store');
    Route::put('/faq/{faq}',   [Admin\FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{faq}',[Admin\FaqController::class, 'destroy'])->name('faq.destroy');

    // Contact Info
    Route::get('/contact-info',                     [Admin\ContactInfoController::class, 'index'])->name('contact-info.index');
    Route::post('/contact-info',                    [Admin\ContactInfoController::class, 'store'])->name('contact-info.store');
    Route::put('/contact-info',                     [Admin\ContactInfoController::class, 'update'])->name('contact-info.update');
    Route::put('/contact-info/{contactInfo}',        [Admin\ContactInfoController::class, 'singleUpdate'])->name('contact-info.single-update');
    Route::delete('/contact-info/{contactInfo}',    [Admin\ContactInfoController::class, 'destroy'])->name('contact-info.destroy');

    // Settings
    Route::get('/settings',     [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings',     [Admin\SettingController::class, 'update'])->name('settings.update');

    // Inquiries
    Route::get('/inquiries',                         [Admin\InquiryController::class, 'index'])->name('inquiries.index');
    Route::put('/inquiries/{inquiry}/status',         [Admin\InquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::delete('/inquiries/{inquiry}',             [Admin\InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Page Sections
    Route::get('/page-sections',                         [Admin\PageSectionController::class, 'index'])->name('page-sections.index');
    Route::post('/page-sections',                        [Admin\PageSectionController::class, 'store'])->name('page-sections.store');
    Route::put('/page-sections/{pageSection}',           [Admin\PageSectionController::class, 'update'])->name('page-sections.update');
    Route::delete('/page-sections/{pageSection}',        [Admin\PageSectionController::class, 'destroy'])->name('page-sections.destroy');

    // Destination Wedding — Why Choose Us cards (standalone)
    Route::get('/wedding-features',                          [Admin\WeddingFeatureController::class, 'index'])->name('wedding-features.index');
    Route::post('/wedding-features',                         [Admin\WeddingFeatureController::class, 'store'])->name('wedding-features.store');
    Route::put('/wedding-features/{weddingFeature}',         [Admin\WeddingFeatureController::class, 'update'])->name('wedding-features.update');
    Route::delete('/wedding-features/{weddingFeature}',      [Admin\WeddingFeatureController::class, 'destroy'])->name('wedding-features.destroy');

    // Destination Wedding — Planning Process steps (standalone)
    Route::get('/wedding-timeline',                          [Admin\WeddingTimelineController::class, 'index'])->name('wedding-timeline.index');
    Route::post('/wedding-timeline',                         [Admin\WeddingTimelineController::class, 'store'])->name('wedding-timeline.store');
    Route::put('/wedding-timeline/{weddingTimeline}',        [Admin\WeddingTimelineController::class, 'update'])->name('wedding-timeline.update');
    Route::delete('/wedding-timeline/{weddingTimeline}',     [Admin\WeddingTimelineController::class, 'destroy'])->name('wedding-timeline.destroy');

    // ── Food & Dining — Unified Admin Hub ───────────────────────────────────
    Route::get('/food-dining-admin', [Admin\FoodDiningController::class, 'index'])->name('food-dining-admin.index');

    Route::post('/food-dining-admin/dining-options',                 [Admin\FoodDiningController::class, 'storeDiningOption'])->name('food-dining-admin.dining-options.store');
    Route::put('/food-dining-admin/dining-options/{experience}',     [Admin\FoodDiningController::class, 'updateDiningOption'])->name('food-dining-admin.dining-options.update');
    Route::delete('/food-dining-admin/dining-options/{experience}',  [Admin\FoodDiningController::class, 'destroyDiningOption'])->name('food-dining-admin.dining-options.destroy');

    Route::post('/food-dining-admin/meal-cards',                     [Admin\FoodDiningController::class, 'storeMealCard'])->name('food-dining-admin.meal-cards.store');
    Route::put('/food-dining-admin/meal-cards/{experience}',         [Admin\FoodDiningController::class, 'updateMealCard'])->name('food-dining-admin.meal-cards.update');
    Route::delete('/food-dining-admin/meal-cards/{experience}',      [Admin\FoodDiningController::class, 'destroyMealCard'])->name('food-dining-admin.meal-cards.destroy');

    Route::post('/food-dining-admin/quality-cards',                  [Admin\FoodDiningController::class, 'storeQualityCard'])->name('food-dining-admin.quality-cards.store');
    Route::put('/food-dining-admin/quality-cards/{experience}',      [Admin\FoodDiningController::class, 'updateQualityCard'])->name('food-dining-admin.quality-cards.update');
    Route::delete('/food-dining-admin/quality-cards/{experience}',   [Admin\FoodDiningController::class, 'destroyQualityCard'])->name('food-dining-admin.quality-cards.destroy');

    Route::post('/food-dining-admin/sections',                       [Admin\FoodDiningController::class, 'storeSection'])->name('food-dining-admin.sections.store');
    Route::put('/food-dining-admin/sections/{pageSection}',          [Admin\FoodDiningController::class, 'updateSection'])->name('food-dining-admin.sections.update');
    Route::delete('/food-dining-admin/sections/{pageSection}',       [Admin\FoodDiningController::class, 'destroySection'])->name('food-dining-admin.sections.destroy');

    // ── Day Out Plan — Unified Admin Hub ────────────────────────────────────
    Route::get('/day-out-plan-admin', [Admin\DayOutPlanController::class, 'index'])->name('day-out-plan-admin.index');

    Route::post('/day-out-plan-admin/includes',                  [Admin\DayOutPlanController::class, 'storeInclude'])->name('day-out-plan-admin.includes.store');
    Route::put('/day-out-plan-admin/includes/{experience}',      [Admin\DayOutPlanController::class, 'updateInclude'])->name('day-out-plan-admin.includes.update');
    Route::delete('/day-out-plan-admin/includes/{experience}',   [Admin\DayOutPlanController::class, 'destroyInclude'])->name('day-out-plan-admin.includes.destroy');

    Route::post('/day-out-plan-admin/activities',                [Admin\DayOutPlanController::class, 'storeActivity'])->name('day-out-plan-admin.activities.store');
    Route::put('/day-out-plan-admin/activities/{experience}',    [Admin\DayOutPlanController::class, 'updateActivity'])->name('day-out-plan-admin.activities.update');
    Route::delete('/day-out-plan-admin/activities/{experience}', [Admin\DayOutPlanController::class, 'destroyActivity'])->name('day-out-plan-admin.activities.destroy');

    Route::post('/day-out-plan-admin/gallery',                   [Admin\DayOutPlanController::class, 'storeGallery'])->name('day-out-plan-admin.gallery.store');
    Route::put('/day-out-plan-admin/gallery/{galleryItem}',      [Admin\DayOutPlanController::class, 'updateGallery'])->name('day-out-plan-admin.gallery.update');
    Route::delete('/day-out-plan-admin/gallery/{galleryItem}',   [Admin\DayOutPlanController::class, 'destroyGallery'])->name('day-out-plan-admin.gallery.destroy');

    Route::post('/day-out-plan-admin/sections',                  [Admin\DayOutPlanController::class, 'storeSection'])->name('day-out-plan-admin.sections.store');
    Route::put('/day-out-plan-admin/sections/{pageSection}',     [Admin\DayOutPlanController::class, 'updateSection'])->name('day-out-plan-admin.sections.update');
    Route::delete('/day-out-plan-admin/sections/{pageSection}',  [Admin\DayOutPlanController::class, 'destroySection'])->name('day-out-plan-admin.sections.destroy');

    // ── Film Shoots — Unified Admin Hub ─────────────────────────────────────
    Route::get('/film-shoots-admin', [Admin\FilmShootsController::class, 'index'])->name('film-shoots-admin.index');

    Route::post('/film-shoots-admin/shoot-types',                    [Admin\FilmShootsController::class, 'storeShootType'])->name('film-shoots-admin.shoot-types.store');
    Route::put('/film-shoots-admin/shoot-types/{experience}',        [Admin\FilmShootsController::class, 'updateShootType'])->name('film-shoots-admin.shoot-types.update');
    Route::delete('/film-shoots-admin/shoot-types/{experience}',     [Admin\FilmShootsController::class, 'destroyShootType'])->name('film-shoots-admin.shoot-types.destroy');

    Route::post('/film-shoots-admin/location-features',              [Admin\FilmShootsController::class, 'storeLocationFeature'])->name('film-shoots-admin.location-features.store');
    Route::put('/film-shoots-admin/location-features/{experience}',  [Admin\FilmShootsController::class, 'updateLocationFeature'])->name('film-shoots-admin.location-features.update');
    Route::delete('/film-shoots-admin/location-features/{experience}',[Admin\FilmShootsController::class, 'destroyLocationFeature'])->name('film-shoots-admin.location-features.destroy');

    Route::post('/film-shoots-admin/trust-badges',                   [Admin\FilmShootsController::class, 'storeTrustBadge'])->name('film-shoots-admin.trust-badges.store');
    Route::put('/film-shoots-admin/trust-badges/{experience}',       [Admin\FilmShootsController::class, 'updateTrustBadge'])->name('film-shoots-admin.trust-badges.update');
    Route::delete('/film-shoots-admin/trust-badges/{experience}',    [Admin\FilmShootsController::class, 'destroyTrustBadge'])->name('film-shoots-admin.trust-badges.destroy');

    Route::post('/film-shoots-admin/sections',                       [Admin\FilmShootsController::class, 'storeSection'])->name('film-shoots-admin.sections.store');
    Route::put('/film-shoots-admin/sections/{pageSection}',          [Admin\FilmShootsController::class, 'updateSection'])->name('film-shoots-admin.sections.update');
    Route::delete('/film-shoots-admin/sections/{pageSection}',       [Admin\FilmShootsController::class, 'destroySection'])->name('film-shoots-admin.sections.destroy');

    // ── Educational Tours — Unified Admin Hub ───────────────────────────────
    Route::get('/educational-tours-admin', [Admin\EducationalToursController::class, 'index'])->name('educational-tours-admin.index');

    Route::post('/educational-tours-admin/highlights',               [Admin\EducationalToursController::class, 'storeHighlight'])->name('educational-tours-admin.highlights.store');
    Route::put('/educational-tours-admin/highlights/{experience}',   [Admin\EducationalToursController::class, 'updateHighlight'])->name('educational-tours-admin.highlights.update');
    Route::delete('/educational-tours-admin/highlights/{experience}',[Admin\EducationalToursController::class, 'destroyHighlight'])->name('educational-tours-admin.highlights.destroy');

    Route::post('/educational-tours-admin/programs',                 [Admin\EducationalToursController::class, 'storeProgram'])->name('educational-tours-admin.programs.store');
    Route::put('/educational-tours-admin/programs/{experience}',     [Admin\EducationalToursController::class, 'updateProgram'])->name('educational-tours-admin.programs.update');
    Route::delete('/educational-tours-admin/programs/{experience}',  [Admin\EducationalToursController::class, 'destroyProgram'])->name('educational-tours-admin.programs.destroy');

    Route::post('/educational-tours-admin/sections',                 [Admin\EducationalToursController::class, 'storeSection'])->name('educational-tours-admin.sections.store');
    Route::put('/educational-tours-admin/sections/{pageSection}',    [Admin\EducationalToursController::class, 'updateSection'])->name('educational-tours-admin.sections.update');
    Route::delete('/educational-tours-admin/sections/{pageSection}', [Admin\EducationalToursController::class, 'destroySection'])->name('educational-tours-admin.sections.destroy');

    // ── Corporate Events — Unified Admin Hub ────────────────────────────────
    Route::get('/corporate-events-admin',  [Admin\CorporateEventsController::class, 'index'])->name('corporate-events-admin.index');

    Route::post('/corporate-events-admin/features',                    [Admin\CorporateEventsController::class, 'storeFeature'])->name('corporate-events-admin.features.store');
    Route::put('/corporate-events-admin/features/{experience}',        [Admin\CorporateEventsController::class, 'updateFeature'])->name('corporate-events-admin.features.update');
    Route::delete('/corporate-events-admin/features/{experience}',     [Admin\CorporateEventsController::class, 'destroyFeature'])->name('corporate-events-admin.features.destroy');

    Route::post('/corporate-events-admin/activities',                  [Admin\CorporateEventsController::class, 'storeActivity'])->name('corporate-events-admin.activities.store');
    Route::put('/corporate-events-admin/activities/{experience}',      [Admin\CorporateEventsController::class, 'updateActivity'])->name('corporate-events-admin.activities.update');
    Route::delete('/corporate-events-admin/activities/{experience}',   [Admin\CorporateEventsController::class, 'destroyActivity'])->name('corporate-events-admin.activities.destroy');

    Route::post('/corporate-events-admin/sections',                    [Admin\CorporateEventsController::class, 'storeSection'])->name('corporate-events-admin.sections.store');
    Route::put('/corporate-events-admin/sections/{pageSection}',       [Admin\CorporateEventsController::class, 'updateSection'])->name('corporate-events-admin.sections.update');
    Route::delete('/corporate-events-admin/sections/{pageSection}',    [Admin\CorporateEventsController::class, 'destroySection'])->name('corporate-events-admin.sections.destroy');

    // ── Events — Unified Admin Hub ───────────────────────────────────────────
    Route::get('/events-admin',  [Admin\EventsAdminController::class, 'index'])->name('events-admin.index');

    Route::post('/events-admin/event-types',                   [Admin\EventsAdminController::class, 'storeEventType'])->name('events-admin.event-types.store');
    Route::put('/events-admin/event-types/{experience}',       [Admin\EventsAdminController::class, 'updateEventType'])->name('events-admin.event-types.update');
    Route::delete('/events-admin/event-types/{experience}',    [Admin\EventsAdminController::class, 'destroyEventType'])->name('events-admin.event-types.destroy');

    Route::post('/events-admin/venues',                        [Admin\EventsAdminController::class, 'storeVenue'])->name('events-admin.venues.store');
    Route::put('/events-admin/venues/{experience}',            [Admin\EventsAdminController::class, 'updateVenue'])->name('events-admin.venues.update');
    Route::delete('/events-admin/venues/{experience}',         [Admin\EventsAdminController::class, 'destroyVenue'])->name('events-admin.venues.destroy');

    Route::post('/events-admin/features',                      [Admin\EventsAdminController::class, 'storeFeature'])->name('events-admin.features.store');
    Route::put('/events-admin/features/{experience}',          [Admin\EventsAdminController::class, 'updateFeature'])->name('events-admin.features.update');
    Route::delete('/events-admin/features/{experience}',       [Admin\EventsAdminController::class, 'destroyFeature'])->name('events-admin.features.destroy');

    Route::post('/events-admin/gallery',                       [Admin\EventsAdminController::class, 'storeGallery'])->name('events-admin.gallery.store');
    Route::put('/events-admin/gallery/{galleryItem}',          [Admin\EventsAdminController::class, 'updateGallery'])->name('events-admin.gallery.update');
    Route::delete('/events-admin/gallery/{galleryItem}',       [Admin\EventsAdminController::class, 'destroyGallery'])->name('events-admin.gallery.destroy');

    Route::post('/events-admin/sections',                      [Admin\EventsAdminController::class, 'storeSection'])->name('events-admin.sections.store');
    Route::put('/events-admin/sections/{pageSection}',         [Admin\EventsAdminController::class, 'updateSection'])->name('events-admin.sections.update');
    Route::delete('/events-admin/sections/{pageSection}',      [Admin\EventsAdminController::class, 'destroySection'])->name('events-admin.sections.destroy');

    // ── Video Tours — Unified Admin Hub ─────────────────────────────────────
    Route::get('/video-tours',  [Admin\VideoTourController::class, 'index'])->name('video-tours.index');

    Route::post('/video-tours/videos',                   [Admin\VideoTourController::class, 'storeVideo'])->name('video-tours.videos.store');
    Route::put('/video-tours/videos/{experience}',       [Admin\VideoTourController::class, 'updateVideo'])->name('video-tours.videos.update');
    Route::delete('/video-tours/videos/{experience}',    [Admin\VideoTourController::class, 'destroyVideo'])->name('video-tours.videos.destroy');

    Route::post('/video-tours/sections',                 [Admin\VideoTourController::class, 'storeSection'])->name('video-tours.sections.store');
    Route::put('/video-tours/sections/{pageSection}',    [Admin\VideoTourController::class, 'updateSection'])->name('video-tours.sections.update');
    Route::delete('/video-tours/sections/{pageSection}', [Admin\VideoTourController::class, 'destroySection'])->name('video-tours.sections.destroy');

    // ── Home Page — Unified Admin Hub ────────────────────────────────────────────
    Route::get('/home-admin', [Admin\HomeAdminController::class, 'index'])->name('home-admin.index');
    Route::post('/home-admin/intro', [Admin\HomeAdminController::class, 'storeIntroSection'])->name('home-admin.intro.store');
    Route::post('/home-admin/sections', [Admin\HomeAdminController::class, 'storeSection'])->name('home-admin.sections.store');
    Route::put('/home-admin/sections/{pageSection}', [Admin\HomeAdminController::class, 'updateSection'])->name('home-admin.sections.update');
    Route::delete('/home-admin/sections/{pageSection}', [Admin\HomeAdminController::class, 'destroySection'])->name('home-admin.sections.destroy');

    // ── About Us — Unified Admin Hub ─────────────────────────────────────────────
    Route::get('/about-admin', [Admin\AboutController::class, 'index'])->name('about-admin.index');

    Route::post('/about-admin/experiences',                  [Admin\AboutController::class, 'storeExperience'])->name('about-admin.experiences.store');
    Route::put('/about-admin/experiences/{experience}',      [Admin\AboutController::class, 'updateExperience'])->name('about-admin.experiences.update');
    Route::delete('/about-admin/experiences/{experience}',   [Admin\AboutController::class, 'destroyExperience'])->name('about-admin.experiences.destroy');

    Route::post('/about-admin/sections',                     [Admin\AboutController::class, 'storeSection'])->name('about-admin.sections.store');
    Route::put('/about-admin/sections/{pageSection}',        [Admin\AboutController::class, 'updateSection'])->name('about-admin.sections.update');
    Route::delete('/about-admin/sections/{pageSection}',     [Admin\AboutController::class, 'destroySection'])->name('about-admin.sections.destroy');

    // ── Facilities — Unified Admin Hub ───────────────────────────────────────────
    Route::get('/facilities-admin', [Admin\FacilitiesController::class, 'index'])->name('facilities-admin.index');

    Route::post('/facilities-admin/facilities',                  [Admin\FacilitiesController::class, 'storeFacility'])->name('facilities-admin.facilities.store');
    Route::put('/facilities-admin/facilities/{experience}',      [Admin\FacilitiesController::class, 'updateFacility'])->name('facilities-admin.facilities.update');
    Route::delete('/facilities-admin/facilities/{experience}',   [Admin\FacilitiesController::class, 'destroyFacility'])->name('facilities-admin.facilities.destroy');

    Route::post('/facilities-admin/sections',                    [Admin\FacilitiesController::class, 'storeSection'])->name('facilities-admin.sections.store');
    Route::put('/facilities-admin/sections/{pageSection}',       [Admin\FacilitiesController::class, 'updateSection'])->name('facilities-admin.sections.update');
    Route::delete('/facilities-admin/sections/{pageSection}',    [Admin\FacilitiesController::class, 'destroySection'])->name('facilities-admin.sections.destroy');

    // ── Spaces — Unified Admin Hub ───────────────────────────────────────────────
    Route::get('/spaces-admin', [Admin\SpacesController::class, 'index'])->name('spaces-admin.index');

    Route::post('/spaces-admin/venues',                   [Admin\SpacesController::class, 'storeVenue'])->name('spaces-admin.venues.store');
    Route::put('/spaces-admin/venues/{experience}',       [Admin\SpacesController::class, 'updateVenue'])->name('spaces-admin.venues.update');
    Route::delete('/spaces-admin/venues/{experience}',    [Admin\SpacesController::class, 'destroyVenue'])->name('spaces-admin.venues.destroy');

    Route::post('/spaces-admin/gallery',                  [Admin\SpacesController::class, 'storeGallery'])->name('spaces-admin.gallery.store');
    Route::put('/spaces-admin/gallery/{galleryItem}',     [Admin\SpacesController::class, 'updateGallery'])->name('spaces-admin.gallery.update');
    Route::delete('/spaces-admin/gallery/{galleryItem}',  [Admin\SpacesController::class, 'destroyGallery'])->name('spaces-admin.gallery.destroy');

    Route::post('/spaces-admin/sections',                 [Admin\SpacesController::class, 'storeSection'])->name('spaces-admin.sections.store');
    Route::put('/spaces-admin/sections/{pageSection}',    [Admin\SpacesController::class, 'updateSection'])->name('spaces-admin.sections.update');
    Route::delete('/spaces-admin/sections/{pageSection}', [Admin\SpacesController::class, 'destroySection'])->name('spaces-admin.sections.destroy');

    // ── Destination Wedding — Unified Admin Hub ──────────────────────────────
    Route::get('/destination-wedding',  [Admin\DestinationWeddingController::class, 'index'])->name('destination-wedding.index');

    // Page text sections
    Route::post('/destination-wedding/sections',                     [Admin\DestinationWeddingController::class, 'storeSection'])->name('destination-wedding.sections.store');
    Route::put('/destination-wedding/sections/{pageSection}',        [Admin\DestinationWeddingController::class, 'updateSection'])->name('destination-wedding.sections.update');
    Route::delete('/destination-wedding/sections/{pageSection}',     [Admin\DestinationWeddingController::class, 'destroySection'])->name('destination-wedding.sections.destroy');

    // Why Choose Us feature cards
    Route::post('/destination-wedding/features',                     [Admin\DestinationWeddingController::class, 'storeFeature'])->name('destination-wedding.features.store');
    Route::put('/destination-wedding/features/{weddingFeature}',     [Admin\DestinationWeddingController::class, 'updateFeature'])->name('destination-wedding.features.update');
    Route::delete('/destination-wedding/features/{weddingFeature}',  [Admin\DestinationWeddingController::class, 'destroyFeature'])->name('destination-wedding.features.destroy');

    // Planning process timeline steps
    Route::post('/destination-wedding/steps',                        [Admin\DestinationWeddingController::class, 'storeStep'])->name('destination-wedding.steps.store');
    Route::put('/destination-wedding/steps/{weddingTimeline}',       [Admin\DestinationWeddingController::class, 'updateStep'])->name('destination-wedding.steps.update');
    Route::delete('/destination-wedding/steps/{weddingTimeline}',    [Admin\DestinationWeddingController::class, 'destroyStep'])->name('destination-wedding.steps.destroy');

    // Wedding gallery photos
    Route::post('/destination-wedding/gallery',                      [Admin\DestinationWeddingController::class, 'storeGallery'])->name('destination-wedding.gallery.store');
    Route::put('/destination-wedding/gallery/{galleryItem}',         [Admin\DestinationWeddingController::class, 'updateGallery'])->name('destination-wedding.gallery.update');
    Route::delete('/destination-wedding/gallery/{galleryItem}',      [Admin\DestinationWeddingController::class, 'destroyGallery'])->name('destination-wedding.gallery.destroy');
});

// Public website pages
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/rooms', [SiteController::class, 'rooms'])->name('rooms');
Route::get('/gallery', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/booking', [SiteController::class, 'booking'])->name('booking');
Route::post('/booking', [SiteController::class, 'storeBooking'])->name('booking.store');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/destination-wedding', [SiteController::class, 'destinationWedding'])->name('destination-wedding');
Route::get('/video-tours', [SiteController::class, 'videoTours'])->name('video-tours');
Route::get('/events', [SiteController::class, 'events'])->name('events');
Route::get('/corporate-events', [SiteController::class, 'corporateEvents'])->name('corporate-events');
Route::get('/educational-tours', [SiteController::class, 'educationalTours'])->name('educational-tours');
Route::get('/film-shoots', [SiteController::class, 'filmShoots'])->name('film-shoots');
Route::get('/accommodation', [SiteController::class, 'accommodation'])->name('accommodation');
Route::get('/food-dining', [SiteController::class, 'foodDining'])->name('food-dining');
Route::get('/stay', [SiteController::class, 'stay'])->name('stay');
Route::get('/spaces', [SiteController::class, 'spaces'])->name('spaces');
Route::get('/day-out-plan', [SiteController::class, 'dayOutPlan'])->name('day-out-plan');
Route::get('/facilities', [SiteController::class, 'facilities'])->name('facilities');
Route::post('/enquiry', [SiteController::class, 'storeEnquiry'])->name('enquiry.store');

// ─── SERVE EXISTING STATIC SITE ─────────────────────────────────────────────
// Static assets (CSS, JS, images) from the "mahua house" folder
Route::get('/site/assets/{path}', function ($path) {
    $file = base_path('../mahua house/assets/' . $path);
    if (!file_exists($file)) abort(404);
    $mime = match (strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'jpg', 'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'webp' => 'image/webp',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
        'eot'  => 'application/vnd.ms-fontobject',
        default => 'application/octet-stream',
    };
    return response()->file($file, ['Content-Type' => $mime]);
})->where('path', '.*')->name('site.assets');

// Root CSS file (style.css at root of mahua house)
Route::get('/site/style.css', function () {
    $file = base_path('../mahua house/style.css');
    return file_exists($file) ? response()->file($file, ['Content-Type' => 'text/css']) : abort(404);
});

// Static HTML pages from "mahua house" folder
Route::get('/site/{page?}', function ($page = 'index') {
    $siteRoot = base_path('../mahua house');
    // Strip .html extension if present (links may include it)
    $page = preg_replace('/\.html$/i', '', $page);
    $file = $siteRoot . '/' . $page . '.html';
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // Rewrite asset paths to go through our proxy
        $content = str_replace('href="assets/', 'href="/site/assets/', $content);
        $content = str_replace('href="style.css"', 'href="/site/style.css"', $content);
        $content = str_replace('src="assets/', 'src="/site/assets/', $content);
        $content = str_replace("href='assets/", "href='/site/assets/", $content);
        $content = str_replace("src='assets/", "src='/site/assets/", $content);
        // Rewrite relative HTML page links so navbar/footer links stay within /site/
        $content = preg_replace('/href="([a-zA-Z0-9][a-zA-Z0-9_\-]*\.html)"/', 'href="/site/$1"', $content);
        $content = preg_replace("/href='([a-zA-Z0-9][a-zA-Z0-9_\-]*\.html)'/", "href='/site/\$1'", $content);
        return response($content)->header('Content-Type', 'text/html');
    }
    abort(404);
})->where('page', '[a-zA-Z0-9_\-\.]+');

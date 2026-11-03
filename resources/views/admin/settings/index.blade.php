@extends('layouts.admin')
@section('title', 'Site Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}">
  @csrf @method('PUT')

  <!-- General -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-globe me-2" style="color:#DAA520"></i>General Settings</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-md-6">
        <label class="form-label">Site Name</label>
        <input type="text" name="settings[site_name]" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Tagline</label>
        <input type="text" name="settings[site_tagline]" class="form-control" value="{{ $settings['site_tagline'] ?? '' }}">
      </div>
      <div class="col-12">
        <label class="form-label">Site Description (SEO)</label>
        <textarea name="settings[site_description]" class="form-control" rows="2">{{ $settings['site_description'] ?? '' }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Logo URL</label>
        <div class="input-group">
          <input type="text" name="settings[logo_url]" id="logo_url" class="form-control" value="{{ $settings['logo_url'] ?? '' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('logoPreview'), document.getElementById('logo_url'))"></label>
        </div>
        @if(!empty($settings['logo_url']))
        <img id="logoPreview" src="{{ $settings['logo_url'] }}" style="height:50px;margin-top:8px;">
        @else
        <img id="logoPreview" style="display:none;height:50px;margin-top:8px;">
        @endif
      </div>
      <div class="col-md-6">
        <label class="form-label">Favicon URL</label>
        <div class="input-group">
          <input type="text" name="settings[favicon_url]" id="favicon_url" class="form-control" value="{{ $settings['favicon_url'] ?? '' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('faviconPreview'), document.getElementById('favicon_url'))"></label>
        </div>
        <img id="faviconPreview" style="display:{{ !empty($settings['favicon_url']) ? 'block' : 'none' }};height:32px;margin-top:8px;" src="{{ $settings['favicon_url'] ?? '' }}">
      </div>
    </div>
  </div>

  <!-- Homepage -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-house-heart-fill me-2" style="color:#DAA520"></i>Homepage Content</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-md-6">
        <label class="form-label">Hero Label</label>
        <input type="text" name="settings[home_hero_label]" class="form-control" value="{{ $settings['home_hero_label'] ?? 'MP Tourism Accredited - Raisen Road, Bhopal' }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Established Year</label>
        <input type="text" name="settings[home_established_year]" class="form-control" value="{{ $settings['home_established_year'] ?? '2014' }}">
      </div>
      <div class="col-md-3">
        <label class="form-label">Established Label</label>
        <input type="text" name="settings[home_established_label]" class="form-control" value="{{ $settings['home_established_label'] ?? 'Est. Year' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Intro Label</label>
        <input type="text" name="settings[home_intro_label]" class="form-control" value="{{ $settings['home_intro_label'] ?? 'Welcome to Mahua House' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Intro Heading</label>
        <input type="text" name="settings[home_intro_heading]" class="form-control" value="{{ $settings['home_intro_heading'] ?? 'The Nostalgic <em>Woods</em>' }}">
      </div>
      <div class="col-12">
        <label class="form-label">Intro Text 1</label>
        <textarea name="settings[home_intro_text_1]" class="form-control" rows="2">{{ $settings['home_intro_text_1'] ?? 'Mahua House - The Nostalgic Woods is an MP Tourism accredited countryside retreat located on Raisen Road, Bhopal, surrounded by serene forest landscapes.' }}</textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Intro Text 2</label>
        <textarea name="settings[home_intro_text_2]" class="form-control" rows="2">{{ $settings['home_intro_text_2'] ?? 'Designed for those who value peace, culture, and meaningful gatherings, Mahua House blends rustic charm with modern comfort.' }}</textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Intro Bullet Points (one per line)</label>
        <textarea name="settings[home_intro_points]" class="form-control" rows="4">{{ $settings['home_intro_points'] ?? "MP Tourism Accredited countryside retreat\nAdjoining Samardha Reserved Forest, Bhopal\nTrusted by Doordarshan productions\nIdeal for weddings, events, picnics and peaceful stays" }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Experiences Heading</label>
        <input type="text" name="settings[home_experiences_heading]" class="form-control" value="{{ $settings['home_experiences_heading'] ?? 'Experiences That <em>Stay With You</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Rooms Heading</label>
        <input type="text" name="settings[home_rooms_heading]" class="form-control" value="{{ $settings['home_rooms_heading'] ?? 'Sleep Amidst the <em>Whispering Forest</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">CTA Heading</label>
        <input type="text" name="settings[home_cta_heading]" class="form-control" value="{{ $settings['home_cta_heading'] ?? 'Ready to Experience <em>Mahua House?</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">CTA Text</label>
        <input type="text" name="settings[home_cta_text]" class="form-control" value="{{ $settings['home_cta_text'] ?? 'Book your stay, plan your event, or simply come to unwind in nature. Our forest is waiting for you.' }}">
      </div>
    </div>
  </div>

  <!-- Booking Page -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-calendar-check-fill me-2" style="color:#DAA520"></i>Booking Page Content</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-md-6">
        <label class="form-label">Hero Label</label>
        <input type="text" name="settings[booking_hero_label]" class="form-control" value="{{ $settings['booking_hero_label'] ?? 'Simple Booking' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Image URL</label>
        <div class="input-group">
          <input type="text" name="settings[booking_hero_image]" id="booking_hero_image" class="form-control" value="{{ $settings['booking_hero_image'] ?? 'assets/images/about/14.jpeg' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, null, document.getElementById('booking_hero_image'))"></label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Heading</label>
        <input type="text" name="settings[booking_hero_heading]" class="form-control" value="{{ $settings['booking_hero_heading'] ?? 'Reserve Your <em>Forest Stay</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Text</label>
        <input type="text" name="settings[booking_hero_text]" class="form-control" value="{{ $settings['booking_hero_text'] ?? 'Send us a WhatsApp message or submit a booking request and we will confirm your stay.' }}">
      </div>
      <div class="col-12">
        <label class="form-label">How To Book Banner</label>
        <input type="text" name="settings[booking_how_to_book]" class="form-control" value="{{ $settings['booking_how_to_book'] ?? '<strong>How to Book:</strong> Choose your room, message us with your dates, or send the form below.' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Rooms Heading</label>
        <input type="text" name="settings[booking_rooms_heading]" class="form-control" value="{{ $settings['booking_rooms_heading'] ?? 'Choose Your <em>Room</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Rooms Description</label>
        <input type="text" name="settings[booking_rooms_text]" class="form-control" value="{{ $settings['booking_rooms_text'] ?? 'Comfortable accommodation options surrounded by nature.' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Form Heading</label>
        <input type="text" name="settings[booking_form_heading]" class="form-control" value="{{ $settings['booking_form_heading'] ?? 'Send a <em>Booking Request</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Form Text</label>
        <input type="text" name="settings[booking_form_text]" class="form-control" value="{{ $settings['booking_form_text'] ?? "Fill in your details and we'll confirm your booking via call or WhatsApp." }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Meal Price</label>
        <input type="text" name="settings[booking_meal_price]" class="form-control" value="{{ $settings['booking_meal_price'] ?? 'Rs. 1,000' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Meal Price Note</label>
        <input type="text" name="settings[booking_meal_price_note]" class="form-control" value="{{ $settings['booking_meal_price_note'] ?? 'per head - full day meal plan' }}">
      </div>
      <div class="col-12">
        <label class="form-label">Meal Items (one per line: Name|Description)</label>
        <textarea name="settings[booking_meal_items]" class="form-control" rows="4">{{ $settings['booking_meal_items'] ?? "Breakfast|Fresh poha, parathas, chai and seasonal fruits.\nLunch|Full dal-chawal-sabzi thali with homemade pickles and salad.\nEvening Snacks|Chai with namkeen or seasonal snacks.\nDinner|Traditional Madhya Pradesh dinner served family-style." }}</textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Policies (one per line: Title|Point 1|Point 2|Point 3)</label>
        <textarea name="settings[booking_policies]" class="form-control" rows="5">{{ $settings['booking_policies'] ?? "Check-in & Out|Check-in from 11:00 AM|Check-out by 10:00 AM|Early check-in on request\nCancellations|Free cancellation 7+ days prior|Special terms for peak season|No-show policy applies\nChildren & Pets|Children of all ages welcome|Extra bed available on request|Pet policy on pre-arrangement\nGeneral Rules|No smoking inside rooms|Quiet hours after 10:00 PM|Respect the forest and wildlife" }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Booking Host Name</label>
        <input type="text" name="settings[booking_host_name]" class="form-control" value="{{ $settings['booking_host_name'] ?? 'Mahua House Team' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Contact Image URL</label>
        <div class="input-group">
          <input type="text" name="settings[booking_contact_image]" id="booking_contact_image" class="form-control" value="{{ $settings['booking_contact_image'] ?? 'assets/images/about/8.jpeg' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, null, document.getElementById('booking_contact_image'))"></label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">CTA Heading</label>
        <input type="text" name="settings[booking_cta_heading]" class="form-control" value="{{ $settings['booking_cta_heading'] ?? 'Your Forest Escape <em>Awaits</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">CTA Text</label>
        <input type="text" name="settings[booking_cta_text]" class="form-control" value="{{ $settings['booking_cta_text'] ?? "Book via WhatsApp, give us a call, or send an enquiry. We'll confirm your stay and welcome you to the forest." }}">
      </div>
    </div>
  </div>

  <!-- Events Page -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-calendar-event-fill me-2" style="color:#DAA520"></i>Events Page Content</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-md-6">
        <label class="form-label">Hero Label</label>
        <input type="text" name="settings[events_hero_label]" class="form-control" value="{{ $settings['events_hero_label'] ?? 'Celebrate in the Forest' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Image URL</label>
        <div class="input-group">
          <input type="text" name="settings[events_hero_image]" id="events_hero_image" class="form-control" value="{{ $settings['events_hero_image'] ?? 'assets/images/about/7.jpeg' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, null, document.getElementById('events_hero_image'))"></label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Heading</label>
        <input type="text" name="settings[events_hero_heading]" class="form-control" value="{{ $settings['events_hero_heading'] ?? 'Unforgettable <em>Events</em><br>in Nature\'s Embrace' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Text</label>
        <input type="text" name="settings[events_hero_text]" class="form-control" value="{{ $settings['events_hero_text'] ?? 'From intimate gatherings to grand celebrations, Mahua House provides a one-of-a-kind forest setting for every occasion that matters.' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Event Types Heading</label>
        <input type="text" name="settings[events_types_heading]" class="form-control" value="{{ $settings['events_types_heading'] ?? 'Events for <em>Every Occasion</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Event Types Text</label>
        <input type="text" name="settings[events_types_text]" class="form-control" value="{{ $settings['events_types_text'] ?? 'Whatever the celebration, our forest provides a backdrop that no banquet hall ever could.' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Why Host Heading</label>
        <input type="text" name="settings[events_why_heading]" class="form-control" value="{{ $settings['events_why_heading'] ?? 'A Venue That Feels <em>Alive</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Why Host Image URL</label>
        <div class="input-group">
          <input type="text" name="settings[events_why_image]" id="events_why_image" class="form-control" value="{{ $settings['events_why_image'] ?? 'assets/images/about/25.jpeg' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, null, document.getElementById('events_why_image'))"></label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Venues Heading</label>
        <input type="text" name="settings[events_venues_heading]" class="form-control" value="{{ $settings['events_venues_heading'] ?? 'Choose Your <em>Forest Setting</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Gallery Heading</label>
        <input type="text" name="settings[events_gallery_heading]" class="form-control" value="{{ $settings['events_gallery_heading'] ?? 'Moments from Our <em>Forest Events</em>' }}">
      </div>
      <div class="col-12">
        <label class="form-label">Planning Steps (one per line: Title|Description|FontAwesome Icon)</label>
        <textarea name="settings[events_steps]" class="form-control" rows="4">{{ $settings['events_steps'] ?? "Initial Enquiry|Call, email, or fill our enquiry form with your event type, date and guest count.|fa-solid fa-phone\nSite Visit & Planning|Explore the venue and shape your event plan with our team.|fa-solid fa-map-location-dot\nCustomise & Confirm|Finalise decor, menus, entertainment and timeline.|fa-solid fa-palette\nYour Perfect Event|Arrive, relax and celebrate while our team manages the day.|fa-solid fa-star" }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Form Heading</label>
        <input type="text" name="settings[events_form_heading]" class="form-control" value="{{ $settings['events_form_heading'] ?? 'Start Planning Your <em>Event Today</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">CTA Heading</label>
        <input type="text" name="settings[events_cta_heading]" class="form-control" value="{{ $settings['events_cta_heading'] ?? 'Your Forest Event is <em>One Call Away</em>' }}">
      </div>
      <div class="col-12">
        <div class="alert alert-light border mb-0" style="font-size:13px;">
          Event cards are edited in <strong>Admin &gt; Services</strong>. Use category <code>events</code> for event type cards, <code>venue</code> for venue cards, and <code>why-host</code> for feature bullets. Event gallery images are edited in <strong>Admin &gt; Gallery</strong> with category <code>events</code>.
        </div>
      </div>
    </div>
  </div>

  <!-- Video Tours Page -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-play-btn-fill me-2" style="color:#DAA520"></i>Video Tours Page Content</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-md-6">
        <label class="form-label">Hero Label</label>
        <input type="text" name="settings[video_tours_hero_label]" class="form-control" value="{{ $settings['video_tours_hero_label'] ?? 'See it Before You Visit' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Image URL</label>
        <div class="input-group">
          <input type="text" name="settings[video_tours_hero_image]" id="video_tours_hero_image" class="form-control" value="{{ $settings['video_tours_hero_image'] ?? 'assets/images/video/video-1.jpg' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, null, document.getElementById('video_tours_hero_image'))"></label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Heading</label>
        <input type="text" name="settings[video_tours_hero_heading]" class="form-control" value="{{ $settings['video_tours_hero_heading'] ?? 'Tour Mahua House<br><em>From Your Screen</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hero Text</label>
        <input type="text" name="settings[video_tours_hero_text]" class="form-control" value="{{ $settings['video_tours_hero_text'] ?? 'Walk through our forest rooms, event spaces, nature trails and dining before you arrive.' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Featured Heading</label>
        <input type="text" name="settings[video_tours_featured_heading]" class="form-control" value="{{ $settings['video_tours_featured_heading'] ?? 'Featured <em>Video Tour</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Grid Heading</label>
        <input type="text" name="settings[video_tours_grid_heading]" class="form-control" value="{{ $settings['video_tours_grid_heading'] ?? 'Browse <em>Every Video</em>' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">YouTube Strip Heading</label>
        <input type="text" name="settings[video_tours_youtube_heading]" class="form-control" value="{{ $settings['video_tours_youtube_heading'] ?? 'Subscribe to Our YouTube Channel' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">CTA Heading</label>
        <input type="text" name="settings[video_tours_cta_heading]" class="form-control" value="{{ $settings['video_tours_cta_heading'] ?? "The Screen Can't Do It <em>Justice</em>" }}">
      </div>
      <div class="col-12">
        <div class="alert alert-light border mb-0" style="font-size:13px;">
          Video entries are managed in <strong>Admin &gt; Services</strong>. Use category <code>video-tour</code>, put the YouTube URL or video ID in <code>Tag / Link</code>, use <code>Icon</code> as the video tag label, and optionally upload a thumbnail image.
        </div>
      </div>
    </div>
  </div>

  <!-- Contact -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-telephone-fill me-2" style="color:#DAA520"></i>Contact Details</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-md-6">
        <label class="form-label">Primary Phone</label>
        <input type="text" name="settings[phone_primary]" class="form-control" value="{{ $settings['phone_primary'] ?? '' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">WhatsApp Number</label>
        <input type="text" name="settings[whatsapp_number]" class="form-control" value="{{ $settings['whatsapp_number'] ?? '' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email Address</label>
        <input type="email" name="settings[email_primary]" class="form-control" value="{{ $settings['email_primary'] ?? '' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Booking Phone</label>
        <input type="text" name="settings[phone_booking]" class="form-control" value="{{ $settings['phone_booking'] ?? '' }}">
      </div>
      <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="settings[address]" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Google Maps Embed URL</label>
        <input type="text" name="settings[maps_url]" class="form-control" value="{{ $settings['maps_url'] ?? '' }}" placeholder="https://maps.google.com/...">
      </div>
      <div class="col-md-6">
        <label class="form-label">Check-In / Check-Out Times</label>
        <input type="text" name="settings[checkin_time]" class="form-control mb-2" value="{{ $settings['checkin_time'] ?? '' }}" placeholder="Check-in: 12:00 PM">
        <input type="text" name="settings[checkout_time]" class="form-control" value="{{ $settings['checkout_time'] ?? '' }}" placeholder="Check-out: 11:00 AM">
      </div>
    </div>
  </div>

  <!-- Social Media -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-share-fill me-2" style="color:#DAA520"></i>Social Media Links</h5>
    </div>
    <div class="p-4 row g-3">
      @foreach(['facebook_url' => 'Facebook', 'instagram_url' => 'Instagram', 'youtube_url' => 'YouTube', 'twitter_url' => 'Twitter/X', 'tripadvisor_url' => 'TripAdvisor'] as $key => $label)
      <div class="col-md-6">
        <label class="form-label">{{ $label }}</label>
        <input type="url" name="settings[{{ $key }}]" class="form-control" value="{{ $settings[$key] ?? '' }}" placeholder="https://...">
      </div>
      @endforeach
    </div>
  </div>

  <!-- SEO -->
  <div class="table-card mb-4">
    <div class="card-header-custom">
      <h5><i class="bi bi-search me-2" style="color:#DAA520"></i>SEO & Meta</h5>
    </div>
    <div class="p-4 row g-3">
      <div class="col-12">
        <label class="form-label">Meta Keywords</label>
        <input type="text" name="settings[meta_keywords]" class="form-control" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="eco resort, nature stay, jungle resort...">
      </div>
      <div class="col-md-6">
        <label class="form-label">OG Image (Social Share Image)</label>
        <div class="input-group">
          <input type="text" name="settings[og_image]" id="og_image" class="form-control" value="{{ $settings['og_image'] ?? '' }}">
          <label class="btn btn-outline-secondary mb-0">Upload <input type="file" accept="image/*" style="display:none" onchange="uploadImage(this, document.getElementById('ogPreview'), document.getElementById('og_image'))"></label>
        </div>
        <img id="ogPreview" style="display:{{ !empty($settings['og_image']) ? 'block' : 'none' }};height:60px;margin-top:8px;" src="{{ $settings['og_image'] ?? '' }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Google Analytics ID</label>
        <input type="text" name="settings[google_analytics_id]" class="form-control" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX">
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 pb-4 px-1">
    <button type="submit" class="btn-mahua btn px-5"><i class="bi bi-save me-1"></i>Save All Settings</button>
  </div>
</form>
@endsection

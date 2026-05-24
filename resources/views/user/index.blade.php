@extends('user.layout')

@section('title', 'Luxury Hotel Booking')

@section('extra_css')
<style>
    .hero {
        position: relative;
        min-height: 86vh;
        display: flex;
        align-items: center;
        background-image:
            linear-gradient(rgba(13, 22, 34, 0.54), rgba(13, 22, 34, 0.58)),
            url('https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=1900&q=80');
        background-size: cover;
        background-position: center;
        margin-bottom: 7rem;
    }

    .hero-wrap {
        width: min(1180px, calc(100% - 2rem));
        margin-inline: auto;
        padding: 8.5rem 0 4rem;
    }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 0.85rem;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 999px;
        color: #f9f0df;
        font-size: 0.85rem;
        margin-bottom: 1.2rem;
        backdrop-filter: blur(4px);
    }

    .hero h1 {
        font-family: 'Poppins', sans-serif;
        color: #fff;
        font-size: clamp(2.5rem, 5.8vw, 5rem);
        line-height: 0.95;
        margin-bottom: 1.2rem;
        max-width: 11ch;
        font-weight: 700;
    }

    .hero p {
        color: rgba(255, 255, 255, 0.92);
        max-width: 52ch;
        font-size: 1.04rem;
    }

    .booking-panel {
        margin-top: 2.2rem;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: 18px;
        box-shadow: 0 24px 40px rgba(10, 20, 30, 0.22);
        padding: 1rem;
        display: grid;
        grid-template-columns: 1.15fr 1fr 1fr 0.7fr auto;
        gap: 0.8rem;
        align-items: end;
        max-width: 1060px;
    }

    .field {
        display: grid;
        gap: 0.42rem;
    }

    .field label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #5f6f7f;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .field input,
    .field select {
        border: 1px solid #d9d0c3;
        border-radius: 12px;
        height: 48px;
        padding: 0 0.86rem;
        font: inherit;
        color: #243240;
        background: #fff;
    }

    .field input:focus,
    .field select:focus {
        outline: none;
        border-color: #b68b52;
        box-shadow: 0 0 0 3px rgba(182, 139, 82, 0.18);
    }

    .section {
        padding: 2rem 0;
    }

    .section-head {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1.4rem;
    }

    .section-label {
        color: #b68b52;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.78rem;
        font-weight: 700;
        margin-bottom: 0.45rem;
    }

    .section h2 {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        line-height: 0.95;
        font-weight: 700;
    }

    .section p {
        color: #526273;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.2rem;
    }

    .room-card {
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 22px 36px rgba(12, 22, 34, 0.08);
        border: 1px solid #ede1d1;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 28px 40px rgba(12, 22, 34, 0.12);
    }

    .room-image {
        aspect-ratio: 16 / 11;
        overflow: hidden;
    }

    .room-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .room-card:hover .room-image img {
        transform: scale(1.05);
    }

    .room-content {
        padding: 1.1rem 1.1rem 1.25rem;
        display: grid;
        gap: 0.75rem;
    }

    .room-top {
        display: flex;
        justify-content: space-between;
        gap: 0.7rem;
        align-items: start;
    }

    .room-name {
        font-size: 1.12rem;
        font-weight: 700;
        color: #1f2a3a;
    }

    .room-location {
        font-size: 0.84rem;
        color: #617181;
    }

    .room-price {
        text-align: right;
        white-space: nowrap;
    }

    .room-price strong {
        color: #b68b52;
        font-size: 1.4rem;
    }

    .room-price span {
        display: block;
        color: #77889a;
        font-size: 0.77rem;
    }

    .room-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        color: #5f6f7f;
    }

    .room-actions {
        display: flex;
        gap: 0.6rem;
    }

    .room-actions .btn {
        flex: 1;
    }

    .soft-wrap {
        background: linear-gradient(180deg, #fffdf9 0%, #fdf8f2 100%);
        border: 1px solid #ecdfcf;
        border-radius: 24px;
        padding: 1.5rem;
        box-shadow: 0 24px 36px rgba(10, 24, 40, 0.06);
    }

    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.8rem;
        margin-top: 1rem;
    }

    .facility {
        background: #fff;
        border: 1px solid #eee2d3;
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        transition: border-color 0.25s ease, transform 0.25s ease;
    }

    .facility:hover {
        border-color: #d6ba90;
        transform: translateY(-4px);
    }

    .facility i {
        font-size: 1.5rem;
        color: #b68b52;
        display: block;
        margin-bottom: 0.45rem;
    }

    .facility span {
        font-size: 0.87rem;
        font-weight: 600;
        color: #334354;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .review-card {
        background: #fff;
        border: 1px solid #ebdecd;
        border-radius: 18px;
        padding: 1.2rem;
        box-shadow: 0 16px 28px rgba(15, 24, 36, 0.06);
    }

    .review-stars {
        color: #c99652;
        margin-bottom: 0.75rem;
        letter-spacing: 0.1em;
        font-size: 0.84rem;
    }

    .review-text {
        color: #526273;
        font-size: 0.93rem;
        margin-bottom: 0.9rem;
    }

    .review-author {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        align-items: center;
    }

    .review-author strong {
        font-size: 0.95rem;
    }

    .review-author small {
        color: #708193;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr 0.8fr;
        grid-auto-rows: 220px;
        gap: 0.9rem;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
    }

    .gallery-item:nth-child(1) {
        grid-row: span 2;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .gallery-item::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 45%, rgba(8, 18, 29, 0.6) 100%);
    }

    .offer {
        margin: 3rem 0;
        background-image:
            linear-gradient(110deg, rgba(10, 20, 34, 0.88), rgba(10, 20, 34, 0.68)),
            url('https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1600&q=80');
        background-size: cover;
        background-position: center;
        border-radius: 24px;
        padding: 2.2rem;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 24px 34px rgba(9, 18, 29, 0.2);
    }

    .offer h3 {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(1.9rem, 3.8vw, 3rem);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .offer p {
        color: rgba(255, 255, 255, 0.9);
        max-width: 54ch;
    }

    .contact-wrap {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 1rem;
    }

    .map-box,
    .contact-form {
        background: #fff;
        border: 1px solid #e9ddcd;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 16px 30px rgba(12, 22, 32, 0.08);
    }

    .map-box iframe {
        border: 0;
        width: 100%;
        min-height: 100%;
        height: 100%;
    }

    .contact-form {
        padding: 1.2rem;
    }

    .form-grid {
        display: grid;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .form-grid input,
    .form-grid textarea {
        width: 100%;
        border: 1px solid #ddd0be;
        border-radius: 12px;
        padding: 0.85rem 0.9rem;
        font: inherit;
    }

    .form-grid input:focus,
    .form-grid textarea:focus {
        outline: none;
        border-color: #b68b52;
        box-shadow: 0 0 0 3px rgba(182, 139, 82, 0.16);
    }

    .form-grid textarea {
        min-height: 120px;
        resize: vertical;
    }

    .contact-note {
        margin-top: 0.75rem;
        font-size: 0.86rem;
        color: #6c7d8d;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.7rem;
        margin-top: 1.5rem;
    }

    .stat {
        background: #fff;
        border: 1px solid #ebdecd;
        border-radius: 14px;
        padding: 0.95rem 1rem;
    }

    .stat strong {
        display: block;
        font-size: 1.45rem;
        color: #1f2a3a;
    }

    .stat span {
        font-size: 0.84rem;
        color: #687a8b;
    }

    @media (max-width: 1080px) {
        .booking-panel {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .rooms-grid,
        .reviews-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .facilities-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .gallery-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            grid-auto-rows: 200px;
        }

        .gallery-item:nth-child(1) {
            grid-row: span 1;
        }

        .contact-wrap {
            grid-template-columns: 1fr;
        }

        .map-box {
            min-height: 320px;
        }
    }

    @media (max-width: 720px) {
        .hero {
            min-height: 78vh;
            margin-bottom: 5.2rem;
        }

        .hero-wrap {
            padding-top: 7rem;
        }

        .booking-panel {
            grid-template-columns: 1fr;
        }

        .rooms-grid,
        .reviews-grid,
        .facilities-grid,
        .stats,
        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .offer {
            flex-direction: column;
            align-items: flex-start;
            padding: 1.6rem;
        }
    }
</style>
@endsection

@section('content')
@php
    $roomFallbackImages = [
        'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=80',
        'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1000&q=80',
    ];
@endphp

<section class="hero">
    <div class="hero-wrap">
        <div class="hero-chip">
            <i class="bi bi-stars"></i>
            Premium Seaside Hospitality
        </div>
        <h1>Stay In The Heart Of Refined Comfort</h1>
        <p>
            Reserve curated rooms, premium amenities, and tailored experiences in one elegant destination.
            Crafted for business trips, romantic escapes, and memorable family stays.
        </p>

        <form method="GET" action="{{ route('user.home') }}" class="booking-panel reveal" id="booking">
            <div class="field">
                <label for="search">Destination Or Hotel</label>
                <input id="search" type="text" name="search" placeholder="Phnom Penh, Riverside, Deluxe Suite" value="{{ $search }}">
            </div>
            <div class="field">
                <label for="checkin">Check In</label>
                <input id="checkin" type="date" name="check_in" value="{{ request('check_in') }}">
            </div>
            <div class="field">
                <label for="checkout">Check Out</label>
                <input id="checkout" type="date" name="check_out" value="{{ request('check_out') }}">
            </div>
            <div class="field">
                <label for="guests">Guests</label>
                <select id="guests" name="guests">
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ (int) request('guests', 2) === $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                    @endfor
                </select>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
    </div>
</section>

<section class="section" id="rooms">
    <div class="container">
        <div class="section-head reveal">
            <div>
                <div class="section-label">Featured Rooms</div>
                <h2>Choose Your Luxury Stay</h2>
            </div>
            <p>Modern suites, serene interiors, and exceptional service across every booking.</p>
        </div>

        <div class="rooms-grid">
            @forelse ($featuredHotels as $index => $hotel)
                @php
                    $imageUrl = $hotel->image ?: $roomFallbackImages[$index % count($roomFallbackImages)];
                @endphp
                <article class="room-card reveal">
                    <div class="room-image">
                        <img src="{{ $imageUrl }}" alt="{{ $hotel->name }}">
                    </div>
                    <div class="room-content">
                        <div class="room-top">
                            <div>
                                <h3 class="room-name">{{ $hotel->name }}</h3>
                                <div class="room-location"><i class="bi bi-geo-alt"></i> {{ $hotel->location }}</div>
                            </div>
                            <div class="room-price">
                                <strong>${{ number_format((float) $hotel->price_per_night, 0) }}</strong>
                                <span>per night</span>
                            </div>
                        </div>
                        <div class="room-meta">
                            <span><i class="bi bi-door-open"></i> {{ $hotel->room_count }} rooms</span>
                            <span><i class="bi bi-award"></i> Premium</span>
                        </div>
                        <div class="room-actions">
                            <a href="{{ route('user.hotels.show', $hotel) }}" class="btn btn-soft">Details</a>
                            @auth
                                <a href="{{ route('user.bookings.create', $hotel) }}" class="btn btn-primary">Book</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Book</a>
                            @endauth
                        </div>
                    </div>
                </article>
            @empty
                @for ($i = 0; $i < 3; $i++)
                    <article class="room-card reveal">
                        <div class="room-image">
                            <img src="{{ $roomFallbackImages[$i] }}" alt="Luxury suite">
                        </div>
                        <div class="room-content">
                            <div class="room-top">
                                <div>
                                    <h3 class="room-name">Executive Suite {{ $i + 1 }}</h3>
                                    <div class="room-location"><i class="bi bi-geo-alt"></i> Riverside District</div>
                                </div>
                                <div class="room-price">
                                    <strong>$180</strong>
                                    <span>per night</span>
                                </div>
                            </div>
                            <div class="room-meta">
                                <span><i class="bi bi-door-open"></i> 2 beds</span>
                                <span><i class="bi bi-award"></i> Signature</span>
                            </div>
                            <div class="room-actions">
                                <a href="#contact" class="btn btn-soft">Details</a>
                                <a href="{{ route('register') }}" class="btn btn-primary">Book</a>
                            </div>
                        </div>
                    </article>
                @endfor
            @endforelse
        </div>

        <div class="stats reveal">
            <div class="stat">
                <strong>{{ $hotels->total() }}</strong>
                <span>Available Rooms</span>
            </div>
            <div class="stat">
                <strong>24/7</strong>
                <span>Concierge Service</span>
            </div>
            <div class="stat">
                <strong>4.9/5</strong>
                <span>Guest Rating</span>
            </div>
            <div class="stat">
                <strong>15%</strong>
                <span>Member Savings</span>
            </div>
        </div>
    </div>
</section>

<section class="section" id="facilities">
    <div class="container">
        <div class="soft-wrap reveal">
            <div class="section-label">Facilities</div>
            <h2 style="margin-bottom: 0.45rem;">Everything You Need For A Perfect Stay</h2>
            <p>Enjoy curated amenities designed for comfort, wellness, and productivity.</p>

            <div class="facilities-grid">
                <div class="facility"><i class="bi bi-wifi"></i><span>High-Speed WiFi</span></div>
                <div class="facility"><i class="bi bi-water"></i><span>Infinity Pool</span></div>
                <div class="facility"><i class="bi bi-flower1"></i><span>Luxury Spa</span></div>
                <div class="facility"><i class="bi bi-cup-hot"></i><span>Fine Restaurant</span></div>
                <div class="facility"><i class="bi bi-activity"></i><span>Fitness Gym</span></div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="reviews">
    <div class="container">
        <div class="section-head reveal">
            <div>
                <div class="section-label">Testimonials</div>
                <h2>What Guests Say</h2>
            </div>
            <p>Real experiences from travelers who stayed with us recently.</p>
        </div>

        <div class="reviews-grid">
            <article class="review-card reveal">
                <div class="review-stars">?????</div>
                <p class="review-text">The room design, pool atmosphere, and team service were exceptional. Check-in was smooth and elegant.</p>
                <div class="review-author">
                    <div>
                        <strong>Emma Chen</strong>
                        <small>Singapore</small>
                    </div>
                    <i class="bi bi-patch-check-fill" style="color:#b68b52;"></i>
                </div>
            </article>
            <article class="review-card reveal">
                <div class="review-stars">?????</div>
                <p class="review-text">Perfect for business travel. Fast WiFi, quiet rooms, and excellent dining made my stay productive and relaxing.</p>
                <div class="review-author">
                    <div>
                        <strong>Daniel Park</strong>
                        <small>Seoul</small>
                    </div>
                    <i class="bi bi-patch-check-fill" style="color:#b68b52;"></i>
                </div>
            </article>
            <article class="review-card reveal">
                <div class="review-stars">?????</div>
                <p class="review-text">The spa and skyline view were unforgettable. This is now my first choice whenever I visit Phnom Penh.</p>
                <div class="review-author">
                    <div>
                        <strong>Sophia Laurent</strong>
                        <small>Paris</small>
                    </div>
                    <i class="bi bi-patch-check-fill" style="color:#b68b52;"></i>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="section" id="gallery">
    <div class="container">
        <div class="section-head reveal">
            <div>
                <div class="section-label">Gallery</div>
                <h2>Luxury Moments In Every Corner</h2>
            </div>
            <p>Explore spaces designed to inspire rest, connection, and unforgettable memories.</p>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item reveal"><img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1300&q=80" alt="Hotel pool"></div>
            <div class="gallery-item reveal"><img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1300&q=80" alt="Hotel lounge"></div>
            <div class="gallery-item reveal"><img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1300&q=80" alt="Restaurant"></div>
            <div class="gallery-item reveal"><img src="https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1300&q=80" alt="Suite bedroom"></div>
            <div class="gallery-item reveal"><img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1300&q=80" alt="Premium room"></div>
        </div>
    </div>
</section>

<section class="container">
    <div class="offer reveal">
        <div>
            <h3>Special Offer: Save Up To 30%</h3>
            <p>Book 3 nights or more and enjoy complimentary breakfast, late checkout, and exclusive spa credit.</p>
        </div>
        @auth
            <a href="{{ route('user.bookings.index') }}" class="btn btn-primary">Claim Offer</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-primary">Claim Offer</a>
        @endauth
    </div>
</section>

<section class="section" id="contact">
    <div class="container">
        <div class="section-head reveal">
            <div>
                <div class="section-label">Contact</div>
                <h2>Plan Your Next Stay</h2>
            </div>
            <p>Talk to our team for group bookings, events, or custom stay arrangements.</p>
        </div>

        <div class="contact-wrap">
            <div class="map-box reveal">
                <iframe
                    loading="lazy"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=104.907%2C11.534%2C104.94%2C11.565&layer=mapnik"
                    title="Hotel location map">
                </iframe>
            </div>
            <div class="contact-form reveal">
                <h3 style="font-size:1.18rem;">Send Us A Message</h3>
                <form class="form-grid" id="contactForm">
                    <input type="text" placeholder="Full name" required>
                    <input type="email" placeholder="Email address" required>
                    <input type="tel" placeholder="Phone number">
                    <textarea placeholder="Tell us about your stay requirements" required></textarea>
                    <button class="btn btn-primary" type="submit">Send Message</button>
                </form>
                <p class="contact-note" id="contactNote">We usually respond within 24 hours.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const checkIn = document.getElementById('checkin');
    const checkOut = document.getElementById('checkout');

    if (checkIn && checkOut) {
        const today = new Date().toISOString().split('T')[0];
        checkIn.min = today;

        const syncCheckout = () => {
            checkOut.min = checkIn.value || today;
            if (checkOut.value && checkIn.value && checkOut.value <= checkIn.value) {
                const nextDay = new Date(checkIn.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOut.value = nextDay.toISOString().split('T')[0];
            }
        };

        checkIn.addEventListener('change', syncCheckout);
        syncCheckout();
    }

    const contactForm = document.getElementById('contactForm');
    const contactNote = document.getElementById('contactNote');

    if (contactForm && contactNote) {
        contactForm.addEventListener('submit', (event) => {
            event.preventDefault();
            contactNote.textContent = 'Thank you. Your message has been sent successfully.';
            contactNote.style.color = '#2f6f46';
            contactForm.reset();
        });
    }
</script>
@endpush

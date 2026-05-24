@extends('user.layout')

@section('title', $hotel->name . ' | Room Details')

@section('extra_css')
<style>
    .detail-shell {
        width: min(1120px, calc(100% - 2rem));
        margin: 2rem auto 0;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #eadfce;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 22px 38px rgba(10, 20, 32, 0.1);
    }

    .detail-image {
        position: relative;
        aspect-ratio: 16 / 7;
    }

    .detail-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(10, 16, 22, 0.05), rgba(10, 16, 22, 0.62));
    }

    .detail-head {
        position: absolute;
        left: 1.4rem;
        right: 1.4rem;
        bottom: 1.2rem;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: end;
        color: #fff;
    }

    .detail-head h1 {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(2rem, 4.2vw, 3.2rem);
        line-height: 0.95;
        margin-bottom: 0.35rem;
    }

    .detail-price strong {
        font-size: 2rem;
        color: #f2d2a0;
    }

    .detail-price span {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.84);
    }

    .detail-body {
        padding: 1.5rem;
        display: grid;
        gap: 1.25rem;
    }

    .detail-text {
        color: #4f6172;
        line-height: 1.75;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.75rem;
    }

    .meta-card {
        background: #fdf9f3;
        border: 1px solid #ecdfcf;
        border-radius: 14px;
        padding: 0.8rem;
    }

    .meta-card i {
        color: #b68b52;
        margin-right: 0.3rem;
    }

    .meta-card strong {
        display: block;
        font-size: 1.15rem;
        color: #1f2a3a;
    }

    .meta-card span {
        font-size: 0.82rem;
        color: #627383;
    }

    .detail-actions {
        display: flex;
        gap: 0.7rem;
        flex-wrap: wrap;
    }

    @media (max-width: 780px) {
        .detail-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .meta-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 520px) {
        .meta-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="detail-shell">
    <article class="detail-card reveal">
        <div class="detail-image">
            <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1400&q=80' }}" alt="{{ $hotel->name }}">
            <div class="detail-head">
                <div>
                    <h1>{{ $hotel->name }}</h1>
                    <p><i class="bi bi-geo-alt"></i> {{ $hotel->location }}</p>
                </div>
                <div class="detail-price">
                    <strong>${{ number_format((float) $hotel->price_per_night, 0) }}</strong>
                    <span>per night</span>
                </div>
            </div>
        </div>

        <div class="detail-body">
            <p class="detail-text">{{ $hotel->description ?: 'Enjoy elegant interiors, attentive hospitality, and premium amenities in this carefully designed room.' }}</p>

            <div class="meta-grid">
                <div class="meta-card">
                    <strong><i class="bi bi-door-open"></i>{{ $hotel->room_count }}</strong>
                    <span>Total rooms available</span>
                </div>
                <div class="meta-card">
                    <strong><i class="bi bi-wifi"></i>24/7</strong>
                    <span>High-speed internet</span>
                </div>
                <div class="meta-card">
                    <strong><i class="bi bi-cup-hot"></i>Included</strong>
                    <span>Breakfast service</span>
                </div>
                <div class="meta-card">
                    <strong><i class="bi bi-shield-check"></i>Secure</strong>
                    <span>Safe booking process</span>
                </div>
            </div>

            <div class="detail-actions">
                @auth
                    <a href="{{ route('user.bookings.create', $hotel) }}" class="btn btn-primary">Book This Room</a>
                    <a href="{{ route('user.bookings.index') }}" class="btn btn-soft">My Bookings</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login To Book</a>
                    <a href="{{ route('register') }}" class="btn btn-soft">Create Account</a>
                @endauth
                <a href="{{ route('user.home') }}#rooms" class="btn btn-soft">Back To Rooms</a>
            </div>
        </div>
    </article>
</div>
@endsection

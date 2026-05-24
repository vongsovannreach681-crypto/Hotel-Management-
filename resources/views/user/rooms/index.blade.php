@extends('user.layout')

@section('title', 'Rooms')

@section('extra_css')
<style>
    .rooms-shell { width: min(1180px, calc(100% - 2rem)); margin: 2rem auto 0; }
    .rooms-hero { background: linear-gradient(135deg, #fffaf3, #fff); border: 1px solid #eadfce; border-radius: 20px; padding: 1.4rem; box-shadow: 0 16px 30px rgba(16, 27, 40, 0.07); }
    .rooms-hero h1 { font-size: clamp(1.5rem, 2.2vw, 2.1rem); margin-bottom: 0.3rem; }
    .rooms-hero p { color: #5f7082; }
    .stats { margin-top: 1rem; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.7rem; }
    .stat { background: #fff; border: 1px solid #e6d8c3; border-radius: 14px; padding: 0.8rem; }
    .stat strong { display: block; font-size: 1.3rem; line-height: 1.1; }
    .stat span { color: #6a7a8a; font-size: 0.84rem; }

    .filter-panel { margin-top: 1rem; background: #fff; border: 1px solid #eadfce; border-radius: 18px; padding: 1rem; box-shadow: 0 14px 26px rgba(16, 27, 40, 0.06); }
    .filter-form { display: grid; grid-template-columns: 1.4fr 0.9fr 0.9fr 0.8fr auto auto; gap: 0.65rem; align-items: end; }
    .field { display: grid; gap: 0.34rem; }
    .field label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: #6f8192; font-weight: 700; }
    .field input, .field select { width: 100%; border: 1px solid #ddcfbd; border-radius: 12px; padding: 0.76rem 0.8rem; font: inherit; background: #fff; }
    .field input:focus, .field select:focus { outline: none; border-color: #b68b52; box-shadow: 0 0 0 3px rgba(182, 139, 82, 0.16); }
    .status-pills { margin-top: 0.9rem; display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .pill { border: 1px solid #ddcfbd; color: #4f6072; background: #fffdf9; border-radius: 999px; padding: 0.4rem 0.85rem; font-size: 0.84rem; font-weight: 600; }
    .pill.active { background: #294460; border-color: #294460; color: #fff; }

    .room-grid { margin-top: 1.2rem; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
    .room-card { border-radius: 18px; overflow: hidden; border: 1px solid #e6d9c8; background: #fff; box-shadow: 0 14px 28px rgba(19, 30, 44, 0.08); display: grid; }
    .room-media { position: relative; aspect-ratio: 16 / 11; overflow: hidden; }
    .room-media img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s ease; }
    .room-card:hover .room-media img { transform: scale(1.03); }
    .status-tag { position: absolute; top: 0.7rem; left: 0.7rem; border-radius: 999px; padding: 0.3rem 0.65rem; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
    .status-available { background: #e7f7ed; color: #1e7a41; }
    .status-booked { background: #fef0ea; color: #a14124; }
    .status-maintenance { background: #fff7de; color: #8e6b18; }
    .room-body { padding: 0.9rem; display: grid; gap: 0.65rem; }
    .room-title { display: flex; justify-content: space-between; align-items: start; gap: 0.6rem; }
    .room-title h2 { font-size: 1.03rem; line-height: 1.2; }
    .room-price { color: #b68b52; font-weight: 700; white-space: nowrap; }
    .room-meta { color: #607286; font-size: 0.85rem; display: flex; gap: 0.65rem; flex-wrap: wrap; }
    .room-desc { color: #5f7184; font-size: 0.87rem; line-height: 1.55; min-height: 2.8em; }
    .room-actions { display: flex; gap: 0.55rem; flex-wrap: wrap; }
    .room-actions .btn { padding: 0.72rem 1rem; font-size: 0.85rem; }
    .empty { margin-top: 1.1rem; text-align: center; border: 1px dashed #d8c8b0; background: #fffaf2; border-radius: 16px; padding: 1.6rem; color: #677889; }
    .pagination-wrap { margin-top: 1rem; display: flex; justify-content: center; }

    @media (max-width: 1050px) {
        .filter-form { grid-template-columns: 1fr 1fr 1fr; }
        .room-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 700px) {
        .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .filter-form { grid-template-columns: 1fr; }
        .room-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="rooms-shell">
    <section class="rooms-hero reveal">
        <h1>Discover Our Rooms</h1>
        <p>Browse every room in one place, then search and filter to find the best match for your stay.</p>
        <div class="stats">
            <div class="stat"><strong>{{ $summary['all'] }}</strong><span>Total Rooms</span></div>
            <div class="stat"><strong>{{ $summary['available'] }}</strong><span>Available</span></div>
            <div class="stat"><strong>{{ $summary['booked'] }}</strong><span>Booked</span></div>
            <div class="stat"><strong>{{ $summary['maintenance'] }}</strong><span>Maintenance</span></div>
        </div>
    </section>

    <section class="filter-panel reveal">
        <form method="GET" action="{{ route('user.rooms.index') }}" class="filter-form">
            <div class="field">
                <label for="search">Search</label>
                <input id="search" type="text" name="search" value="{{ $search }}" placeholder="Search room name, location, or description">
            </div>
            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="booked" {{ $status === 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="maintenance" {{ $status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="field">
                <label for="location">Location</label>
                <select id="location" name="location">
                    <option value="all" {{ $location === 'all' ? 'selected' : '' }}>All Locations</option>
                    @foreach ($locations as $locationOption)
                        <option value="{{ $locationOption }}" {{ $location === $locationOption ? 'selected' : '' }}>{{ $locationOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="sort">Sort By</label>
                <select id="sort" name="sort">
                    <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="popular" {{ $sortBy === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="price_low" {{ $sortBy === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ $sortBy === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
            <a href="{{ route('user.rooms.index') }}" class="btn btn-soft">Reset</a>
        </form>

        <div class="status-pills">
            <a href="{{ route('user.rooms.index', array_merge(request()->except('page'), ['status' => 'all'])) }}" class="pill {{ $status === 'all' ? 'active' : '' }}">All ({{ $summary['all'] }})</a>
            <a href="{{ route('user.rooms.index', array_merge(request()->except('page'), ['status' => 'available'])) }}" class="pill {{ $status === 'available' ? 'active' : '' }}">Available ({{ $summary['available'] }})</a>
            <a href="{{ route('user.rooms.index', array_merge(request()->except('page'), ['status' => 'booked'])) }}" class="pill {{ $status === 'booked' ? 'active' : '' }}">Booked ({{ $summary['booked'] }})</a>
            <a href="{{ route('user.rooms.index', array_merge(request()->except('page'), ['status' => 'maintenance'])) }}" class="pill {{ $status === 'maintenance' ? 'active' : '' }}">Maintenance ({{ $summary['maintenance'] }})</a>
        </div>
    </section>

    @if ($hotels->count() > 0)
        <section class="room-grid">
            @foreach ($hotels as $hotel)
                <article class="room-card reveal">
                    <div class="room-media">
                        <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $hotel->name }}">
                        <span class="status-tag status-{{ $hotel->status }}">{{ ucfirst($hotel->status) }}</span>
                    </div>
                    <div class="room-body">
                        <div class="room-title">
                            <h2>{{ $hotel->name }}</h2>
                            <div class="room-price">${{ number_format((float) $hotel->price_per_night, 2) }}/night</div>
                        </div>
                        <div class="room-meta">
                            <span><i class="bi bi-geo-alt"></i> {{ $hotel->location }}</span>
                            <span><i class="bi bi-door-open"></i> {{ $hotel->room_count }} rooms</span>
                        </div>
                        <p class="room-desc">{{ \Illuminate\Support\Str::limit($hotel->description ?: 'Designed for comfort with curated amenities and elegant details throughout your stay.', 120) }}</p>
                        <div class="room-actions">
                            @if ($hotel->status === 'available')
                                <a href="{{ route('user.hotels.show', $hotel) }}" class="btn btn-soft">Details</a>
                                @auth
                                    <a href="{{ route('user.bookings.create', $hotel) }}" class="btn btn-primary">Book Now</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login To Book</a>
                                @endauth
                            @else
                                <span class="btn btn-soft">Not Available</span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="pagination-wrap">
            {{ $hotels->links() }}
        </div>
    @else
        <div class="empty reveal">
            <h3 style="margin-bottom: 0.4rem;">No rooms matched your filters</h3>
            <p style="margin-bottom: 0.85rem;">Try adjusting status, location, or search keywords.</p>
            <a href="{{ route('user.rooms.index') }}" class="btn btn-primary">Clear Filters</a>
        </div>
    @endif
</div>
@endsection

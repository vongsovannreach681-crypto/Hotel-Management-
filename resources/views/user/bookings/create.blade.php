@extends('user.layout')

@section('title', 'Book ' . $hotel->name)

@section('extra_css')
<style>
    .shell { width:min(960px, calc(100% - 2rem)); margin:2rem auto 0; }
    .grid { display:grid; grid-template-columns:1fr 0.9fr; gap:1rem; }
    .card { background:#fff; border:1px solid #eadfce; border-radius:18px; box-shadow:0 18px 30px rgba(11,20,31,0.08); overflow:hidden; }
    .img-wrap { aspect-ratio:16/10; }
    .img-wrap img { width:100%; height:100%; object-fit:cover; }
    .pad { padding:1rem; }
    h1 { font-family:'Poppins', sans-serif; font-size:2.4rem; line-height:0.95; margin-bottom:0.5rem; }
    .price { color:#b68b52; font-size:1.4rem; font-weight:700; }
    .form { display:grid; gap:0.8rem; }
    .field { display:grid; gap:0.38rem; }
    .field label { font-size:0.8rem; font-weight:700; color:#637484; text-transform:uppercase; letter-spacing:0.08em; }
    .field input, .field textarea, .field select { border:1px solid #ddcfbd; border-radius:12px; padding:0.8rem; font:inherit; }
    .field input:focus, .field textarea:focus, .field select:focus { outline:none; border-color:#b68b52; box-shadow:0 0 0 3px rgba(182,139,82,.16); }
    .field textarea { min-height:100px; resize:vertical; }
    .note { color:#617282; font-size:0.87rem; }
    .error { color:#9a3528; font-size:0.82rem; }

    @media (max-width: 780px) {
        .grid { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
<div class="shell">
    <div class="grid">
        <article class="card reveal">
            <div class="img-wrap">
                <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $hotel->name }}">
            </div>
            <div class="pad">
                <h1>{{ $hotel->name }}</h1>
                <p style="color:#5e7081;"><i class="bi bi-geo-alt"></i> {{ $hotel->location }}</p>
                <p class="price">${{ number_format((float) $hotel->price_per_night, 2) }} <span style="font-size:0.82rem; color:#6f8090;">per night</span></p>
                <p class="note">You are making a reservation request. Your booking will be created with pending status.</p>
            </div>
        </article>

        <article class="card pad reveal">
            <h2 style="font-size:1.2rem; margin-bottom:0.9rem;">Booking Details</h2>
            <form class="form" method="POST" action="{{ route('user.bookings.store', $hotel) }}" id="bookingForm">
                @csrf
                <div class="field">
                    <label for="check_in_date">Check In</label>
                    <input id="check_in_date" type="date" name="check_in_date" value="{{ old('check_in_date') }}" required>
                    @error('check_in_date') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="check_out_date">Check Out</label>
                    <input id="check_out_date" type="date" name="check_out_date" value="{{ old('check_out_date') }}" required>
                    @error('check_out_date') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="guests">Guests</label>
                    <select id="guests" name="guests" required>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ (int) old('guests', 2) === $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                        @endfor
                    </select>
                    @error('guests') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" placeholder="Special requests, arrival time, or preferences">{{ old('notes') }}</textarea>
                    @error('notes') <p class="error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Confirm Booking Request</button>
                <a href="{{ route('user.hotels.show', $hotel) }}" class="btn btn-soft">Back</a>
            </form>
        </article>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const checkIn = document.getElementById('check_in_date');
    const checkOut = document.getElementById('check_out_date');

    if (checkIn && checkOut) {
        const today = new Date().toISOString().split('T')[0];
        checkIn.min = today;

        const syncDates = () => {
            checkOut.min = checkIn.value || today;
            if (checkOut.value && checkIn.value && checkOut.value <= checkIn.value) {
                const next = new Date(checkIn.value);
                next.setDate(next.getDate() + 1);
                checkOut.value = next.toISOString().split('T')[0];
            }
        };

        checkIn.addEventListener('change', syncDates);
        syncDates();
    }
</script>
@endpush

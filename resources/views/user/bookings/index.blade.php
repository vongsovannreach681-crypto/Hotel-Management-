@extends('user.layout')

@section('title', 'My Bookings')

@section('extra_css')
<style>
    .wrap { width: min(1120px, calc(100% - 2rem)); margin: 2rem auto 0; }
    .head { display:flex; justify-content:space-between; align-items:end; gap:1rem; margin-bottom:1.1rem; }
    .head h1 { font-family:'Poppins', sans-serif; font-size:2.5rem; line-height:0.95; }
    .summary { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:0.75rem; margin-bottom:1rem; }
    .box { background:#fff; border:1px solid #ebdfcf; border-radius:14px; padding:0.9rem; }
    .box strong { display:block; font-size:1.35rem; color:#1f2a3a; }
    .box span { font-size:0.82rem; color:#6b7c8d; }
    .filters { display:flex; gap:0.55rem; flex-wrap:wrap; margin-bottom:1rem; }
    .pill { padding:0.55rem 0.9rem; border-radius:999px; border:1px solid #dfd1be; background:#fff; color:#314355; font-size:0.84rem; }
    .pill.active { background:#1f2a3a; color:#fff; border-color:#1f2a3a; }
    .list { display:grid; gap:0.8rem; }
    .card { background:#fff; border:1px solid #e9dece; border-radius:16px; padding:1rem; display:grid; gap:0.7rem; }
    .top { display:flex; justify-content:space-between; gap:0.8rem; flex-wrap:wrap; }
    .code { font-weight:700; color:#1f2a3a; }
    .meta { color:#5e7080; font-size:0.88rem; display:flex; flex-wrap:wrap; gap:0.8rem; }
    .status { padding:0.3rem 0.62rem; border-radius:999px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; }
    .pending { background:#fff6dd; color:#87600f; }
    .confirmed { background:#eaf7ee; color:#216442; }
    .checked_in { background:#e8f2ff; color:#255ea8; }
    .checked_out { background:#edf0f3; color:#4c5f71; }
    .cancelled { background:#fdecec; color:#923b3b; }
    .actions { display:flex; gap:0.6rem; flex-wrap:wrap; }
    .empty { background:#fff; border:1px solid #eadfce; border-radius:16px; padding:2rem; text-align:center; color:#607282; }

    @media (max-width: 860px) {
        .summary { grid-template-columns:1fr 1fr; }
    }

    @media (max-width: 560px) {
        .summary { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
<div class="wrap">
    <div class="head reveal">
        <div>
            <p style="color:#b68b52; text-transform:uppercase; letter-spacing:0.08em; font-size:0.76rem; font-weight:700;">Account</p>
            <h1>My Bookings</h1>
        </div>
        <a href="{{ route('user.home') }}#rooms" class="btn btn-soft">Find More Rooms</a>
    </div>

    <div class="summary reveal">
        <div class="box"><strong>{{ $summary['all'] }}</strong><span>Total Bookings</span></div>
        <div class="box"><strong>{{ $summary['upcoming'] }}</strong><span>Upcoming</span></div>
        <div class="box"><strong>{{ $summary['active'] }}</strong><span>Active Stay</span></div>
        <div class="box"><strong>{{ $summary['past'] }}</strong><span>Past</span></div>
    </div>

    <div class="filters reveal">
        @php
            $filters = ['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'checked_in' => 'Checked In', 'checked_out' => 'Checked Out', 'cancelled' => 'Cancelled'];
        @endphp
        @foreach ($filters as $value => $label)
            <a class="pill {{ $filter === $value ? 'active' : '' }}" href="{{ route('user.bookings.index', ['filter' => $value]) }}">{{ $label }}</a>
        @endforeach
    </div>

    @if ($bookings->count() > 0)
        <div class="list">
            @foreach ($bookings as $booking)
                <article class="card reveal">
                    <div class="top">
                        <div>
                            <div class="code">{{ $booking->booking_no }}</div>
                            <div style="font-weight:600;">{{ $booking->hotel?->name ?? 'Hotel' }}</div>
                        </div>
                        <span class="status {{ $booking->status }}">{{ str_replace('_', ' ', $booking->status) }}</span>
                    </div>
                    <div class="meta">
                        <span><i class="bi bi-calendar-event"></i> {{ $booking->check_in_date->format('M d, Y') }} - {{ $booking->check_out_date->format('M d, Y') }}</span>
                        <span><i class="bi bi-people"></i> {{ $booking->guests }} guests</span>
                        <span><i class="bi bi-cash-stack"></i> ${{ number_format((float) $booking->total_price, 2) }}</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-soft">View</a>
                        @if (!in_array($booking->status, ['checked_in', 'checked_out', 'cancelled'], true))
                            <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Cancel</button>
                            </form>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <div style="margin-top:1rem;">{{ $bookings->withQueryString()->links() }}</div>
    @else
        <div class="empty reveal">
            <p style="margin-bottom:0.8rem;">No bookings found for this filter.</p>
            <a href="{{ route('user.home') }}#rooms" class="btn btn-primary">Book Your First Stay</a>
        </div>
    @endif
</div>
@endsection

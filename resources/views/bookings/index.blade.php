@extends('layouts.app')

@section('page_title', 'User Booking List')
@section('page_title_key', 'page.user_booking_list')

@section('topbar_search')
    <form method="GET" action="{{ route('bookings.index') }}" class="search-pill">
        <input type="hidden" name="filter" value="{{ $filter }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search booking number, guest, email" data-i18n-placeholder="booking.search_placeholder">
        <button type="submit">Q</button>
    </form>
@endsection

@section('toolbar')
    <div class="toolbar">
        <div class="panel" style="padding: 6px; display: inline-flex; gap: 4px; flex-wrap: wrap;">
            <a href="{{ route('bookings.index', ['filter' => 'all', 'search' => $search]) }}" class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="booking.all">All</span> ({{ $summary['all'] }})</a>
            <a href="{{ route('bookings.index', ['filter' => 'confirmed', 'search' => $search]) }}" class="btn {{ $filter === 'confirmed' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="booking.confirmed">Confirmed</span> ({{ $summary['confirmed'] }})</a>
            <a href="{{ route('bookings.index', ['filter' => 'pending', 'search' => $search]) }}" class="btn {{ $filter === 'pending' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="booking.pending">Pending</span> ({{ $summary['pending'] }})</a>
            <a href="{{ route('bookings.index', ['filter' => 'cancelled', 'search' => $search]) }}" class="btn {{ $filter === 'cancelled' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="booking.cancelled">Cancelled</span> ({{ $summary['cancelled'] }})</a>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('bookings.index') }}" class="btn btn-muted" data-i18n="room.reset">Reset</a>
            <a href="{{ route('bookings.create') }}" class="btn btn-primary">+ Add Booking</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="panel" style="overflow: hidden;">
        @if($bookings->isEmpty())
            <div style="padding: 36px; text-align: center; color: #8894ac;" data-i18n="booking.no_data">No booking records yet. Create some data in the bookings table to display user bookings.</div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 1100px;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e8edf5; color: #8c97ad; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.4px;">
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.booking_no">Booking No</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.guest">Guest</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.room">Room</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.check_in">Check In</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.check_out">Check Out</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.guests">Guests</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.total_price">Total Price</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="booking.status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr style="border-bottom: 1px solid #eef2f8;">
                                <td style="padding: 14px 16px; color: #2b5fe0; font-weight: 600;">{{ $booking->booking_no }}</td>
                                <td style="padding: 14px 16px;">
                                    <div style="font-weight: 600; color: #22314f;">{{ $booking->guest_name }}</div>
                                    <div style="font-size: 0.8rem; color: #8f9cb3;">{{ $booking->guest_email }}</div>
                                    @if($booking->user)
                                        <div style="font-size: 0.72rem; color: #6f7f9f; margin-top: 2px;">User: {{ $booking->user->name }}</div>
                                    @endif
                                </td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $booking->hotel->name ?? 'N/A' }}</td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $booking->check_in_date->format('d M Y') }}</td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $booking->check_out_date->format('d M Y') }}</td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $booking->guests }}</td>
                                <td style="padding: 14px 16px; color: #22314f; font-weight: 600;">${{ number_format((float) $booking->total_price, 2) }}</td>
                                <td style="padding: 14px 16px;">
                                    <span class="status-badge status-{{ $booking->status }}">
                                        <span class="status-dot"></span>
                                        {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding: 16px; display: flex; justify-content: space-between; align-items: center; color: #8a96ad; font-size: 0.84rem; gap: 12px; flex-wrap: wrap;">
                <div>
                    <span data-i18n="booking.showing">Showing</span> {{ $bookings->firstItem() ?? 0 }} <span data-i18n="booking.to">to</span> {{ $bookings->lastItem() ?? 0 }} <span data-i18n="booking.from">from</span> {{ $bookings->total() }} <span data-i18n="booking.bookings">bookings</span>
                </div>
                <div>
                    {{ $bookings->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

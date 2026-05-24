@extends('layouts.app')

@section('page_title', 'Dashboard Overview')
@section('page_title_key', 'page.dashboard_overview')

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px;">
        <div class="panel card" style="padding: 16px;">
            <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.total_rooms">Total Rooms</div>
            <div style="font-size: 1.7rem; font-weight: 700; margin-top: 6px;">{{ $totalRooms }}</div>
        </div>
        <div class="panel card" style="padding: 16px;">
            <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.available_rooms">Available Rooms</div>
            <div style="font-size: 1.7rem; font-weight: 700; margin-top: 6px; color: #24bf64;">{{ $availableRooms }}</div>
        </div>
        <div class="panel card" style="padding: 16px;">
            <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.booked_rooms">Booked Rooms</div>
            <div style="font-size: 1.7rem; font-weight: 700; margin-top: 6px; color: #ff5f58;">{{ $bookedRooms }}</div>
        </div>
        <div class="panel card" style="padding: 16px;">
            <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.maintenance">Maintenance</div>
            <div style="font-size: 1.7rem; font-weight: 700; margin-top: 6px; color: #f6b73c;">{{ $maintenanceRooms }}</div>
        </div>
        <div class="panel card" style="padding: 16px;">
            <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.total_bookings">Total Bookings</div>
            <div style="font-size: 1.7rem; font-weight: 700; margin-top: 6px;">{{ $totalBookings }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">
        <div class="panel card">
            <div class="card-header" style="margin-bottom: 12px;">
                <h2><span data-i18n="dashboard.today_snapshot">Today Snapshot</span> ({{ $today->format('d M Y') }})</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 14px;">
                <div style="padding: 14px; border-radius: 12px; background: #f7faff; border: 1px solid #e4ecfb;">
                    <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.arrivals">Arrivals</div>
                    <div style="font-weight: 700; font-size: 1.4rem; margin-top: 5px;">{{ $todayArrivals }}</div>
                </div>
                <div style="padding: 14px; border-radius: 12px; background: #f7faff; border: 1px solid #e4ecfb;">
                    <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.departures">Departures</div>
                    <div style="font-weight: 700; font-size: 1.4rem; margin-top: 5px;">{{ $todayDepartures }}</div>
                </div>
                <div style="padding: 14px; border-radius: 12px; background: #f7faff; border: 1px solid #e4ecfb;">
                    <div class="small-text" style="margin-top: 0;" data-i18n="dashboard.active_stays">Active Stays</div>
                    <div style="font-weight: 700; font-size: 1.4rem; margin-top: 5px;">{{ $activeStays }}</div>
                </div>
            </div>

            <div style="padding: 14px; border-radius: 12px; background: linear-gradient(120deg, #1a6fff, #25b8ff); color: #fff;">
                <div style="font-size: 0.78rem; opacity: 0.9;" data-i18n="dashboard.month_revenue">This Month Revenue</div>
                <div style="font-size: 1.9rem; font-weight: 700; margin-top: 6px;">${{ number_format($monthlyRevenue, 2) }}</div>
            </div>
        </div>

        <div class="panel card">
            <div class="card-header" style="margin-bottom: 10px;">
                <h2 data-i18n="dashboard.room_utilization">Room Utilization</h2>
            </div>

            <div style="margin-bottom: 14px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.86rem; color: #586782;">
                    <span data-i18n="dashboard.occupied">Occupied</span>
                    <span>{{ $roomUtilization }}%</span>
                </div>
                <div style="height: 10px; border-radius: 99px; background: #eaf0fb; overflow: hidden;">
                    <div style="height: 100%; width: {{ $roomUtilization }}%; background: linear-gradient(110deg, #1a6fff, #25b8ff);"></div>
                </div>
            </div>

            <div style="display: grid; gap: 8px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.86rem;"><span data-i18n="room.available">Available</span><strong>{{ $availableRooms }}</strong></div>
                <div style="display: flex; justify-content: space-between; font-size: 0.86rem;"><span data-i18n="room.booked">Booked</span><strong>{{ $bookedRooms }}</strong></div>
                <div style="display: flex; justify-content: space-between; font-size: 0.86rem;"><span data-i18n="dashboard.maintenance">Maintenance</span><strong>{{ $maintenanceRooms }}</strong></div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">
        <div class="panel card">
            <div class="card-header" style="margin-bottom: 10px;">
                <h2 data-i18n="dashboard.booking_status">Booking Status</h2>
            </div>

            <div style="display: grid; gap: 8px;">
                @foreach($bookingSummary as $status => $count)
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f8; padding-bottom: 6px;">
                        <span class="status-badge status-{{ $status }}"><span class="status-dot"></span>{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel" style="overflow: hidden;">
            <div class="card-header" style="padding: 16px 16px 0;">
                <h2 data-i18n="dashboard.recent_bookings">Recent Bookings</h2>
                <a href="{{ route('bookings.index') }}" class="btn btn-muted" data-i18n="dashboard.view_all">View All</a>
            </div>

            <div style="overflow-x: auto; padding: 0 16px 16px;">
                <table style="width: 100%; border-collapse: collapse; min-width: 700px;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e8edf5; color: #8c97ad; font-size: 0.8rem; text-transform: uppercase;">
                            <th style="padding: 12px 8px; text-align: left;" data-i18n="dashboard.booking">Booking</th>
                            <th style="padding: 12px 8px; text-align: left;" data-i18n="dashboard.guest">Guest</th>
                            <th style="padding: 12px 8px; text-align: left;" data-i18n="dashboard.room">Room</th>
                            <th style="padding: 12px 8px; text-align: left;" data-i18n="dashboard.check_in">Check In</th>
                            <th style="padding: 12px 8px; text-align: left;" data-i18n="dashboard.status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr style="border-bottom: 1px solid #eef2f8;">
                                <td style="padding: 12px 8px; color: #2b5fe0; font-weight: 600;">{{ $booking->booking_no }}</td>
                                <td style="padding: 12px 8px;">
                                    <div style="font-weight: 600; color: #22314f;">{{ $booking->guest_name }}</div>
                                    <div style="font-size: 0.78rem; color: #8f9cb3;">{{ $booking->guest_email }}</div>
                                </td>
                                <td style="padding: 12px 8px;">{{ $booking->hotel->name ?? 'N/A' }}</td>
                                <td style="padding: 12px 8px;">{{ $booking->check_in_date->format('d M Y') }}</td>
                                <td style="padding: 12px 8px;">
                                    <span class="status-badge status-{{ $booking->status }}"><span class="status-dot"></span>{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 18px 8px; color: #8f9cb3; text-align: center;" data-i18n="dashboard.no_bookings_yet">No bookings yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

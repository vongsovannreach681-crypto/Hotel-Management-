<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalRooms = Hotel::count();
        $availableRooms = Hotel::where('status', 'available')->count();
        $bookedRooms = Hotel::where('status', 'booked')->count();
        $maintenanceRooms = Hotel::where('status', 'maintenance')->count();

        $totalBookings = Booking::count();
        $todayArrivals = Booking::whereDate('check_in_date', $today)->count();
        $todayDepartures = Booking::whereDate('check_out_date', $today)->count();
        $activeStays = Booking::whereDate('check_in_date', '<=', $today)
            ->whereDate('check_out_date', '>=', $today)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->count();

        $monthlyRevenue = (float) Booking::whereIn('status', ['confirmed', 'checked_in', 'checked_out'])
            ->whereYear('check_in_date', $today->year)
            ->whereMonth('check_in_date', $today->month)
            ->sum('total_price');

        $bookingSummary = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'checked_in' => Booking::where('status', 'checked_in')->count(),
            'checked_out' => Booking::where('status', 'checked_out')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        $recentBookings = Booking::with('hotel')
            ->latest()
            ->take(8)
            ->get();

        $roomUtilization = $totalRooms > 0 ? round(($bookedRooms / $totalRooms) * 100, 1) : 0;

        return view('dashboard.index', compact(
            'today',
            'totalRooms',
            'availableRooms',
            'bookedRooms',
            'maintenanceRooms',
            'totalBookings',
            'todayArrivals',
            'todayDepartures',
            'activeStays',
            'monthlyRevenue',
            'bookingSummary',
            'recentBookings',
            'roomUtilization'
        ));
    }
}

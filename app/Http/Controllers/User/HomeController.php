<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $search = trim((string) request('search', ''));
        $sortBy = request('sort', 'latest');

        $hotelsQuery = Hotel::where('status', 'available');

        if ($search !== '') {
            $hotelsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        match ($sortBy) {
            'price_low' => $hotelsQuery->orderBy('price_per_night', 'asc'),
            'price_high' => $hotelsQuery->orderBy('price_per_night', 'desc'),
            'popular' => $hotelsQuery->withCount('bookings')->orderByDesc('bookings_count'),
            default => $hotelsQuery->latest(),
        };

        $hotels = $hotelsQuery->paginate(12);
        $featuredHotels = Hotel::where('status', 'available')->inRandomOrder()->take(3)->get();

        return view('user.index', compact('hotels', 'featuredHotels', 'search', 'sortBy'));
    }

    public function rooms(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');
        $location = $request->query('location', 'all');
        $sortBy = $request->query('sort', 'latest');

        $hotelsQuery = Hotel::query();

        if ($search !== '') {
            $hotelsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (in_array($status, ['available', 'booked', 'maintenance'], true)) {
            $hotelsQuery->where('status', $status);
        } else {
            $status = 'all';
        }

        $locations = Hotel::query()
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        if ($location !== 'all' && $locations->contains($location)) {
            $hotelsQuery->where('location', $location);
        } else {
            $location = 'all';
        }

        match ($sortBy) {
            'price_low' => $hotelsQuery->orderBy('price_per_night', 'asc'),
            'price_high' => $hotelsQuery->orderBy('price_per_night', 'desc'),
            'name_asc' => $hotelsQuery->orderBy('name', 'asc'),
            'popular' => $hotelsQuery->withCount('bookings')->orderByDesc('bookings_count'),
            default => $hotelsQuery->latest(),
        };

        if (! in_array($sortBy, ['latest', 'price_low', 'price_high', 'name_asc', 'popular'], true)) {
            $sortBy = 'latest';
        }

        $hotels = $hotelsQuery->paginate(12)->withQueryString();

        $summary = [
            'all' => Hotel::count(),
            'available' => Hotel::where('status', 'available')->count(),
            'booked' => Hotel::where('status', 'booked')->count(),
            'maintenance' => Hotel::where('status', 'maintenance')->count(),
        ];

        return view('user.rooms.index', compact(
            'hotels',
            'search',
            'status',
            'location',
            'sortBy',
            'locations',
            'summary'
        ));
    }

    public function show(Hotel $hotel)
    {
        if ($hotel->status !== 'available') {
            return redirect()->route('user.home')->with('error', 'This hotel is not available.');
        }

        return view('user.show', compact('hotel'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');
        $search = trim((string) request('search', ''));

        $hotelsQuery = Hotel::query()->latest();

        if (in_array($filter, ['available', 'booked', 'maintenance'], true)) {
            $hotelsQuery->where('status', $filter);
        }

        if ($search !== '') {
            $hotelsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $hotels = $hotelsQuery->paginate(10)->withQueryString();

        $summary = [
            'all' => Hotel::count(),
            'available' => Hotel::where('status', 'available')->count(),
            'booked' => Hotel::where('status', 'booked')->count(),
            'maintenance' => Hotel::where('status', 'maintenance')->count(),
        ];

        return view('hotels.index', compact('hotels', 'summary', 'filter', 'search'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'room_count' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|string|max:2048',
            'status' => 'required|in:available,booked,maintenance',
            'available' => 'sometimes|boolean',
        ]);

        $data['available'] = $request->has('available');
        $data['image'] = $this->normalizeImageUrl($request->input('image'));

        Hotel::create($data);

        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'room_count' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|string|max:2048',
            'status' => 'required|in:available,booked,maintenance',
            'available' => 'sometimes|boolean',
        ]);

        $data['available'] = $request->has('available');
        if ($request->filled('image')) {
            $data['image'] = $this->normalizeImageUrl($request->input('image'));
        } else {
            unset($data['image']);
        }

        $hotel->update($data);

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }

    private function normalizeImageUrl(?string $image): ?string
    {
        $image = trim((string) $image);
        if ($image === '') {
            return null;
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return 'https://' . ltrim($image, '/');
    }
}

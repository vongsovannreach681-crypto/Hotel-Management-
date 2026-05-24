<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');
        $search = trim((string) request('search', ''));

        $bookingsQuery = Booking::with(['hotel', 'user'])->latest();

        if (in_array($filter, ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'], true)) {
            $bookingsQuery->where('status', $filter);
        }

        if ($search !== '') {
            $bookingsQuery->where(function ($query) use ($search) {
                $query->where('booking_no', 'like', "%{$search}%")
                    ->orWhere('guest_name', 'like', "%{$search}%")
                    ->orWhere('guest_email', 'like', "%{$search}%")
                    ->orWhereHas('hotel', function ($hotelQuery) use ($search) {
                        $hotelQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $bookingsQuery->paginate(10)->withQueryString();

        $summary = [
            'all' => Booking::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('bookings.index', compact('bookings', 'summary', 'filter', 'search'));
    }

    public function create()
    {
        $hotels = Hotel::orderBy('name')->get(['id', 'name', 'price_per_night']);
        return view('bookings.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:20',
            'total_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
            'notes' => 'nullable|string|max:2000',
        ]);

        $hotel = Hotel::findOrFail($data['hotel_id']);
        $checkIn = Carbon::parse($data['check_in_date']);
        $checkOut = Carbon::parse($data['check_out_date']);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $data['booking_no'] = $this->generateBookingNo();
        $data['user_id'] = null;
        $data['total_price'] = $request->filled('total_price')
            ? $data['total_price']
            : (float) $hotel->price_per_night * $nights;

        Booking::create($data);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    private function generateBookingNo(): string
    {
        do {
            $candidate = 'BK-' . now()->format('Ymd') . '-' . random_int(1000, 9999);
        } while (Booking::where('booking_no', $candidate)->exists());

        return $candidate;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'all');
        $search = trim((string) request('search', ''));

        $guestsQuery = Guest::query()->latest();

        if (in_array($filter, ['active', 'inactive', 'blacklisted'], true)) {
            $guestsQuery->where('status', $filter);
        }

        if ($search !== '') {
            $guestsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('nationality', 'like', "%{$search}%");
            });
        }

        $guests = $guestsQuery->paginate(10)->withQueryString();

        $summary = [
            'all' => Guest::count(),
            'active' => Guest::where('status', 'active')->count(),
            'inactive' => Guest::where('status', 'inactive')->count(),
            'blacklisted' => Guest::where('status', 'blacklisted')->count(),
        ];

        return view('guests.index', compact('guests', 'summary', 'filter', 'search'));
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'nationality' => 'nullable|string|max:120',
            'id_number' => 'nullable|string|max:120',
            'status' => 'required|in:active,inactive,blacklisted',
            'address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
        ]);

        Guest::create($data);

        return redirect()->route('guests.index')->with('success', 'Guest created successfully.');
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'nationality' => 'nullable|string|max:120',
            'id_number' => 'nullable|string|max:120',
            'status' => 'required|in:active,inactive,blacklisted',
            'address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:2000',
        ]);

        $guest->update($data);

        return redirect()->route('guests.index')->with('success', 'Guest updated successfully.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully.');
    }
}

@extends('layouts.app')

@section('page_title', 'Room List')
@section('page_title_key', 'page.room_list')

@section('topbar_search')
    <form method="GET" action="{{ route('hotels.index') }}" class="search-pill">
        <input type="hidden" name="filter" value="{{ $filter }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search room name or location" data-i18n-placeholder="room.search_placeholder">
        <button type="submit">Q</button>
    </form>
@endsection

@section('toolbar')
    <div class="toolbar">
        <div class="panel" style="padding: 6px; display: inline-flex; gap: 4px;">
            <a href="{{ route('hotels.index', ['filter' => 'all', 'search' => $search]) }}" class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="room.all_room">All Room</span> ({{ $summary['all'] }})</a>
            <a href="{{ route('hotels.index', ['filter' => 'available', 'search' => $search]) }}" class="btn {{ $filter === 'available' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="room.available">Available</span> ({{ $summary['available'] }})</a>
            <a href="{{ route('hotels.index', ['filter' => 'booked', 'search' => $search]) }}" class="btn {{ $filter === 'booked' ? 'btn-primary' : 'btn-muted' }}"><span data-i18n="room.booked">Booked</span> ({{ $summary['booked'] }})</a>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('hotels.index') }}" class="btn btn-muted" data-i18n="room.reset">Reset</a>
            <a href="{{ route('hotels.create') }}" class="btn btn-primary" data-i18n="room.add_room">+ Add Room</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="panel" style="overflow: hidden;">
        @if($hotels->isEmpty())
            <div style="padding: 36px; text-align: center; color: #8894ac;" data-i18n="room.no_data">No room data found for this filter.</div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 980px;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e8edf5; color: #8c97ad; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.4px;">
                            <th style="padding: 16px; text-align: left;" data-i18n="room.room_name">Room Name</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="room.bed_type">Bed Type</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="room.room_floor">Room Floor</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="room.room_facility">Room Facility</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="room.status">Status</th>
                            <th style="padding: 16px; text-align: left;" data-i18n="room.actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $hotel)
                            @php
                                $roomCode = '#' . str_pad((string) $hotel->id, 4, '0', STR_PAD_LEFT);
                                $bedType = $hotel->room_count >= 4 ? 'Family Bed' : ($hotel->room_count >= 2 ? 'Double Bed' : 'Single Bed');
                                $floor = 'Floor G-' . str_pad((string) (($hotel->id % 8) + 1), 2, '0', STR_PAD_LEFT);
                                $facility = $hotel->description ? \Illuminate\Support\Str::limit($hotel->description, 55) : 'AC, Shower, Towel, Coffee Set, Wifi';
                            @endphp
                            <tr style="border-bottom: 1px solid #eef2f8;">
                                <td style="padding: 14px 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if($hotel->image)
                                            @php
                                                $imageUrl = \Illuminate\Support\Str::startsWith($hotel->image, ['http://', 'https://'])
                                                    ? $hotel->image
                                                    : asset('storage/' . $hotel->image);
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $hotel->name }}" style="width: 110px; height: 64px; object-fit: cover; border-radius: 10px;">
                                        @else
                                            <div style="width: 110px; height: 64px; border-radius: 10px; background: #eef4ff; display: flex; align-items: center; justify-content: center; color: #6389d9; font-size: 0.78rem; font-weight: 600;" data-i18n="room.no_image">No Image</div>
                                        @endif
                                        <div>
                                            <div style="font-size: 0.78rem; color: #4f7ff5; font-weight: 600; margin-bottom: 4px;">{{ $roomCode }}</div>
                                            <div style="font-weight: 600; color: #22314f;">{{ $hotel->name }}</div>
                                            <div style="font-size: 0.8rem; color: #8f9cb3;">{{ $hotel->location }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $bedType }}</td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $floor }}</td>
                                <td style="padding: 14px 16px; color: #697a9c; max-width: 300px;">{{ $facility }}</td>
                                <td style="padding: 14px 16px;">
                                    <span class="status-badge status-{{ $hotel->status }}">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($hotel->status) }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="{{ route('hotels.show', $hotel) }}" class="btn btn-muted" data-i18n="room.view">View</a>
                                        <a href="{{ route('hotels.edit', $hotel) }}" class="btn btn-muted" data-i18n="room.edit">Edit</a>
                                        <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this room?');" data-i18n="room.delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding: 16px; display: flex; justify-content: space-between; align-items: center; color: #8a96ad; font-size: 0.84rem; gap: 12px; flex-wrap: wrap;">
                <div>
                    <span data-i18n="room.showing">Showing</span> {{ $hotels->firstItem() ?? 0 }} <span data-i18n="room.to">to</span> {{ $hotels->lastItem() ?? 0 }} <span data-i18n="room.from">from</span> {{ $hotels->total() }} <span data-i18n="room.data">data</span>
                </div>
                <div>
                    {{ $hotels->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

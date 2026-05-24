@extends('layouts.app')

@section('page_title', 'Guest List')

@section('topbar_search')
    <form method="GET" action="{{ route('guests.index') }}" class="search-pill">
        <input type="hidden" name="filter" value="{{ $filter }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search name, email, phone">
        <button type="submit">Q</button>
    </form>
@endsection

@section('toolbar')
    <div class="toolbar">
        <div class="panel" style="padding: 6px; display: inline-flex; gap: 4px; flex-wrap: wrap;">
            <a href="{{ route('guests.index', ['filter' => 'all', 'search' => $search]) }}" class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-muted' }}">All ({{ $summary['all'] }})</a>
            <a href="{{ route('guests.index', ['filter' => 'active', 'search' => $search]) }}" class="btn {{ $filter === 'active' ? 'btn-primary' : 'btn-muted' }}">Active ({{ $summary['active'] }})</a>
            <a href="{{ route('guests.index', ['filter' => 'inactive', 'search' => $search]) }}" class="btn {{ $filter === 'inactive' ? 'btn-primary' : 'btn-muted' }}">Inactive ({{ $summary['inactive'] }})</a>
            <a href="{{ route('guests.index', ['filter' => 'blacklisted', 'search' => $search]) }}" class="btn {{ $filter === 'blacklisted' ? 'btn-primary' : 'btn-muted' }}">Blacklisted ({{ $summary['blacklisted'] }})</a>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('guests.index') }}" class="btn btn-muted">Reset</a>
            <a href="{{ route('guests.create') }}" class="btn btn-primary">+ Add Guest</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="panel" style="overflow: hidden;">
        @if($guests->isEmpty())
            <div style="padding: 36px; text-align: center; color: #8894ac;">No guest records found.</div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 980px;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e8edf5; color: #8c97ad; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.4px;">
                            <th style="padding: 16px; text-align: left;">Guest Name</th>
                            <th style="padding: 16px; text-align: left;">Contact</th>
                            <th style="padding: 16px; text-align: left;">Nationality</th>
                            <th style="padding: 16px; text-align: left;">ID Number</th>
                            <th style="padding: 16px; text-align: left;">Status</th>
                            <th style="padding: 16px; text-align: left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guests as $guest)
                            <tr style="border-bottom: 1px solid #eef2f8;">
                                <td style="padding: 14px 16px; font-weight: 600; color: #22314f;">{{ $guest->name }}</td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">
                                    <div>{{ $guest->email ?: '-' }}</div>
                                    <div style="font-size: 0.82rem; color: #8f9cb3;">{{ $guest->phone ?: '-' }}</div>
                                </td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $guest->nationality ?: '-' }}</td>
                                <td style="padding: 14px 16px; color: #4f5f7f;">{{ $guest->id_number ?: '-' }}</td>
                                <td style="padding: 14px 16px;">
                                    <span class="status-badge status-{{ $guest->status === 'blacklisted' ? 'cancelled' : ($guest->status === 'inactive' ? 'maintenance' : 'available') }}">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($guest->status) }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <a href="{{ route('guests.edit', $guest) }}" class="btn btn-muted">Edit</a>
                                        <form action="{{ route('guests.destroy', $guest) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this guest?');">Delete</button>
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
                    Showing {{ $guests->firstItem() ?? 0 }} to {{ $guests->lastItem() ?? 0 }} from {{ $guests->total() }} guests
                </div>
                <div>
                    {{ $guests->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

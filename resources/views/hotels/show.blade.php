@extends('layouts.app')

@section('page_title', 'Guest Detail')
@section('page_title_key', 'page.guest_detail')

@section('content')
    <div class="panel card">
        <div class="card-header">
            <div>
                <h2>{{ $hotel->name }}</h2>
                <p class="small-text">{{ $hotel->location }}</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('hotels.edit', $hotel) }}" class="btn btn-muted" data-i18n="room.edit">Edit</a>
                <a href="{{ route('hotels.index') }}" class="btn btn-muted" data-i18n="show.back">Back</a>
            </div>
        </div>

        @if($hotel->image)
            <div style="margin-bottom: 20px;">
                @php
                    $imageUrl = \Illuminate\Support\Str::startsWith($hotel->image, ['http://', 'https://'])
                        ? $hotel->image
                        : asset('storage/' . $hotel->image);
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $hotel->name }}" style="width: 100%; max-height: 370px; object-fit: cover; border-radius: 14px; border: 1px solid #e8edf5;">
            </div>
        @endif

        <div class="form-grid-two" style="margin-bottom: 16px;">
            <div class="panel" style="padding: 14px;">
                <div class="small-text" data-i18n="show.room_count">Room Count</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #2468f2; margin-top: 4px;">{{ $hotel->room_count }}</div>
            </div>
            <div class="panel" style="padding: 14px;">
                <div class="small-text" data-i18n="show.price_per_night">Price Per Night</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #2468f2; margin-top: 4px;">${{ number_format($hotel->price_per_night, 2) }}</div>
            </div>
        </div>

        <div class="panel" style="padding: 14px; margin-bottom: 16px;">
            <div class="small-text" data-i18n="room.status">Status</div>
            <div style="margin-top: 6px;">
                <span class="status-badge status-{{ $hotel->status }}">
                    <span class="status-dot"></span>
                    {{ ucfirst($hotel->status) }}
                </span>
            </div>
        </div>

        <div class="panel" style="padding: 14px;">
            <h3 style="font-size: 1rem; margin-bottom: 8px;" data-i18n="show.room_description">Room Description</h3>
            <p style="line-height: 1.6; color: #556482;" @if(!$hotel->description) data-i18n="show.no_description" @endif>{{ $hotel->description ?: 'No description provided yet.' }}</p>
        </div>
    </div>
@endsection

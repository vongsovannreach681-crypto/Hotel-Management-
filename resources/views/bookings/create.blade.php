@extends('layouts.app')

@section('page_title', 'Create Booking')

@section('content')
    <div class="panel card">
        <div class="card-header">
            <h2>Create Booking</h2>
            <a href="{{ route('bookings.index') }}" class="btn btn-muted">Back</a>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <div class="form-grid-two">
                <div class="form-group">
                    <label for="hotel_id">Room / Hotel</label>
                    <select id="hotel_id" name="hotel_id" class="form-control" required>
                        <option value="">Select room</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }} (${{ number_format((float) $hotel->price_per_night, 2) }}/night)
                            </option>
                        @endforeach
                    </select>
                    @error('hotel_id')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ old('status') === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ old('status') === 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-grid-two">
                <div class="form-group">
                    <label for="guest_name">Guest Name</label>
                    <input type="text" id="guest_name" name="guest_name" class="form-control" value="{{ old('guest_name') }}" required>
                    @error('guest_name')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="guest_email">Guest Email</label>
                    <input type="email" id="guest_email" name="guest_email" class="form-control" value="{{ old('guest_email') }}" required>
                    @error('guest_email')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-grid-two">
                <div class="form-group">
                    <label for="check_in_date">Check In Date</label>
                    <input type="date" id="check_in_date" name="check_in_date" class="form-control" value="{{ old('check_in_date') }}" required>
                    @error('check_in_date')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="check_out_date">Check Out Date</label>
                    <input type="date" id="check_out_date" name="check_out_date" class="form-control" value="{{ old('check_out_date') }}" required>
                    @error('check_out_date')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-grid-two">
                <div class="form-group">
                    <label for="guests">Guests</label>
                    <input type="number" id="guests" name="guests" class="form-control" value="{{ old('guests', 1) }}" min="1" max="20" required>
                    @error('guests')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="total_price">Total Price (optional)</label>
                    <input type="number" id="total_price" name="total_price" class="form-control" value="{{ old('total_price') }}" min="0" step="0.01" placeholder="Auto-calculate if empty">
                    @error('total_price')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" class="form-control" placeholder="Special request, check-in time, etc.">{{ old('notes') }}</textarea>
                @error('notes')<p class="field-error">{{ $message }}</p>@enderror
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">Create Booking</button>
                <a href="{{ route('bookings.index') }}" class="btn btn-muted">Cancel</a>
            </div>
        </form>
    </div>
@endsection

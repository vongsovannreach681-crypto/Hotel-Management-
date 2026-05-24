@csrf

<div class="form-group">
    <label for="name" data-i18n="form.room_name">Room Name</label>
    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $hotel->name ?? '') }}" placeholder="Enter room name" data-i18n-placeholder="form.placeholder_room_name" required>
    @error('name')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="location" data-i18n="form.location">Location</label>
    <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $hotel->location ?? '') }}" placeholder="City, State/Country" data-i18n-placeholder="form.placeholder_location" required>
    @error('location')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div class="form-grid-two">
    <div class="form-group">
        <label for="room_count" data-i18n="form.room_count">Room Count</label>
        <input type="number" id="room_count" name="room_count" class="form-control" value="{{ old('room_count', $hotel->room_count ?? '') }}" min="1" placeholder="Number of rooms" data-i18n-placeholder="form.placeholder_room_count" required>
        @error('room_count')<p class="field-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label for="price_per_night" data-i18n="form.price_per_night">Price per Night</label>
        <input type="number" id="price_per_night" name="price_per_night" class="form-control" value="{{ old('price_per_night', $hotel->price_per_night ?? '') }}" min="0" step="0.01" placeholder="0.00" required>
        @error('price_per_night')<p class="field-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="form-group">
    <label for="image" data-i18n="form.room_image">Room Image</label>
    <input type="text" id="image" name="image" class="form-control" value="{{ old('image', $hotel->image ?? '') }}" placeholder="https://example.com/room.jpg" data-i18n-placeholder="form.placeholder_image_url">
    <small class="small-text" data-i18n="form.image_url_help">Use image URL (accepts with or without https://)</small>

    @if($hotel && $hotel->image)
        <div style="margin-top: 12px;">
            <p class="small-text" style="margin-bottom: 8px;" data-i18n="form.current_image">Current Image</p>
            @php
                $imageUrl = \Illuminate\Support\Str::startsWith($hotel->image, ['http://', 'https://'])
                    ? $hotel->image
                    : asset('storage/' . $hotel->image);
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $hotel->name }}" style="max-width: 220px; border-radius: 10px; border: 1px solid #e8edf5;">
        </div>
    @endif

    @error('image')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="status" data-i18n="form.status">Status</label>
    <select id="status" name="status" class="form-control" required>
        <option value="available" {{ old('status', $hotel->status ?? 'available') === 'available' ? 'selected' : '' }} data-i18n="room.available">Available</option>
        <option value="booked" {{ old('status', $hotel->status ?? '') === 'booked' ? 'selected' : '' }} data-i18n="room.booked">Booked</option>
        <option value="maintenance" {{ old('status', $hotel->status ?? '') === 'maintenance' ? 'selected' : '' }} data-i18n="dashboard.maintenance">Maintenance</option>
    </select>
    @error('status')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="description" data-i18n="form.description">Description / Facilities</label>
    <textarea id="description" name="description" class="form-control" placeholder="Describe room facilities and details" data-i18n-placeholder="form.placeholder_description">{{ old('description', $hotel->description ?? '') }}</textarea>
    @error('description')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label style="display: flex; align-items: center; gap: 10px; font-weight: 500; cursor: pointer;">
        <input type="checkbox" name="available" value="1" {{ old('available', $hotel->available ?? true) ? 'checked' : '' }} style="width: auto;">
        <span data-i18n="form.available_for_booking">Available for booking</span>
    </label>
</div>

<div style="display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
    <button type="submit" class="btn btn-primary" @if(!empty($submitKey)) data-i18n="{{ $submitKey }}" @endif>{{ $buttonText }}</button>
    <a href="{{ route('hotels.index') }}" class="btn btn-muted" data-i18n="form.cancel">Cancel</a>
</div>

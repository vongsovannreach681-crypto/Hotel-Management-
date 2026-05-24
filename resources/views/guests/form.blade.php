@csrf

<div class="form-grid-two">
    <div class="form-group">
        <label for="name">Guest Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $guest->name ?? '') }}" required>
        @error('name')<p class="field-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active" {{ old('status', $guest->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $guest->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="blacklisted" {{ old('status', $guest->status ?? '') === 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
        </select>
        @error('status')<p class="field-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="form-grid-two">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $guest->email ?? '') }}">
        @error('email')<p class="field-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $guest->phone ?? '') }}">
        @error('phone')<p class="field-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="form-grid-two">
    <div class="form-group">
        <label for="nationality">Nationality</label>
        <input type="text" id="nationality" name="nationality" class="form-control" value="{{ old('nationality', $guest->nationality ?? '') }}">
        @error('nationality')<p class="field-error">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label for="id_number">ID/Passport Number</label>
        <input type="text" id="id_number" name="id_number" class="form-control" value="{{ old('id_number', $guest->id_number ?? '') }}">
        @error('id_number')<p class="field-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="form-group">
    <label for="address">Address</label>
    <textarea id="address" name="address" class="form-control">{{ old('address', $guest->address ?? '') }}</textarea>
    @error('address')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea id="notes" name="notes" class="form-control">{{ old('notes', $guest->notes ?? '') }}</textarea>
    @error('notes')<p class="field-error">{{ $message }}</p>@enderror
</div>

<div style="display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('guests.index') }}" class="btn btn-muted">Cancel</a>
</div>

@extends('user.layout')

@section('title', 'My Profile')

@section('extra_css')
<style>
    .profile-shell {
        width: min(980px, calc(100% - 2rem));
        margin: 2rem auto 0;
        display: grid;
        gap: 1rem;
    }

    .profile-hero {
        background: #1f3147;
        color: #fff;
        border-radius: 18px;
        padding: 1.4rem;
        box-shadow: 0 14px 30px rgba(20, 32, 48, 0.2);
    }

    .profile-hero h1 {
        font-size: 1.6rem;
        margin-bottom: 0.3rem;
    }

    .profile-hero p {
        color: rgba(255, 255, 255, 0.88);
        font-size: 0.95rem;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .profile-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 1.15rem;
        box-shadow: var(--shadow);
    }

    .profile-card h2 {
        font-size: 1.12rem;
        margin-bottom: 0.85rem;
        color: var(--ink);
    }

    .field {
        display: grid;
        gap: 0.35rem;
        margin-bottom: 0.75rem;
    }

    .field label {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--ink-soft);
    }

    .field input {
        width: 100%;
        border: 1px solid #d9c8ae;
        border-radius: 10px;
        background: #fff;
        color: var(--ink);
        padding: 0.72rem 0.82rem;
        font-size: 0.93rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .field input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(182, 139, 82, 0.15);
    }

    .error-box {
        border: 1px solid #f0c6c0;
        background: #fdf1ef;
        border-radius: 10px;
        color: #9a362a;
        padding: 0.8rem 0.95rem;
        font-size: 0.9rem;
    }

    .error-box ul {
        margin: 0;
        padding-left: 1.1rem;
    }

    .logout-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .logout-card p {
        color: var(--ink-soft);
        font-size: 0.92rem;
    }

    .current-photo {
        margin-bottom: 0.75rem;
    }

    .current-photo img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #e6d4ba;
        display: block;
    }

    @media (max-width: 860px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<section class="profile-shell reveal">
    <div class="profile-hero">
        <h1>My Profile</h1>
        <p>Manage your account details and password in one place.</p>
    </div>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-grid">
        <article class="profile-card">
            <h2>Update Profile</h2>
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($user->image)
                    <div class="current-photo">
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}">
                    </div>
                @endif
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="field">
                    <label for="image">Profile Image</label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </article>

        <article class="profile-card">
            <h2>Update Password</h2>
            <form action="{{ route('user.profile.password') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="field">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </article>
    </div>

    <article class="profile-card logout-card">
        <div>
            <h2>Sign Out</h2>
            <p>End your current session on this device.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline">Logout</button>
        </form>
    </article>
</section>
@endsection

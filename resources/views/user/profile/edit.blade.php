@extends('user.layout')

@section('title', 'My Profile')

@section('extra_css')
<style>
    .shell { width:min(980px, calc(100% - 2rem)); margin:2rem auto 0; }
    .grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .card { background:#fff; border:1px solid #eadfce; border-radius:18px; box-shadow:0 18px 30px rgba(10,20,30,.08); padding:1.1rem; }
    h1 { font-family:'Poppins', sans-serif; font-size:2.4rem; line-height:0.95; margin-bottom:0.8rem; }
    .form { display:grid; gap:0.8rem; }
    .field { display:grid; gap:0.36rem; }
    .field label { font-size:0.8rem; text-transform:uppercase; letter-spacing:.08em; color:#617383; font-weight:700; }
    .field input, .field textarea { width:100%; border:1px solid #ddcfbd; border-radius:12px; padding:0.82rem; font:inherit; }
    .field textarea { min-height:95px; resize:vertical; }
    .field input:focus, .field textarea:focus { outline:none; border-color:#b68b52; box-shadow:0 0 0 3px rgba(182,139,82,.16); }
    .error { color:#9a3528; font-size:.82rem; }

    @media (max-width: 760px) {
        .grid { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
<div class="shell">
    <h1 class="reveal">My Profile</h1>

    <div class="grid">
        <section class="card reveal">
            <h2 style="font-size:1.1rem; margin-bottom:0.8rem;">Account Information</h2>
            <form class="form" method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save Profile</button>
            </form>
        </section>

        <section class="card reveal">
            <h2 style="font-size:1.1rem; margin-bottom:0.8rem;">Change Password</h2>
            <form class="form" method="POST" action="{{ route('user.profile.password') }}">
                @csrf
                <div class="field">
                    <label for="current_password">Current Password</label>
                    <input id="current_password" type="password" name="current_password" required>
                    @error('current_password') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="password">New Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </section>
    </div>
</div>
@endsection

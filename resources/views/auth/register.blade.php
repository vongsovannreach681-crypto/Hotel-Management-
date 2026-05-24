@extends('user.layout')

@section('title', 'Create Account')

@section('extra_css')
<style>
    .auth-shell {
        width: min(560px, calc(100% - 2rem));
        margin: 3rem auto;
    }

    .auth-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: 0 24px 36px rgba(13, 22, 34, 0.08);
        overflow: hidden;
    }

    .auth-head {
        padding: 1.4rem 1.3rem 1rem;
        background:
            linear-gradient(120deg, rgba(24, 39, 56, 0.9), rgba(45, 71, 96, 0.82)),
            url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1000&q=80');
        background-size: cover;
        background-position: center;
        color: #fff;
    }

    .auth-head h1 {
        font-size: 1.55rem;
        margin-bottom: 0.25rem;
    }

    .auth-head p {
        color: rgba(255, 255, 255, 0.84);
        font-size: 0.9rem;
    }

    .auth-body {
        padding: 1.3rem;
    }

    .auth-alert {
        margin-bottom: 0.9rem;
        border-radius: 12px;
        border: 1px solid #f0c6c0;
        background: #fdf1ef;
        color: #9a362a;
        padding: 0.75rem 0.85rem;
        font-size: 0.88rem;
    }

    .auth-alert ul {
        margin-left: 1rem;
    }

    .field {
        display: grid;
        gap: 0.4rem;
        margin-bottom: 0.9rem;
    }

    .field label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #5f6f7f;
    }

    .field input {
        width: 100%;
        border: 1px solid #ddd0be;
        border-radius: 12px;
        height: 46px;
        padding: 0 0.85rem;
        font: inherit;
        color: #243240;
    }

    .field input:focus {
        outline: none;
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(182, 139, 82, 0.16);
    }

    .field-error {
        color: #9a3528;
        font-size: 0.8rem;
    }

    .auth-submit {
        width: 100%;
        margin-top: 0.2rem;
    }

    .auth-foot {
        text-align: center;
        font-size: 0.9rem;
        color: #6a7c8d;
        margin-top: 0.95rem;
    }

    .auth-foot a {
        color: var(--brand-deep);
        font-weight: 700;
    }

    @media (max-width: 560px) {
        .auth-shell {
            margin: 1.8rem auto;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-shell reveal">
    <article class="auth-card">
        <header class="auth-head">
            <h1>Create Your Account</h1>
            <p>Join Clermont Royale and unlock seamless booking access.</p>
        </header>

        <div class="auth-body">
            @if ($errors->any())
                <div class="auth-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="field">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary auth-submit">Create Account</button>
            </form>

            <p class="auth-foot">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </article>
</div>
@endsection

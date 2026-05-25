@extends('user.layout')

@section('title', 'Login')

@section('extra_css')
<style>
    .auth-shell {
        width: min(520px, calc(100% - 2rem));
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
        background-image: url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1000&q=80');
        background-size: cover;
        background-position: center;
        box-shadow: inset 0 0 0 999px rgba(10, 20, 34, 0.72);
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

    .auth-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.8rem;
        margin: 0.5rem 0 1.1rem;
    }

    .remember {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        color: #5c6e80;
        font-size: 0.86rem;
    }

    .remember input {
        accent-color: var(--brand);
    }

    .auth-submit {
        width: 100%;
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
            <h1>Welcome Back</h1>
            <p>Sign in to manage bookings and continue your luxury stay planning.</p>
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

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
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

                <div class="auth-meta">
                    <label class="remember" for="remember">
                        <input type="checkbox" id="remember" name="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-primary auth-submit">Login</button>
            </form>

            <p class="auth-foot">
                Don&apos;t have an account?
                <a href="{{ route('register') }}">Sign up</a>
            </p>
        </div>
    </article>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Clermont Royale')</title>
    <meta name="description" content="Experience elegant stays, tailored comfort, and effortless hotel booking.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --bg: #f6f1ea;
            --surface: #fffdf9;
            --surface-muted: #fdf8f2;
            --ink: #1f2a3a;
            --ink-soft: #4b5c6c;
            --brand: #b68b52;
            --brand-deep: #8a6639;
            --accent: #294460;
            --line: #e8dece;
            --shadow: 0 20px 40px rgba(25, 36, 51, 0.08);
            --radius-lg: 22px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --container: 1180px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
            background: var(--bg);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: min(var(--container), calc(100% - 2rem));
            margin-inline: auto;
        }

        .btn {
            border: none;
            border-radius: 999px;
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1;
            padding: 0.9rem 1.4rem;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease, color 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
            box-shadow: 0 12px 22px rgba(182, 139, 82, 0.25);
        }

        .btn-primary:hover {
            background: var(--brand-deep);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #cdb79a;
            color: var(--ink);
        }

        .btn-outline:hover {
            background: #fff8ef;
        }

        .btn-soft {
            background: var(--surface);
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .btn-soft:hover {
            background: #fff;
        }

        .top-nav {
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(12px);
            background: rgba(255, 252, 247, 0.86);
            border-bottom: 1px solid rgba(176, 149, 113, 0.28);
        }

        .top-nav .inner {
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .brand {
            color: var(--ink);
            font-family: 'Poppins', sans-serif;
            font-size: 1.55rem;
            letter-spacing: 0.04em;
            font-weight: 700;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 1.25rem;
        }

        .nav-links a {
            color: #4f5d6f;
            font-size: 0.94rem;
            font-weight: 600;
            transition: color 0.25s ease, background-color 0.25s ease;
            border-radius: 999px;
            padding: 0.42rem 0.8rem;
        }

        .nav-links a:hover {
            color: var(--accent);
            background: rgba(41, 68, 96, 0.1);
        }

        .nav-links a.active {
            color: #fff;
            background: var(--accent);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            color: var(--ink);
        }

        .user-pill {
            padding: 0.45rem 0.75rem;
            border: 1px solid #dbc9b0;
            background: #fff9f1;
            border-radius: 999px;
            font-size: 0.82rem;
            white-space: nowrap;
        }

        .user-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            object-fit: cover;
            display: inline-block;
        }

        .user-initial {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .menu-toggle {
            display: none;
            background: transparent;
            border: none;
            color: var(--ink);
            font-size: 1.45rem;
            cursor: pointer;
        }

        .alert-stack {
            width: min(var(--container), calc(100% - 2rem));
            margin-inline: auto;
            margin-top: 1rem;
            display: grid;
            gap: 0.75rem;
        }

        .alert {
            border-radius: var(--radius-sm);
            padding: 0.9rem 1rem;
            border: 1px solid;
            font-size: 0.92rem;
        }

        .alert-success {
            background: #eef9f2;
            border-color: #b6e4c8;
            color: #22653d;
        }

        .alert-error {
            background: #fdf1ef;
            border-color: #f0c6c0;
            color: #9a362a;
        }

        .site-main {
            overflow: clip;
        }

        .site-footer {
            background: #101a28;
            color: #d9e3ed;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.2fr repeat(3, minmax(130px, 1fr));
            gap: 1.4rem;
            align-items: start;
        }

        .footer-brand {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            color: #fff;
            margin-bottom: 0.8rem;
            letter-spacing: 0.05em;
        }

        .footer-copy {
            color: #b8c8d8;
            font-size: 0.92rem;
            max-width: 34ch;
        }

        .footer-title {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .footer-list {
            list-style: none;
            display: grid;
            gap: 0.45rem;
            color: #b8c8d8;
            font-size: 0.9rem;
        }

        .footer-list a:hover {
            color: #fff;
        }

        .socials {
            display: flex;
            gap: 0.55rem;
        }

        .social-link {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: background-color 0.25s ease, transform 0.25s ease;
        }

        .social-link:hover {
            background: var(--brand);
            transform: translateY(-2px);
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            margin-top: 2.3rem;
            padding-top: 1.1rem;
            text-align: center;
            color: #9fb1c2;
            font-size: 0.84rem;
        }

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 1024px) {
            .nav-links {
                gap: 0.9rem;
            }

            .nav-links a {
                font-size: 0.88rem;
            }

            .footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 840px) {
            .menu-toggle {
                display: inline-flex;
            }

            .nav-links,
            .nav-actions {
                position: absolute;
                left: 1rem;
                right: 1rem;
                background: rgba(255, 252, 247, 0.98);
                border: 1px solid rgba(176, 149, 113, 0.3);
                border-radius: var(--radius-md);
                padding: 1rem;
                transform: scale(0.98);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s ease, transform 0.2s ease;
            }

            .nav-links {
                top: 82px;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
            }

            .nav-actions {
                top: 295px;
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 0.7rem;
            }

            .top-nav.open .nav-links,
            .top-nav.open .nav-actions {
                opacity: 1;
                pointer-events: auto;
                transform: scale(1);
            }

            .top-nav .inner {
                min-height: 74px;
            }
        }

        @media (max-width: 620px) {
            .brand {
                font-size: 1.3rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @yield('extra_css')
</head>
<body>
    @php($currentRoute = Route::currentRouteName())
    <header class="top-nav" id="home">
        <div class="container inner">
            <a href="{{ Route::has('user.home') ? route('user.home') : '#' }}" class="brand">Clermont Royale</a>
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu">
                <i class="bi bi-list"></i>
            </button>
            <ul class="nav-links" id="menuLinks">
                <li><a href="{{ Route::has('user.home') ? route('user.home') : '#' }}" class="{{ $currentRoute === 'user.home' ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ Route::has('user.rooms.index') ? route('user.rooms.index') : '#' }}" class="{{ $currentRoute === 'user.rooms.index' ? 'active' : '' }}">Rooms</a></li>
                <li><a href="{{ Route::has('user.home') ? route('user.home') : '#' }}#about">About</a></li>
                <li><a href="{{ Route::has('user.home') ? route('user.home') : '#' }}#contact">Contact</a></li>
            </ul>
            <div class="nav-actions" id="menuActions">
                @if (auth()->check())
                    <?php
                        $user = auth()->user();
                        $userName = $user?->name ?? 'User';
                        $nameParts = explode(' ', $userName);
                        $initials = count($nameParts) > 1
                            ? strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1))
                            : strtoupper(substr($userName, 0, 2));
                    ?>
                    <a href="{{ Route::has('user.profile.edit') ? route('user.profile.edit') : '#' }}" class="user-pill" style="display: inline-flex; align-items: center; gap: 8px; padding-left: 0.35rem; cursor: pointer; transition: transform 0.2s ease;">
                        @if ($user && $user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $userName }}" class="user-avatar">
                        @else
                            <span class="user-initial">{{ $initials }}</span>
                        @endif
                        <span>{{ $userName }}</span>
                    </a>
                    <a href="{{ Route::has('user.bookings.index') ? route('user.bookings.index') : '#' }}" class="btn btn-soft">My Bookings</a>
                    @if ($user && $user->email === 'reach@gmail.com')
                        <a href="{{ Route::has('dashboard.index') ? route('dashboard.index') : url('/admin') }}" class="btn btn-soft">Admin</a>
                    @endif
                @else
                    <a href="{{ Route::has('login') ? route('login') : '#' }}" class="btn btn-outline">Login</a>
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="btn btn-primary">Book Now</a>
                @endif
            </div>
        </div>
    </header>

    <div class="alert-stack">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
    </div>

    <main class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer" id="about">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">Clermont Royale</div>
                    <p class="footer-copy">
                        A refined destination for exceptional comfort, personalized service, and memorable stays.
                    </p>
                </div>
                <div>
                    <div class="footer-title">Navigation</div>
                    <ul class="footer-list">
                        <li><a href="{{ Route::has('user.home') ? route('user.home') : '#' }}">Home</a></li>
                        <li><a href="{{ Route::has('user.rooms.index') ? route('user.rooms.index') : '#' }}">Rooms</a></li>
                        <li><a href="{{ Route::has('user.bookings.index') ? route('user.bookings.index') : '#' }}">My Bookings</a></li>
                        <li><a href="{{ Route::has('user.home') ? route('user.home') : '#' }}#contact">Contact</a></li>
                    </ul>
                </div>
                <div id="contact">
                    <div class="footer-title">Contact</div>
                    <ul class="footer-list">
                        <li>+855 12 345 678</li>
                        <li>reservations@clermontroyale.com</li>
                        <li>245 Riverside Boulevard, Phnom Penh</li>
                    </ul>
                </div>
                <div>
                    <div class="footer-title">Follow</div>
                    <div class="socials">
                        <a class="social-link" href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a class="social-link" href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a class="social-link" href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a class="social-link" href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <p class="copyright">&copy; <span id="copyrightYear"></span> Clermont Royale. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navRoot = document.querySelector('.top-nav');

        if (menuToggle && navRoot) {
            menuToggle.addEventListener('click', () => {
                navRoot.classList.toggle('open');
            });
        }

        document.getElementById('copyrightYear').textContent = new Date().getFullYear();

        const reveals = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window && reveals.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            reveals.forEach((el) => observer.observe(el));
        } else {
            reveals.forEach((el) => el.classList.add('revealed'));
        }
    </script>

    @stack('scripts')
</body>
</html>

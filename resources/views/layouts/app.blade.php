<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #f5f7fb;
            --surface: #ffffff;
            --border: #e8edf5;
            --text: #192335;
            --muted: #7f8aa3;
            --primary-start: #1a6fff;
            --primary-end: #25b8ff;
            --danger: #ff5f58;
            --success: #24bf64;
            --warning: #f6b73c;
            --bg-gradient-start: #eff4ff;
            --bg-gradient-end: #f5f7fb;
            --surface-elevated: rgba(255, 255, 255, 0.9);
            --surface-muted: #f3f7ff;
            --footer: #97a3ba;
        }

        html[data-theme="dark"] {
            --bg: #0f1726;
            --surface: #111c2e;
            --border: #22314b;
            --text: #ebf1ff;
            --muted: #a6b3ca;
            --bg-gradient-start: #1a2a45;
            --bg-gradient-end: #0f1726;
            --surface-elevated: rgba(17, 28, 46, 0.92);
            --surface-muted: #1a2a42;
            --footer: #7f8ca4;
        }

        html[data-theme="dark"] .sidebar-link {
            color: #9fb0cc;
        }

        html[data-theme="dark"] .btn-muted {
            background: #1a2940;
            color: #d5e0f5;
        }

        html[data-theme="dark"] .btn-danger {
            background: #3a1e29;
            color: #ffb9b9;
        }

        html[data-theme="dark"] .form-control {
            background: #0f1726;
            border-color: #2f3e5d;
            color: #e8eeff;
        }

        html[data-theme="dark"] .form-group label {
            color: #c7d4ee;
        }

        html[data-theme="dark"] .search-pill input {
            color: #eaf1ff;
        }

        html[data-theme="dark"] .panel,
        html[data-theme="dark"] .panel th,
        html[data-theme="dark"] .panel td,
        html[data-theme="dark"] .panel p,
        html[data-theme="dark"] .panel h1,
        html[data-theme="dark"] .panel h2,
        html[data-theme="dark"] .panel h3,
        html[data-theme="dark"] .panel h4,
        html[data-theme="dark"] .panel h5,
        html[data-theme="dark"] .panel h6,
        html[data-theme="dark"] .panel strong,
        html[data-theme="dark"] .panel span,
        html[data-theme="dark"] .panel div,
        html[data-theme="dark"] .panel a {
            color: #eef4ff !important;
        }

        html[data-theme="dark"] .panel .status-available { color: var(--success) !important; }
        html[data-theme="dark"] .panel .status-booked { color: var(--danger) !important; }
        html[data-theme="dark"] .panel .status-maintenance { color: var(--warning) !important; }
        html[data-theme="dark"] .panel .status-pending { color: #f09c00 !important; }
        html[data-theme="dark"] .panel .status-confirmed { color: #2d9cff !important; }
        html[data-theme="dark"] .panel .status-checked_in { color: #24bf64 !important; }
        html[data-theme="dark"] .panel .status-checked_out { color: #9db3d6 !important; }
        html[data-theme="dark"] .panel .status-cancelled { color: #ff8c85 !important; }

        body {
            font-family: "Poppins", "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(circle at top left, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 55%);
            color: var(--text);
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .layout {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 248px;
            background: var(--surface-elevated);
            border-right: 1px solid var(--border);
            backdrop-filter: blur(8px);
            position: fixed;
            inset: 0 auto 0 0;
            padding: 26px 20px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .brand {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            color: var(--text);
            text-decoration: none;
            font-style: italic;
            letter-spacing: 0.5px;
            margin-left: 8px;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 14px;
            padding: 12px 16px;
            color: #8f98ab;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: var(--text);
            background: var(--surface-muted);
        }

        .sidebar-link.active {
            background: linear-gradient(110deg, var(--primary-start), var(--primary-end));
            color: #fff;
            box-shadow: 0 10px 18px rgba(26, 111, 255, 0.25);
        }

        .icon-dot {
            width: 20px;
            height: 20px;
            border-radius: 7px;
            border: 1.8px solid currentColor;
            display: inline-block;
            position: relative;
            opacity: 0.9;
        }

        .icon-dot::before {
            content: "";
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: currentColor;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sidebar-note {
            margin-top: auto;
            color: #a1a9b8;
            font-size: 0.8rem;
            line-height: 1.6;
            padding: 0 8px;
        }

        .main {
            margin-left: 248px;
            width: calc(100% - 248px);
            padding: 18px 26px 24px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .page-title {
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .search-pill {
            width: min(430px, 44vw);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 14px rgba(25, 35, 53, 0.04);
        }

        .search-pill input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 0.92rem;
            color: #425172;
            background: transparent;
        }

        .search-pill button,
        .icon-btn {
            border: none;
            background: var(--surface-muted);
            color: #5483ff;
            border-radius: 10px;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .icon-btn svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 1.8;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            border-radius: 14px;
            padding: 6px 10px 6px 6px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dbe7ff, #a9c5ff);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #305dbf;
        }

        .profile-name {
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .profile-role {
            color: var(--muted);
            font-size: 0.72rem;
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .toolbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 14px 30px rgba(28, 42, 64, 0.06);
        }

        .alert {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #bbe7cc;
            background: #ebfff2;
            color: #186735;
            font-size: 0.9rem;
        }

        .btn {
            border: none;
            border-radius: 12px;
            padding: 9px 15px;
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary-start), var(--primary-end));
            color: #fff;
            box-shadow: 0 10px 20px rgba(26, 111, 255, 0.28);
        }

        .btn-muted {
            background: #f1f5fd;
            color: #495572;
        }

        .btn-danger {
            background: #ffefef;
            color: #d04545;
        }

        .card {
            padding: 22px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .card-header h2 {
            font-size: 1.24rem;
            letter-spacing: -0.1px;
        }

        .form-grid-two {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.88rem;
            color: #384969;
        }

        .form-control {
            width: 100%;
            border: 1px solid #d9e1ef;
            border-radius: 12px;
            padding: 11px 13px;
            font-size: 0.92rem;
            color: #233150;
            background: #fcfdff;
        }

        .form-control:focus {
            outline: none;
            border-color: #8eb1ff;
            box-shadow: 0 0 0 3px rgba(78, 128, 255, 0.14);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .small-text {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 6px;
            display: block;
        }

        .field-error {
            color: #d04545;
            margin-top: 6px;
            font-size: 0.78rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .status-available { color: var(--success); }
        .status-available .status-dot { background: var(--success); }
        .status-booked { color: var(--danger); }
        .status-booked .status-dot { background: var(--danger); }
        .status-maintenance { color: var(--warning); }
        .status-maintenance .status-dot { background: var(--warning); }
        .status-pending { color: #f09c00; }
        .status-pending .status-dot { background: #f09c00; }
        .status-confirmed { color: #2d9cff; }
        .status-confirmed .status-dot { background: #2d9cff; }
        .status-checked_in { color: #24bf64; }
        .status-checked_in .status-dot { background: #24bf64; }
        .status-checked_out { color: #637089; }
        .status-checked_out .status-dot { background: #637089; }
        .status-cancelled { color: #ff5f58; }
        .status-cancelled .status-dot { background: #ff5f58; }

        .footer {
            color: var(--footer);
            font-size: 0.76rem;
            text-align: center;
            margin-top: auto;
            padding-top: 12px;
        }

        @media (max-width: 1100px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .layout {
                flex-direction: column;
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .search-pill {
                width: 100%;
            }

            .topbar {
                flex-wrap: wrap;
            }

            .topbar-right {
                width: 100%;
                margin-left: 0;
            }
        }

        @media (max-width: 720px) {
            .form-grid-two {
                grid-template-columns: 1fr;
            }

            .main {
                padding: 14px;
            }

            .card {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <a href="{{ route('dashboard.index') }}" class="brand">Hotel</a>

            <ul class="sidebar-menu">
                <li><a class="sidebar-link @if(Route::is('dashboard.*')) active @endif" href="{{ route('dashboard.index') }}"><span class="icon-dot"></span><span data-i18n="nav.dashboard">Dashboard</span></a></li>
                <li><a class="sidebar-link @if(Route::is('hotels.*')) active @endif" href="{{ route('hotels.index') }}"><span class="icon-dot"></span><span data-i18n="nav.room">Room</span></a></li>
                <li><a class="sidebar-link @if(Route::is('bookings.*')) active @endif" href="{{ route('bookings.index') }}"><span class="icon-dot"></span><span data-i18n="nav.booking">Booking</span></a></li>
                <li><a class="sidebar-link @if(Route::is('guests.*')) active @endif" href="{{ route('guests.index') }}"><span class="icon-dot"></span><span data-i18n="nav.guest">Guest</span></a></li>
                <li><a class="sidebar-link" href="{{ route('hotels.index') }}"><span class="icon-dot"></span><span data-i18n="nav.concierge">Concierge</span></a></li>
                <li><a class="sidebar-link" href="{{ route('hotels.index') }}"><span class="icon-dot"></span><span data-i18n="nav.settings">Settings</span></a></li>
            </ul>

            <div class="sidebar-note">
                <span data-i18n="sidebar.note_admin">Hotel Admin</span><br>
                <span data-i18n="sidebar.note_rights">2026 All Rights Reserved</span>
            </div>
        </aside>

        <main class="main">
            @php($pageTitleKey = trim($__env->yieldContent('page_title_key')))
            <header class="topbar">
                <h1 class="page-title" @if($pageTitleKey !== '') data-i18n="{{ $pageTitleKey }}" @endif>@yield('page_title', 'Hotel Management')</h1>

                <div class="topbar-right">
                    @yield('topbar_search')
                    <button class="icon-btn" id="theme-toggle" type="button" data-i18n-title="topbar.toggle_theme" title="Toggle theme">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 1 0 9.8 9.8z"></path></svg>
                    </button>
                    <button class="icon-btn" id="lang-toggle" type="button" data-i18n-title="topbar.toggle_language" title="Switch language"><span id="lang-toggle-label">KH</span></button>
                    <button class="icon-btn" type="button" aria-label="Notification">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path><path d="M9 17a3 3 0 0 0 6 0"></path></svg>
                    </button>
                    <div class="profile">
                        <span class="avatar">VS</span>
                        <div>
                            <div class="profile-name">Vorng Sovannreach</div>
                            <div class="profile-role" data-i18n="profile.role">Hotel admin</div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="content">
                @if (session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif

                @yield('toolbar')
                @yield('content')
            </section>

            <footer class="footer" data-i18n="footer.built">Built with Laravel and Blade</footer>
        </main>
    </div>

    <script>
        const translations = {
            en: {
                "nav.dashboard": "Dashboard",
                "nav.room": "Room",
                "nav.booking": "Booking",
                "nav.guest": "Guest",
                "nav.concierge": "Concierge",
                "nav.settings": "Settings",
                "sidebar.note_admin": "Hotel Admin",
                "sidebar.note_rights": "2026 All Rights Reserved",
                "profile.role": "Hotel admin",
                "footer.built": "Built with Laravel and Blade",
                "topbar.toggle_theme": "Toggle dark/light theme",
                "topbar.toggle_language": "Switch English/Khmer",
                "page.dashboard_overview": "Dashboard Overview",
                "page.room_list": "Room List",
                "page.user_booking_list": "User Booking List",
                "page.add_new_hotel": "Add New Hotel",
                "page.edit_hotel": "Edit Hotel",
                "page.guest_detail": "Guest Detail",
                "dashboard.total_rooms": "Total Rooms",
                "dashboard.available_rooms": "Available Rooms",
                "dashboard.booked_rooms": "Booked Rooms",
                "dashboard.maintenance": "Maintenance",
                "dashboard.total_bookings": "Total Bookings",
                "dashboard.today_snapshot": "Today Snapshot",
                "dashboard.arrivals": "Arrivals",
                "dashboard.departures": "Departures",
                "dashboard.active_stays": "Active Stays",
                "dashboard.month_revenue": "This Month Revenue",
                "dashboard.room_utilization": "Room Utilization",
                "dashboard.occupied": "Occupied",
                "dashboard.booking_status": "Booking Status",
                "dashboard.recent_bookings": "Recent Bookings",
                "dashboard.view_all": "View All",
                "dashboard.no_bookings_yet": "No bookings yet.",
                "dashboard.booking": "Booking",
                "dashboard.guest": "Guest",
                "dashboard.room": "Room",
                "dashboard.check_in": "Check In",
                "dashboard.status": "Status",
                "room.search_placeholder": "Search room name or location",
                "room.all_room": "All Room",
                "room.available": "Available",
                "room.booked": "Booked",
                "room.reset": "Reset",
                "room.add_room": "+ Add Room",
                "room.no_data": "No room data found for this filter.",
                "room.room_name": "Room Name",
                "room.bed_type": "Bed Type",
                "room.room_floor": "Room Floor",
                "room.room_facility": "Room Facility",
                "room.status": "Status",
                "room.actions": "Actions",
                "room.no_image": "No Image",
                "room.view": "View",
                "room.edit": "Edit",
                "room.delete": "Delete",
                "room.showing": "Showing",
                "room.to": "to",
                "room.from": "from",
                "room.data": "data",
                "booking.search_placeholder": "Search booking number, guest, email",
                "booking.all": "All",
                "booking.confirmed": "Confirmed",
                "booking.pending": "Pending",
                "booking.cancelled": "Cancelled",
                "booking.no_data": "No booking records yet. Create some data in the bookings table to display user bookings.",
                "booking.booking_no": "Booking No",
                "booking.guest": "Guest",
                "booking.room": "Room",
                "booking.check_in": "Check In",
                "booking.check_out": "Check Out",
                "booking.guests": "Guests",
                "booking.total_price": "Total Price",
                "booking.status": "Status",
                "booking.showing": "Showing",
                "booking.to": "to",
                "booking.from": "from",
                "booking.bookings": "bookings",
                "form.room_name": "Room Name",
                "form.location": "Location",
                "form.room_count": "Room Count",
                "form.price_per_night": "Price per Night",
                "form.room_image": "Room Image",
                "form.max_file": "Max file size: 2MB (JPEG, PNG, GIF)",
                "form.current_image": "Current Image",
                "form.status": "Status",
                "form.description": "Description / Facilities",
                "form.available_for_booking": "Available for booking",
                "form.cancel": "Cancel",
                "form.create_room": "Create Room",
                "form.save_changes": "Save Changes",
                "form.placeholder_room_name": "Enter room name",
                "form.placeholder_location": "City, State/Country",
                "form.placeholder_room_count": "Number of rooms",
                "form.placeholder_image_url": "https://example.com/room.jpg",
                "form.image_url_help": "Use image URL (accepts with or without https://)",
                "form.placeholder_description": "Describe room facilities and details",
                "show.back": "Back",
                "show.room_count": "Room Count",
                "show.price_per_night": "Price Per Night",
                "show.room_description": "Room Description",
                "show.no_description": "No description provided yet."
            },
            km: {
                "nav.dashboard": "ផ្ទាំងគ្រប់គ្រង",
                "nav.room": "បន្ទប់",
                "nav.booking": "ការកក់",
                "nav.guest": "ភ្ញៀវ",
                "nav.concierge": "សេវាជំនួយ",
                "nav.settings": "ការកំណត់",
                "sidebar.note_admin": "គ្រប់គ្រងសណ្ឋាគារ Hotel",
                "sidebar.note_rights": "រក្សាសិទ្ធិគ្រប់យ៉ាង ឆ្នាំ 2026",
                "profile.role": "អ្នកគ្រប់គ្រងសណ្ឋាគារ",
                "footer.built": "បង្កើតដោយ Laravel និង Blade",
                "topbar.toggle_theme": "ប្ដូរទៅរបៀបងងឹត/ភ្លឺ",
                "topbar.toggle_language": "ប្ដូរភាសា អង់គ្លេស/ខ្មែរ",
                "page.dashboard_overview": "ទិដ្ឋភាពទូទៅផ្ទាំងគ្រប់គ្រង",
                "page.room_list": "បញ្ជីបន្ទប់",
                "page.user_booking_list": "បញ្ជីការកក់របស់អ្នកប្រើ",
                "page.add_new_hotel": "បន្ថែមសណ្ឋាគារថ្មី",
                "page.edit_hotel": "កែសម្រួលសណ្ឋាគារ",
                "page.guest_detail": "ព័ត៌មានភ្ញៀវ",
                "dashboard.total_rooms": "បន្ទប់សរុប",
                "dashboard.available_rooms": "បន្ទប់ទំនេរ",
                "dashboard.booked_rooms": "បន្ទប់បានកក់",
                "dashboard.maintenance": "កំពុងថែទាំ",
                "dashboard.total_bookings": "ការកក់សរុប",
                "dashboard.today_snapshot": "ស្ថានភាពថ្ងៃនេះ",
                "dashboard.arrivals": "អ្នកមកដល់",
                "dashboard.departures": "អ្នកចាកចេញ",
                "dashboard.active_stays": "ភ្ញៀវកំពុងស្នាក់នៅ",
                "dashboard.month_revenue": "ចំណូលខែនេះ",
                "dashboard.room_utilization": "អត្រាប្រើប្រាស់បន្ទប់",
                "dashboard.occupied": "បានប្រើ",
                "dashboard.booking_status": "ស្ថានភាពការកក់",
                "dashboard.recent_bookings": "ការកក់ថ្មីៗ",
                "dashboard.view_all": "មើលទាំងអស់",
                "dashboard.no_bookings_yet": "មិនទាន់មានការកក់ទេ។",
                "dashboard.booking": "លេខកក់",
                "dashboard.guest": "ភ្ញៀវ",
                "dashboard.room": "បន្ទប់",
                "dashboard.check_in": "ថ្ងៃចូលស្នាក់",
                "dashboard.status": "ស្ថានភាព",
                "room.search_placeholder": "ស្វែងរកឈ្មោះបន្ទប់ ឬ ទីតាំង",
                "room.all_room": "បន្ទប់ទាំងអស់",
                "room.available": "ទំនេរ",
                "room.booked": "បានកក់",
                "room.reset": "កំណត់ឡើងវិញ",
                "room.add_room": "+ បន្ថែមបន្ទប់",
                "room.no_data": "មិនមានទិន្នន័យបន្ទប់តាមតម្រងនេះទេ។",
                "room.room_name": "ឈ្មោះបន្ទប់",
                "room.bed_type": "ប្រភេទគ្រែ",
                "room.room_floor": "ជាន់បន្ទប់",
                "room.room_facility": "សេវាបន្ទប់",
                "room.status": "ស្ថានភាព",
                "room.actions": "សកម្មភាព",
                "room.no_image": "គ្មានរូបភាព",
                "room.view": "មើល",
                "room.edit": "កែសម្រួល",
                "room.delete": "លុប",
                "room.showing": "បង្ហាញ",
                "room.to": "ដល់",
                "room.from": "ពី",
                "room.data": "ទិន្នន័យ",
                "booking.search_placeholder": "ស្វែងរកលេខកក់ ឈ្មោះភ្ញៀវ ឬ អ៊ីមែល",
                "booking.all": "ទាំងអស់",
                "booking.confirmed": "បានបញ្ជាក់",
                "booking.pending": "រង់ចាំ",
                "booking.cancelled": "បានបោះបង់",
                "booking.no_data": "មិនទាន់មានកំណត់ត្រាការកក់ទេ។ សូមបន្ថែមទិន្នន័យក្នុងតារាង bookings។",
                "booking.booking_no": "លេខកក់",
                "booking.guest": "ភ្ញៀវ",
                "booking.room": "បន្ទប់",
                "booking.check_in": "ថ្ងៃចូលស្នាក់",
                "booking.check_out": "ថ្ងៃចេញ",
                "booking.guests": "ចំនួនភ្ញៀវ",
                "booking.total_price": "តម្លៃសរុប",
                "booking.status": "ស្ថានភាព",
                "booking.showing": "បង្ហាញ",
                "booking.to": "ដល់",
                "booking.from": "ពី",
                "booking.bookings": "ការកក់",
                "form.room_name": "ឈ្មោះបន្ទប់",
                "form.location": "ទីតាំង",
                "form.room_count": "ចំនួនបន្ទប់",
                "form.price_per_night": "តម្លៃក្នុងមួយយប់",
                "form.room_image": "រូបភាពបន្ទប់",
                "form.max_file": "ទំហំឯកសារអតិបរមា៖ 2MB (JPEG, PNG, GIF)",
                "form.current_image": "រូបភាពបច្ចុប្បន្ន",
                "form.status": "ស្ថានភាព",
                "form.description": "ពិពណ៌នា / សម្ភារៈបន្ទប់",
                "form.available_for_booking": "អាចកក់បាន",
                "form.cancel": "បោះបង់",
                "form.create_room": "បង្កើតបន្ទប់",
                "form.save_changes": "រក្សាទុកការកែប្រែ",
                "form.placeholder_room_name": "បញ្ចូលឈ្មោះបន្ទប់",
                "form.placeholder_location": "ទីក្រុង ខេត្ត/ប្រទេស",
                "form.placeholder_room_count": "ចំនួនបន្ទប់",
                "form.placeholder_image_url": "https://example.com/room.jpg",
                "form.image_url_help": "ប្រើតំណរូបភាព (អាចដាក់មាន ឬ គ្មាន https://)",
                "form.placeholder_description": "ពិពណ៌នាសេវា និងព័ត៌មានបន្ទប់",
                "show.back": "ត្រឡប់ក្រោយ",
                "show.room_count": "ចំនួនបន្ទប់",
                "show.price_per_night": "តម្លៃក្នុងមួយយប់",
                "show.room_description": "ពិពណ៌នាបន្ទប់",
                "show.no_description": "មិនទាន់មានពិពណ៌នាទេ។"
            }
        };

        const getThemeIcon = (theme) => {
            if (theme === "dark") {
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2.5M12 19.5V22M4.93 4.93l1.77 1.77M17.3 17.3l1.77 1.77M2 12h2.5M19.5 12H22M4.93 19.07l1.77-1.77M17.3 6.7l1.77-1.77"></path></svg>';
            }
            return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 1 0 9.8 9.8z"></path></svg>';
        };

        const setTheme = (theme) => {
            document.documentElement.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
            const button = document.getElementById("theme-toggle");
            if (button) {
                button.innerHTML = getThemeIcon(theme);
            }
        };

        const translatePage = (language) => {
            const map = translations[language] || translations.en;
            document.documentElement.lang = language === "km" ? "km" : "en";
            localStorage.setItem("lang", language);

            document.querySelectorAll("[data-i18n]").forEach((element) => {
                const key = element.getAttribute("data-i18n");
                if (map[key]) {
                    element.textContent = map[key];
                }
            });

            document.querySelectorAll("[data-i18n-placeholder]").forEach((element) => {
                const key = element.getAttribute("data-i18n-placeholder");
                if (map[key]) {
                    element.setAttribute("placeholder", map[key]);
                }
            });

            document.querySelectorAll("[data-i18n-title]").forEach((element) => {
                const key = element.getAttribute("data-i18n-title");
                if (map[key]) {
                    element.setAttribute("title", map[key]);
                }
            });

            const langLabel = document.getElementById("lang-toggle-label");
            if (langLabel) {
                langLabel.textContent = language === "km" ? "EN" : "KH";
            }
        };

        const preferredTheme = localStorage.getItem("theme")
            || (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");
        const preferredLang = localStorage.getItem("lang") || "en";

        setTheme(preferredTheme);
        translatePage(preferredLang);

        const themeToggle = document.getElementById("theme-toggle");
        if (themeToggle) {
            themeToggle.addEventListener("click", () => {
                const current = document.documentElement.getAttribute("data-theme") || "light";
                setTheme(current === "dark" ? "light" : "dark");
            });
        }

        const langToggle = document.getElementById("lang-toggle");
        if (langToggle) {
            langToggle.addEventListener("click", () => {
                const current = localStorage.getItem("lang") || "en";
                translatePage(current === "km" ? "en" : "km");
            });
        }
    </script>
</body>
</html>

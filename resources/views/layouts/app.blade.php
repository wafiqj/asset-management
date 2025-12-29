<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Asset Management') - IT Asset Management</title>
    <link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dhl-yellow: #FFCC00;
            --dhl-yellow-light: #FFE066;
            --dhl-yellow-dark: #E6B800;
            --dhl-red: #D40511;
            --dhl-red-dark: #B00410;
            --dhl-black: #333333;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #FFFEF5;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, var(--dhl-yellow) 0%, var(--dhl-yellow-dark) 100%);
            color: var(--dhl-black);
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            background: var(--dhl-red);
            color: white;
            border-bottom: 3px solid var(--dhl-yellow-dark);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-link {
            color: var(--dhl-black);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.5);
            border-left-color: var(--dhl-red);
        }

        .sidebar-nav .nav-link.active {
            background: var(--dhl-red);
            color: white;
            border-left-color: var(--dhl-black);
        }

        .sidebar-nav .nav-header {
            padding: 1.25rem 1.5rem 0.5rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--dhl-red);
            letter-spacing: 0.1em;
            font-weight: 700;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: linear-gradient(90deg, var(--dhl-red) 0%, var(--dhl-red-dark) 100%);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .top-navbar h5 {
            color: white;
        }

        .top-navbar .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .top-navbar .btn-link {
            color: white !important;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, var(--dhl-yellow) 0%, var(--dhl-yellow-light) 100%);
            color: var(--dhl-black);
            border-bottom: 3px solid var(--dhl-red);
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .card-header a {
            color: var(--dhl-red);
        }

        .badge-status {
            padding: 0.375rem 0.75rem;
            font-weight: 500;
            border-radius: 9999px;
        }

        .table th {
            font-weight: 600;
            color: var(--dhl-black);
            background: #FFFBEB;
            border-bottom: 2px solid var(--dhl-yellow);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--dhl-red) 0%, var(--dhl-red-dark) 100%);
            border: none;
            font-weight: 600;
            color: white !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dhl-red-dark) 0%, #900310 100%);
            color: white !important;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #444 0%, #111 100%);
            border: none;
            font-weight: 600;
            color: white !important;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #111 0%, #111 100%);
            color: white !important;
        }

        .btn-warning,
        .btn-outline-success {
            background-color: var(--dhl-yellow);
            border-color: var(--dhl-yellow-dark);
            color: var(--dhl-black);
            font-weight: 600;
        }

        .btn-warning:hover,
        .btn-outline-success:hover {
            background-color: var(--dhl-yellow-dark);
            border-color: var(--dhl-yellow-dark);
            color: var(--dhl-black);
        }

        .stat-card {
            border-radius: 1rem;
            padding: 1.5rem;
            color: white;
            border: none;
        }

        .stat-card.bg-gradient-primary {
            background: linear-gradient(135deg, var(--dhl-yellow) 0%, var(--dhl-yellow-dark) 100%);
            color: var(--dhl-black);
        }

        .stat-card.bg-gradient-primary h2,
        .stat-card.bg-gradient-primary h6 {
            color: var(--dhl-black) !important;
        }

        .stat-card.bg-gradient-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .stat-card.bg-gradient-warning {
            background: linear-gradient(135deg, var(--dhl-red) 0%, var(--dhl-red-dark) 100%);
        }

        .stat-card.bg-gradient-danger {
            background: linear-gradient(135deg, #333333 0%, #1a1a1a 100%);
        }

        a {
            color: var(--dhl-red);
        }

        a:hover {
            color: var(--dhl-red-dark);
        }

        .alert-success {
            background: linear-gradient(90deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(90deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid var(--dhl-red);
        }

        /* .progress-bar.bg-primary {
            background-color: var(--dhl-red) !important;
        } */

        .progress-bar.bg-warning {
            background-color: var(--dhl-yellow) !important;
        }

        /* Sidebar Toggle */
        .sidebar-toggle {
            background: var(--dhl-yellow);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--dhl-black);
            font-size: 1.2rem;
        }

        .sidebar-toggle:hover {
            background: var(--dhl-yellow-dark);
            transform: scale(1.05);
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        body.sidebar-collapsed .sidebar {
            width: 70px;
        }

        body.sidebar-collapsed .sidebar-brand {
            padding: 1.5rem 0.5rem;
            text-align: center;
            font-size: 0;
        }

        body.sidebar-collapsed .sidebar-brand i {
            font-size: 1.5rem;
            margin: 0;
        }

        body.sidebar-collapsed .sidebar-nav .nav-link {
            padding: 0.75rem;
            justify-content: center;
        }

        body.sidebar-collapsed .sidebar-nav .nav-link span {
            display: none;
        }

        body.sidebar-collapsed .sidebar-nav .nav-link i {
            font-size: 1.2rem;
        }

        body.sidebar-collapsed .sidebar-nav .nav-header {
            display: none;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 70px;
        }

        /* Tooltip for collapsed sidebar */
        body.sidebar-collapsed .sidebar-nav .nav-link {
            position: relative;
        }

        body.sidebar-collapsed .sidebar-nav .nav-link:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 75px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--dhl-black);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 1001;
            font-size: 0.875rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('icon.png') }}" alt="DSC ID - IT Asset" width="30" class="me-2">
            <span>IT Asset Manage</span>
        </div>
        <div class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                data-title="Dashboard">
                <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
            </a>

            <div class="nav-header">Asset Management</div>
            <a href="{{ route('assets.index') }}" class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}"
                data-title="Assets">
                <i class="bi bi-pc-display"></i> <span>Assets</span>
            </a>
            <a href="{{ route('assignments.index') }}"
                class="nav-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}" data-title="Assignments">
                <i class="bi bi-arrow-left-right"></i> <span>Assignments</span>
            </a>
            <a href="{{ route('maintenance.index') }}"
                class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}" data-title="Maintenance">
                <i class="bi bi-tools"></i> <span>Maintenance</span>
            </a>
            <a href="{{ route('incidents.index') }}"
                class="nav-link {{ request()->routeIs('incidents.*') ? 'active' : '' }}" data-title="Incidents">
                <i class="bi bi-exclamation-triangle"></i> <span>Incidents</span>
            </a>

            <div class="nav-header">Master Data</div>
            <a href="{{ route('categories.index') }}"
                class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" data-title="Categories">
                <i class="bi bi-tags"></i> <span>Categories</span>
            </a>
            <a href="{{ route('locations.index') }}"
                class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}" data-title="Locations">
                <i class="bi bi-geo-alt"></i> <span>Locations</span>
            </a>
            <a href="{{ route('departments.index') }}"
                class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" data-title="Departments">
                <i class="bi bi-building"></i> <span>Departments</span>
            </a>

            @if(auth()->user()->hasPermission('users.view'))
                <div class="nav-header">Administration</div>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                    data-title="Users">
                    <i class="bi bi-people"></i> <span>Users</span>
                </a>
            @endif

            @if(auth()->user()->hasPermission('audit.view'))
                <a href="{{ route('audit.index') }}" class="nav-link {{ request()->routeIs('audit.*') ? 'active' : '' }}"
                    data-title="Audit Trail">
                    <i class="bi bi-journal-text"></i> <span>Audit Trail</span>
                </a>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                    <i class="bi bi-list" id="sidebar-toggle-icon"></i>
                </button>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">{{ auth()->user()->name }}</span>
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-collapsed');
            const icon = document.getElementById('sidebar-toggle-icon');
            if (document.body.classList.contains('sidebar-collapsed')) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-chevron-right');
                localStorage.setItem('sidebarCollapsed', 'true');
            } else {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-list');
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        }

        // Restore sidebar state on page load
        document.addEventListener('DOMContentLoaded', function () {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
                const icon = document.getElementById('sidebar-toggle-icon');
                icon.classList.remove('bi-list');
                icon.classList.add('bi-chevron-right');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin') - Metascholar Consult</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Icofont -->
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        /* Top Navigation */
        .top-nav {
            background: #fff;
            color: #333;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 70px;
            border-bottom: 3px solid #01b2ac;
        }

        .top-nav .container-fluid {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: 700;
            color: #333;
            text-decoration: none;
        }

        .nav-brand i {
            font-size: 28px;
            color: #01b2ac;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8f9fa;
            padding: 8px 20px;
            border-radius: 50px;
            border: 1px solid #e0e0e0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #01b2ac;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .btn-logout {
            background: #dc3545;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #c82333;
            color: white;
            transform: translateY(-2px);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            width: 260px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 25px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-menu a i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .sidebar-menu a:hover {
            background: #f8f9fa;
            color: #01b2ac;
        }

        .sidebar-menu a.active {
            background: #01b2ac;
            color: white;
            border-radius: 0 25px 25px 0;
            margin-right: 10px;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 20px;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            font-size: 18px;
        }

        .card-body {
            padding: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .user-info span {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="container-fluid">
            <a href="{{ route('super-admin.dashboard') }}" class="nav-brand">
                <i class="icofont-shield"></i>
                <span>Super Admin</span>
            </a>

            <div class="nav-user">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                    </div>
                    <span>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                </div>
                <a href="{{ route('logout') }}" class="btn-logout">
                    <i class="icofont-logout"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('super-admin.dashboard') }}" class="{{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                    <i class="icofont-dashboard-web"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.subscriptions.index') }}" class="{{ request()->routeIs('super-admin.subscriptions.*') ? 'active' : '' }}">
                    <i class="icofont-tasks-alt"></i>
                    <span>Subscriptions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.payments.index') }}" class="{{ request()->routeIs('super-admin.payments.*') ? 'active' : '' }}">
                    <i class="icofont-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.maintenance.index') }}" class="{{ request()->routeIs('super-admin.maintenance.*') ? 'active' : '' }}">
                    <i class="icofont-tools"></i>
                    <span>Maintenance</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.settings.index') }}" class="{{ request()->routeIs('super-admin.settings.*') ? 'active' : '' }}">
                    <i class="icofont-settings-alt"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.roles.index') }}" class="{{ request()->routeIs('super-admin.roles.*') ? 'active' : '' }}">
                    <i class="icofont-users-alt-3"></i>
                    <span>User Roles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('super-admin.analytics') }}" class="{{ request()->routeIs('super-admin.analytics') ? 'active' : '' }}">
                    <i class="icofont-chart-bar-graph"></i>
                    <span>Analytics</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="icofont-check-circled"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="icofont-error"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="icofont-warning"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KUESAENA') - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background-color: #fff;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            padding: 0 20px 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .logo img {
            max-width: 180px;
            height: auto;
        }

        .menu {
            margin-top: 20px;
        }

        .menu a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .menu a:hover {
            background-color: #f8f8f8;
            color: #5C4033;
        }

        .menu a.active {
            background-color: #5C4033;
            color: #fff;
            border-left: 4px solid #3E2723;
        }

        .menu a i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
            padding: 8px 16px;
            border-radius: 8px;
            gap: 8px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 250px;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-badge {
            background-color: #5C4033;
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: #f5f5f5;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .icon-btn:hover {
            background-color: #e0e0e0;
        }

        /* Content Area */
        .content {
            padding: 40px;
            flex: 1;
        }

        /* Footer */
        .footer {
            background-color: #5C4033;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        /* Icon placeholders - gunakan icon library seperti Font Awesome atau Boxicons */
        .icon-home::before { content: "🏠"; }
        .icon-cash::before { content: "💰"; }
        .icon-box::before { content: "📦"; }
        .icon-cart::before { content: "🛒"; }
        .icon-history::before { content: "📜"; }
        .icon-chart::before { content: "📊"; }
        .icon-wallet::before { content: "💳"; }
        .icon-users::before { content: "👥"; }
        .icon-tag::before { content: "🏷️"; }
        .icon-admin::before { content: "👤"; }
        .icon-search::before { content: "🔍"; }
        .icon-settings::before { content: "⚙️"; }
        .icon-bell::before { content: "🔔"; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar .logo,
            .menu a span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .navbar {
                padding: 15px 20px;
            }

            .search-box {
                display: none;
            }

            .content {
                padding: 20px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            @include('layouts.partials.navbar')

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer">
                @ Copyright 2025, All Rights Reserved by Kuesaena
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

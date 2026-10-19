<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel – Dapur Bunda</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body class="admin-body">

    <!-- ===== SIDEBAR BACKDROP (MOBILE) ===== -->
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="admin-sidebar" id="admin-sidebar">
        <!-- Logo -->
        <div class="sidebar-logo-area">
            <div class="sidebar-logo-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <div class="sidebar-logo-text">
                <span class="logo-brand">Dapur</span>
                <span class="logo-brand">Bunda</span>
            </div>
        </div>

        <!-- Nav Links -->
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-nav-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="sidebar-nav-item {{ str_contains(Route::currentRouteName() ?? '', 'admin.orders') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i>
                <span>Orders</span>
                @php $pendingCount = \App\Models\CustomOrder::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="sidebar-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.menu.index') }}"
               class="sidebar-nav-item {{ str_contains(Route::currentRouteName() ?? '', 'admin.menu') ? 'active' : '' }}">
                <i class="fa-solid fa-utensils"></i>
                <span>Menu Management</span>
            </a>
            <a href="{{ route('admin.chat') }}"
               class="sidebar-nav-item {{ Route::currentRouteName() == 'admin.chat' ? 'active' : '' }}">
                <i class="fa-solid fa-inbox"></i>
                <span>Chat Inbox</span>
                <span class="sidebar-badge" id="sidebar-chat-badge" style="display: none;">0</span>
            </a>
            <a href="{{ route('admin.analytics') }}"
               class="sidebar-nav-item {{ Route::currentRouteName() == 'admin.analytics' ? 'active' : '' }}">
                <i class="fa-solid fa-chart-bar"></i>
                <span>Analytics</span>
            </a>
            <a href="{{ route('admin.reviews.index') }}"
               class="sidebar-nav-item {{ str_contains(Route::currentRouteName() ?? '', 'admin.reviews') ? 'active' : '' }}">
                <i class="fa-solid fa-star"></i>
                <span>Ulasan Customer</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('home') }}" class="sidebar-nav-item" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>View Website</span>
            </a>
            <a href="{{ route('admin.settings') }}"
               class="sidebar-nav-item {{ Route::currentRouteName() == 'admin.settings' ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
            <div class="sidebar-divider"></div>
            <a href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();" class="sidebar-nav-item" style="color:var(--brand-red);">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Logout</span>
            </a>
            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>

        <!-- User Profile -->
        <div class="sidebar-user-area">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=80&h=80&q=80" alt="Admin">
            <div class="sidebar-user-info">
                <span class="user-name">Bunda Admin</span>
                <span class="user-role">Kitchen Manager</span>
            </div>
        </div>

        <!-- New Listing CTA -->
        <a href="{{ route('admin.menu.create') }}" class="sidebar-new-listing-btn">
            <i class="fa-solid fa-plus"></i> New Listing
        </a>
    </aside>

    <!-- ===== MAIN WRAPPER ===== -->
    <div class="admin-main-wrapper">

        <!-- Top Bar -->
        <header class="admin-topbar">
            <button class="topbar-mobile-toggle" id="sidebar-toggle-btn" aria-label="Toggle Sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="topbar-search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search orders..." id="admin-global-search">
            </div>
            <div class="topbar-actions">
                <button class="topbar-icon-btn" id="topbar-notif-btn" aria-label="Notifications">
                    <i class="fa-regular fa-bell"></i>
                    <span class="topbar-notif-dot"></span>
                </button>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="admin-flash success" id="admin-flash-msg">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
                <button onclick="document.getElementById('admin-flash-msg').remove()" class="flash-close">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="admin-flash error" id="admin-flash-msg">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
                <button onclick="document.getElementById('admin-flash-msg').remove()" class="flash-close">&times;</button>
            </div>
        @endif

        <!-- Page Content -->
        <main class="admin-page-content">
            @yield('admin-content')
        </main>
    </div>

    @php
        // Mengambil pesanan pending terbaru yang dibuat dalam 24 jam terakhir untuk notifikasi dinamis
        $latestPendingOrder = \App\Models\CustomOrder::where('status', 'pending')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->first();
    @endphp
    @if($latestPendingOrder)
    <!-- New Order Toast -->
    <div class="admin-toast-notification" id="admin-order-toast">
        <div class="toast-icon-wrap">
            <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <div class="toast-body-text">
            <strong>Pesanan Baru Masuk!</strong>
            <span>Order #{{ $latestPendingOrder->id }} oleh {{ $latestPendingOrder->customer_name }}</span>
            <div class="toast-actions-row">
                <form action="{{ route('admin.orders.status', $latestPendingOrder->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="processing">
                    <button type="submit" class="toast-action-btn accept">TERIMA</button>
                </form>
                <a href="{{ route('admin.orders.index') }}" class="toast-action-btn view">LIHAT</a>
            </div>
        </div>
        <button class="toast-close-btn" onclick="document.getElementById('admin-order-toast').remove()">&times;</button>
    </div>
    @endif

    @yield('admin-scripts')
    <script src="/js/admin.js"></script>

    <!-- Global Firebase Chat Badge Listener -->
    <script type="module">
        import { listenAllChats } from '/js/firebase-chat.js';
        
        const badge = document.getElementById('sidebar-chat-badge');
        if (badge) {
            listenAllChats((threads) => {
                let totalUnread = 0;
                threads.forEach(t => {
                    if (t.unread) {
                        totalUnread += parseInt(t.unread) || 0;
                    }
                });
                
                if (totalUnread > 0) {
                    badge.textContent = totalUnread;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

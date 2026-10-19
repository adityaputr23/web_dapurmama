@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Admin Overview</h1>
        <p class="admin-page-subtitle">Welcome back to the modern hearth. Here's what's happening today.</p>
    </div>
</div>

<!-- ─── Stat Cards ──────────────────────────────────────────────── -->
<div class="stat-cards-grid">
    <div class="stat-card">
        <div class="stat-card-icon icon-orange">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div class="stat-card-body">
            <p class="stat-label">TOTAL SALES</p>
            <h3 class="stat-value">Rp {{ number_format(($totalOrders * 85000), 0, ',', '.') }}</h3>
            <span class="stat-change positive"><i class="fa-solid fa-arrow-trend-up"></i> +12% minggu ini</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon icon-teal">
            <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <div class="stat-card-body">
            <p class="stat-label">ACTIVE ORDERS</p>
            <h3 class="stat-value">{{ $activeOrders }}</h3>
            <span class="stat-change neutral">{{ $completedOrders }} selesai hari ini</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon icon-purple">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-card-body">
            <p class="stat-label">NEW CUSTOMERS</p>
            <h3 class="stat-value">{{ $newCustomers }}</h3>
            <span class="stat-change positive"><i class="fa-solid fa-arrow-trend-up"></i> +5% kenaikan</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon icon-red">
            <i class="fa-solid fa-star"></i>
        </div>
        <div class="stat-card-body">
            <p class="stat-label">AVG. RATING</p>
            <h3 class="stat-value">{{ number_format($avgRating ?? 4.9, 1) }}/5.0</h3>
            <span class="stat-change neutral">Berdasarkan ulasan</span>
        </div>
    </div>
</div>

<!-- ─── Body Grid ─────────────────────────────────────────────────── -->
<div class="dashboard-body-grid">

    <!-- LEFT: Manage Menu + Sales Chart -->
    <div class="dashboard-left-col">

        <!-- Manage Menu Table -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Manage Menu</h2>
                <div class="card-header-actions">
                    <button class="btn-admin btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
                    <a href="{{ route('admin.menu.create') }}" class="btn-admin btn-primary"><i class="fa-solid fa-plus"></i> Add Item</a>
                </div>
            </div>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ITEM DETAILS</th>
                            <th>CATEGORY</th>
                            <th>PRICE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus->take(5) as $menu)
                        <tr>
                            <td>
                                <div class="table-item-detail">
                                    <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}" class="table-item-img">
                                    <div>
                                        <p class="table-item-name">{{ $menu->name }}</p>
                                        <p class="table-item-desc">{{ Str::limit($menu->description, 30) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="category-badge cat-{{ strtolower(str_replace(' ', '-', $menu->category ?? 'other')) }}">
                                    {{ strtoupper($menu->category ?? 'Other') }}
                                </span>
                            </td>
                            <td>
                                <span class="table-price">Rp {{ number_format($menu->price * 1000, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="status-pill status-{{ $menu->status ?? 'available' }}">
                                    <span class="status-dot"></span>
                                    {{ $menu->status === 'sold_out' ? 'Sold Out' : 'Available' }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.menu.edit', $menu) }}" class="action-btn edit" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" class="inline-form" onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-table-row">Belum ada menu. <a href="{{ route('admin.menu.create') }}">Tambah sekarang</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($menus->count() > 5)
            <div class="card-view-all-row">
                <a href="{{ route('admin.menu.index') }}" class="view-all-link">Lihat Semua Menu <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            @endif
        </div>

        <!-- Sales Performance Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Sales Performance</h2>
                <div class="chart-period-badge">
                    <i class="fa-solid fa-calendar-days"></i> Last 7 Days
                </div>
            </div>
            <div class="chart-container" id="sales-chart-wrapper">
                <canvas id="salesBarChart" height="160"></canvas>
            </div>
        </div>
    </div>

    <!-- RIGHT: Recent Activity + Chat Inbox -->
    <div class="dashboard-right-col">

        <!-- Recent Activity -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Recent Activity</h2>
            </div>
            <ul class="activity-feed">
                @forelse($recentOrders as $order)
                <li class="activity-item">
                    <div class="activity-icon-wrap {{ $order->status === 'completed' ? 'icon-green' : ($order->status === 'cancelled' ? 'icon-red' : 'icon-orange') }}">
                        <i class="fa-solid {{ $order->status === 'completed' ? 'fa-circle-check' : ($order->status === 'cancelled' ? 'fa-circle-xmark' : 'fa-clock') }}"></i>
                    </div>
                    <div class="activity-body">
                        <p class="activity-title">
                            @if($order->status === 'completed') Order Selesai
                            @elseif($order->status === 'cancelled') Order Dibatalkan
                            @else Pesanan Baru dari {{ $order->customer_name }}
                            @endif
                        </p>
                        <span class="activity-time">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                </li>
                @empty
                <li class="activity-item-empty">Belum ada aktivitas.</li>
                @endforelse
                <li class="activity-item">
                    <div class="activity-icon-wrap icon-blue">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>
                    <div class="activity-body">
                        <p class="activity-title">New Message</p>
                        <p class="activity-desc">Inquiry about custom catering for 50 pax</p>
                        <span class="activity-time">1 jam lalu</span>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon-wrap icon-amber">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="activity-body">
                        <p class="activity-title">Low Stock Alert</p>
                        <p class="activity-desc">Santan kelapa turun di bawah 10%</p>
                        <span class="activity-time">3 jam lalu</span>
                    </div>
                </li>
            </ul>
            <div class="card-view-all-row">
                <a href="{{ route('admin.orders.index') }}" class="view-all-link">Lihat Semua Aktivitas <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Chat Inbox -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Chat Inbox</h2>
                <span class="chat-new-badge">3 New</span>
            </div>
            <ul class="chat-inbox-list">
                <li class="chat-inbox-item">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Andini Putri" class="chat-avatar">
                    <div class="chat-inbox-body">
                        <div class="chat-inbox-meta">
                            <span class="chat-sender-name">Andini Putri</span>
                            <span class="chat-time">10:45 AM</span>
                        </div>
                        <p class="chat-preview">Is the catering menu available for...</p>
                    </div>
                    <span class="chat-unread-dot"></span>
                </li>
                <li class="chat-inbox-item">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Budi Santoso" class="chat-avatar">
                    <div class="chat-inbox-body">
                        <div class="chat-inbox-meta">
                            <span class="chat-sender-name">Budi Santoso</span>
                            <span class="chat-time">09:12 AM</span>
                        </div>
                        <p class="chat-preview">Halo bunda, apakah bisa pesan nasi...</p>
                    </div>
                    <span class="chat-unread-dot"></span>
                </li>
                <li class="chat-inbox-item">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Siti Rahayu" class="chat-avatar">
                    <div class="chat-inbox-body">
                        <div class="chat-inbox-meta">
                            <span class="chat-sender-name">Siti Rahayu</span>
                            <span class="chat-time">Yesterday</span>
                        </div>
                        <p class="chat-preview">Pesanan saya sudah dikirim belum ya?</p>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</div>
@endsection

@section('admin-scripts')
<script>
    // Pass PHP sales data to JS
    window.salesChartData = @json($salesData);
</script>
@endsection

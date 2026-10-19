@extends('layouts.admin')

@section('admin-content')

{{-- ─── PAGE HEADER ──────────────────────────────────────────── --}}
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Analytics</h1>
        <p class="admin-page-subtitle">Gambaran performa penjualan dan popularitas menu.</p>
    </div>
    <div style="font-size: 13px; color: var(--admin-text-muted);">
        <i class="fa-regular fa-calendar-check"></i>
        Update: {{ now()->format('d M Y, H:i') }} WIB
    </div>
</div>

{{-- ─── TOP KPI CARDS ────────────────────────────────────────── --}}
<div class="analytics-kpi-row">
    @php
        $totalMenus      = \App\Models\Menu::count();
        $totalOrders     = \App\Models\CustomOrder::count();
        $doneOrders      = \App\Models\CustomOrder::where('status','completed')->count();
        $pendingOrders   = \App\Models\CustomOrder::where('status','pending')->count();
        $soldOut         = \App\Models\Menu::where('status','sold_out')->count();
        $featured        = \App\Models\Menu::where('is_featured',true)->count();
        $conversionRate  = $totalOrders > 0 ? round(($doneOrders / $totalOrders) * 100) : 0;
    @endphp

    <div class="kpi-card">
        <div class="kpi-icon" style="background: #fff4ef; color: #c8735a;">
            <i class="fa-solid fa-utensils"></i>
        </div>
        <div class="kpi-data">
            <span class="kpi-value">{{ $totalMenus }}</span>
            <span class="kpi-label">Total Menu</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background: #edf2ff; color: #4c6ef5;">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <div class="kpi-data">
            <span class="kpi-value">{{ $totalOrders }}</span>
            <span class="kpi-label">Total Pesanan</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background: #ebfbee; color: #2f9e44;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="kpi-data">
            <span class="kpi-value">{{ $doneOrders }}</span>
            <span class="kpi-label">Pesanan Selesai</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background: #fff8e7; color: #f59f00;">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="kpi-data">
            <span class="kpi-value">{{ $pendingOrders }}</span>
            <span class="kpi-label">Pending</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon" style="background: #f8f0ff; color: #ae3ec9;">
            <i class="fa-solid fa-star"></i>
        </div>
        <div class="kpi-data">
            <span class="kpi-value">{{ $conversionRate }}%</span>
            <span class="kpi-label">Completion Rate</span>
        </div>
    </div>
</div>

{{-- ─── CHARTS ROW ───────────────────────────────────────────── --}}
<div class="analytics-charts-row">
    <!-- Monthly Sales Chart -->
    <div class="analytics-card analytics-card-wide">
        <div class="analytics-card-header">
            <div>
                <h3 class="analytics-card-title">Penjualan Bulanan</h3>
                <p class="analytics-card-sub">12 bulan terakhir</p>
            </div>
            <div class="analytics-legend">
                <span class="legend-bar"></span> Estimasi Pendapatan
            </div>
        </div>
        <div class="chart-area">
            <canvas id="monthlyBarChart" height="120"></canvas>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="analytics-card">
        <div class="analytics-card-header">
            <div>
                <h3 class="analytics-card-title">Menu per Kategori</h3>
                <p class="analytics-card-sub">Distribusi item</p>
            </div>
        </div>
        <div class="chart-area donut-area">
            <canvas id="categoryDoughnutChart" height="200"></canvas>
        </div>
        <ul class="analytics-legend-list">
            @php $palette = ['#c8735a','#5c9e5c','#b0937a','#4a7cb8','#d4a843','#7c68a0']; @endphp
            @foreach($categoryStats as $stat)
            <li class="analytics-legend-item">
                <span class="analytics-legend-dot" style="background:{{ $palette[$loop->index % count($palette)] }};"></span>
                <span>{{ ucfirst($stat->category) }}</span>
                <strong>{{ $stat->total }} item</strong>
            </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- ─── SUMMARY TABLE ────────────────────────────────────────── --}}
<div class="analytics-card" style="margin-top: 0;">
    <div class="analytics-card-header">
        <div>
            <h3 class="analytics-card-title">Ringkasan Metrik</h3>
            <p class="analytics-card-sub">Snapshot performa terkini</p>
        </div>
    </div>
    <div class="analytics-metrics-grid">
        <div class="metric-row">
            <div class="metric-info">
                <i class="fa-solid fa-bowl-food" style="color:#c8735a;"></i>
                <span>Menu Aktif</span>
            </div>
            <div class="metric-bar-wrap">
                <div class="metric-bar" style="width: {{ $totalMenus > 0 ? ((\App\Models\Menu::where('status','available')->count()) / $totalMenus * 100) : 0 }}%; background:#c8735a;"></div>
            </div>
            <strong>{{ \App\Models\Menu::where('status','available')->count() }}</strong>
        </div>
        <div class="metric-row">
            <div class="metric-info">
                <i class="fa-solid fa-ban" style="color:#e03131;"></i>
                <span>Menu Sold Out</span>
            </div>
            <div class="metric-bar-wrap">
                <div class="metric-bar" style="width: {{ $totalMenus > 0 ? ($soldOut / $totalMenus * 100) : 0 }}%; background:#e03131;"></div>
            </div>
            <strong>{{ $soldOut }}</strong>
        </div>
        <div class="metric-row">
            <div class="metric-info">
                <i class="fa-solid fa-fire" style="color:#f59f00;"></i>
                <span>Menu Featured</span>
            </div>
            <div class="metric-bar-wrap">
                <div class="metric-bar" style="width: {{ $totalMenus > 0 ? ($featured / $totalMenus * 100) : 0 }}%; background:#f59f00;"></div>
            </div>
            <strong>{{ $featured }}</strong>
        </div>
        <div class="metric-row">
            <div class="metric-info">
                <i class="fa-solid fa-circle-check" style="color:#2f9e44;"></i>
                <span>Pesanan Selesai</span>
            </div>
            <div class="metric-bar-wrap">
                <div class="metric-bar" style="width: {{ $conversionRate }}%; background:#2f9e44;"></div>
            </div>
            <strong>{{ $doneOrders }}/{{ $totalOrders }}</strong>
        </div>
        <div class="metric-row">
            <div class="metric-info">
                <i class="fa-solid fa-ban" style="color:#868e96;"></i>
                <span>Pesanan Dibatalkan</span>
            </div>
            <div class="metric-bar-wrap">
                <div class="metric-bar" style="width: {{ $totalOrders > 0 ? (\App\Models\CustomOrder::where('status','cancelled')->count() / $totalOrders * 100) : 0 }}%; background:#868e96;"></div>
            </div>
            <strong>{{ \App\Models\CustomOrder::where('status','cancelled')->count() }}</strong>
        </div>
    </div>
</div>

{{-- ─── STYLES ──────────────────────────────────────────────── --}}
<style>
/* KPI Row */
.analytics-kpi-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media(max-width: 1200px) { .analytics-kpi-row { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 768px)  { .analytics-kpi-row { grid-template-columns: repeat(2, 1fr); } }

.kpi-card {
    background: #fff;
    border: 1px solid var(--admin-border);
    border-radius: var(--radius-md);
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: var(--shadow-sm);
    transition: transform .2s, box-shadow .2s;
}
.kpi-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.kpi-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.kpi-data { display: flex; flex-direction: column; }
.kpi-value { font-size: 24px; font-weight: 800; color: var(--admin-text-primary); line-height: 1.1; }
.kpi-label { font-size: 12px; color: var(--admin-text-muted); margin-top: 2px; font-weight: 500; }

/* Charts Row */
.analytics-charts-row {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 20px;
    margin-bottom: 20px;
}
@media(max-width: 1024px) { .analytics-charts-row { grid-template-columns: 1fr; } }

/* Analytics Card */
.analytics-card {
    background: #fff;
    border: 1px solid var(--admin-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    min-width: 0;
}
.analytics-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--admin-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #faf8f5;
}
.analytics-card-title { font-size: 15px; font-weight: 700; color: var(--admin-text-primary); }
.analytics-card-sub   { font-size: 12px; color: var(--admin-text-muted); margin-top: 2px; }
.analytics-legend     { font-size: 12px; color: var(--admin-text-secondary); display: flex; align-items: center; gap: 6px; }
.legend-bar           { display: inline-block; width: 24px; height: 6px; background: var(--brand-orange); border-radius: 3px; }

.chart-area   { padding: 20px; position: relative; width: 100%; overflow: hidden; min-width: 0; }
.donut-area   { max-width: 240px; margin: 0 auto; padding: 16px; position: relative; width: 100%; }

/* Legend List */
.analytics-legend-list { list-style: none; padding: 0 20px 20px; display: flex; flex-direction: column; gap: 8px; }
.analytics-legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--admin-text-secondary);
}
.analytics-legend-item strong { margin-left: auto; color: var(--admin-text-primary); }
.analytics-legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

/* Metrics Grid */
.analytics-metrics-grid {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.metric-row {
    display: grid;
    grid-template-columns: 160px 1fr 60px;
    align-items: center;
    gap: 12px;
}
.metric-info { display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: var(--admin-text-secondary); }
.metric-bar-wrap { height: 8px; background: #f0ebe4; border-radius: 4px; overflow: hidden; }
.metric-bar { height: 100%; border-radius: 4px; transition: width .6s ease; }
.metric-row strong { font-size: 13.5px; font-weight: 700; color: var(--admin-text-primary); text-align: right; }
</style>

@section('admin-scripts')
<script>
    window.monthlyChartData  = @json($monthlySales);
    window.categoryChartData = @json($categoryStats);
</script>
@endsection
@endsection

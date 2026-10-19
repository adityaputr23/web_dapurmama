@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Menu Management</h1>
        <p class="admin-page-subtitle">Tambah, edit, atau hapus item menu restoran.</p>
    </div>
    <a href="{{ route('admin.menu.create') }}" class="btn-admin btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Menu
    </a>
</div>

<!-- Filters -->
<div class="admin-card">
    <form method="GET" action="{{ route('admin.menu.index') }}" class="filter-form-row">
        <div class="filter-input-group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu...">
        </div>
        <select name="category" class="filter-select">
            <option value="">Semua Kategori</option>
            <option value="main course" {{ request('category') === 'main course' ? 'selected' : '' }}>Main Course</option>
            <option value="dessert"     {{ request('category') === 'dessert' ? 'selected' : '' }}>Dessert</option>
            <option value="appetizer"   {{ request('category') === 'appetizer' ? 'selected' : '' }}>Appetizer</option>
            <option value="beverages"   {{ request('category') === 'beverages' ? 'selected' : '' }}>Beverages</option>
        </select>
        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="sold_out"  {{ request('status') === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
        </select>
        <button type="submit" class="btn-admin btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="{{ route('admin.menu.index') }}" class="btn-admin btn-outline">Reset</a>
    </form>
</div>

<!-- Menu Table -->
<div class="admin-card">
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ITEM DETAILS</th>
                    <th>CATEGORY</th>
                    <th>PRICE</th>
                    <th>RATING</th>
                    <th>STATUS</th>
                    <th>FEATURED</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>
                        <div class="table-item-detail">
                            <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}" class="table-item-img">
                            <div>
                                <p class="table-item-name">{{ $menu->name }}</p>
                                <p class="table-item-desc">{{ Str::limit($menu->description, 40) }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="category-badge cat-{{ strtolower(str_replace(' ', '-', $menu->category ?? 'other')) }}">
                            {{ strtoupper($menu->category ?? 'Other') }}
                        </span>
                    </td>
                    <td><span class="table-price">Rp {{ number_format($menu->price * 1000, 0, ',', '.') }}</span></td>
                    <td>
                        <span class="rating-cell">
                            <i class="fa-solid fa-star text-amber"></i>
                            {{ number_format($menu->rating ?? 0, 1) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-pill status-{{ $menu->status ?? 'available' }}">
                            <span class="status-dot"></span>
                            {{ $menu->status === 'sold_out' ? 'Sold Out' : 'Available' }}
                        </span>
                    </td>
                    <td>
                        @if($menu->is_featured)
                            <span class="featured-badge"><i class="fa-solid fa-fire"></i> Featured</span>
                        @else
                            <span class="not-featured">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.menu.edit', $menu) }}" class="action-btn edit" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-table-row">Belum ada menu. <a href="{{ route('admin.menu.create') }}">Tambah sekarang</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination-row">
        {{ $menus->links('vendor.pagination.custom-pagination') }}
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Moderasi Ulasan Pelanggan</h1>
        <p class="admin-page-subtitle">Kelola ulasan makanan dan tempat yang dikirimkan oleh customer di landing page.</p>
    </div>
</div>

<!-- Filters -->
<div class="admin-card">
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="filter-form-row">
        <div class="filter-input-group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peninjau atau isi ulasan...">
        </div>
        <button type="submit" class="btn-admin btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="{{ route('admin.reviews.index') }}" class="btn-admin btn-outline">Reset</a>
    </form>
</div>

<!-- Reviews Table -->
<div class="admin-card">
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NAMA CUSTOMER</th>
                    <th>EMAIL</th>
                    <th>RATING</th>
                    <th style="width: 40%;">ULASAN</th>
                    <th>STATUS TAMPIL</th>
                    <th>TANGGAL</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td class="order-id-cell">#{{ $review->id }}</td>
                    <td style="font-weight: 600; color: var(--admin-text-primary);">{{ $review->name }}</td>
                    <td class="table-item-desc">{{ $review->email ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 2px; color: #f59f00;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star" style="font-size: 12px;"></i>
                            @endfor
                        </div>
                    </td>
                    <td>
                        <p style="font-size: 13px; color: var(--admin-text-secondary); line-height: 1.5; word-break: break-word;">
                            {{ $review->comment }}
                        </p>
                    </td>
                    <td>
                        @if($review->is_approved)
                            <span class="status-pill status-available" style="padding: 3px 10px;">
                                <span class="status-dot"></span> Aktif / Tampil
                            </span>
                        @else
                            <span class="status-pill status-sold_out" style="padding: 3px 10px;">
                                <span class="status-dot"></span> Disembunyikan
                            </span>
                        @endif
                    </td>
                    <td>{{ $review->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="table-actions">
                            <!-- Toggle Approve/Hide -->
                            <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST" class="inline-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn {{ $review->is_approved ? 'edit' : 'view' }}"
                                        title="{{ $review->is_approved ? 'Sembunyikan Ulasan' : 'Tampilkan Ulasan' }}">
                                    <i class="fa-solid fa-{{ $review->is_approved ? 'eye-slash' : 'eye' }}"></i>
                                </button>
                            </form>
                            <!-- Delete -->
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline-form"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" title="Hapus Ulasan">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-table-row">Belum ada ulasan yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination-row">
        {{ $reviews->links('vendor.pagination.custom-pagination') }}
    </div>
</div>
@endsection

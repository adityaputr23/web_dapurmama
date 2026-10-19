@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Edit Pesanan <span style="color: var(--brand-orange);">#{{ $order->id }}</span></h1>
        <p class="admin-page-subtitle">Perbaiki data pesanan kustom yang salah input dari pelanggan.</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="settings-container-grid">
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="settings-form-wrapper">
        @csrf
        @method('PUT')

        <div class="settings-grid">
            <!-- Kolom Kiri: Data Pelanggan -->
            <div class="settings-card">
                <div class="card-header-styled">
                    <i class="fa-solid fa-user" style="color: var(--brand-orange);"></i>
                    <h3>Data Pelanggan</h3>
                </div>
                <div class="card-body-styled">
                    @if($errors->any())
                        <div class="error-alert-box">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="form-group-styled">
                        <label for="customer_name">Nama Lengkap</label>
                        <input type="text" id="customer_name" name="customer_name" class="styled-input"
                               value="{{ old('customer_name', $order->customer_name) }}" required>
                    </div>

                    <div class="form-group-styled">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="styled-input"
                               value="{{ old('email', $order->email) }}" required>
                    </div>

                    <div class="form-group-styled">
                        <label for="phone">Nomor Telepon / WhatsApp</label>
                        <input type="text" id="phone" name="phone" class="styled-input"
                               value="{{ old('phone', $order->phone) }}" required>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Pesanan -->
            <div class="settings-card">
                <div class="card-header-styled">
                    <i class="fa-solid fa-clipboard-list" style="color: var(--brand-orange);"></i>
                    <h3>Detail Pesanan</h3>
                </div>
                <div class="card-body-styled">
                    <div class="form-group-styled">
                        <label for="delivery_date">Tanggal Pengiriman</label>
                        <input type="date" id="delivery_date" name="delivery_date" class="styled-input"
                               value="{{ old('delivery_date', $order->delivery_date) }}" required>
                    </div>

                    <div class="form-group-styled">
                        <label for="status">Status Pesanan</label>
                        <select id="status" name="status" class="styled-input">
                            <option value="pending"    {{ old('status', $order->status) === 'pending'    ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ old('status', $order->status) === 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="completed"  {{ old('status', $order->status) === 'completed'  ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled"  {{ old('status', $order->status) === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group-styled">
                        <label for="order_details">Detail Pesanan (Menu & Porsi)</label>
                        <textarea id="order_details" name="order_details" class="styled-input textarea-styled" rows="6" required>{{ old('order_details', $order->order_details) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="settings-action-row" style="justify-content: space-between; margin-top: 24px;">
            <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-outline" style="padding: 12px 24px;">
                Batal
            </a>
            <button type="submit" class="settings-save-btn">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection

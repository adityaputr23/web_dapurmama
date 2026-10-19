@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Settings</h1>
        <p class="admin-page-subtitle">Kelola informasi toko kuliner dan kredensial akun administrator Anda.</p>
    </div>
</div>

<div class="settings-container-grid">
    <!-- Form Card -->
    <form action="{{ route('admin.settings.update') }}" method="POST" class="settings-form-wrapper">
        @csrf
        
        <div class="settings-grid">
            <!-- Left Side: Shop Settings -->
            <div class="settings-card">
                <div class="card-header-styled">
                    <i class="fa-solid fa-store font-brand-color"></i>
                    <h3>Pengaturan Toko</h3>
                </div>
                <div class="card-body-styled">
                    <div class="form-group-styled">
                        <label for="shop_name">Nama Toko / Brand</label>
                        <input type="text" id="shop_name" name="shop_name" class="styled-input" 
                               value="{{ old('shop_name', $settings['shop_name'] ?? '') }}" required>
                    </div>

                    <div class="form-group-styled">
                        <label for="whatsapp_number">Nomor WhatsApp Bantuan</label>
                        <input type="text" id="whatsapp_number" name="whatsapp_number" class="styled-input" 
                               value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" required>
                        <small class="help-text">Nomor kontak pelanggan untuk order manual / WhatsApp CS</small>
                    </div>

                    <div class="form-group-styled">
                        <label for="shop_open_hours">Jam Operasional</label>
                        <input type="text" id="shop_open_hours" name="shop_open_hours" class="styled-input" 
                               value="{{ old('shop_open_hours', $settings['shop_open_hours'] ?? '') }}" required>
                    </div>

                    <div class="form-group-styled">
                        <label for="shop_address">Alamat Toko</label>
                        <textarea id="shop_address" name="shop_address" class="styled-input textarea-styled" rows="4" required>{{ old('shop_address', $settings['shop_address'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Side: Account Settings -->
            <div class="settings-card">
                <div class="card-header-styled">
                    <i class="fa-solid fa-user-gear font-brand-color"></i>
                    <h3>Profil Administrator</h3>
                </div>
                <div class="card-body-styled">
                    @if($errors->any())
                        <div class="error-alert-box">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="form-group-styled">
                        <label for="admin_name">Nama Lengkap</label>
                        <input type="text" id="admin_name" name="admin_name" class="styled-input" 
                               value="{{ old('admin_name', $admin->name) }}" required>
                    </div>

                    <div class="form-group-styled">
                        <label for="admin_email">Email Administrator</label>
                        <input type="email" id="admin_email" name="admin_email" class="styled-input" 
                               value="{{ old('admin_email', $admin->email) }}" required>
                    </div>

                    <div class="divider-styled">
                        <span>Ganti Password (Opsional)</span>
                    </div>

                    <div class="form-group-styled">
                        <label for="admin_password">Password Baru</label>
                        <input type="password" id="admin_password" name="admin_password" class="styled-input" 
                               placeholder="Kosongkan jika tidak ingin diganti">
                    </div>

                    <div class="form-group-styled">
                        <label for="admin_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" id="admin_password_confirmation" name="admin_password_confirmation" 
                               class="styled-input" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Action -->
        <div class="settings-action-row">
            <button type="submit" class="settings-save-btn">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Pengaturan</span>
            </button>
        </div>
    </form>
</div>
@endsection

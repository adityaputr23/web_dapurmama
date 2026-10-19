@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Tambah Menu Baru</h1>
        <p class="admin-page-subtitle">Isi semua detail untuk menambahkan item menu baru.</p>
    </div>
    <a href="{{ route('admin.menu.index') }}" class="btn-admin btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="admin-form-card">
    <form action="{{ route('admin.menu.store') }}" method="POST" id="menu-form">
        @csrf
        @include('admin.menu._form', ['menu' => null])
        <div class="form-actions-row">
            <a href="{{ route('admin.menu.index') }}" class="btn-admin btn-outline">Batal</a>
            <button type="submit" class="btn-admin btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Menu</button>
        </div>
    </form>
</div>
@endsection

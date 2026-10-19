@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Edit Menu: {{ $menu->name }}</h1>
        <p class="admin-page-subtitle">Perbarui detail untuk item menu ini.</p>
    </div>
    <a href="{{ route('admin.menu.index') }}" class="btn-admin btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="admin-form-card">
    <form action="{{ route('admin.menu.update', $menu) }}" method="POST" id="menu-form">
        @csrf @method('PUT')
        @include('admin.menu._form', ['menu' => $menu])
        <div class="form-actions-row">
            <a href="{{ route('admin.menu.index') }}" class="btn-admin btn-outline">Batal</a>
            <button type="submit" class="btn-admin btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

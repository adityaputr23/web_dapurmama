@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Daftar Pesanan Kustom</h1>
        <p class="admin-page-subtitle">Kelola semua pesanan kustom masuk dari pelanggan.</p>
    </div>
</div>

<!-- Filters -->
<div class="admin-card">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-form-row">
        <div class="filter-input-group">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pelanggan...">
        </div>
        <select name="status" class="filter-select">
            <option value="">Semua Status</option>
            <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="completed"  {{ request('status') === 'completed'  ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="btn-admin btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
        <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-outline">Reset</a>
    </form>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>PELANGGAN</th>
                    <th>DETAIL PESANAN</th>
                    <th>TANGGAL KIRIM</th>
                    <th>STATUS</th>
                    <th>DIBUAT</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="order-id-cell">#{{ $order->id }}</td>
                    <td>
                        <p class="table-item-name">{{ $order->customer_name }}</p>
                        <p class="table-item-desc">{{ $order->email }}</p>
                        <p class="table-item-desc">{{ $order->phone }}</p>
                    </td>
                    <td>
                        <p class="order-details-text">{{ Str::limit($order->order_details, 60) }}</p>
                    </td>
                    <td>{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') : '-' }}</td>
                    <td>
                        <select class="status-select-inline order-status-select"
                                data-order-id="{{ $order->id }}"
                                data-url="{{ route('admin.orders.status', $order) }}">
                            <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                            <option value="completed"  {{ $order->status === 'completed'  ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <!-- Lihat Detail -->
                            <button class="action-btn view order-detail-toggle"
                                    data-id="{{ $order->id }}"
                                    data-name="{{ $order->customer_name }}"
                                    data-email="{{ $order->email }}"
                                    data-phone="{{ $order->phone }}"
                                    data-date="{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') : '-' }}"
                                    data-status="{{ $order->status }}"
                                    data-created="{{ $order->created_at->format('d M Y, H:i') }}"
                                    data-details="{{ $order->order_details }}"
                                    title="Lihat & Cetak Nota">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <!-- Edit Pesanan -->
                            <a href="{{ route('admin.orders.edit', $order) }}"
                               class="action-btn edit" title="Edit Pesanan">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-table-row">Belum ada pesanan kustom masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination-row">
        {{ $orders->links('vendor.pagination.custom-pagination') }}
    </div>
</div>

<!-- Nota / Receipt Print Modal -->
<div class="modal-backdrop" id="nota-print-modal" style="align-items: flex-start; padding: 24px;">
    <div class="modal-card" id="nota-modal-card" style="max-width: 520px; width: 100%; border-radius: 16px; overflow: hidden;">
        <div class="modal-header" style="background: #2c2416; color: #fff; padding: 18px 24px;">
            <h3 style="color:#fff; font-size:16px;">
                <i class="fa-solid fa-receipt" style="margin-right:8px; color: #c8b896;"></i>
                Nota Pesanan Kustom
            </h3>
            <div style="display:flex; gap:8px; align-items:center;">
                <button onclick="printNota()" class="btn-nota-print" title="Cetak Nota">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
                <button class="close-modal" id="nota-modal-close" style="color:#fff; background:rgba(255,255,255,.15); border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center;">&times;</button>
            </div>
        </div>
        <div class="modal-body" id="nota-printable-area" style="padding: 0;">
            <!-- Nota Header -->
            <div style="background: linear-gradient(135deg, #c8735a, #a05040); padding: 24px; text-align: center;">
                <div style="font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: #fff; letter-spacing: .5px;">Dapur Bunda</div>
                <div style="font-size: 12px; color: rgba(255,255,255,.8); margin-top: 4px;">Masakan Rumahan Penuh Cinta</div>
            </div>

            <!-- Nota Body -->
            <div style="padding: 24px; background: #fff;">
                <!-- Order meta -->
                <div style="display:flex; justify-content: space-between; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1.5px dashed #e0d5ca;">
                    <div>
                        <div style="font-size: 11px; color: #a89278; text-transform: uppercase; letter-spacing: .05em; font-weight: 700;">No. Pesanan</div>
                        <div style="font-size: 18px; font-weight: 800; color: #c8735a;" id="nota-id">#000</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 11px; color: #a89278; text-transform: uppercase; letter-spacing: .05em; font-weight: 700;">Tanggal Dibuat</div>
                        <div style="font-size: 13px; font-weight: 600; color: #2c2416;" id="nota-created">-</div>
                    </div>
                </div>

                <!-- Customer info -->
                <div style="margin-bottom: 16px; background: #faf7f3; padding: 14px; border-radius: 10px;">
                    <div style="font-size: 11px; color: #a89278; text-transform: uppercase; letter-spacing: .05em; font-weight: 700; margin-bottom: 8px;">Data Pelanggan</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <div>
                            <div style="font-size: 11px; color: #b0a090;">Nama</div>
                            <div style="font-size: 13.5px; font-weight: 600; color: #2c2416;" id="nota-name">-</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: #b0a090;">Telepon</div>
                            <div style="font-size: 13.5px; font-weight: 600; color: #2c2416;" id="nota-phone">-</div>
                        </div>
                        <div style="grid-column: span 2;">
                            <div style="font-size: 11px; color: #b0a090;">Email</div>
                            <div style="font-size: 13.5px; font-weight: 600; color: #2c2416;" id="nota-email">-</div>
                        </div>
                    </div>
                </div>

                <!-- Order details -->
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 11px; color: #a89278; text-transform: uppercase; letter-spacing: .05em; font-weight: 700; margin-bottom: 8px;">Detail Pesanan</div>
                    <div id="nota-details" style="font-size: 13.5px; color: #2c2416; line-height: 1.6; padding: 12px; background: #faf7f3; border-radius: 8px; border-left: 3px solid #c8735a;">-</div>
                </div>

                <!-- Delivery date & status -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div style="padding: 12px; background: #faf7f3; border-radius: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #a89278; font-weight: 700;">Tanggal Pengiriman</div>
                        <div style="font-size: 14px; font-weight: 700; color: #2c2416; margin-top: 4px;" id="nota-date">-</div>
                    </div>
                    <div style="padding: 12px; background: #faf7f3; border-radius: 8px; text-align: center;">
                        <div style="font-size: 11px; color: #a89278; font-weight: 700;">Status Pesanan</div>
                        <div style="margin-top: 6px;" id="nota-status-wrap">-</div>
                    </div>
                </div>

                <!-- Footer -->
                <div style="border-top: 1.5px dashed #e0d5ca; padding-top: 14px; text-align: center;">
                    <div style="font-size: 12px; color: #b0a090;">Terima kasih telah mempercayai <strong style="color: #c8735a;">Dapur Bunda</strong> ❤️</div>
                    <div style="font-size: 11px; color: #c0b0a0; margin-top: 4px;">Nota ini sah sebagai bukti pemesanan.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-nota-print {
    background: rgba(255,255,255,.2);
    color: #fff;
    border: 1px solid rgba(255,255,255,.3);
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background .2s;
}
.btn-nota-print:hover { background: rgba(255,255,255,.3); }
.action-btn.edit {
    background: #eef3ff;
    color: #4c6ef5;
    border: none;
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 13px;
    transition: background .2s;
    text-decoration: none;
}
.action-btn.edit:hover { background: #dce4fd; }
@media print {
    body > * { display: none !important; }
    #nota-print-modal { display: flex !important; position: static !important; background: none !important; padding: 0 !important; }
    #nota-modal-card { box-shadow: none !important; }
    .modal-header button, .close-modal, .btn-nota-print { display: none !important; }
    .modal-header { background: #2c2416 !important; -webkit-print-color-adjust: exact; }
}
</style>

@section('admin-scripts')
<script>
    // ── Order Detail / Nota Toggle ──────────────────────────────
    document.querySelectorAll('.order-detail-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('nota-id').textContent     = '#' + btn.dataset.id;
            document.getElementById('nota-name').textContent   = btn.dataset.name;
            document.getElementById('nota-email').textContent  = btn.dataset.email;
            document.getElementById('nota-phone').textContent  = btn.dataset.phone;
            document.getElementById('nota-date').textContent   = btn.dataset.date;
            document.getElementById('nota-details').textContent = btn.dataset.details;
            document.getElementById('nota-created').textContent = btn.dataset.created;

            // Status badge
            const statusMap = {
                pending:    ['Pending',    '#f59f00', '#fff8e7'],
                processing: ['Diproses',   '#1c7ed6', '#e8f4ff'],
                completed:  ['Selesai',    '#2f9e44', '#ebfbee'],
                cancelled:  ['Dibatalkan', '#e03131', '#fff0f0'],
            };
            const [label, color, bg] = statusMap[btn.dataset.status] || ['Unknown', '#888', '#f0f0f0'];
            document.getElementById('nota-status-wrap').innerHTML =
                `<span style="background:${bg}; color:${color}; font-weight:700; font-size:12.5px; padding:4px 12px; border-radius:20px;">${label}</span>`;

            document.getElementById('nota-print-modal').classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    document.getElementById('nota-modal-close').addEventListener('click', () => {
        document.getElementById('nota-print-modal').classList.remove('active');
        document.body.style.overflow = '';
    });

    document.getElementById('nota-print-modal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('nota-print-modal')) {
            document.getElementById('nota-print-modal').classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    function printNota() {
        window.print();
    }

    // ── Status Select AJAX ──────────────────────────────────────
    document.querySelectorAll('.order-status-select').forEach(sel => {
        sel.addEventListener('change', () => {
            fetch(sel.dataset.url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ status: sel.value })
            });
        });
    });
</script>
@endsection
@endsection

/**
 * DAPUR BUNDA – ADMIN PANEL JS
 * Handles: Charts, inline status update, sidebar toggle, modal, toast auto-hide
 */

// ─── Load Chart.js from CDN dynamically ────────────────────────
(function loadChartJS() {
    if (window.Chart) { initAdminPanel(); return; }
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
    script.onload = initAdminPanel;
    document.head.appendChild(script);
})();

function initAdminPanel() {

    // ─── Global Top Bar Search Handler ──────────────────────────
    const globalSearch = document.getElementById('admin-global-search');
    if (globalSearch) {
        globalSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    const currentUrl = window.location.pathname;
                    if (currentUrl.includes('/admin/menu')) {
                        window.location.href = `/admin/menu?search=${encodeURIComponent(query)}`;
                    } else {
                        window.location.href = `/admin/orders?search=${encodeURIComponent(query)}`;
                    }
                }
            }
        });
    }

    // ─── Sidebar Toggle (Mobile) ──────────────────────────────────
    const sidebarToggle   = document.getElementById('sidebar-toggle-btn');
    const sidebar         = document.getElementById('admin-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');

    function toggleSidebar(state) {
        if (!sidebar) return;
        const isOpen = state !== undefined ? state : !sidebar.classList.contains('open');
        sidebar.classList.toggle('open', isOpen);
        if (sidebarBackdrop) {
            sidebarBackdrop.classList.toggle('active', isOpen);
        }
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebar();
        });
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', () => {
            toggleSidebar(false);
        });
    }

    document.addEventListener('click', (e) => {
        if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(e.target) && sidebarToggle && !sidebarToggle.contains(e.target)) {
            toggleSidebar(false);
        }
    });

    // ─── Dashboard Sales Bar Chart ────────────────────────────────
    const salesCanvas = document.getElementById('salesBarChart');
    if (salesCanvas && window.salesChartData) {
        const labels = window.salesChartData.map(d => d.label);
        const values = window.salesChartData.map(d => d.value);
        const maxVal = Math.max(...values);

        new Chart(salesCanvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Pendapatan (IDR)',
                    data: values,
                    backgroundColor: values.map(v =>
                        v === maxVal ? '#c8735a' : '#d4b483'
                    ),
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'IDR ' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Inter' }, color: '#a89880' }
                    },
                    y: {
                        grid: { color: '#f0ebe3', drawBorder: false },
                        ticks: {
                            font: { size: 10, family: 'Inter' },
                            color: '#a89880',
                            callback: val => 'Rp ' + (val / 1000).toFixed(0) + 'k'
                        }
                    }
                }
            }
        });
    }

    // ─── Analytics Monthly Chart ──────────────────────────────────
    const monthlyCanvas = document.getElementById('monthlyBarChart');
    if (monthlyCanvas && window.monthlyChartData) {
        const mLabels = window.monthlyChartData.map(d => d.label);
        const mValues = window.monthlyChartData.map(d => d.value);

        new Chart(monthlyCanvas, {
            type: 'bar',
            data: {
                labels: mLabels,
                datasets: [{
                    label: 'Pendapatan (IDR)',
                    data: mValues,
                    backgroundColor: '#c8735a',
                    hoverBackgroundColor: '#b5624a',
                    borderRadius: 6,
                    barPercentage: 0.65,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'IDR ' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Inter' }, color: '#a89880' }
                    },
                    y: {
                        grid: { color: '#f0ebe3' },
                        ticks: {
                            font: { size: 10 },
                            color: '#a89880',
                            callback: val => 'Rp ' + (val / 1000).toFixed(0) + 'k'
                        }
                    }
                }
            }
        });
    }

    // ─── Analytics Category Doughnut ─────────────────────────────
    const doughnutCanvas = document.getElementById('categoryDoughnutChart');
    if (doughnutCanvas && window.categoryChartData) {
        const cLabels = window.categoryChartData.map(d => d.category || 'Other');
        const cValues = window.categoryChartData.map(d => d.total);
        const palette = ['#c8956c', '#7ab87a', '#b0937a', '#6b8fa8', '#d4b483'];

        new Chart(doughnutCanvas, {
            type: 'doughnut',
            data: {
                labels: cLabels,
                datasets: [{
                    data: cValues,
                    backgroundColor: palette,
                    hoverOffset: 6,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw} item`
                        }
                    }
                }
            }
        });
    }

    // ─── Orders: Inline Status Update (AJAX PATCH) ───────────────
    document.querySelectorAll('.order-status-select').forEach(select => {
        select.addEventListener('change', function () {
            const url    = this.dataset.url;
            const status = this.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status })
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal memperbarui status.');
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showAdminToast('Status pesanan berhasil diperbarui!', 'success');
                }
            })
            .catch(err => {
                showAdminToast(err.message || 'Terjadi kesalahan.', 'error');
            });
        });
    });

    // ─── Order Detail Modal ───────────────────────────────────────
    const orderDetailModal   = document.getElementById('order-detail-modal');
    const orderModalClose    = document.getElementById('order-modal-close');
    const orderModalContent  = document.getElementById('order-detail-modal-content');

    document.querySelectorAll('.order-detail-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            if (orderDetailModal && orderModalContent) {
                orderModalContent.textContent = btn.dataset.details || 'Tidak ada detail tersedia.';
                orderDetailModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    if (orderModalClose) {
        orderModalClose.addEventListener('click', closeOrderModal);
    }
    if (orderDetailModal) {
        orderDetailModal.addEventListener('click', e => {
            if (e.target === orderDetailModal) closeOrderModal();
        });
    }

    function closeOrderModal() {
        if (orderDetailModal) {
            orderDetailModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // ─── New Order Toast Auto-hide ────────────────────────────────
    const orderToast = document.getElementById('admin-order-toast');
    if (orderToast) {
        setTimeout(() => {
            orderToast.style.transition = 'opacity 0.5s';
            orderToast.style.opacity = '0';
            setTimeout(() => orderToast.remove(), 500);
        }, 8000);
    }

    // ─── Flash Message Auto-hide ──────────────────────────────────
    const flashMsg = document.getElementById('admin-flash-msg');
    if (flashMsg) {
        setTimeout(() => {
            flashMsg.style.transition = 'opacity 0.4s';
            flashMsg.style.opacity = '0';
            setTimeout(() => flashMsg.remove(), 400);
        }, 4000);
    }

    // ─── Placeholder Nav Items click handler ───────────────────────
    document.querySelectorAll('.sidebar-nav-item[href="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            showAdminToast('Fitur ini sedang dalam pengembangan oleh tim Dapur Bunda!', 'info');
        });
    });
}

// ─── Inline Admin Toast ───────────────────────────────────────
function showAdminToast(message, type = 'success') {
    const toast = document.createElement('div');
    
    let bg = '#e8f0e8';
    let color = '#3a6a3a';
    let border = '#c3dbc3';
    let icon = 'fa-circle-check';

    if (type === 'error') {
        bg = '#fdeaea';
        color = '#cc4444';
        border = '#f0c0c0';
        icon = 'fa-circle-exclamation';
    } else if (type === 'info') {
        bg = '#e3eaf5';
        color = '#4a6a9a';
        border = '#c0d0f0';
        icon = 'fa-circle-info';
    }

    toast.style.cssText = `
        position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
        background: ${bg};
        color: ${color};
        border: 1px solid ${border};
        padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1); z-index: 10000;
        display: flex; align-items: center; gap: 8px;
        animation: fadeIn 0.3s ease;
    `;
    toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

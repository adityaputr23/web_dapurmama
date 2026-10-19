<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Firebase auth info for chat -->
    <meta name="chat-user-id"   content="{{ auth()->check() ? auth()->id() : '' }}">
    <meta name="chat-user-name" content="{{ auth()->check() ? auth()->user()->name : 'Tamu' }}">
    <meta name="user-is-admin"  content="{{ auth()->check() && auth()->user()->isAdmin() ? '1' : '0' }}">
    
    <!-- SEO Meta Tags -->
    <title>Dapur Bunda - Nostalgia in Every Bite</title>
    <meta name="description" content="Rasakan kehangatan masakan ibu yang diantarkan langsung ke pintu rumah Anda. Hidangan tradisional Indonesia yang dibuat dengan cinta, bahan segar, dan tanpa pengawet.">
    <meta name="author" content="Dapur Bunda">
    
    <!-- Google Fonts: Playfair Display & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <!-- Top Navbar -->
    <header class="navbar-header">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="logo">Dapur Bunda</a>
            
            <nav class="nav-links">
                <!-- Search bar inside mobile drawer -->
                <form action="{{ route('menu.index') }}" method="GET" class="nav-links-mobile-search mobile-only">
                    <i class="fa-solid fa-magnifying-glass search-icon-mobile"></i>
                    <input type="text" name="search" placeholder="Cari masakan harian..." value="{{ request('search') }}" aria-label="Search meals">
                </form>

                <a href="{{ route('menu.index') }}" class="nav-link {{ Route::currentRouteName() == 'menu.index' ? 'active' : '' }}">
                    <span><i class="fa-solid fa-utensils mobile-nav-icon"></i> Menu</span>
                    <i class="fa-solid fa-chevron-right mobile-nav-arrow"></i>
                </a>
                <a href="{{ route('custom-order.index') }}" class="nav-link {{ Route::currentRouteName() == 'custom-order.index' ? 'active' : '' }}">
                    <span><i class="fa-solid fa-wand-magic-sparkles mobile-nav-icon"></i> Custom Order</span>
                    <i class="fa-solid fa-chevron-right mobile-nav-arrow"></i>
                </a>
                <a href="{{ Route::currentRouteName() == 'home' ? '#promise-section' : route('home') . '#promise-section' }}" class="nav-link">
                    <span><i class="fa-solid fa-heart mobile-nav-icon"></i> About</span>
                    <i class="fa-solid fa-chevron-right mobile-nav-arrow"></i>
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link admin-nav-link mobile-only" style="color:#c8735a; font-weight:700;">
                            <span><i class="fa-solid fa-gauge-high mobile-nav-icon"></i> Admin Dashboard</span>
                            <i class="fa-solid fa-chevron-right mobile-nav-arrow"></i>
                        </a>
                    @endif
                    <div class="mobile-user-drawer-box mobile-only">
                        <span class="user-greeting-text"><i class="fa-solid fa-circle-user"></i> Halo, {{ explode(' ', auth()->user()->name)[0] }}</span>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="mobile-logout-btn">
                                Logout <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="login-btn mobile-drawer-login-btn mobile-only">Login</a>
                @endauth
            </nav>

            <!-- Search Bar in Navbar (Desktop) -->
            <form action="{{ route('menu.index') }}" method="GET" class="navbar-search-form">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="search" placeholder="Find home-cooked flavors..." value="{{ request('search') }}" aria-label="Search meals">
            </form>
            
            <div class="nav-actions">
                <!-- Cart Icon -->
                <button class="icon-btn" id="cart-trigger" aria-label="Shopping Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge" id="cart-count">0</span>
                </button>
                
                <!-- Chat Icon -->
                <button class="icon-btn" id="chat-trigger" aria-label="Customer Support">
                    <i class="fa-regular fa-comment-dots"></i>
                </button>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="admin-badge-btn desktop-only">
                            <i class="fa-solid fa-gauge-high"></i> Admin
                        </a>
                    @endif
                    <span class="user-greeting desktop-only">Halo, {{ explode(' ', auth()->user()->name)[0] }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="desktop-only" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-link-btn">
                            Logout <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="login-btn desktop-only">Login</a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-toggle" id="mobile-toggle-btn" aria-label="Toggle Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-section">
        <div class="footer-container">
            <div class="footer-brand">
                <h3 class="footer-logo">Dapur Bunda</h3>
                <p class="footer-copyright-text">
                    &copy; 2024 Dapur Bunda. The Modern Hearth.<br>
                    Bringing the warmth of home-cooked artisanal meals to your contemporary lifestyle.
                </p>
            </div>
            
            <div class="footer-links-group">
                <div class="footer-column">
                    <h4>SHOP</h4>
                    <ul>
                        <li><a href="{{ route('menu.index') }}">Daily Menu</a></li>
                        <li><a href="{{ route('menu.index', ['categories' => ['Party Platters']]) }}">Party Sets</a></li>
                        <li><a href="{{ route('custom-order.index') }}">Custom Order</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>SUPPORT</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>DELIVERY</h4>
                    <ul>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">Tracking</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h4>FOLLOW US</h4>
                    <div class="social-icons">
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Sidebar / Drawer Modal -->
    <div class="cart-drawer-backdrop" id="cart-drawer">
        <div class="cart-drawer-content">
            <div class="cart-header">
                <h3>Keranjang Belanja</h3>
                <button class="close-drawer" id="cart-close">&times;</button>
            </div>
            <div class="cart-items" id="cart-items-container">
                <!-- Cart items will be injected here by JS -->
                <p class="empty-cart-message">Keranjang Anda masih kosong.</p>
            </div>
            <div class="cart-footer">
                <div class="cart-summary">
                    <span>Total:</span>
                    <span id="cart-total-price">IDR 0</span>
                </div>
                <button class="checkout-btn" id="cart-checkout-btn">Pesan Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Custom Request Modal -->
    <div class="modal-backdrop" id="custom-order-modal">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Formulir Custom Order</h3>
                <button class="close-modal" id="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-subtitle">Rencanakan katering atau pesanan khusus untuk acara keluarga Anda. Bunda siap menyiapkannya!</p>
                
                <form id="custom-order-form" method="POST" action="{{ route('custom-order.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="customer_name">Nama Lengkap</label>
                        <input type="text" id="customer_name" name="customer_name" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon / WA</label>
                            <input type="tel" id="phone" name="phone" placeholder="0812xxxxxxxx" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="delivery_date">Tanggal Pengiriman</label>
                        <input type="date" id="delivery_date" name="delivery_date" required>
                    </div>

                    <div class="form-group">
                        <label for="order_details">Detail Pesanan (Menu & Porsi)</label>
                        <textarea id="order_details" name="order_details" rows="4" placeholder="Contoh: Nasi Tumpeng Kuning untuk 20 porsi, dikirim pagi hari pukul 09.00." required></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="cancel-btn" id="modal-cancel">Batal</button>
                        <button type="submit" class="submit-btn" id="modal-submit-btn">Kirim Permintaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="toast-container" id="toast-container"></div>

    <!-- ======================================================
         FIREBASE REALTIME CHAT WIDGET
         ====================================================== -->

    <!-- Floating Chat Toggle Button -->
    <button class="fchat-fab" id="fchat-fab-btn" aria-label="Buka Chat" style="display:none">
        <i class="fa-solid fa-comment-dots"></i>
        <span class="fchat-fab-badge" id="fchat-fab-badge" style="display:none">!</span>
    </button>

    <!-- Chat Popup Window -->
    <div class="fchat-window" id="fchat-window">
        <!-- Header -->
        <div class="fchat-header">
            <div class="fchat-header-info">
                <div class="fchat-avatar">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <div>
                    <div class="fchat-header-name">Dapur Bunda</div>
                    <div class="fchat-header-status" id="fchat-status-text">
                        <span class="fchat-dot"></span> Online
                    </div>
                </div>
            </div>
            <button class="fchat-close-btn" id="fchat-close-btn" aria-label="Tutup chat">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Messages stream -->
        <div class="fchat-messages" id="fchat-messages">
            <!-- Welcome bubble -->
            <div class="fchat-bubble fchat-admin">
                <div class="fchat-bubble-text">Halo! 👋 Selamat datang di Dapur Bunda. Ada yang bisa Bunda bantu?</div>
                <div class="fchat-bubble-time">Baru saja</div>
            </div>
        </div>

        <!-- Input footer -->
        <form class="fchat-input-bar" id="fchat-form">
            <input type="text" id="fchat-input" placeholder="Ketik pesan..." autocomplete="off" maxlength="500">
            <button type="submit" class="fchat-send-btn" aria-label="Kirim">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <style>
    /* ── Floating Chat Button ── */
    .fchat-fab {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9000;
        width: 52px; height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c8735a, #a05040);
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 20px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 20px rgba(200,115,90,.45);
        transition: transform .2s, box-shadow .2s;
        animation: fabPop .4s cubic-bezier(.22,.68,0,1.3) both;
    }
    @keyframes fabPop {
        from { transform: scale(0); opacity:0; }
        to   { transform: scale(1); opacity:1; }
    }
    .fchat-fab:hover { transform: scale(1.08); box-shadow: 0 8px 24px rgba(200,115,90,.55); }
    .fchat-fab-badge {
        position: absolute;
        top: 0; right: 0;
        background: #e74c3c;
        color: #fff;
        border-radius: 50%;
        width: 18px; height: 18px;
        font-size: 10px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff;
        animation: badgePulse 2s infinite;
    }
    @keyframes badgePulse {
        0%,100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    /* ── Chat Window ── */
    .fchat-window {
        position: fixed;
        bottom: 84px;
        right: 24px;
        z-index: 8999;
        width: 340px;
        max-height: 480px;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 16px 48px rgba(44,36,22,.18), 0 4px 16px rgba(44,36,22,.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: scale(.92) translateY(12px);
        opacity: 0;
        pointer-events: none;
        transition: transform .25s cubic-bezier(.22,.68,0,1.15), opacity .2s ease;
        border: 1px solid rgba(200,115,90,.15);
    }
    .fchat-window.open {
        transform: scale(1) translateY(0);
        opacity: 1;
        pointer-events: auto;
    }
    @media (max-width: 420px) {
        .fchat-window {
            width: calc(100vw - 24px);
            right: 12px;
            bottom: 80px;
        }
    }

    /* ── Header ── */
    .fchat-header {
        background: linear-gradient(135deg, #c8735a, #9e5540);
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
    }
    .fchat-header-info { display: flex; align-items: center; gap: 10px; }
    .fchat-avatar {
        width: 36px; height: 36px;
        background: rgba(255,255,255,.2);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 15px;
        border: 1px solid rgba(255,255,255,.3);
    }
    .fchat-header-name {
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        font-weight: 700;
        color: #fff;
    }
    .fchat-header-status {
        font-size: 11px;
        color: rgba(255,255,255,.75);
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 1px;
    }
    .fchat-dot {
        width: 6px; height: 6px;
        background: #5eff9c;
        border-radius: 50%;
        animation: dotPulse 2s infinite;
    }
    @keyframes dotPulse {
        0%,100% { opacity:1; } 50% { opacity:.4; }
    }
    .fchat-close-btn {
        background: rgba(255,255,255,.15);
        border: none;
        color: #fff;
        width: 28px; height: 28px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s;
    }
    .fchat-close-btn:hover { background: rgba(255,255,255,.28); }

    /* ── Messages ── */
    .fchat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #faf7f3;
        scroll-behavior: smooth;
    }
    .fchat-messages::-webkit-scrollbar { width: 4px; }
    .fchat-messages::-webkit-scrollbar-thumb { background: #e0d5ca; border-radius: 4px; }

    .fchat-bubble {
        max-width: 82%;
        display: flex;
        flex-direction: column;
    }
    .fchat-bubble.fchat-customer { align-self: flex-end; }
    .fchat-bubble.fchat-admin    { align-self: flex-start; }

    .fchat-bubble-text {
        padding: 9px 13px;
        border-radius: 14px;
        font-size: 13.5px;
        line-height: 1.45;
        word-break: break-word;
    }
    .fchat-customer .fchat-bubble-text {
        background: linear-gradient(135deg, #c8735a, #a05040);
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .fchat-admin .fchat-bubble-text {
        background: #fff;
        color: #2c2416;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
    }
    .fchat-bubble-time {
        font-size: 10px;
        color: #b0a090;
        margin-top: 3px;
    }
    .fchat-customer .fchat-bubble-time { text-align: right; }

    /* Typing dots */
    .fchat-typing {
        display: flex;
        gap: 4px;
        align-items: center;
        padding: 10px 14px;
        background: #fff;
        border-radius: 14px;
        border-bottom-left-radius: 4px;
        align-self: flex-start;
        box-shadow: 0 1px 4px rgba(0,0,0,.07);
    }
    .fchat-typing span {
        width: 6px; height: 6px;
        background: #c8b8a8;
        border-radius: 50%;
        animation: typingBounce 1.2s infinite ease-in-out;
    }
    .fchat-typing span:nth-child(2) { animation-delay: .2s; }
    .fchat-typing span:nth-child(3) { animation-delay: .4s; }
    @keyframes typingBounce {
        0%,100% { transform: translateY(0); }
        50%      { transform: translateY(-5px); }
    }

    /* ── Input ── */
    .fchat-input-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-top: 1px solid #ebe3da;
        background: #fff;
        flex-shrink: 0;
    }
    .fchat-input-bar input {
        flex: 1;
        border: 1.5px solid #e6ddd4;
        border-radius: 20px;
        padding: 8px 14px;
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border-color .2s;
        color: #2c2416;
    }
    .fchat-input-bar input:focus { border-color: #c8735a; }
    .fchat-send-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c8735a, #a05040);
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 13px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: transform .15s, box-shadow .15s;
        box-shadow: 0 3px 10px rgba(200,115,90,.35);
    }
    .fchat-send-btn:hover { transform: scale(1.08); box-shadow: 0 5px 14px rgba(200,115,90,.45); }

    /* ── Login prompt (for guests without account) ── */
    .fchat-guest-note {
        font-size: 11.5px;
        color: #a89278;
        text-align: center;
        padding: 4px 12px 8px;
        background: #fff;
    }
    .fchat-guest-note a { color: #c8735a; font-weight: 600; text-decoration: none; }
    </style>

    <script type="module">
    // ========================================================
    //  Customer Firebase Realtime Chat Widget
    // ========================================================
    import {
        initFirebase,
        getGuestId,
        sendMessage,
        listenMessages,
        formatTime
    } from '/js/firebase-chat.js';

    const fab       = document.getElementById('fchat-fab-btn');
    const win       = document.getElementById('fchat-window');
    const closeBtn  = document.getElementById('fchat-close-btn');
    const form      = document.getElementById('fchat-form');
    const input     = document.getElementById('fchat-input');
    const stream    = document.getElementById('fchat-messages');
    const fabBadge  = document.getElementById('fchat-fab-badge');

    // ── User info from blade meta ────────────────────────────
    const authUserId   = document.querySelector('meta[name="chat-user-id"]')?.content || '';
    const authUserName = document.querySelector('meta[name="chat-user-name"]')?.content || 'Tamu';
    const isAdmin      = document.querySelector('meta[name="user-is-admin"]')?.content === '1';

    // Hide widget for admin users (they use the admin panel)
    if (isAdmin) {
        // Don't show customer chat widget to admins
    } else {
        fab.style.display = 'flex';

        // Chat ID: logged-in user id OR persistent guest id
        const chatId   = authUserId ? `user_${authUserId}` : getGuestId();
        const chatName = authUserName;

        let isOpen        = false;
        let knownMsgCount = 0;
        let firstLoad     = true;

        // ── Toggle open/close ──────────────────────────────────
        fab.addEventListener('click', () => {
            isOpen = !isOpen;
            win.classList.toggle('open', isOpen);
            fab.querySelector('i').className = isOpen
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-comment-dots';
            if (isOpen) {
                fabBadge.style.display = 'none';
                input.focus();
                stream.scrollTop = stream.scrollHeight;
            }
        });

        closeBtn.addEventListener('click', () => {
            isOpen = false;
            win.classList.remove('open');
            fab.querySelector('i').className = 'fa-solid fa-comment-dots';
        });

        // ── Listen for messages ────────────────────────────────
        listenMessages(chatId, (messages) => {
            // Detect new messages from admin when window is closed
            if (!firstLoad && messages.length > knownMsgCount) {
                const newest = messages[messages.length - 1];
                if (newest.sender === 'admin' && !isOpen) {
                    fabBadge.style.display = 'flex';
                }
            }

            knownMsgCount = messages.length;

            // Re-render all messages (keep welcome bubble)
            stream.innerHTML = `
                <div class="fchat-bubble fchat-admin">
                    <div class="fchat-bubble-text">Halo! 👋 Selamat datang di Dapur Bunda. Ada yang bisa Bunda bantu?</div>
                    <div class="fchat-bubble-time">Baru saja</div>
                </div>`;

            messages.forEach(msg => {
                const isCustomer = msg.sender === 'customer';
                const bubble = document.createElement('div');
                bubble.className = `fchat-bubble ${isCustomer ? 'fchat-customer' : 'fchat-admin'}`;
                bubble.innerHTML = `
                    <div class="fchat-bubble-text">${escapeHtml(msg.text)}</div>
                    <div class="fchat-bubble-time">${formatTime(msg.timestamp)}</div>`;
                stream.appendChild(bubble);
            });

            stream.scrollTop = stream.scrollHeight;
            firstLoad = false;
        });

        // ── Send message ───────────────────────────────────────
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = input.value.trim();
            if (!text) return;

            input.value = '';
            input.disabled = true;

            try {
                await sendMessage(chatId, text, 'customer', chatName);
            } catch (err) {
                console.error('Firebase send error:', err);
                // Fallback: show error bubble
                const errBubble = document.createElement('div');
                errBubble.style.cssText = 'font-size:11px;color:#e74c3c;text-align:center;padding:4px 8px';
                errBubble.textContent = '⚠ Pesan gagal terkirim. Cek koneksi Firebase.';
                stream.appendChild(errBubble);
            } finally {
                input.disabled = false;
                input.focus();
            }
        });

        // ── Helper ─────────────────────────────────────────────
        function escapeHtml(str) {
            const d = document.createElement('div');
            d.textContent = str;
            return d.innerHTML;
        }
    }
    </script>

    <!-- Custom JS -->
    <script src="/js/app.js"></script>

    @yield('page-scripts')
</body>
</html>

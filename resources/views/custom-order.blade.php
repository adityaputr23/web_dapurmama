@extends('layouts.app')

@section('content')
<div class="custom-order-page-container">
    <div class="custom-order-header-section">
        <h1 class="custom-order-page-title">Create Your Own Masterpiece</h1>
        <p class="custom-order-page-subtitle">
            Collaborate with Mama Bunda to tailor the perfect meal for your family's needs. Choose every detail, from the harvest source to the spice level.
        </p>
    </div>

    <div class="custom-order-layout">
        <!-- Left Side: Custom Request Form -->
        <div class="custom-request-form-card">
            <h2 class="card-section-title"><i class="fa-solid fa-list-check"></i> Custom Request Form</h2>

            <!-- Select Base Dish -->
            <div class="custom-form-group">
                <label class="custom-field-label">SELECT YOUR BASE DISH</label>
                <div class="base-dish-selector-grid">
                    <div class="base-dish-card" data-dish="Traditional Nasi">
                        <div class="dish-icon-wrapper green-icon">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <span class="dish-card-name">Traditional Nasi</span>
                    </div>
                    <div class="base-dish-card selected" data-dish="Artisan Noodles">
                        <div class="dish-icon-wrapper orange-icon">
                            <i class="fa-solid fa-bowl-food"></i>
                        </div>
                        <span class="dish-card-name">Artisan Noodles</span>
                    </div>
                    <div class="base-dish-card" data-dish="Savory Pastry">
                        <div class="dish-icon-wrapper gray-icon">
                            <i class="fa-solid fa-bread-slice"></i>
                        </div>
                        <span class="dish-card-name">Savory Pastry</span>
                    </div>
                </div>
            </div>

            <!-- Premium Ingredients -->
            <div class="custom-form-group">
                <label class="custom-field-label">PREMIUM INGREDIENTS</label>
                <div class="ingredients-selection-grid">
                    <div class="ingredient-select-card selected" data-ingredient="Farm Fresh Veggies">
                        <div class="ingredient-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=400&q=80" alt="Farm Fresh Veggies">
                            <div class="check-overlay"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="ingredient-info">
                            <span class="ingredient-card-name">Farm Fresh Veggies</span>
                            <span class="ingredient-card-meta">Sourced this morning</span>
                        </div>
                    </div>

                    <div class="ingredient-select-card" data-ingredient="Wagyu Beef">
                        <div class="ingredient-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=400&q=80" alt="Wagyu Beef">
                            <div class="check-overlay"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="ingredient-info">
                            <span class="ingredient-card-name">Wagyu Beef</span>
                            <span class="ingredient-card-meta">Premium melt-in-mouth</span>
                        </div>
                    </div>

                    <div class="ingredient-select-card" data-ingredient="Exotic Spices">
                        <div class="ingredient-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1596797038530-2c107229654b?auto=format&fit=crop&w=400&q=80" alt="Exotic Spices">
                            <div class="check-overlay"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="ingredient-info">
                            <span class="ingredient-card-name">Exotic Spices</span>
                            <span class="ingredient-card-meta">Rich traditional herbs</span>
                        </div>
                    </div>

                    <div class="ingredient-select-card selected" data-ingredient="Wild Mushrooms">
                        <div class="ingredient-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=400&q=80" alt="Wild Mushrooms">
                            <div class="check-overlay"><i class="fa-solid fa-circle-check"></i></div>
                        </div>
                        <div class="ingredient-info">
                            <span class="ingredient-card-name">Wild Mushrooms</span>
                            <span class="ingredient-card-meta">Fresh mountain forest</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Portion Size and Spice Level -->
            <div class="form-row-2col">
                <div class="custom-form-group">
                    <label for="portion-select" class="custom-field-label">PORTION SIZE</label>
                    <div class="select-dropdown-wrapper">
                        <select id="portion-select" class="custom-select-element">
                            <option value="Single Portion">Single Portion</option>
                            <option value="Couple Pack">Couple Pack (2 Persons)</option>
                            <option value="Family Gathering" selected>Family Gathering (4-6 Persons)</option>
                            <option value="Party Pack">Party Pack (10-12 Persons)</option>
                        </select>
                        <i class="fa-solid fa-chevron-down select-chevron"></i>
                    </div>
                </div>

                <div class="custom-form-group">
                    <label class="custom-field-label">SPICE LEVEL</label>
                    <div class="spice-level-buttons">
                        <button type="button" class="spice-btn active" data-spice="Mild">Mild</button>
                        <button type="button" class="spice-btn" data-spice="Medium">Medium</button>
                        <button type="button" class="spice-btn" data-spice="Hot">Hot</button>
                    </div>
                </div>
            </div>

            <!-- Special Instructions -->
            <div class="custom-form-group">
                <label for="custom-instructions" class="custom-field-label">SPECIAL INSTRUCTIONS</label>
                <textarea id="custom-instructions" class="custom-textarea-element" placeholder="Tell Mama Bunda about any allergies, specific preferences, or even the memory you want this dish to evoke..." rows="4"></textarea>
            </div>
        </div>

        <!-- Right Side: Consultation Chat Box -->
        <div class="consultation-chat-card">
            <!-- Chat Header -->
            <div class="chat-card-header">
                <div class="chef-avatar-wrapper">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=100&h=100&q=80" alt="Mama Bunda">
                    <span class="online-indicator"></span>
                </div>
                <div class="chef-chat-title-info">
                    <h3 class="chef-name-title">Consultation with Mama Bunda</h3>
                    <span class="chef-status-text">Online & Ready to Cook</span>
                </div>
                <button class="chat-menu-dots-btn" aria-label="Chat options">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>

            <!-- Chat Message Feed -->
            <div class="chat-message-feed" id="chat-messages-container">
                <!-- Pesan akan dimuat dari Firebase secara real-time -->
                <div class="chat-loading-state" id="chat-loading-indicator" style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; gap:10px; color:#a0a0a0;">
                    <i class="fa-solid fa-circle-notch fa-spin" style="font-size:1.5rem; color:#e07b39;"></i>
                    <span style="font-size:0.85rem;">Memuat percakapan...</span>
                </div>
            </div>

            <!-- Typing Indicator (hidden by default) -->
            <div class="chat-typing-indicator" id="chat-typing-bubble" style="display: none;">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>

            <!-- Chat Input Form -->
            <form class="chat-input-row" id="firebase-consultation-chat-form">
                <button type="button" class="attachment-plus-btn" aria-label="Attach File">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <input type="text" id="firebase-consultation-chat-input" placeholder="Message Mama Bunda..." aria-label="Type your message" required autocomplete="off">
                <button type="submit" class="send-message-btn" aria-label="Send Message">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom: Custom Order Summary Footer Card -->
    <div class="custom-summary-footer-bar">
        <div class="summary-footer-container">
            <div class="summary-details-section">
                <div class="summary-bag-icon-square">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <div class="summary-meta-pills-row">
                    <h4 class="summary-bar-title">Your Custom Order Summary</h4>
                    <div class="summary-pills-wrap" id="summary-badge-pills-container">
                        <!-- Summary pills dynamically injected here by JS -->
                    </div>
                </div>
            </div>

            <div class="summary-action-pricing-section">
                <div class="summary-pricing-labels">
                    <span class="summary-original-price" id="original-price-display">IDR 285.000</span>
                    <span class="summary-discounted-price" id="discounted-price-display">IDR 245.500</span>
                </div>
                <button class="review-place-order-btn" id="summary-review-order-btn">
                    Review & Place Order <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog for Submitting Custom Order Details to DB -->
<div class="modal-backdrop" id="checkout-custom-modal">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Konfirmasi Pemesanan Kustom</h3>
            <button class="close-modal" id="checkout-modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p class="modal-subtitle">Detail kustom Anda telah kami simpan. Silakan isi informasi kontak untuk menyelesaikan pesanan Anda.</p>
            
            <form id="custom-checkout-details-form" method="POST" action="{{ route('custom-order.store') }}">
                @csrf
                <!-- Hidden inputs to carry compiled selection details -->
                <input type="hidden" name="order_details" id="hidden-compiled-order-details">

                <div class="form-group">
                    <label for="checkout_customer_name">Nama Lengkap</label>
                    <input type="text" id="checkout_customer_name" name="customer_name" placeholder="Masukkan nama lengkap Anda" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="checkout_email">Alamat Email</label>
                        <input type="email" id="checkout_email" name="email" placeholder="nama@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout_phone">Nomor Telepon / WhatsApp</label>
                        <input type="tel" id="checkout_phone" name="phone" placeholder="0812xxxxxxxx" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="checkout_delivery_date">Tanggal Pengiriman</label>
                    <input type="date" id="checkout_delivery_date" name="delivery_date" required>
                </div>

                <div class="form-actions">
                    <button type="button" class="cancel-btn" id="checkout-modal-cancel">Batal</button>
                    <button type="submit" class="submit-btn" id="checkout-modal-submit-btn">Kirim & Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script type="module">
// Global error logging untuk debugging di client
window.addEventListener('error', function(e) {
    alert("JS Error: " + e.message + " di " + e.filename + ":" + e.lineno);
});
window.addEventListener('unhandledrejection', function(e) {
    alert("Unhandled promise error: " + (e.reason ? (e.reason.message || e.reason) : e));
});

// ============================================================
//  Custom Order Page — Firebase Realtime Consultation Chat
//  Menggunakan helper global dari /js/firebase-chat.js
// ============================================================
import {
    getGuestId,
    sendMessage,
    listenMessages,
    formatTime
} from '/js/firebase-chat.js';


// ── Get user identity ─────────────────────────────────────────
const authUserId   = document.querySelector('meta[name="chat-user-id"]')?.content || '';
const authUserName = document.querySelector('meta[name="chat-user-name"]')?.content || 'Tamu';
const chatId       = authUserId ? `user_${authUserId}` : getGuestId();
const chatName     = authUserName;

// ── DOM References ────────────────────────────────────────────
const chatForm     = document.getElementById('firebase-consultation-chat-form');
const chatInput    = document.getElementById('firebase-consultation-chat-input');
const msgContainer = document.getElementById('chat-messages-container');
const spinner      = document.getElementById('chat-loading-indicator');

// ── Helpers ───────────────────────────────────────────────────
function escapeHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function scrollToBottom() {
    msgContainer.scrollTop = msgContainer.scrollHeight;
}

function renderBubble(msg) {
    const isUser  = msg.sender === 'customer';
    const div     = document.createElement('div');
    div.className = `chat-message ${isUser ? 'user-msg' : 'chef-msg'}`;
    div.innerHTML = `
        <div class="msg-bubble">${escapeHtml(msg.text)}</div>
        <span class="msg-timestamp">${formatTime(msg.timestamp)}</span>
    `;
    return div;
}

// ── State ─────────────────────────────────────────────────────
let   initialLoadDone = false;
const renderedIds     = new Set();
let   welcomeShown    = false;

function removeSpinner() {
    if (spinner && spinner.parentNode) {
        spinner.remove();
    } else {
        const activeSpinner = document.getElementById('chat-loading-indicator');
        if (activeSpinner) activeSpinner.remove();
    }
}

function removeWelcomeMsg() {
    const w = msgContainer.querySelector('.welcome-chat-msg');
    if (w) { w.remove(); welcomeShown = false; }
}

// ── Fallback Timeout ──────────────────────────────────────────
// Jika dalam 5 detik Firebase tidak merespons, hilangkan spinner & tampilkan welcome message
const fallbackTimeout = setTimeout(() => {
    if (!initialLoadDone) {
        console.warn('[Firebase Chat] Connection timeout or empty database, showing fallback welcome.');
        initialLoadDone = true;
        removeSpinner();
        showWelcomeMessage();
    }
}, 5000);

function showWelcomeMessage() {
    if (!welcomeShown) {
        welcomeShown = true;
        const welcome = document.createElement('div');
        welcome.className = 'chat-message chef-msg welcome-chat-msg';
        welcome.innerHTML = `
            <div class="msg-bubble">Halo! Saya Mama Bunda 👋<br>Ada yang bisa Bunda bantu untuk pesanan kustommu?</div>
            <span class="msg-timestamp">Sekarang</span>
        `;
        msgContainer.appendChild(welcome);
        scrollToBottom();
    }
}

// ── Listen to messages in real-time ───────────────────────────
try {
    listenMessages(chatId, (messages) => {
        clearTimeout(fallbackTimeout);

        if (!initialLoadDone) {
            initialLoadDone = true;
            removeSpinner();
        }

        if (messages.length === 0) {
            showWelcomeMessage();
        } else {
            removeWelcomeMsg();
            let hasNew = false;
            messages.forEach(msg => {
                if (!renderedIds.has(msg.id)) {
                    renderedIds.add(msg.id);
                    msgContainer.appendChild(renderBubble(msg));
                    hasNew = true;
                }
            });
            if (hasNew) scrollToBottom();
        }
    });
} catch (err) {
    console.error('[Firebase Chat] Error setting up listener:', err);
    clearTimeout(fallbackTimeout);
    removeSpinner();
    showWelcomeMessage();
}

// ── Handle form submit ────────────────────────────────────────
if (chatForm && chatInput) {
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text) return;

        chatInput.value    = '';
        chatInput.disabled = true;

        // Optimistic UI: Tampilkan bubble chat secara instan
        removeWelcomeMsg();
        const optDiv = document.createElement('div');
        optDiv.className = 'chat-message user-msg msg-pending';
        optDiv.innerHTML = `
            <div class="msg-bubble">${escapeHtml(text)}</div>
            <span class="msg-timestamp" style="opacity:0.5">Mengirim...</span>
        `;
        msgContainer.appendChild(optDiv);
        scrollToBottom();

        try {
            await sendMessage(chatId, text, 'customer', chatName);
            
            // Hapus status pending/mengirim jika pengiriman sukses
            optDiv.classList.remove('msg-pending');
            const ts = optDiv.querySelector('.msg-timestamp');
            if (ts) {
                ts.textContent = 'Baru saja';
                ts.style.opacity = '1';
            }
        } catch (err) {
            console.error('[Firebase Chat] Error sending message:', err);
            // Tampilkan error di bubble chat
            const ts = optDiv.querySelector('.msg-timestamp');
            if (ts) {
                ts.textContent = '⚠ Gagal: ' + (err.message || err.code || 'koneksi');
                ts.style.color = '#cc3333';
                ts.style.opacity = '1';
            }
        } finally {
            chatInput.disabled = false;
            chatInput.focus();
        }
    });
}
</script>
@endsection

@extends('layouts.admin')

@section('admin-content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Chat Inbox</h1>
        <p class="admin-page-subtitle">Konsultasi menu dan katering langsung dengan pelanggan.</p>
    </div>
</div>

<div class="admin-chat-layout-wrapper">
    <!-- Chat Sidebar / Users List -->
    <div class="admin-chat-threads-sidebar">
        <div class="chat-search-threads">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari percakapan..." id="thread-search-input">
        </div>
        
        <ul class="chat-threads-list" id="chat-threads-list-container">
            <li style="padding: 20px; text-align: center; color: var(--admin-text-muted); font-size: 13px;">
                <i class="fa-solid fa-spinner fa-spin" style="margin-right: 6px;"></i> Memuat percakapan...
            </li>
        </ul>
    </div>

    <!-- Active Chat Conversation Pane -->
    <div class="admin-chat-pane">
        <!-- Active Chat Header -->
        <div class="active-chat-header" id="active-chat-header-pane" style="display: none;">
            <button type="button" class="mobile-chat-back-btn" id="mobile-chat-back-btn" style="display: none;">
                <i class="fa-solid fa-chevron-left"></i> Daftar
            </button>
            <div class="active-user-avatar-wrap">
                <img src="" alt="" id="active-chat-user-avatar">
                <span class="status-indicator online" id="active-chat-user-status"></span>
            </div>
            <div class="active-user-info-text">
                <h3 class="active-user-display-name" id="active-chat-user-name">Memuat...</h3>
                <span class="active-user-status-desc" id="active-chat-status-desc">Menghubungkan...</span>
            </div>
            <div class="active-chat-actions">
                <button class="chat-action-circle-btn" title="Call Customer"><i class="fa-solid fa-phone"></i></button>
                <button class="chat-action-circle-btn" title="Create Order"><i class="fa-solid fa-file-invoice-dollar"></i></button>
            </div>
        </div>

        <!-- Chat Stream Body -->
        <div class="active-chat-message-stream" id="admin-chat-stream-container">
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--admin-text-muted); font-size: 14px; gap: 10px;">
                <i class="fa-regular fa-comments" style="font-size: 40px; color: #d0c0b0;"></i>
                <span>Pilih percakapan di sebelah kiri untuk mulai chatting</span>
            </div>
        </div>

        <!-- Chat Input Footer -->
        <form class="active-chat-input-bar" id="admin-chat-reply-form" style="display: none;">
            <button type="button" class="chat-input-tool-btn" title="Attach template"><i class="fa-solid fa-bolt"></i></button>
            <input type="text" placeholder="Ketik balasan Anda di sini..." id="admin-chat-reply-input" required autocomplete="off">
            <button type="submit" class="chat-send-reply-btn" title="Send Reply"><i class="fa-solid fa-paper-plane"></i></button>
        </form>
    </div>
</div>

<style>
/* Additional style tokens specifically for Chat Inbox component */
.admin-chat-layout-wrapper {
    display: grid;
    grid-template-columns: 300px 1fr;
    background: var(--admin-surface);
    border: 1px solid var(--admin-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    height: calc(100vh - 180px);
    box-shadow: var(--shadow-sm);
}

.admin-chat-threads-sidebar {
    border-right: 1px solid var(--admin-border);
    display: flex;
    flex-direction: column;
    background: #fff;
}

.chat-search-threads {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    border-bottom: 1px solid var(--admin-border);
    background: var(--admin-bg);
}
.chat-search-threads i { color: var(--admin-text-muted); }
.chat-search-threads input {
    border: none;
    outline: none;
    font-size: 13px;
    width: 100%;
    background: transparent;
}

.chat-threads-list {
    flex: 1;
    overflow-y: auto;
}

.chat-thread-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-bottom: 1px solid #f5f0eb;
    cursor: pointer;
    transition: background var(--transition);
}
.chat-thread-item:hover { background: #faf7f3; }
.chat-thread-item.active { background: #f0f7f0; border-left: 4px solid var(--brand-green); }

.thread-avatar-wrap {
    position: relative;
    width: 42px; height: 42px;
    flex-shrink: 0;
}
.thread-avatar-wrap img {
    width: 100%; height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.status-indicator {
    position: absolute;
    bottom: 0; right: 0;
    width: 10px; height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
}
.status-indicator.online { background: var(--brand-green); }
.status-indicator.offline { background: var(--admin-text-muted); }

.thread-meta-details {
    flex: 1;
    min-width: 0;
}
.thread-name-time {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 2px;
}
.thread-user-name { font-weight: 600; font-size: 13.5px; color: var(--admin-text-primary); }
.thread-last-time { font-size: 11px; color: var(--admin-text-muted); }

.thread-msg-preview-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.thread-preview-text {
    font-size: 12px;
    color: var(--admin-text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}
.thread-unread-count {
    background: var(--brand-orange);
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 1px 5px;
    border-radius: 10px;
    min-width: 16px;
    text-align: center;
    margin-left: 5px;
}

/* Chat Pane */
.admin-chat-pane {
    display: flex;
    flex-direction: column;
    background: #faf8f5;
}

.active-chat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 1.25rem;
    border-bottom: 1px solid var(--admin-border);
    background: #fff;
}
.active-user-avatar-wrap {
    position: relative;
    width: 40px; height: 40px;
}
.active-user-avatar-wrap img {
    width: 100%; height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
.active-user-display-name { font-size: 14.5px; font-weight: 700; color: var(--admin-text-primary); }
.active-user-status-desc { font-size: 11.5px; color: var(--admin-text-secondary); }

.active-chat-actions {
    margin-left: auto;
    display: flex;
    gap: 8px;
}
.chat-action-circle-btn {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: var(--admin-bg);
    color: var(--admin-text-secondary);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    transition: background var(--transition), color var(--transition);
}
.chat-action-circle-btn:hover { background: var(--brand-orange-light); color: var(--brand-orange); }

.active-chat-message-stream {
    flex: 1;
    overflow-y: auto;
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.chat-bubble-row {
    display: flex;
    flex-direction: column;
    max-width: 70%;
}
.chat-bubble-row.admin-bubble {
    align-self: flex-end;
}
.chat-bubble-row.customer-bubble {
    align-self: flex-start;
}

.chat-bubble-content {
    padding: 10px 14px;
    border-radius: var(--radius-md);
    font-size: 13.5px;
    line-height: 1.4;
    word-break: break-word;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.admin-bubble .chat-bubble-content {
    background: #e6f2e6;
    color: #1e3a1e;
    border-bottom-right-radius: 2px;
}
.customer-bubble .chat-bubble-content {
    background: #fff;
    color: var(--admin-text-primary);
    border-bottom-left-radius: 2px;
}

.chat-bubble-timestamp {
    font-size: 10px;
    color: var(--admin-text-muted);
    margin-top: 4px;
    align-self: flex-end;
}
.customer-bubble .chat-bubble-timestamp { align-self: flex-start; }

/* Typing dot */
.typing-bubble-pane {
    background: #fff;
    padding: 8px 14px;
    border-radius: var(--radius-md);
    border-bottom-left-radius: 2px;
    align-self: flex-start;
    display: flex;
    gap: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.typing-dot-chat {
    width: 6px; height: 6px;
    background: var(--admin-text-muted);
    border-radius: 50%;
    animation: typingBounce 1.2s infinite ease-in-out;
}
.typing-dot-chat:nth-child(2) { animation-delay: 0.2s; }
.typing-dot-chat:nth-child(3) { animation-delay: 0.4s; }

@keyframes typingBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}

.active-chat-input-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 1.25rem;
    border-top: 1px solid var(--admin-border);
    background: #fff;
}

.chat-input-tool-btn {
    font-size: 16px;
    color: var(--admin-text-muted);
    transition: color var(--transition);
}
.chat-input-tool-btn:hover { color: var(--brand-orange); }

.active-chat-input-bar input {
    flex: 1;
    border: 1px solid var(--admin-border);
    border-radius: var(--radius-sm);
    padding: 8px 12px;
    font-size: 13.5px;
    outline: none;
    color: var(--admin-text-primary);
}
.active-chat-input-bar input:focus { border-color: var(--brand-green); }

.chat-send-reply-btn {
    background: var(--brand-green);
    color: #fff;
    width: 34px; height: 34px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    transition: background var(--transition);
}
.mobile-chat-back-btn {
    display: none;
}

@media (max-width: 768px) {
    .admin-chat-layout-wrapper {
        grid-template-columns: 1fr;
        height: calc(100vh - 160px);
        position: relative;
    }

    .admin-chat-threads-sidebar {
        display: flex;
        width: 100%;
        height: 100%;
    }

    .admin-chat-threads-sidebar.hidden-mobile {
        display: none !important;
    }

    .admin-chat-pane {
        display: none;
        width: 100%;
        height: 100%;
    }

    .admin-chat-pane.active-mobile {
        display: flex !important;
    }

    .mobile-chat-back-btn {
        display: inline-flex !important;
        align-items: center;
        gap: 6px;
        background: var(--admin-bg);
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--admin-text-primary);
        cursor: pointer;
        margin-right: 4px;
        flex-shrink: 0;
    }
}
</style>
@endsection

@section('admin-scripts')
<script type="module">
    import {
        initFirebase,
        sendMessage,
        listenMessages,
        listenAllChats,
        markAsRead,
        formatTime
    } from '/js/firebase-chat.js';

    let activeThreadId = null;
    let allThreads = [];
    let messagesListenerUnsubscribe = null;

    const threadsContainer = document.getElementById('chat-threads-list-container');
    const streamContainer  = document.getElementById('admin-chat-stream-container');
    const replyForm        = document.getElementById('admin-chat-reply-form');
    const replyInput       = document.getElementById('admin-chat-reply-input');

    const activeUserName   = document.getElementById('active-chat-user-name');
    const activeUserAvatar = document.getElementById('active-chat-user-avatar');
    const activeStatusDesc = document.getElementById('active-chat-status-desc');
    const activeUserStatus = document.getElementById('active-chat-user-status');

    // ── Listen to All Chat Threads ────────────────────────────
    listenAllChats((threads) => {
        allThreads = threads;
        renderThreadsList();

        // Auto select first thread if none is active
        if (threads.length > 0 && !activeThreadId) {
            switchThread(threads[0].chatId);
        }
    });

    // ── Render Threads in Sidebar ─────────────────────────────
    function renderThreadsList() {
        if (!threadsContainer) return;

        if (allThreads.length === 0) {
            threadsContainer.innerHTML = `
                <li style="padding: 20px; text-align: center; color: var(--admin-text-muted); font-size: 13px;">
                    Tidak ada percakapan terbaru saat ini
                </li>`;
            return;
        }

        let threadsHTML = '';
        allThreads.forEach(t => {
            const isActive = t.chatId === activeThreadId;
            const hasUnread = t.unread && t.unread > 0;
            const lastMsgPreview = t.lastMessage || 'Mengirim pesan...';
            const displayTime = formatTime(t.lastTime);

            // Generate profile picture based on name hash for consistency
            const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(t.name)}&background=random&color=fff&size=80`;

            threadsHTML += `
                <li class="chat-thread-item ${isActive ? 'active' : ''}" data-thread-id="${t.chatId}">
                    <div class="thread-avatar-wrap">
                        <img src="${avatarUrl}" alt="${t.name}">
                        <span class="status-indicator online"></span>
                    </div>
                    <div class="thread-meta-details">
                        <div class="thread-name-time">
                            <span class="thread-user-name">${t.name}</span>
                            <span class="thread-last-time">${displayTime}</span>
                        </div>
                        <div class="thread-msg-preview-row">
                            <p class="thread-preview-text" style="${hasUnread ? 'font-weight: 700; color: #2c2416;' : ''}">${escapeHtml(lastMsgPreview)}</p>
                            ${hasUnread ? `<span class="thread-unread-count">${t.unread}</span>` : ''}
                        </div>
                    </div>
                </li>
            `;
        });

        threadsContainer.innerHTML = threadsHTML;

        // Re-attach click listeners to thread items
        document.querySelectorAll('.chat-thread-item').forEach(item => {
            item.addEventListener('click', () => {
                switchThread(item.dataset.threadId);
            });
        });
    }

    // ── Switch Active Chat Thread ──────────────────────────────
    function switchThread(threadId) {
        activeThreadId = threadId;
        const currentThread = allThreads.find(t => t.chatId === threadId);

        if (!currentThread) return;

        // Show header and reply form which are hidden by default
        const headerPane = document.getElementById('active-chat-header-pane');
        const inputForm  = document.getElementById('admin-chat-reply-form');
        if (headerPane) headerPane.style.display = 'flex';
        if (inputForm) inputForm.style.display = 'flex';

        // Toggle mobile view state (show pane, hide sidebar)
        const sidebar = document.querySelector('.admin-chat-threads-sidebar');
        const pane    = document.querySelector('.admin-chat-pane');
        if (sidebar && pane) {
            sidebar.classList.add('hidden-mobile');
            pane.classList.add('active-mobile');
        }

        // Update header UI
        activeUserName.textContent = currentThread.name;
        activeUserAvatar.src       = `https://ui-avatars.com/api/?name=${encodeURIComponent(currentThread.name)}&background=random&color=fff&size=80`;
        activeStatusDesc.textContent = 'Pelanggan Dapur Bunda';
        activeUserStatus.className = 'status-indicator online';

        // Update active class in sidebar items
        document.querySelectorAll('.chat-thread-item').forEach(item => {
            item.classList.toggle('active', item.dataset.threadId === threadId);
        });

        // Mark thread as read in Firebase Realtime Database
        markAsRead(threadId);

        // Listen for messages in this thread
        listenMessages(threadId, (messages) => {
            if (activeThreadId !== threadId) return; // avoid race conditions
            renderMessagesStream(messages);
        });
    }

    // ── Render Messages Stream ────────────────────────────────
    function renderMessagesStream(messages) {
        if (!streamContainer) return;

        if (messages.length === 0) {
            streamContainer.innerHTML = `
                <div style="flex: 1; display: flex; align-items: center; justify-content: center; color: var(--admin-text-muted); font-size: 13px;">
                    Mulai percakapan baru...
                </div>`;
            return;
        }

        let streamHTML = '';
        messages.forEach(msg => {
            const isAdmin = msg.sender === 'admin';
            streamHTML += `
                <div class="chat-bubble-row ${isAdmin ? 'admin-bubble' : 'customer-bubble'}">
                    <div class="chat-bubble-content">${escapeHtml(msg.text)}</div>
                    <span class="chat-bubble-timestamp">${formatTime(msg.timestamp)}</span>
                </div>
            `;
        });

        streamContainer.innerHTML = streamHTML;
        streamContainer.scrollTop = streamContainer.scrollHeight;
    }

    // ── Send Reply Message ─────────────────────────────────────
    if (replyForm && replyInput) {
        replyForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = replyInput.value.trim();
            if (!text || !activeThreadId) return;

            replyInput.value = '';
            replyInput.disabled = true;

            try {
                await sendMessage(activeThreadId, text, 'admin', 'Bunda Admin');
            } catch (err) {
                console.error('Firebase send error (admin):', err);
                alert('Gagal mengirim pesan, periksa kembali koneksi.');
            } finally {
                replyInput.disabled = false;
                replyInput.focus();
            }
        });
    }

    // ── Search threads filter ─────────────────────────────────
    const searchInput = document.getElementById('thread-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.chat-thread-item').forEach(item => {
                const name = item.querySelector('.thread-user-name').textContent.toLowerCase();
                if (name.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // ── Mobile Back Button Handler ─────────────────────────────
    const mobileBackBtn = document.getElementById('mobile-chat-back-btn');
    if (mobileBackBtn) {
        mobileBackBtn.addEventListener('click', () => {
            const sidebar = document.querySelector('.admin-chat-threads-sidebar');
            const pane    = document.querySelector('.admin-chat-pane');
            if (sidebar && pane) {
                sidebar.classList.remove('hidden-mobile');
                pane.classList.remove('active-mobile');
            }
        });
    }

    // Helper: Escape HTML
    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
</script>
@endsection

// ============================================================
//  firebase-chat.js — Dapur Bunda
//  Core Firebase Realtime Database chat helpers.
//  Digunakan oleh: app.blade.php (customer) & chat.blade.php (admin)
// ============================================================

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
import {
    getDatabase,
    ref,
    push,
    set,
    onValue,
    onChildAdded,
    update,
    serverTimestamp,
    query,
    orderByChild,
    limitToLast,
    get
} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

import FIREBASE_CONFIG from "./firebase-config.js";

// ── Initialize Firebase ──────────────────────────────────────
let app, db;

function initFirebase() {
    if (app) return db; // Singleton
    app = initializeApp(FIREBASE_CONFIG);
    db  = getDatabase(app);
    return db;
}

// ── Get or Create Guest ID ───────────────────────────────────
function getGuestId() {
    let gId = localStorage.getItem("db_chat_guest_id");
    if (!gId) {
        gId = "guest_" + Math.random().toString(36).slice(2, 10) + "_" + Date.now();
        localStorage.setItem("db_chat_guest_id", gId);
    }
    return gId;
}

// ── Send a message ───────────────────────────────────────────
async function sendMessage(chatId, text, sender, senderName) {
    const database = initFirebase();
    const msgRef   = ref(database, `chats/${chatId}/messages`);
    const newMsg   = push(msgRef);

    await set(newMsg, {
        sender:    sender,       // "customer" | "admin"
        name:      senderName,
        text:      text,
        timestamp: Date.now()
    });

    // Update metadata for admin thread list
    const metaRef = ref(database, `chats/${chatId}/metadata`);
    await update(metaRef, {
        chatId:      chatId,
        name:        senderName,
        lastMessage: text,
        lastTime:    Date.now(),
        unread:      sender === "customer" ? (await getUnreadCount(chatId) + 1) : 0
    });
}

// ── Get current unread count ─────────────────────────────────
async function getUnreadCount(chatId) {
    const database = initFirebase();
    const snap = await get(ref(database, `chats/${chatId}/metadata/unread`));
    return snap.exists() ? (snap.val() || 0) : 0;
}

// ── Listen to messages in a chat thread ─────────────────────
function listenMessages(chatId, callback) {
    const database = initFirebase();
    const msgsRef  = query(
        ref(database, `chats/${chatId}/messages`),
        orderByChild("timestamp")
    );
    onValue(msgsRef, (snap) => {
        const messages = [];
        snap.forEach((child) => {
            messages.push({ id: child.key, ...child.val() });
        });
        callback(messages);
    });
}

// ── Listen to ALL chat threads (for admin inbox) ─────────────
function listenAllChats(callback) {
    const database = initFirebase();
    const chatsRef = ref(database, "chats");
    onValue(chatsRef, (snap) => {
        const threads = [];
        snap.forEach((child) => {
            const meta = child.val()?.metadata;
            if (meta) {
                threads.push({ chatId: child.key, ...meta });
            }
        });
        // Sort by lastTime descending
        threads.sort((a, b) => (b.lastTime || 0) - (a.lastTime || 0));
        callback(threads);
    });
}

// ── Mark thread as read (reset unread) ──────────────────────
async function markAsRead(chatId) {
    const database = initFirebase();
    const metaRef  = ref(database, `chats/${chatId}/metadata`);
    await update(metaRef, { unread: 0 });
}

// ── Format timestamp helper ──────────────────────────────────
function formatTime(ts) {
    if (!ts) return "";
    const d    = new Date(ts);
    const now  = new Date();
    const diff = now - d;

    if (diff < 60000)         return "Baru saja";
    if (diff < 3600000)       return Math.floor(diff / 60000) + " mnt lalu";
    if (diff < 86400000)      return d.toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit" });
    return d.toLocaleDateString("id-ID", { day: "numeric", month: "short" });
}

export {
    initFirebase,
    getGuestId,
    sendMessage,
    listenMessages,
    listenAllChats,
    markAsRead,
    formatTime
};

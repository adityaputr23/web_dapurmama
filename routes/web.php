<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu.index');
Route::get('/custom-order', [OrderController::class, 'showCustomOrderPage'])->name('custom-order.index');
Route::post('/custom-order', [OrderController::class, 'storeCustomOrder'])->name('custom-order.store');
Route::post('/reviews', [HomeController::class, 'storeReview'])->name('reviews.store');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login',      [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',     [AuthController::class, 'login']);
    Route::get('/register',   [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',  [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (secured with custom AdminMiddleware)
Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/',          [AdminController::class, 'dashboard'])->name('dashboard');

    // Menu Management
    Route::get('/menu',              [AdminController::class, 'menuIndex'])->name('menu.index');
    Route::get('/menu/create',       [AdminController::class, 'menuCreate'])->name('menu.create');
    Route::post('/menu',             [AdminController::class, 'menuStore'])->name('menu.store');
    Route::get('/menu/{menu}/edit',  [AdminController::class, 'menuEdit'])->name('menu.edit');
    Route::put('/menu/{menu}',       [AdminController::class, 'menuUpdate'])->name('menu.update');
    Route::delete('/menu/{menu}',    [AdminController::class, 'menuDestroy'])->name('menu.destroy');

    // Orders
    Route::get('/orders',                        [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{order}/edit',           [AdminController::class, 'orderEdit'])->name('orders.edit');
    Route::put('/orders/{order}',                [AdminController::class, 'orderUpdate'])->name('orders.update');
    Route::patch('/orders/{order}/status',       [AdminController::class, 'orderUpdateStatus'])->name('orders.status');

    // Chat Inbox
    Route::get('/chat', [AdminController::class, 'chat'])->name('chat');

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');

    // Reviews Moderation
    Route::get('/reviews',                       [AdminController::class, 'reviewsIndex'])->name('reviews.index');
    Route::patch('/reviews/{review}/toggle',     [AdminController::class, 'reviewToggleApprove'])->name('reviews.toggle');
    Route::delete('/reviews/{review}',           [AdminController::class, 'reviewDestroy'])->name('reviews.destroy');

    // Settings
    Route::get('/settings',  [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
});

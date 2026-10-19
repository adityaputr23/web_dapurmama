<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\CustomOrder;
use App\Models\Review;
use Carbon\Carbon;

class AdminController extends Controller
{
    /* ─── Dashboard ─────────────────────────────────────────────────── */
    public function dashboard()
    {
        $totalMenus        = Menu::count();
        $activeOrders      = CustomOrder::where('status', 'pending')->count();
        $completedOrders   = CustomOrder::where('status', 'completed')->count();
        $totalOrders       = CustomOrder::count();
        $newCustomers      = CustomOrder::whereBetween('created_at', [
                                now()->startOfWeek(), now()
                            ])->count();
        $avgRating         = Menu::whereNotNull('rating')->avg('rating');

        // Sales performance – simulate 7-day data from orders
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $count = CustomOrder::whereDate('created_at', $day->toDateString())->count();
            $salesData[] = [
                'label' => $day->format('D'),
                'value' => $count * 75000 + rand(30000, 120000), // simulate revenue
            ];
        }

        $menus = Menu::orderBy('created_at', 'desc')->get();

        $recentOrders = CustomOrder::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMenus', 'activeOrders', 'completedOrders', 'totalOrders',
            'newCustomers', 'avgRating', 'salesData', 'menus', 'recentOrders'
        ));
    }

    /* ─── Menu Management ────────────────────────────────────────────── */
    public function menuIndex(Request $request)
    {
        $query = Menu::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $menus = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.menu.index', compact('menus'));
    }

    public function menuCreate()
    {
        return view('admin.menu.create');
    }

    public function menuStore(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image_path'  => 'required|string',
            'badge'       => 'nullable|string|max:50',
            'tags'        => 'nullable|string',
            'category'    => 'required|string',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'status'      => 'required|in:available,sold_out',
            'is_featured' => 'boolean',
        ]);

        $validated['tags']        = $request->filled('tags')
            ? array_map('trim', explode(',', $request->tags))
            : [];
        $validated['is_featured'] = $request->boolean('is_featured');

        Menu::create($validated);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function menuEdit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function menuUpdate(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image_path'  => 'required|string',
            'badge'       => 'nullable|string|max:50',
            'tags'        => 'nullable|string',
            'category'    => 'required|string',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'status'      => 'required|in:available,sold_out',
            'is_featured' => 'boolean',
        ]);

        $validated['tags']        = $request->filled('tags')
            ? array_map('trim', explode(',', $request->tags))
            : [];
        $validated['is_featured'] = $request->boolean('is_featured');

        $menu->update($validated);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu berhasil diperbarui!');
    }

    public function menuDestroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu berhasil dihapus!');
    }

    /* ─── Orders ─────────────────────────────────────────────────────── */
    public function ordersIndex(Request $request)
    {
        $query = CustomOrder::query();
        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function orderEdit(CustomOrder $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function orderUpdate(Request $request, CustomOrder $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'order_details' => 'required|string',
            'delivery_date' => 'required|date',
            'status'        => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pesanan #'.$order->id.' berhasil diperbarui!');
    }

    public function orderUpdateStatus(Request $request, CustomOrder $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,completed,cancelled']);
        $order->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $order->status]);
        }
        return back()->with('success', 'Status pesanan diperbarui!');
    }

    /* ─── Analytics ──────────────────────────────────────────────────── */
    public function analytics()
    {
        $monthlySales = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = CustomOrder::whereYear('created_at', $month->year)
                                ->whereMonth('created_at', $month->month)
                                ->count();
            $monthlySales[] = [
                'label' => $month->format('M'),
                'value' => $count * 75000 + rand(50000, 200000),
            ];
        }

        $categoryStats = Menu::selectRaw('category, count(*) as total')
                             ->groupBy('category')
                             ->get();

        return view('admin.analytics', compact('monthlySales', 'categoryStats'));
    }

    /* ─── Chat Inbox ─────────────────────────────────────────────────── */
    public function chat()
    {
        return view('admin.chat');
    }

    /* ─── Reviews Moderation ─────────────────────────────────────────── */
    public function reviewsIndex(Request $request)
    {
        $query = Review::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('comment', 'like', '%'.$request->search.'%');
        }
        $reviews = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function reviewToggleApprove(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return back()->with('success', 'Status tampil ulasan #' . $review->id . ' berhasil diubah!');
    }

    public function reviewDestroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Ulasan #' . $review->id . ' berhasil dihapus!');
    }

    /* ─── Settings ───────────────────────────────────────────────────── */
    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->all();
        $admin = auth()->user();
        return view('admin.settings', compact('settings', 'admin'));
    }

    public function settingsUpdate(Request $request)
    {
        // Validasi input
        $request->validate([
            'shop_name'       => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:255',
            'shop_address'    => 'required|string',
            'shop_open_hours' => 'required|string|max:255',
            'admin_name'      => 'required|string|max:255',
            'admin_email'     => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'admin_password'  => 'nullable|string|min:8|confirmed',
        ]);

        // Update settings key-value
        \App\Models\Setting::setByKey('shop_name', $request->shop_name);
        \App\Models\Setting::setByKey('whatsapp_number', $request->whatsapp_number);
        \App\Models\Setting::setByKey('shop_address', $request->shop_address);
        \App\Models\Setting::setByKey('shop_open_hours', $request->shop_open_hours);

        // Update profil admin
        $admin = auth()->user();
        $admin->name = $request->admin_name;
        $admin->email = $request->admin_email;
        if ($request->filled('admin_password')) {
            $admin->password = \Illuminate\Support\Facades\Hash::make($request->admin_password);
        }
        $admin->save();

        return redirect()->route('admin.settings')
                         ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}

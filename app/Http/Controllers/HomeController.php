<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // For the landing page Today's Specials, show first 6 menus
        $menus = Menu::limit(6)->get();
        // Load approved customer reviews
        $reviews = Review::where('is_approved', true)->latest()->get();
        return view('home', compact('menus', 'reviews'));
    }

    public function menu(Request $request)
    {
        $query = Menu::query();

        // 1. Search Query
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 2. Categories
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category', $request->categories);
        }

        // 3. Dietary Tags (stored as JSON array)
        if ($request->has('dietary') && is_array($request->dietary)) {
            foreach ($request->dietary as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        // 4. Price Max Filter
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Paginate menus (6 per page)
        $menus = $query->paginate(6)->withQueryString();

        return view('menu', compact('menus'));
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        Review::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'],
            'is_approved' => true, // Auto approve untuk kemudahan demo, admin tetap bisa menyembunyikan/menghapus
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas feedback-nya.');
    }
}

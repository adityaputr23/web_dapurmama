<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CustomOrder;

class OrderController extends Controller
{
    public function showCustomOrderPage()
    {
        return view('custom-order');
    }

    public function storeCustomOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'order_details' => 'required|string',
            'delivery_date' => 'required|date|after_or_equal:today',
        ]);

        $order = CustomOrder::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan kustom Anda berhasil dikirim! Kami akan menghubungi Anda segera.',
            'order' => $order
        ]);
    }
}

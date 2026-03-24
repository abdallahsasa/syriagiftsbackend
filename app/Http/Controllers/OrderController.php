<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(
            Order::with('items.product')->where('user_id', Auth::id())->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'delivery_date' => 'required|date',
            // Payment method validation could go here
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        return DB::transaction(function () use ($request, $cartItems) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => 0, // Will calculate below
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'delivery_address' => $request->address,
                'phone_number' => $request->phone,
                'delivery_date' => $request->delivery_date,
            ]);

            $total = 0;
            foreach ($cartItems as $item) {
                // In a real app, you'd fetch the current price from the Product model
                // For now assuming we have access to it or a placeholder
                $price = 25.00; // Placeholder price logic
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'options' => $item->options,
                ]);
                $total += $price * $item->quantity;
            }

            $order->update(['total_amount' => $total]);

            // Clear Cart
            CartItem::where('user_id', Auth::id())->delete();

            return response()->json($order->load('items'), 201);
        });
    }

    public function show($id)
    {
        return response()->json(
            Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id)
        );
    }
}

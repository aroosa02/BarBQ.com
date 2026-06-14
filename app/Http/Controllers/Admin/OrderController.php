<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders (KDS system).
     */
    public function index()
    {
        $orders = Order::with('user', 'orderItems.menuItem', 'orderItems.deal')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update order preparation status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,preparing,ready,completed,cancelled']);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }

    /**
     * Update payment status.
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate(['payment_status' => 'required|in:unpaid,paid']);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated to ' . ucfirst($request->payment_status));
    }
}

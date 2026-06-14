<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display customer's orders history.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show order checkout page.
     */
    public function create(Request $request)
    {
        $menuItem = null;
        $deal = null;

        if ($request->has('item_id')) {
            $menuItem = MenuItem::findOrFail($request->item_id);
        } elseif ($request->has('deal_id')) {
            $deal = Deal::findOrFail($request->deal_id);
        } else {
            return redirect()->route('menu')->with('error', 'Please select an item to order.');
        }

        return view('customer.orders.create', compact('menuItem', 'deal'));
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:dine-in,takeaway',
            'table_number' => 'nullable|required_if:type,dine-in',
            'item_id' => 'nullable|exists:menu_items,id',
            'deal_id' => 'nullable|exists:deals,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $price = 0;
            if ($request->item_id) {
                $item = MenuItem::findOrFail($request->item_id);
                $price = $item->price;
            } else {
                $deal = Deal::findOrFail($request->deal_id);
                $price = $deal->price;
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $price * $request->quantity,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'type' => $request->type,
                'table_number' => $request->table_number,
                'payment_method' => $request->payment_method ?? 'cash'
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $request->item_id,
                'deal_id' => $request->deal_id,
                'quantity' => $request->quantity,
                'price' => $price
            ]);

            DB::commit();

            return redirect()->route('customer.orders.show', $order)->with('success', 'Order placed successfully! We are preparing your meal.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    /**
     * Show order details.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.menuItem', 'orderItems.deal');
        return view('customer.orders.show', compact('order'));
    }
}

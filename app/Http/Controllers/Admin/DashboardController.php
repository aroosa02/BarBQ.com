<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Expense;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary Stats
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_expenses' => Expense::sum('amount'),
            'active_orders' => Order::whereIn('status', ['pending', 'preparing', 'ready'])->count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'menu_items' => MenuItem::count()
        ];

        // Recent Activity
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentReservations = Reservation::with('user')->latest()->take(5)->get();

        // Revenue Analytics (Mocking daily revenue for chart if needed, or just totals)
        $revenueByCategory = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('categories', 'menu_items.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->groupBy('categories.name')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentReservations', 'revenueByCategory'));
    }
}

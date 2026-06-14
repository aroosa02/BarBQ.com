<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->whereIn('status', ['pending', 'preparing', 'ready'])->count(),
            'active_reservations' => $user->reservations()->where('status', 'approved')->where('reservation_date', '>=', date('Y-m-d'))->count(),
            'total_feedback' => $user->complaints()->count()
        ];

        $recentOrders = $user->orders()->latest()->take(3)->get();
        $upcomingReservations = $user->reservations()
            ->where('reservation_date', '>=', date('Y-m-d'))
            ->orderBy('reservation_date', 'asc')
            ->take(2)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders', 'upcomingReservations'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display all reservations for the admin.
     */
    public function index()
    {
        $reservations = Reservation::with('user')->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Update reservation status.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string'
        ]);

        $reservation->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Reservation status updated to ' . ucfirst($request->status));
    }
}

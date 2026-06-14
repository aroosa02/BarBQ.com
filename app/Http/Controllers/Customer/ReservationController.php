<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display customer's reservations.
     */
    public function index()
    {
        $reservations = auth()->user()->reservations()->latest()->get();
        return view('customer.reservations.index', compact('reservations'));
    }

    /**
     * Show reservation form.
     */
    public function create()
    {
        return view('customer.reservations.create');
    }

    /**
     * Store a new reservation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
        ]);

        auth()->user()->reservations()->create([
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guests' => $request->guests,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.reservations.index')->with('success', 'Your reservation request has been submitted. We will notify you once approved!');
    }

    /**
     * Cancel a reservation.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->status === 'pending') {
            $reservation->update(['status' => 'cancelled']);
            return back()->with('success', 'Reservation cancelled.');
        }

        return back()->with('error', 'Only pending reservations can be cancelled.');
    }
}

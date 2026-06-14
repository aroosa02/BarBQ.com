<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = auth()->user()->complaints()->latest()->get();
        return view('customer.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('customer.complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required|min:10'
        ]);

        auth()->user()->complaints()->create([
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return redirect()->route('customer.complaints.index')->with('success', 'Your feedback has been submitted. We appreciate your input!');
    }
}

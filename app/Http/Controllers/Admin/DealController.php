<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::latest()->get();
        return view('admin.deals.index', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuItems = MenuItem::where('status', 'available')->get();
        return view('admin.deals.create', compact('menuItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'items' => 'required|array|min:1',
            'items.*' => 'exists:menu_items,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $data = $request->only(['name', 'description', 'price']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('deals', 'public');
        }

        $deal = Deal::create($data);

        $syncData = [];
        foreach ($request->items as $itemId) {
            $syncData[$itemId] = ['quantity' => $request->quantities[$itemId] ?? 1];
        }
        $deal->menuItems()->sync($syncData);

        return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        $menuItems = MenuItem::where('status', 'available')->get();
        $selectedItems = $deal->menuItems->pluck('id')->toArray();
        $selectedQuantities = $deal->menuItems->pluck('pivot.quantity', 'id')->toArray();

        return view('admin.deals.edit', compact('deal', 'menuItems', 'selectedItems', 'selectedQuantities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'items' => 'required|array|min:1',
            'items.*' => 'exists:menu_items,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $data = $request->only(['name', 'description', 'price']);

        if ($request->hasFile('image')) {
            if ($deal->image) {
                Storage::disk('public')->delete($deal->image);
            }
            $data['image'] = $request->file('image')->store('deals', 'public');
        }

        $deal->update($data);

        $syncData = [];
        foreach ($request->items as $itemId) {
            $syncData[$itemId] = ['quantity' => $request->quantities[$itemId] ?? 1];
        }
        $deal->menuItems()->sync($syncData);

        return redirect()->route('admin.deals.index')->with('success', 'Deal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        if ($deal->image) {
            Storage::disk('public')->delete($deal->image);
        }

        $deal->delete();

        return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully.');
    }
}

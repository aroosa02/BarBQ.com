<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deal;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        $categories = Category::withCount('menuItems')->get();
        $featuredItems = MenuItem::where('status', 'available')->latest()->take(6)->get();
        $deals = Deal::latest()->take(3)->get();

        return view('welcome', compact('categories', 'featuredItems', 'deals'));
    }

    /**
     * Show the full menu with filtering and search.
     */
    public function menu(Request $request)
    {
        $query = MenuItem::where('status', 'available')->with('category');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $menuItems = $query->paginate(12);
        $categories = Category::all();
        $deals = Deal::all();

        return view('menu', compact('menuItems', 'categories', 'deals'));
    }
}

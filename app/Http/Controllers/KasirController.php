<?php

namespace App\Http\Controllers;

use App\Models\menu_categories;
use Illuminate\Http\Request;
use App\Models\Menus;
use App\Models\MenuCategory;
use App\Models\Promotions;

class KasirController extends Controller
{
    public function index()
    {
        $menus = Menus::all();
        $categories = menu_categories::all();
        $promotions = Promotions::all();
        return view('kasir', compact('menus', 'categories', 'promotions'));
    }
}

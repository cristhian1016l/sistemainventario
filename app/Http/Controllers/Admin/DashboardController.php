<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $brands = DB::select("SELECT COUNT(*) FROM brands");
        $suppliers = DB::select("SELECT COUNT(*) FROM suppliers");
        $stores = DB::select("SELECT COUNT(*) FROM stores");
        $categories = DB::select("SELECT COUNT(*) FROM categories");
        $products = DB::select("SELECT COUNT(*) FROM products");
        $workers = DB::select("SELECT COUNT(*) FROM workers");
        $data = ['brands' => $brands, 
                'suppliers' => $suppliers, 
                'stores' => $stores, 
                'categories' => $categories, 
                'products' => $products,
                'workers' => $workers];
        return view('admin.dashboard.index', $data);
    }
}

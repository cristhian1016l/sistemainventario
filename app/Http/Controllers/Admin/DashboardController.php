<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $suppliers = DB::select("SELECT COUNT(*) AS total FROM suppliers");
        $stores = DB::select("SELECT COUNT(*) AS total FROM stores");
        $categories = DB::select("SELECT COUNT(*) AS total FROM categories");
        $products = DB::select("SELECT COUNT(*) AS total FROM products");
        $workers = DB::select("SELECT COUNT(*) AS total FROM workers");
        $requests = DB::select("SELECT COUNT(*) AS total FROM requests");

        $data = ['suppliers' => $suppliers, 
                'stores' => $stores, 
                'categories' => $categories, 
                'products' => $products,
                'requests' => $requests,
                'workers' => $workers];
        return view('admin.dashboard.index', $data);
    }
}

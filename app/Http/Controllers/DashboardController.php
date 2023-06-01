<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_news(){
        return view('dashboard.news');
    }

    public function show_dashboard_admin(){
        $suppliers = DB::select("SELECT COUNT(*) AS total FROM suppliers");        
        $categories = DB::select("SELECT COUNT(*) AS total FROM categories");
        $products = DB::select("SELECT COUNT(*) AS total FROM products");
        $workers = DB::select("SELECT COUNT(*) AS total FROM workers");
        $requests = DB::select("SELECT COUNT(*) AS total FROM requests");        

        $data = ['suppliers' => $suppliers,                
                'categories' => $categories, 
                'products' => $products,
                'requests' => $requests,
                'workers' => $workers];

        return view('dashboard.admin', $data);
    }

    public function show_dashboard_assistance(){
        $suppliers = DB::select("SELECT COUNT(*) AS total FROM suppliers");        
        $categories = DB::select("SELECT COUNT(*) AS total FROM categories");
        $products = DB::select("SELECT COUNT(*) AS total FROM products");
        $workers = DB::select("SELECT COUNT(*) AS total FROM workers");
        $requests = DB::select("SELECT COUNT(*) AS total FROM requests");        

        $data = ['suppliers' => $suppliers,                
                'categories' => $categories, 
                'products' => $products,
                'requests' => $requests,
                'workers' => $workers];

        return view('dashboard.assistance', $data);
    }

}

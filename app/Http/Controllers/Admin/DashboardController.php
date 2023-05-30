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
        $categories = DB::select("SELECT COUNT(*) AS total FROM categories");
        $products = DB::select("SELECT COUNT(*) AS total FROM products");
        $workers = DB::select("SELECT COUNT(*) AS total FROM workers");
        $requests = DB::select("SELECT COUNT(*) AS total FROM requests");        

        $data = ['suppliers' => $suppliers,                
                'categories' => $categories, 
                'products' => $products,
                'requests' => $requests,
                'workers' => $workers];

        return view('admin.dashboard.index', $data);
    }

    public function categories_with_more_products()
    {
        $categories_with_more_products = 
            DB::select("SELECT c.name, SUM(p.stock) AS stock FROM products p INNER JOIN categories c ON p.category_id = c.id
                        GROUP BY c.name ORDER BY stock DESC LIMIT 5");

        $data = ['categories_with_more_products' => $categories_with_more_products];
        return response()->json($data);
    }

    public function employees_in_companies()
    {
        $employees_in_companies = 
        DB::select("SELECT c.name, SUM(w.company_id) AS total FROM workers w
                    INNER JOIN companies c 
                    ON w.company_id = c.id
                    GROUP BY c.name
                    ORDER BY total DESC");
        $data = ['employees_in_companies' => $employees_in_companies];
        return response()->json($data);                    
    }

    public function employees_in_payroll()
    {
        $payroll = DB::select("SELECT SUM(case when payroll = 1 THEN 1 ELSE 0 END) AS on_payroll, SUM(case when payroll = 0 THEN 1 ELSE 0 END) AS off_payroll
                    FROM workers WHERE deleted_at IS NULL");

        $data = ['employees_in_payroll' => $payroll];
        return response()->json($data);
    }
}

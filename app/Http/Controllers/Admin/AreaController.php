<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('area.index');
    }

    public function returnAreas()
    {
        $areas = DB::table('areas')->get();
        return $areas;
    }

    // RETURN DATA LIKE JSON

    public function getAreas()
    {
        return response()->json(['areas' => $this->returnAreas() ]);
    }

    public function getPositionsByArea(Request $request)
    {
        $positions = DB::select("SELECT * FROM worker_type WHERE area_id = ".$request->area_id);
        return response()->json(['positions' => $positions]);
    }
}
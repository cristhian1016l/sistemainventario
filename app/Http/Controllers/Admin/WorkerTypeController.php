<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function returnPositions($area_id)
    {
        if(!isset($area_id) || $area_id == "" || $area_id == null){
            $worker_type = DB::table('worker_type')->get();
        }else{
            $worker_type = DB::table('worker_type')->where('area_id', $area_id)->get();
        }
        return $worker_type;
    }

    // RETURN DATA LIKE JSON

    public function getWorkerTypes(Request $request)
    {
        return response()->json(['positions' => $this->returnPositions($request->area_id)]);
    }
}

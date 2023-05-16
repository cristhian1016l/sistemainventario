<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashdriveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $brands = DB::select("SELECT * FROM brands");
        $data = ['brands' => $brands];
        return view('flashdrive.index', $data);
    }

    public function returnFlashdrives()
    {
        $flashdrives = DB::select("SELECT * FROM flashdrives");
        return $flashdrives;
    }

    // RETURN DATA LIKE JSON

    public function getFlashdrives()
    {
        return response()->json(['flashdrives' => $this->returnFlashdrives()]);
    }
}

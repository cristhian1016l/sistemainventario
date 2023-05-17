<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Flashdrive;

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

    public function insert(Request $request)
    {
        return response()->json($request->all());

        $rules = [                
            'storage' => 'required|numeric',
            'speed' => 'required|numeric',
            'color' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'stock' => 'required|numeric',            
        ];

        $messages = [                
            'storage.required' => 'Ingrese el almacenamiento',
            'storage.numeric' => 'El almacenamiento debe ser numérico',
            'speed.required' => 'Ingrese la velocidad',
            'speed.numeric' => 'La velocidad debe ser numérica',
            'color.required' => 'El color es obligatorio',            
            'brand_id.required' => 'Elija la marca',
            'brand_id.numeric' => 'Error al elegir la marca',
            'stock.required' => 'Ingrese el stick',
            'stock.numeric' => 'El stock debe ser numérico',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return response()->json(['status' => 500, 'msg' => 'La memoria no fue agregada', 'errors' => $validator->errors()->all()]);
        }else{
            
            try{

                DB::beginTransaction();
                $flashdrive = new Flashdrive();
                $flashdrive->speed = mb_strtoupper($request->speed, 'utf-8');
                $flashdrive->storage = mb_strtoupper($request->storage, 'utf-8');
                $flashdrive->color = mb_strtoupper($request->color, 'utf-8');
                $flashdrive->description = mb_strtoupper($request->description, 'utf-8');
                $flashdrive->stock = $request->stock;
                $flashdrive->brand_id = $request->brand_id;                
                $flashdrive->save();
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'msg' => 'La memoria fue agregada correctamente'
                ]);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'msg' => $th->getMessage(),
                ]);
            }

        }

    }

}

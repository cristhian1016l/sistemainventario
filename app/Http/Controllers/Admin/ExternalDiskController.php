<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ExternalDisk;

class ExternalDiskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // $categories = DB::select("SELECT * FROM categories");
        // $suppliers = DB::select("SELECT * FROM suppliers");
        $brands = DB::select("SELECT * FROM brands");
        // $stores = DB::select("SELECT * FROM stores");
        $data = ['brands' => $brands];

        return view('external_disk.index', $data);
    }

    public function returnExternalDisks()
    {        
        $disks = DB::select("SELECT e.*, b.name FROM external_disks e 
                            INNER JOIN brands b
                            ON e.brand_id = b.id");
        return $disks;
    }

    // RETURN DATA LIKE JSON

    public function getExternalDisks()
    {
        return response()->json(['disks' => $this->returnExternalDisks()]);
    }

    public function getExternalDiskById($id)
    {        
        $disk = ExternalDisk::where('id', '=', $id)->first();
        if($disk === null){
            return response()->json(['status' => 500, 'msg' => 'El disco seleccionado no existe', 'disk' => []]);
        }else{            
            $disk = DB::select("SELECT * FROM external_disks e
                                INNER JOIN brands b ON e.brand_id = b.id
                                WHERE e.id = ".$id);
            return response()->json(['status' => 200, 'msg' => 'Datos devueltos', 'disk' => $disk[0]]);
        }
    }

    public function insert(Request $request)
    {
        $disk = ExternalDisk::where('code', '=', $request->code)->first();
        if($disk){
            return response()->json([
                'status' => 500,                    
                'msg' => "El código del disco ya existe"
            ]);
        }

        $rules = [                
            'code' => 'required|min:10|max:10',
            'brand_id' => 'required',
            'storage' => 'required|numeric',            
        ];

        $messages = [                
            'code.required' => 'El código es obligatorio',
            'code.min' => 'El código no puede tener menos de 12 caracteres',
            'code.max' => 'El código no puede tener mas de 12 caracteres',
            'brand_id.required' => 'Ingrese la marca',
            'storage.required' => 'Ingrese la capacidad del disco',
            'storage.numeric' => 'La capacidad del disco debe ser numérica'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);        

        if($validator->fails()){                
            return response()->json(['status' => 500, 'msg' => 'El disco no fue agregado', 'errors' => $validator->errors()->all()]);
        }else{

            try{
                DB::beginTransaction();
                
                $disk = new ExternalDisk();
                $disk->code = mb_strtoupper($request->code, 'utf-8');
                $disk->storage = $request->storage;
                $disk->description = mb_strtoupper($request->description, 'utf-8');
                $disk->brand_id = $request->brand_id;                
                $disk->save();
                DB::commit();
                return response()->json([
                    'status' => 200,                    
                    'msg' => "Disco agregado correctamente"
                ]);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json([
                    'status' => 500,                    
                    'msg' => $th->getMessage()
                ]);
            }
        }

    }

    public function edit(Request $request)
    {
        
        if($request->id == null || $request->id == ""){
            return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del disco']);
        }

        $disk = ExternalDisk::where('id', '=', $request->id)->first();

        if(isset($disk)){

            $rules = [                
                'code' => 'required|min:10|max:10',
                'brand_id' => 'required',
                'storage' => 'required|numeric',            
            ];
    
            $messages = [                
                'code.required' => 'El código es obligatorio',
                'code.min' => 'El código no puede tener menos de 12 caracteres',
                'code.max' => 'El código no puede tener mas de 12 caracteres',
                'brand_id.required' => 'Ingrese la marca',
                'storage.required' => 'Ingrese la capacidad del disco',
                'storage.numeric' => 'La capacidad del disco debe ser numérica'
            ];
    
            $validator = Validator::make($request->all(), $rules, $messages);        
    

            if($validator->fails()){
                return response()->json(['status' => 500, 'msg' => 'El disco no fue editado', 'errors' => $validator->errors()->all()]);
            }else{

                try{
                    DB::beginTransaction();
                    $update = DB::update('UPDATE external_disks SET
                                        storage = ?,
                                        description = ?,
                                        brand_id = ?,
                                        updated_at = ?
                                        WHERE id = ? ',
                                [$request->storage,
                                mb_strtoupper($request->description, 'utf-8'), 
                                $request->brand_id,                                
                                date_format(now(), "Y-m-d H:i:s"), 
                                $request->id]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,                        
                        'msg' => 'El disco fue actualizado correctamente'
                    ]);
                }catch(\Exception $th){
                    DB::rollback();
                    return response()->json([
                        'status' => 500,                        
                        'msg' => $th->getMessage(),
                    ]);
                }
            }
            
        }else{
            return response()->json("NO");
        }        
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $delete = DB::table('external_disks')
                    ->where('id', $request->cod_disk)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,                
                'msg' => "El disco fue eliminado correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,               
                'msg' => $th->getMessage()
            ]);
        }
    }

}

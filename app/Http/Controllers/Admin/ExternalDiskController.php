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
            'in_use' => 'required',
            'video_format' => 'required',            
            'video_type' => 'required',
            'since' => 'required',
            'until' => 'required',      
        ];

        $messages = [                
            'code.required' => 'El código es obligatorio',
            'code.min' => 'El código no puede tener menos de 12 caracteres',
            'code.max' => 'El código no puede tener mas de 12 caracteres',
            'brand_id.required' => 'Ingrese la marca',
            'storage.required' => 'Ingrese la capacidad del disco',
            'storage.numeric' => 'La capacidad del disco debe ser numérica',
            'in_use.required' => 'Debe seleccionar si el disco está en uso o almacenado',
            'video_format.required' => 'Ingrese el formato que hay en el vídeo',            
            'video_type.required' => 'Debe seleccionar el tipo de vídeo',
            'since.required' => 'Ingrese la fecha de inicio de uso del disco',
            'until.required' => 'Ingrese la fecha de fin de uso del disco'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);        

        if($validator->fails()){                
            return response()->json(['status' => 500, 'msg' => 'El disco no fue agregado', 'errors' => $validator->errors()->all()]);
        }else{

            try{

                $in_use = ($request->in_use == true) ?  1 : 0;

                DB::beginTransaction();
                
                $disk = new ExternalDisk();
                $disk->code = mb_strtoupper($request->code, 'utf-8');
                $disk->storage = $request->storage;
                $disk->description = mb_strtoupper($request->description, 'utf-8');
                $disk->brand_id = $request->brand_id;                
                $disk->in_use = $in_use;                
                $disk->video_format = $request->video_format;                
                $disk->video_type = $request->video_type;
                $disk->since = date("Y/m/d", strtotime($request->since));
                $disk->until = date("Y/m/d", strtotime($request->until));
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
                'in_use' => 'required',
                'video_format' => 'required',            
                'video_type' => 'required',
                'since' => 'required',
                'until' => 'required',      
            ];
    
            $messages = [                
                'code.required' => 'El código es obligatorio',
                'code.min' => 'El código no puede tener menos de 12 caracteres',
                'code.max' => 'El código no puede tener mas de 12 caracteres',
                'brand_id.required' => 'Ingrese la marca',
                'storage.required' => 'Ingrese la capacidad del disco',
                'storage.numeric' => 'La capacidad del disco debe ser numérica',
                'in_use.required' => 'Debe seleccionar si el disco está en uso o almacenado',
                'video_format.required' => 'Ingrese el formato que hay en el vídeo',            
                'video_type.required' => 'Debe seleccionar el tipo de vídeo',
                'since.required' => 'Ingrese la fecha de inicio de uso del disco',
                'until.required' => 'Ingrese la fecha de fin de uso del disco'
            ];
    
            $validator = Validator::make($request->all(), $rules, $messages);        
    

            if($validator->fails()){
                return response()->json(['status' => 500, 'msg' => 'El disco no fue editado', 'errors' => $validator->errors()->all()]);
            }else{

                try{
                    $in_use = $request->in_use == "true" ? 1 : 0;
                    DB::beginTransaction();
                    $update = DB::update('UPDATE external_disks SET
                                        storage = ?,
                                        description = ?,
                                        brand_id = ?,
                                        in_use = ?,
                                        video_format = ?,
                                        video_type = ?,
                                        since = ?,
                                        until = ?,
                                        updated_at = ?
                                        WHERE id = ? ',
                                [$request->storage,
                                mb_strtoupper($request->description, 'utf-8'), 
                                $request->brand_id,
                                $in_use,
                                $request->video_format,
                                $request->video_type,                                
                                date('Y-m-d', strtotime($request->since)), 
                                date('Y-m-d', strtotime($request->until)), 
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

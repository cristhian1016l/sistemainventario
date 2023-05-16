<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {        
        return view('store.index');
    }

    public function returnStores()
    {
        $stores = DB::table('stores')->get();
        return $stores;
    }

    // RETURN DATA LIKE JSON

    public function getStores()
    {        
        return response()->json(['stores' => $this->returnStores()]);
    }

    public function getStoreById($id)
    {
        $store  = DB::select("SELECT * FROM stores WHERE id = ".$id);
        if($store === null){            
            return response()->json(['status' => 500, 'msg' => 'El almacén no existe', 'store' => []]);
        }else{
            $store = Store::findOrFail($id);
            return response()->json(['status' => 200, 'msg' => 'Datos devueltos', 'store' => $store]);
        }
    }

    public function insert(Request $request)
    {

        $in_use = 0;

        if($request->in_use == 'true'){
            $in_use = 1;
        }
        
        $rules = [                
            'name' => 'required',
            'address' => 'required',
            'manager' => 'required',
        ];

        $messages = [                
            'name.required' => 'El nombre del almacén es obligatorio',
            'address.required' => 'Ingrese la dirección del almacén',
            'manager.required' => 'Ingrese el encargado del almacén',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()){
            return response()->json(['status' => 500, 'msg' => 'No se pudo registrar el almacén', 'errors' => $validator->errors()->all()]);
        }

        try{
            DB::beginTransaction();
            
            $store = new Store();
            $store->name = mb_strtoupper($request->name, 'utf-8');
            $store->manager = mb_strtoupper($request->manager, 'utf-8');
            $store->address = mb_strtoupper($request->address, 'utf-8');
            $store->phone = mb_strtoupper($request->phone, 'utf-8');
            $store->city = mb_strtoupper($request->city, 'utf-8');
            $store->in_use = $in_use;
            $store->save();
            DB::commit();            
            return response()->json([
                'status' => 200,
                'stores' => $this->returnStores(),
                'msg' => "Ok"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'stores' => $this->returnStores(),
                'msg' => "Mensaje de excepción",
            ]);
        }  
    }

    public function edit(Request $request)
    {

        if($request->cod_store == null || $request->cod_store == ""){
            return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del almacén']);
        }

        $ExistsStore = Store::where('id', '=', $request->cod_store)->first();

        if($ExistsStore == []){
            return response()->json(['status' => 500, 'msg' => 'El almacén que se quiere editar no existe']);
        }

        $in_use = 0;

        if($request->in_use == 'true'){
            $in_use = 1;
        }

        $rules = [                
            'name' => 'required',
            'address' => 'required',
            'manager' => 'required',
        ];

        $messages = [                
            'name.required' => 'El nombre del almacén es obligatorio',
            'address.required' => 'Ingrese la dirección del almacén',
            'manager.required' => 'Ingrese el encargado del almacén',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()){
            return response()->json(['status' => 500, 'msg' => 'No se pudo actualizar el almacén', 'errors' => $validator->errors()->all()]);
        }

        try{
            DB::beginTransaction();
            $update = DB::update('UPDATE stores SET 
                        name = ?, address = ?, manager = ?, phone = ?, city = ?, in_use = ?, updated_at = ? WHERE id = ? ',
                        [mb_strtoupper($request->name, 'utf-8'), 
                        mb_strtoupper($request->address, 'utf-8'), 
                        mb_strtoupper($request->manager, 'utf-8'), 
                        mb_strtoupper($request->phone, 'utf-8'), 
                        mb_strtoupper($request->city, 'utf-8'), 
                        $in_use,
                        date_format(now(), "Y-m-d H:i:s"), $request->cod_store]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'stores' => $this->returnStores(),
                'msg' => 'OK'
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'stores' => $this->returnStores(),
                'msg' => "Mensaje de excepción",
            ]);
        }
    }

    public function delete(Request $request)
    {                   
        try{
            DB::beginTransaction();
            
            $delete = DB::table('stores')                    
                    ->where('id', $request->cod_store)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,
                'stores' => $this->returnStores(),
                'msg' => "Ok"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'stores' => $this->returnStores(),
                'msg' => $th->getMessage()
            ]);
        }  
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

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
        $store = Store::where('id', '=', $id)->first();
        if($store === null){            
            return response()->json(['status' => 500, 'msg' => 'El almacén no existe', 'store' => []]);
        }else{
            $store = Store::findOrFail($id);
            return response()->json(['status' => 200, 'msg' => 'Datos devueltos', 'store' => $store]);
        }
    }

    public function insert(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $store = new Store();
            $store->name = mb_strtoupper($request->name, 'utf-8');
            $store->manager = mb_strtoupper($request->manager, 'utf-8');
            $store->address = mb_strtoupper($request->address, 'utf-8');
            $store->phone = mb_strtoupper($request->phone, 'utf-8');
            $store->city = mb_strtoupper($request->city, 'utf-8');
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
                'msg' => $th->getMessage()
            ]);
        }  
    }

    public function edit(Request $request)
    {
        
        try{
            DB::beginTransaction();
            $update = DB::update('UPDATE stores SET 
                        name = ?, address = ?, manager = ?, phone = ?, city = ?, updated_at = ? WHERE id = ? ',
                        [mb_strtoupper($request->name, 'utf-8'), 
                        mb_strtoupper($request->address, 'utf-8'), 
                        mb_strtoupper($request->manager, 'utf-8'), 
                        mb_strtoupper($request->phone, 'utf-8'), 
                        mb_strtoupper($request->city, 'utf-8'), 
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
                'msg' => $th->getMessage(),
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

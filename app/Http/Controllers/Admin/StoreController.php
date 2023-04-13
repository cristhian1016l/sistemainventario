<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

class StoreController extends Controller
{
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

    public function insert(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $store = new Store();
            $store->address = mb_strtoupper($request->address, 'utf-8');
            $store->description = mb_strtoupper($request->description, 'utf-8');
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
            $update = DB::update('UPDATE stores SET address = ?, description = ?, updated_at = ? WHERE id = ? ',
                        [mb_strtoupper($request->address, 'utf-8'), mb_strtoupper($request->description, 'utf-8'), date_format(now(), "Y-m-d H:i:s"), $request->cod_store]);
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

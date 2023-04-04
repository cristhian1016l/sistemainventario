<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {        
        return view('store.index');
    }

    // RETURN DATA LIKE JSON

    public function getStores()
    {
        $stores = DB::table('store')->get();
        return response()->json(['stores' => $stores]);
    }


    public function delete()
    {
        $stores = DB::table('store')->get();
        return response()->json(['stores' => $stores]);
        // try{
        //     DB::beginTransaction();
            
        //     $delete = DB::table('TabGruposMiem')                    
        //             ->where('CodCon', $request->codcon)
        //             ->delete();            

        //     $stores = DB::table('store')->get();
        //     DB::commit();
        //     return response()->json([
        //         'status' => '200',
        //         'stores' => $stores,
        //         'msg' => "El almacén fue eliminado correctamente"
        //     ]);
        // }catch(\Exception $th){
        //     DB::rollback();
        //     return response()->json([
        //         'status' => '500',                
        //         'msg' => $th->getMessage()
        //     ]);
        // }  
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('brand.index');
    }    

    public function returnBrands()
    {
        $brands = DB::table('brands')->get();
        return $brands;
    }

    // RETURN DATA LIKE JSON

    public function getBrands()
    {
        return response()->json(['brands' => $this->returnBrands() ]);
    }

    public function insert(Request $request)
    {        
        try{
            DB::beginTransaction();
            
            $brand = new Brand();
            $brand->name = mb_strtoupper($request->name, 'utf-8');            
            $brand->save();
            DB::commit();            
            return response()->json([
                'status' => 200,
                'brands' => $this->returnBrands(),
                'msg' => "Marca agregada correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'brands' => $this->returnBrands(),
                'msg' => $th->getMessage()
            ]);
        }     
    }

    public function edit(Request $request)
    {
        try{
            DB::beginTransaction();
            $update = DB::update('UPDATE brands SET name = ?, updated_at = ? WHERE id = ? ',
                        [mb_strtoupper($request->brand, 'utf-8'), date_format(now(), "Y-m-d H:i:s"), $request->cod_brand]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'brands' => $this->returnBrands(),
                'msg' => 'La marca fue actualizada correctamente'
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'brands' => $this->returnBrands(),
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $delete = DB::table('brands')                    
                    ->where('id', $request->cod_brand)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,
                'brands' => $this->returnBrands(),
                'msg' => "La marca fue eliminada correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'brands' => $this->returnBrands(),
                'msg' => $th->getMessage()
            ]);
        }  
    }
}

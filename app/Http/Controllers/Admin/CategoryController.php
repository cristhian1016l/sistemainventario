<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }    

    public function returnCategories()
    {
        $categories = DB::table('categories')->get();
        return $categories;
    }

    // RETURN DATA LIKE JSON

    public function getCategories()
    {
        return response()->json(['categories' => $this->returnCategories() ]);
    }

    public function insert(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $category = new Category();
            $category->name = mb_strtoupper($request->category, 'utf-8');            
            $category->save();
            DB::commit();            
            return response()->json([
                'status' => 200,
                'categories' => $this->returnCategories(),
                'msg' => "Categoría agregada correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'categories' => $this->returnCategories(),
                'msg' => $th->getMessage()
            ]);
        }     
    }

    public function edit(Request $request)
    {
        try{
            DB::beginTransaction();
            $update = DB::update('UPDATE categories SET name = ?, updated_at = ? WHERE id = ? ',
                        [mb_strtoupper($request->category, 'utf-8'),
                        date_format(now(), "Y-m-d H:i:s"), 
                        $request->cod_category]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'categories' => $this->returnCategories(),
                'msg' => 'La categoría fue actualizada correctamente'
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'categories' => $this->returnCategories(),
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $delete = DB::table('categories')                    
                    ->where('id', $request->cod_category)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,
                'categories' => $this->returnCategories(),
                'msg' => "La categoría fue eliminada correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'categories' => $this->returnCategories(),
                'msg' => $th->getMessage()
            ]);
        }  
    }
}

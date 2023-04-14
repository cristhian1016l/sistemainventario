<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = DB::select("SELECT * FROM categories");
        $suppliers = DB::select("SELECT * FROM suppliers");
        $brands = DB::select("SELECT * FROM brands");
        $stores = DB::select("SELECT * FROM stores");
        $data = ['categories' => $categories, 'suppliers' => $suppliers, 'brands' => $brands, 'stores' => $stores];

        return view('product.index', $data);
    }

    public function returnProducts()
    {        
        $products = DB::select("SELECT p.id, p.code, p.stock, p.product_name, p.description, b.name AS brand, st.address AS store FROM products p
                                INNER JOIN brands b ON p.brand_id = b.id                                
                                INNER JOIN stores st ON p.store_id = st.id;");
        return $products;
    }

    // RETURN DATA LIKE JSON

    public function getProducts()
    {        
        return response()->json(['products' => $this->returnProducts()]);
    }

    public function getProductById($id)
    {
        $product = Product::where('id', '=', $id)->first();
        if($product === null){            
            return response()->json(['status' => 500, 'msg' => 'El producto no existe', 'product' => []]);
        }else{
            $product = Product::findOrFail($id);
            return response()->json(['status' => 200, 'msg' => 'Datos devueltos', 'product' => $product]);
        }
    }

    // public function insert(Request $request)
    // {
    //     if(strlen($request->ruc) != 11)
    //     {
    //         return response()->json([
    //             'status' => 500,
    //             'suppliers' => $this->returnProducts(),
    //             'msg' => 'EL RUC debe de tener 11 dígitos'
    //         ]);
    //     }else{
    //         try{
    //             DB::beginTransaction();
                
    //             $supplier = new Supplier();
    //             $supplier->bussiness_name = mb_strtoupper($request->bussiness, 'utf-8');
    //             $supplier->ruc = mb_strtoupper($request->ruc, 'utf-8');
    //             $supplier->address = mb_strtoupper($request->address, 'utf-8');
    //             $supplier->phone = mb_strtoupper($request->phone, 'utf-8');
    //             $supplier->landline = mb_strtoupper($request->landline, 'utf-8');
    //             $supplier->save();
    //             DB::commit();            
    //             return response()->json([
    //                 'status' => 200,
    //                 'suppliers' => $this->returnProducts(),
    //                 'msg' => "Proveedor agregado correctamente"
    //             ]);
    //         }catch(\Exception $th){
    //             DB::rollback();
    //             return response()->json([
    //                 'status' => 500,
    //                 'suppliers' => $this->returnProducts(),
    //                 'msg' => $th->getMessage()
    //             ]);
    //         }
    //     }        
    // }

    public function edit(Request $request)
    {
        return response()->json($request->all());

        $product = Product::where('id', '=', $id)->first();

        // if(strlen($request->ruc) != 11)
        // {
        //     return response()->json([
        //         'status' => 500,
        //         'suppliers' => $this->returnProducts(),
        //         'msg' => 'EL RUC debe de tener 11 dígitos'
        //     ]);
        // }else{        

        //     try{
        //         DB::beginTransaction();
        //         $update = DB::update('UPDATE suppliers SET bussiness_name = ?, ruc = ?, address = ?, phone = ?, landline = ?, updated_at = ? WHERE id = ? ',
        //                     [mb_strtoupper($request->bussiness, 'utf-8'), 
        //                     mb_strtoupper($request->ruc, 'utf-8'), 
        //                     mb_strtoupper($request->address), 
        //                     mb_strtoupper($request->phone), 
        //                     mb_strtoupper($request->landline), 
        //                     date_format(now(), "Y-m-d H:i:s"), 
        //                     $request->cod_product]);
        //         DB::commit();
        //         return response()->json([
        //             'status' => 200,
        //             'suppliers' => $this->returnProducts(),
        //             'msg' => 'El proveedor fue actualizado correctamente'
        //         ]);
        //     }catch(\Exception $th){
        //         DB::rollback();
        //         return response()->json([
        //             'status' => 500,
        //             'suppliers' => $this->returnProducts(),
        //             'msg' => $th->getMessage(),
        //         ]);
        //     }
        // }
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $delete = DB::table('products')
                    ->where('id', $request->cod_product)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,
                'products' => $this->returnProducts(),
                'msg' => "El producto fue eliminado correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'products' => $this->returnProducts(),
                'msg' => $th->getMessage()
            ]);
        }
    }
}

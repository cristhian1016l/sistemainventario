<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Validation\ProductValidation;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        $products = DB::select("SELECT p.id, p.code, p.stock, p.product_name, p.description, b.name AS brand, c.name AS category FROM products p
                                INNER JOIN brands b ON p.brand_id = b.id
                                INNER JOIN categories c ON p.category_id = c.id");
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

    public function gerProductsByCategory(Request $request)
    {
        $products = DB::select("SELECT * FROM products WHERE category_id = ".$request->category_id);
        return response()->json(['products' => $products]);
    }

    public function insert(Request $request)
    {
        
        $ProductValidation = new ProductValidation;                

        $validator = $ProductValidation->validateInsertAndUpdate($request);            

        if($validator->fails()){                
            return response()->json(['status' => 500, 'msg' => 'El producto no fue agregado', 'errors' => $validator->errors()->all()]);
        }else{

            $price = 0;
            if(str_starts_with($request->price, 'S/ ')){
                $price = substr($request->price, 3);
            }else{
                $price = $request->price;
            }

            try{
                DB::beginTransaction();
                
                $product = new Product();
                $product->product_name = mb_strtoupper($request->product_name, 'utf-8');
                $product->supplier_id = $request->supplier_id;
                $product->brand_id = $request->brand_id;
                $product->category_id = $request->category_id;
                // $product->store_id = $request->store_id;
                $product->description = mb_strtoupper($request->description, 'utf-8');
                $product->price = $price;
                $product->stock = $request->stock;
                $product->save();
                DB::commit();            
                return response()->json([
                    'status' => 200,                    
                    'msg' => "Producto agregado correctamente"
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

        $ProductValidation = new ProductValidation;                

        $ProductValidation->validateIfIsNullOrEmpty($request->id);

        $product = $ProductValidation->validateIfExists($request->id);

        if(isset($product)){

            $validator = $ProductValidation->validateInsertAndUpdate($request);            

            if($validator->fails()){
                return response()->json(['status' => 500, 'msg' => 'El producto no fue editado', 'errors' => $validator->errors()->all()]);
            }else{
                $price = 0;
                if(str_starts_with($request->price, 'S/ ')){
                    $price = substr($request->price, 3);
                }else{
                    $price = $request->price;
                }

                try{
                    DB::beginTransaction();
                    $update = DB::update('UPDATE products SET
                                        product_name = ?,
                                        supplier_id = ?,
                                        brand_id = ?,
                                        category_id = ?,
                                        -- store_id = ?,
                                        description = ?,
                                        price = ?,
                                        stock = ?,
                                        updated_at = ?
                                        WHERE id = ? ',
                                [mb_strtoupper($request->product_name, 'utf-8'), 
                                $request->supplier_id,
                                $request->brand_id,
                                $request->category_id,
                                // $request->store_id,
                                mb_strtoupper($request->description),
                                $price,
                                $request->stock,
                                date_format(now(), "Y-m-d H:i:s"), 
                                $request->id]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,                        
                        'msg' => 'El producto fue actualizado correctamente'
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

    // ****************************  REPORTES  ****************************

    public function productsReport()
    {
        $products = DB::select("SELECT p.product_name, p.price, p.stock, c.name AS category FROM products p
                                INNER JOIN categories c ON p.category_id = c.id");
        $data = ['products' => $products];
        $pdf=PDF::loadView('admin.reports.products_report', $data);
        // $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}

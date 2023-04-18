<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Worker;

class WorkerController extends Controller
{
    public function index()
    {
        $documents = DB::select("SELECT * FROM document_type");
        $data = ["documents" => $documents];
        return view('worker.index', $data);
    }

    public function returnWorkers()
    {        
        $workers = DB::table('workers')->get();
        return $workers;
    }

    // RETURN DATA LIKE JSON

    public function getWorkers()
    {        
        return response()->json(['workers' => $this->returnWorkers()]);
    }

    public function getWorkerById($id)
    {
        $worker = Worker::where('id', '=', $id)->first();
        if($worker === null){            
            return response()->json(['status' => 500, 'msg' => 'El trabajador no existe', 'worker' => []]);
        }else{
            $worker = Worker::findOrFail($id);
            return response()->json(['status' => 200, 'msg' => 'Datos devueltos', 'worker' => $worker]);
        }
    }

    // public function insert(Request $request)
    // {
    //     return response()->json(['data' => $request->all(), 'action' => "insert"]);     

    //     // if(strlen($request->ruc) != 11)
    //     // {
    //     //     return response()->json([
    //     //         'status' => 500,
    //     //         'suppliers' => $this->returnProducts(),
    //     //         'msg' => 'EL RUC debe de tener 11 dígitos'
    //     //     ]);
    //     // }else{
    //     //     try{
    //     //         DB::beginTransaction();
                
    //     //         $supplier = new Supplier();
    //     //         $supplier->bussiness_name = mb_strtoupper($request->bussiness, 'utf-8');
    //     //         $supplier->ruc = mb_strtoupper($request->ruc, 'utf-8');
    //     //         $supplier->address = mb_strtoupper($request->address, 'utf-8');
    //     //         $supplier->phone = mb_strtoupper($request->phone, 'utf-8');
    //     //         $supplier->landline = mb_strtoupper($request->landline, 'utf-8');
    //     //         $supplier->save();
    //     //         DB::commit();            
    //     //         return response()->json([
    //     //             'status' => 200,
    //     //             'suppliers' => $this->returnProducts(),
    //     //             'msg' => "Proveedor agregado correctamente"
    //     //         ]);
    //     //     }catch(\Exception $th){
    //     //         DB::rollback();
    //     //         return response()->json([
    //     //             'status' => 500,
    //     //             'suppliers' => $this->returnProducts(),
    //     //             'msg' => $th->getMessage()
    //     //         ]);
    //     //     }
    //     // }        
    // }

    // public function edit(Request $request)
    // {
    //     // return response()->json($request->all());

    //     // return response()->json(['data' => $request->all(), 'action' => "update"]);     

    //     if($request->id == null || $request->id == ""){
    //         return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del producto']);
    //     }

    //     $product = Product::where('id', '=', $request->id)->first();
    //     if(isset($product)){

    //         $rules = [
    //             'id' => 'required',
    //             'brand_id' => 'required',
    //             'category_id' => 'required',
    //             'store_id' => 'required',
    //             'supplier_id' => 'required',
    //             'price' => 'required',
    //             'stock' => 'required|numeric'
    //         ];

    //         $messages = [
    //             'id.required' => 'Error en el código del producto',
    //             'brand_id.required' => 'La marca es obligatoria',
    //             'category_id.required' => 'La categoría es obligatoria',
    //             'store_id.required' => 'El almacén es obligatorio',
    //             'supplier_id.required' => 'El proveedor es obligatorio',
    //             'price.required' => 'Ingrese el precio mínimo del producto',                
    //             'stock.required' => 'Ingrese el stock mínimo del producto',
    //             'stock.numeric' => 'El stock debe de ser numérico'
    //         ];

    //         $validator = Validator::make($request->all(), $rules, $messages);

    //         if($validator->fails()){                
    //             return response()->json(['status' => 500, 'msg' => 'El producto no fue editado', 'errors' => $validator->errors()->all()]);
    //         }else{
    //             $price = 0;
    //             if(str_starts_with($request->price, 'S/ ')){
    //                 $price = substr($request->price, 3);
    //             }else{
    //                 $price = $request->price;
    //             }

    //             try{
    //                 DB::beginTransaction();
    //                 $update = DB::update('UPDATE products SET
    //                                     product_name = ?,
    //                                     supplier_id = ?,
    //                                     brand_id = ?,
    //                                     category_id = ?,
    //                                     store_id = ?,
    //                                     description = ?,
    //                                     price = ?,
    //                                     stock = ?,
    //                                     updated_at = ?
    //                                     WHERE id = ? ',
    //                             [mb_strtoupper($request->product_name, 'utf-8'), 
    //                             $request->supplier_id,
    //                             $request->brand_id,
    //                             $request->category_id,
    //                             $request->store_id,
    //                             mb_strtoupper($request->description),
    //                             $price,
    //                             $request->stock,
    //                             date_format(now(), "Y-m-d H:i:s"), 
    //                             $request->id]);
    //                 DB::commit();
    //                 return response()->json([
    //                     'status' => 200,                        
    //                     'msg' => 'El producto fue actualizado correctamente'
    //                 ]);
    //             }catch(\Exception $th){
    //                 DB::rollback();
    //                 return response()->json([
    //                     'status' => 500,                        
    //                     'msg' => $th->getMessage(),
    //                 ]);
    //             }
    //         }
            
    //     }else{
    //         return response()->json("NO");
    //     }        
    // }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $delete = DB::table('workers')
                    ->where('id', $request->cod_worker)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,                
                'msg' => "El trabajador fue eliminado correctamente"
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }    

    public function returnSuppliers()
    {
        $suppliers = DB::table('suppliers')->get();
        return $suppliers;
    }

    // RETURN DATA LIKE JSON

    public function getSuppliers()
    {
        return response()->json(['suppliers' => $this->returnSuppliers() ]);
    }

    public function insert(Request $request)
    {
        if(strlen($request->ruc) != 11)
        {
            return response()->json([
                'status' => 500,
                'suppliers' => $this->returnSuppliers(),
                'msg' => 'EL RUC debe de tener 11 dígitos'
            ]);
        }else{
            try{
                DB::beginTransaction();
                
                $supplier = new Supplier();
                $supplier->bussiness_name = mb_strtoupper($request->bussiness, 'utf-8');
                $supplier->ruc = mb_strtoupper($request->ruc, 'utf-8');
                $supplier->address = mb_strtoupper($request->address, 'utf-8');
                $supplier->phone = mb_strtoupper($request->phone, 'utf-8');
                $supplier->landline = mb_strtoupper($request->landline, 'utf-8');
                $supplier->save();
                DB::commit();            
                return response()->json([
                    'status' => 200,
                    'suppliers' => $this->returnSuppliers(),
                    'msg' => "Proveedor agregado correctamente"
                ]);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'suppliers' => $this->returnSuppliers(),
                    'msg' => $th->getMessage()
                ]);
            }
        }        
    }

    public function edit(Request $request)
    {
        if(strlen($request->ruc) != 11)
        {
            return response()->json([
                'status' => 500,
                'suppliers' => $this->returnSuppliers(),
                'msg' => 'EL RUC debe de tener 11 dígitos'
            ]);
        }else{        

            try{
                DB::beginTransaction();
                $update = DB::update('UPDATE suppliers SET bussiness_name = ?, ruc = ?, address = ?, phone = ?, landline = ?, updated_at = ? WHERE id = ? ',
                            [mb_strtoupper($request->bussiness, 'utf-8'), 
                            mb_strtoupper($request->ruc, 'utf-8'), 
                            mb_strtoupper($request->address), 
                            mb_strtoupper($request->phone), 
                            mb_strtoupper($request->landline), 
                            date_format(now(), "Y-m-d H:i:s"), 
                            $request->cod_supplier]);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'suppliers' => $this->returnSuppliers(),
                    'msg' => 'El proveedor fue actualizado correctamente'
                ]);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'suppliers' => $this->returnSuppliers(),
                    'msg' => $th->getMessage(),
                ]);
            }
        }
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            
            $delete = DB::table('suppliers')                    
                    ->where('id', $request->cod_supplier)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,
                'suppliers' => $this->returnSuppliers(),
                'msg' => "El proveedor fue eliminado correctamente"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'suppliers' => $this->returnSuppliers(),
                'msg' => $th->getMessage()
            ]);
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Worker;
use App\Models\WorkerProduct;
use App\Validation\WorkerValidation;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = DB::select("SELECT * FROM products");
        $documents = DB::select("SELECT * FROM document_type");
        $worker_types = DB::select("SELECT * FROM worker_type");
        $areas = DB::select("SELECT * FROM areas");
        $companies = DB::select("SELECT * FROM companies");
        $data = ["documents" => $documents,
                "products" => $products,
                "types" => $worker_types,
                "areas" => $areas,
                "companies" => $companies];
        return view('worker.index', $data);
    }

    public function returnWorkers()
    {
        $workers = DB::select("SELECT w.id, CONCAT(w.lastname,' ', w.name) as names, wt.name AS type, dt.document_type, w.document, a.name AS area, c.name AS company FROM workers w
                                INNER JOIN document_type dt ON w.document_type_id = dt.id
                                INNER JOIN worker_type wt ON w.worker_type_id = wt.id
                                INNER JOIN areas a ON w.area_type_id = a.id
                                INNER JOIN companies c ON w.company_id = c.id
                                WHERE w.deleted_at IS NULL");
        return $workers;
    }

    // RETURN DATA LIKE JSON

    public function getWorkers()
    {
        return response()->json(['workers' => $this->returnWorkers()]);
    }

    public function getWorkerById($id)
    {
        $WorkerValidation = new WorkerValidation;
        $worker = $WorkerValidation->validateIfExists($id);
        if($worker === null){
            return response()->json(['status' => 500, 'msg' => 'El trabajador no existe', 'worker' => []]);
        }else{
            $worker = Worker::findOrFail($id);
            return response()->json(['status' => 200, 'msg' => 'Datos devueltos', 'worker' => $worker]);
        }
    }

    public function insert(Request $request)
    {
        $WorkerValidation = new WorkerValidation;

        $validator = $WorkerValidation->validateInsertAndUpdate($request);

        if($validator->fails()){
            return response()->json(['status' => 500, 'msg' => 'El trabajador no fue agregado', 'errors' => $validator->errors()->all()]);
        }else{

            try{

                DB::beginTransaction();
                $worker = new Worker();
                $worker->name = mb_strtoupper($request->name, 'utf-8');
                $worker->lastname = mb_strtoupper($request->lastname, 'utf-8');
                $worker->address = mb_strtoupper($request->address, 'utf-8');
                $worker->document_type_id = $request->document_type_id;
                $worker->document = $request->document;
                $worker->worker_type_id = $request->worker_type_id;
                $worker->area_type_id = $request->area_type;
                $worker->company_id = $request->company_id;
                $worker->save();
                DB::commit();

                return response()->json([
                    'status' => 200,
                    'msg' => 'El trabajador fue agregado correctamente'
                ]);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json([
                    'status' => 500,
                    'msg' => $th->getMessage(),
                ]);
            }
        }

    }

    public function edit(Request $request)
    {
        $WorkerValidation = new WorkerValidation;

        $WorkerValidation->validateIfIsNullOrEmpty($request->id);

        $worker = $WorkerValidation->validateIfExists($request->id);
        if(isset($worker)){

            $validator = $WorkerValidation->validateInsertAndUpdate($request);

            if($validator->fails()){
                return response()->json(['status' => 500, 'msg' => 'El trabajador no fue editado', 'errors' => $validator->errors()->all()]);
            }else{

                try{
                    DB::beginTransaction();
                    $update = DB::update('UPDATE workers SET
                                        name = ?,
                                        lastname = ?,
                                        address = ?,
                                        document_type_id = ?,
                                        worker_type_id = ?,
                                        area_type_id = ?,
                                        company_id = ?,
                                        document = ?,
                                        updated_at = ?
                                        WHERE id = ? ',
                                [mb_strtoupper($request->name, 'utf-8'),
                                mb_strtoupper($request->lastname, 'utf-8'),
                                mb_strtoupper($request->address, 'utf-8'),
                                $request->document_type_id,
                                $request->worker_type_id,
                                $request->area_type,
                                $request->company_id,
                                $request->document,
                                date_format(now(), "Y-m-d H:i:s"),
                                $request->id]);
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'msg' => 'El trabajador fue actualizado correctamente'
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
            return response()->json([
                'status' => 500,
                'msg' => 'El trabajar no existe en la base de datos',
            ]);
        }
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();

            $worker = Worker::find($request->cod_worker);
            $worker->delete();

            // $delete = DB::table('workers')
            //         ->where('id', $request->cod_worker)
            //         ->delete();

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

    // ELIMINAR PERMAMENTEMENTE

    // public function deletePermanently(Request $request)
    // {
    //     try{
    //         DB::beginTransaction();

    //         $worker = Worker::onlyTrashed()->find($request->cod_worker);
    //         $worker->forceDelete();

    //         DB::commit();

    //         return response()->json([
    //             'status' => 200,
    //             'msg' => "El trabajador fue eliminado correctamente"
    //         ]);
    //     }catch(\Exception $th){
    //         DB::rollback();
    //         return response()->json([
    //             'status' => 500,
    //             'msg' => $th->getMessage()
    //         ]);
    //     }
    // }

    // ELIMINAR PERMAMENTEMENTE

    public function getAssignedProducts(Request $request)
    {

        try{
            $products = DB::select("SELECT wp.id, p.product_name, b.name, wp.amount FROM worker_product wp
                        INNER JOIN workers w ON wp.worker_id = w.id
                        INNER JOIN products p ON wp.product_id = p.id
                        INNER JOIN brands b ON p.brand_id = b.id
                        WHERE wp.worker_id = ".$request->cod_worker);

            return response()->json([
                'status' => 200,
                'products' => $products,
                'msg' => "Productos devueltos"
            ]);
        }catch(\Exception $th){
            return response()->json([
                'status' => 500,
                'products' => null,
                'msg' => $th->getMessage()
            ]);
        }

    }

    public function assignProductsToWorker(Request $request)
    {
        // return response()->json($request->all());
        $WorkerValidation = new WorkerValidation;

        if($request->cod_worker == null || $request->cod_worker == ""){
            return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del trabajador']);
        }

        $validator = $WorkerValidation->validateAsignProductToWorker($request);

        if($validator->fails()){
            return response()->json(['status' => 500, 'msg' => 'El trabajador no fue editado', 'errors' => $validator->errors()->all()]);
        }else{

            try{
                DB::beginTransaction();
                $workerProduct = new WorkerProduct();
                $workerProduct->worker_id = $request->cod_worker;
                $workerProduct->product_id = $request->product_id;
                $workerProduct->amount = $request->amount;
                $workerProduct->save();
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'msg' => 'El producto fue asignado al trabajador correctamente'
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

    public function deleteProductAssigned(Request $request)
    {
        if($request->product_worker_id == null || $request->product_worker_id == ""){
            return response()->json(['status' => 500, 'msg' => 'Error al recibir el código']);
        }

        $WorkerValidation = new WorkerValidation;
        $worker = $WorkerValidation->validateIfExistsProductAssigned($request->product_worker_id);

        if($worker === null){
            return response()->json(['status' => 500, 'msg' => 'El producto asignado no existe', 'worker' => []]);
        }else{
            try{
                DB::beginTransaction();
                $delete = DB::table('worker_product')
                        ->where('id', $request->product_worker_id)
                        ->delete();
                DB::commit();
                return response()->json(['status' => 200, 'msg' => 'El producto asignado fue eliminado correctamente']);
            }catch(\Exception $th){
                DB::rollback();
                return response()->json(['status' => 500, 'msg' => 'Error al eliminar el producto asignado']);
            }
        }

        // return response()->json($request->all());
    }

    // ****************************  REPORTES  ****************************

    public function swornDeclarationPDF($area)
    {
        // dd($area);
        // exit;
        $all_data = array();
        $products_asigned = array();

        $workers = DB::select("SELECT * FROM workers WHERE area_type_id = ".$area);

        foreach($workers as $worker){
            $products = DB::select("SELECT p.id, p.product_name, wp.amount FROM worker_product wp
                                    INNER JOIN products p ON wp.product_id = p.id
                                    WHERE wp.worker_id = ".$worker->id);

            foreach($products as $product){
                array_push($products_asigned, ['product_name' => $product->product_name, 'amount' => $product->amount]);
            }
            array_push($all_data, ['id' => $worker->id, 'names' => $worker->name.' '.$worker->lastname, 'document' => $worker->document, 'address' => $worker->address, 'products' => collect($products_asigned) ]);
            $products_asigned = [];
        }


        $data = ['all_data' => collect($all_data)];
        // dd($data);
        // exit;
        $pdf=PDF::loadView('admin.reports.sworndeclaration', $data);
        return $pdf->stream();
    }

    public function listingByPositionPDF($cod_type)
    {        
        $workers = DB::select("SELECT * FROM workers WHERE worker_type_id = ".$cod_type);

        $type = DB::select("SELECT name FROM worker_type WHERE id = ".$cod_type);

        $data = ['workers' => $workers, 'type' => $type];
        $pdf=PDF::loadView('admin.reports.listingByPosition', $data);
        return $pdf->stream();
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Worker;
use App\Validation\WorkerValidation;

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
        $workers = DB::select("SELECT w.id, w.name, w.lastname, dt.document_type, w.document FROM workers w
                                INNER JOIN document_type dt ON w.document_type_id = dt.id");
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
                $worker->document_type_id = $request->document_type_id;
                $worker->document = $request->document;
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
                                        document_type_id = ?,
                                        document = ?,
                                        updated_at = ?
                                        WHERE id = ? ',
                                [mb_strtoupper($request->name, 'utf-8'), 
                                mb_strtoupper($request->lastname, 'utf-8'),
                                $request->document_type_id,
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Validation\RequestValidation;
use App\Models\Request as RequestModel;
use App\Models\RequestDetails;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('request.index');
    }

    public function create()
    {
        $categories = DB::select("SELECT * FROM categories");
        $workers = DB::select("SELECT * FROM workers WHERE worker_type_id = 2");
        $data = ["workers" => $workers, "categories" => $categories];
        
        return view('request.create', $data);
    }

    public function returnRequests()
    {        
        $requests = DB::select("SELECT r.cod_request, r.since_date, r.to_date, r.deadline, r.was_entered, CONCAT(w.name, ' ', w.lastname) as name FROM requests r INNER JOIN workers w 
                                ON r.responsible_id = w.id");
        return $requests;
    }

    // RETURN DATA LIKE JSON

    public function getRequests()
    {
        return response()->json(['requests' => $this->returnRequests()]);
    }
    
    public function insert(Request $request)
    {
        if($request->products == []){
            return response()->json([
                'status' => 500,
                'msg' => "Debe seleccionar algún producto",
            ]);
        }

        // return response()->json($request->all());


        $RequestValidation = new RequestValidation;        

        $validator = $RequestValidation->validateInsertAndUpdate($request);

        // return response()->json($request->products);

        if($validator->fails()){
            return response()->json([
                'status' => 500, 
                "msg" => "La solicitud no fue creada", 
                'errors' => $validator->errors()->all()
            ]);
        }else{
            try{

                DB::beginTransaction();

                $date = \Carbon\Carbon::now();
                define('_CodRequest', $date->format('dmYis'));

                $requestModel = new RequestModel();
                $requestModel->cod_request = _CodRequest;
                $requestModel->responsible_id = $request->responsible_id;
                $requestModel->date = date_format(now(), "Y-m-d H:i:s");
                $requestModel->since_date = $request->since_date;
                $requestModel->to_date = $request->to_date;
                $requestModel->deadline = null;
                $requestModel->was_entered = false;
                $requestModel->save();

                // return response()->json($request->products);


                foreach($request->products as $detail){
                    $requestDetail = new RequestDetails();
                    $requestDetail->cod_request = _CodRequest;
                    $requestDetail->product_id = $detail['id'];
                    $requestDetail->amount = $detail['amount'];
                    $requestDetail->save();
                }                

                DB::commit();                                
                
                return response()->json([
                    'status' => 200,
                    'msg' => 'La solicitud fue realizada correctamente',
                    'cod_request' => _CodRequest
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

    public function changeStatus(Request $request)
    {

        // return response()->json($request->all());

        $status = $request->entered;        

        $response = [];

        try {
            DB::beginTransaction();
            switch ($status) {
                case '0':                
                    $update = DB::update('UPDATE requests SET
                                        was_entered = true,
                                        deadline = ?
                                        WHERE cod_request = ?',
                                        [ date_format(now(), "Y-m-d H:i:s"), $request->request_id ] );                                        
                    DB::commit();                
    
                    $response = ['status' => 200,
                                'msg' => 'La solicitud fue cerrada correctamente'];
                    break;
    
                case '1':
                    $update = DB::update('UPDATE requests SET
                                        was_entered = false,
                                        deadline = ?
                                        WHERE cod_request = ?',
                                        [ null, $request->request_id ] );
                    DB::commit();
                    $response = ['status' => 200,
                                'msg' => 'La solicitud fue abierta nuevamente'];
                    break;
                
                default:
                    $response = ['status' => 500,
                                'msg' => 'Hubo un error al cambiar el estado'];
                    break;
            }
        } catch (\Exception $th) {
                    $response = ['status' => 500,
                                'msg' => $th->getMessage()];
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        // return response()->json($request->all());

        try{
            DB::beginTransaction();
            
            $delete = DB::table('requests')
                    ->where('cod_request', $request->cod_request)
                    ->delete();            
            
            DB::commit();            

            return response()->json([
                'status' => 200,
                'requests' => $this->returnRequests(),
                'msg' => "Ok"
            ]);
        }catch(\Exception $th){
            DB::rollback();
            return response()->json([
                'status' => 500,
                'requests' => $this->returnRequests(),
                'msg' => $th->getMessage()
            ]);
        }  

    }

    // ****************************  REPORTES  ****************************

    public function request_report($cod_request)
    {
        $all_data = array();
        $products_asigned = array();  

        $header = DB::select("SELECT 
                                    r.cod_request, r.since_date, r.to_date, 
                                    r.deadline, r.date, r.was_entered, CONCAT(w.name, ' ', w.lastname) as name,
                                    w.document, w.address
                                FROM requests r INNER JOIN workers w 
                                ON r.responsible_id = w.id
                                WHERE r.cod_request = '".$cod_request."'");

        $details = DB::select("SELECT rd.id, p.product_name, p.description, rd.amount
                                FROM requests_details rd INNER JOIN products p
                                ON rd.product_id = p.id
                                WHERE rd.cod_request = '".$cod_request."'");
        
        $data = ['cod' => $cod_request, 'header' => $header, 'details' => $details];    

        $pdf=PDF::loadView('admin.reports.request_report', $data);
        return $pdf->stream();
        // return $pdf->download('solicitud: '.$cod_request.'.pdf');
    }


}
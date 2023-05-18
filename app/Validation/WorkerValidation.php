<?php

namespace App\Validation;
use Illuminate\Support\Facades\Validator;
use App\Models\Worker;
use App\Models\WorkerProduct;

class WorkerValidation{

       function validateIfIsNullOrEmpty($id){
              if($id == null || $id == ""){
                     return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del trabajador']);
              }
       }

       function validateIfExists($id){
              return Worker::where('id', '=', $id)->first();
       }

       function validateIfExistsProductAssigned($id){
              return WorkerProduct::where('id', '=', $id)->first();
       }

       function validateInsertAndUpdate($request){
              $rules = [                
                'name' => 'required',
                'lastname' => 'required',
                'document_type_id' => 'required|numeric',
                'worker_type_id' => 'required|numeric',
                'area_type' => 'required|numeric',
                'company_id' => 'required|numeric',
                'document' => 'required|numeric|min_digits:8'
            ];

            $messages = [                
                'name.required' => 'Ingrese el nombre',
                'lastname.required' => 'Ingrese el apellido',
                'document_type_id.required' => 'Elige el tipo de documento',
                'document_type_id.numeric' => 'Error al elegir el tipo de documento',
                'worker_type_id.required' => 'Elija el cargo',
                'worker_type_id.numeric' => 'Error al elegir el cargo',
                'area_type.required' => 'Elija el area',
                'area_type.numeric' => 'Error al elegir el area',
                'company_id.required' => 'Elija la empresa',
                'company_id.numeric' => 'Error al elegir la empresa',
                'document.required' => 'Ingrese el documento',
                'document.numeric' => 'El documento no tiene el formato correcto',
                'document.min_digits' => 'El documento no tiene los dígitos suficientes'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            return $validator;
       }

       function validateAsignProductToWorker($request){
              $rules = [                
                     'cod_worker' => 'required|numeric',
                     'product_id' => 'required|numeric',
                     'amount' => 'required|numeric'
              ];

              $messages = [                
                     'cod_worker.required' => 'No se seleccionó el trabajador',
                     'cod_worker.numeric' => 'Error al elegir el trabajador',                     
                     'product_id.required' => 'Ingrese el producto asignado',
                     'product_id.numeric' => 'Error al elegir el product',                     
                     'amount.required' => 'Ingrese la cantidad',
                     'amount.numeric' => 'Error al ingresar la cantidad',
                     
              ];

              $validator = Validator::make($request->all(), $rules, $messages);
              return $validator;
       }

}

?>
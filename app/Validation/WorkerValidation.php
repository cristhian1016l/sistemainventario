<?php

namespace App\Validation;
use Illuminate\Support\Facades\Validator;
use App\Models\Worker;

class WorkerValidation{

       function validateIfIsNullOrEmpty($id){
              if($id == null || $id == ""){
                     return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del trabajador']);
              }
       }

       function validateIfExists($id){
              return Worker::where('id', '=', $id)->first();
       }

       function validateInsertAndUpdate($request){
              $rules = [                
                'name' => 'required',
                'lastname' => 'required',
                'document_type_id' => 'required|numeric',
                'document' => 'required|numeric|min_digits:8'
            ];

            $messages = [                
                'name.required' => 'Ingrese el nombre',
                'lastname.required' => 'Ingrese el apellido',
                'document_type_id.required' => 'Elige el tipo de documento',
                'document_type_id.numeric' => 'Error al elegir el tipo de documento',
                'document.required' => 'Ingrese el documento',
                'document.numeric' => 'El documento no tiene el formato correcto',
                'document.min_digits' => 'El documento no tiene los dígitos suficientes'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            return $validator;
       }

}

?>
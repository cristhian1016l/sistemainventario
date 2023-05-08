<?php

namespace App\Validation;
use Illuminate\Support\Facades\Validator;
use App\Models\Request;

class RequestValidation{

       function validateIfIsNullOrEmpty($id){
              if($id == null || $id == ""){
                     return response()->json(['status' => 500, 'msg' => 'Error al enviar el código de la solicitud']);
              }
       }

       function validateIfExists($id){
              return Request::where('id', '=', $id)->first();
       }

       function validateInsertAndUpdate($request){
              $rules = [
                'responsible_id' => 'required',
                'since_date' => 'required',
                'to_date' => 'required'
            ];

            $messages = [
                'responsible_id.required' => 'Ingrese el responsable de la solicitud',
                'since_date.required' => 'Ingrese la fecha de inicio',
                'to_date.required' => 'Ingrese la fecha de devolución',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            return $validator;
       }

}

?>
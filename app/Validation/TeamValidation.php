<?php

namespace App\Validation;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;

class TeamValidation{

    //    function validateIfIsNullOrEmpty($id){
    //           if($id == null || $id == ""){
    //                  return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del equipo']);
    //           }
    //    }

    //    function validateIfExists($id){
    //           return Team::where('id', '=', $id)->first();
    //    }

       function validateInsertAndUpdate($request){
              $rules = [
                'team' => 'required',
                'productor_id' => 'required',
            ];

            $messages = [
                'team.required' => 'Ingrese el nombre del equipo',
                'productor_id.required' => 'Ingrese el productor del equipo',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            return $validator;
       }

}

?>
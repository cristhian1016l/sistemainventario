<?php

namespace App\Validation;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductValidation{

       function validateIfIsNullOrEmpty($id){
              if($id == null || $id == ""){
                     return response()->json(['status' => 500, 'msg' => 'Error al enviar el código del producto']);
              }
       }

       function validateIfExists($id){
              return Product::where('id', '=', $id)->first();
       }

       function validateInsertAndUpdate($request){
              $rules = [                
                'product_name' => 'required',
                'brand_id' => 'required',
                'category_id' => 'required',
              //   'store_id' => 'required',
                'supplier_id' => 'required',
                'price' => 'required',
                'stock' => 'required|numeric'
            ];

            $messages = [                
                'product_name.required' => 'El nombre del producto es obligatorio',
                'brand_id.required' => 'Ingrese la marca',
                'category_id.required' => 'Ingrese la categoría',
              //   'store_id.required' => 'Elija el almacén correspondiente',                
                'supplier_id.required' => 'Elija el proveedor del producto',
                'price.required' => 'indique el precio del producto',
                'stock.required' => 'Ingrese el stock mínimo del producto',
                'stock.numeric' => 'El stock debe ser numérico'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            return $validator;
       }

}

?>
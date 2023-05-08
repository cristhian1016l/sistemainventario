<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['login', 'logout']]);
    }

    public function show_login()
    {
        return view('auth.login');
    }

    public function login()
    {        
        // return redirect('/admin/panel');

        $validator = Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            //mostrar errores, o en json o lo que necesites
            return redirect('/')->with('msg', 'Ingrese el usuario y contraseña')->with('typealert', 'error');;

        }
        $user = User::where('email', request('email').'@ponceproducciones.com')->first();
        
        if($user == null){
            return redirect('/')->with('msg', 'El usuario no existe en la base de datos')->with('typealert', 'error');;
        }else{           
            if($user['active'] == 1){
                if(Hash::check(request('password'), $user['password'])){
                    Auth::attempt(['email' => request('email').'@ponceproducciones.com', 'password' => request('password')]);
                    return redirect('/panel');
                }else{                    
                    return redirect('/')->with('msg', 'Usuario y/o contraseña incorrectos')->with('typealert', 'error');;
                }
            }else{
                return redirect('/')->with('msg', 'Su cuenta está desactivada')->with('typealert', 'error');
            }             
        }    
    }

    public function logout(){
        //Desconctamos al usuario
        Auth::logout();
        //Redireccionamos al inicio de la app con un mensaje
        return redirect('/')->with('msg', 'Gracias por visitarnos!.')->with('typealert', 'success');
    }

}

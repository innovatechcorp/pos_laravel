<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;

class loginController extends Controller
{
    //
    public function index(){
        if(Auth::check()){
            return redirect()->route('panel');
        }
        return view('auth.login');
    }
    public function login(loginRequest $request){
        //validar credenciales
        if(!Auth::validate($request->only('email','password'))){
            return redirect()->to('login')->withErrors('Credenciales incorrectas');
        }
        //Crear una sesion
        $user = Auth::getProvider()->retrieveByCredentials($request->only('email','password'));
        Auth::login($user);

        return redirect()->route('panel')->with('success', 'Bienvenido '.$user->name);
    }
}

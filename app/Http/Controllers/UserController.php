<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App; //Recuperando modelos, App es el namespace

class UserController extends Controller
{    
    /*
    public function index(){
    }

    public function create(){
    }

    public function store(Request $request){
    }

    public function show($id){
    }

    public function edit($id){
    }

    public function update(Request $request, $id){
    }

    public function destroy($id){
    }
    */

    public function config(){
        return view('user.config');
    }

    public function update(Request $request){    
        /* Recogemos datos del formulario */
        $id      = \Auth::user()->id;
        $name    = $request->input('name');
        $surname = $request->input('surname');
        $nick    = $request->input('nick');
        $email   = $request->input('email'); 
        
        // echo $id;
        // echo "<pre>";        
        // print_r($request->all());
        // echo "</pre>";
        // return;

        /* Validacion del formulario */
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],           //El nick sera unico, pero puede haber una excepción que el nick coincide con el nick del id actual
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id] //El email sera unico, pero puede haber una excepción que el email coincide con el email del id actual            
        ]);    
        
        /* Asignar nuevos valores al objeto de usuario */
        $user = App\User::findOrFail($id);
        $user->name    = $name;
        $user->surname = $surname;
        $user->nick    = $nick;
        $user->email   = $email;
        $user->update();

        return redirect()->route('config.index')
                         ->with('mensaje', 'Usuario actualizado correctamente');
    }
}

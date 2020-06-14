<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App; //Recuperando modelos, App es el namespace

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

    public function __construct(){
        $this->middleware('auth');
    }

    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        // echo "<pre>";        
        // print_r($request->all());
        // echo "</pre>";
        // return;

        /* Recogemos datos del formulario */
        $id      = \Auth::user()->id;
        $name    = $request->input('name');
        $surname = $request->input('surname');
        $nick    = $request->input('nick');
        $email   = $request->input('email');

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

        /* Subimos imagen */
        $image = $request->file('image');
        if($image){ //Solo si hay imagen
            $image_path = time()."_".$image->getClientOriginalName(); //Poner nombre unico
            Storage::disk('disk_users')->put($image_path, File::get($image)); //Guardar en la carpeta storage/app/users
            $user->image = $image_path; //Seteo el nombre de la imagen en el objeto
        }

        $user->update();

        return redirect()->route('config.index')
                         ->with('mensaje', 'Usuario actualizado correctamente');
    }

    public function getImage($filename){
        $file = Storage::disk('disk_users')->get($filename);
        $response = Response::make($file, 200);
        return $response;
    }
}

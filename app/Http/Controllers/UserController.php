<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config()
    {
        return view('user.config');
    }

    public function update(Request $request, $id)
    {
        /* Obtenemos todo el request */
        // return $request->all();                

        /* Validamos datos */        
        $request->validate([
            'name'    => "required|string|max:255",
            'surname' => "required|string|max:255",
            'nick'    => "required|string|max:255|unique:users,nick,".$id,        //El nick sera unico, pero puede haber una excepción que el nick coincide con el nick del id actual
            'email'   => "required|string|email|max:255|unique:users,email,".$id, //El email sera unico, pero puede haber una excepción que el email coincide con el email del id actual                        
            'image'   => "mimes:jpg,jpeg,png,gif"
        ]);        
        
        /* Actualizamos usuario */
        $usuarioActualizado          = App\User::findOrFail($id);
        $usuarioActualizado->name    = $request->name;
        $usuarioActualizado->surname = $request->surname;
        $usuarioActualizado->nick    = $request->nick; 
        $usuarioActualizado->email   = $request->email; 
        /* Subimos imagen en base 64 */  
        $image  = $request->image;
        $base64 = $request->base64;
        if($image){                                                   //Solo si hay imagen
            $image_name = time()."_".$image->getClientOriginalName(); //Poner nombre unico
            
            /* Base 64 */
            $base_to_php = explode(',', $base64);
            $data        = base64_decode($base_to_php[1]);                        
            
            \Storage::disk('disk_users')->put($image_name, $data);     //Guardar en la carpeta storage/app/users
            $usuarioActualizado->image = $image_name;                 //Seteo el nombre de la imagen en el objeto                        
        }
        /* Fin Subimos imagen en base 64 */  
        $usuarioActualizado->update();    
        return redirect()->route('config.index')->with('mensaje', 'Usuario actualizado correctamente');
    }
    
    public function getImage($filename)
    {
        return \Storage::disk('disk_users')->download($filename);

        // $file = Storage::disk('disk_users')->get($filename);
        // return $file;
    }
}

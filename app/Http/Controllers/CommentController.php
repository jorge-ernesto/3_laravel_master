<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{    
    public function index(){
        //
    }
    
    public function create(){
        //
    }
    
    public function store(Request $request){
        /* Obtenemos todo el request */
        // return $request->all();                               

        /* Validacion del formulario */
        $validate = $this->validate($request, [
            'content' => 'required|string|max:255'
        ]);      
        
        /* Asignar nuevos valores al objeto de usuario */
        $comentarioNuevo           = new App\Comment;
        $comentarioNuevo->user_id  = Auth::user()->id;
        $comentarioNuevo->image_id = $request->image_id;
        $comentarioNuevo->content  = $request->content;    
        $comentarioNuevo->save();                        
        return redirect()->route('image.show', $request->image_id)->with('mensaje', 'Haz publicado tu comentario correctamente');
    }
    
    public function show($id){
        //
    }
    
    public function edit($id){
        //
    }
    
    public function update(Request $request, $id){
        //
    }
    
    public function destroy($id){
        //
    }
}

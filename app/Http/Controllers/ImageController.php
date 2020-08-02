<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 

    public function index(){
        $dataImages = \App\Image::orderBy('id', 'DESC')
                                ->paginate(5);
        return view('image.index', compact('dataImages'));
    }

    public function create(){
        return view('image.create');
    }

    public function store(Request $request){
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // return;        

        /* Recogemos datos del formulario */
        $id           = Auth::user()->id;
        $image        = $request->file('image');
        $description  = $request->input('description');

        /* Validacion del formulario */
        $validate = $this->validate($request, [
            'image'       => 'required|mimes:jpg,jpeg,png,gif',
            'description' => 'required|string|max:255'
        ]);

        /* Asignar nuevos valores al objeto de usuario */
        $user              = New \App\Image;
        $user->user_id     = $id;
        $user->description = $description;

        /* Subimos imagen */
        $image = $request->file('image');
        if($image){ //Solo si hay imagen
            $image_path = time()."_".$image->getClientOriginalName(); //Poner nombre unico
            Storage::disk('disk_images')->put($image_path, \File::get($image)); //Guardar en la carpeta storage/app/users
            $user->image_path = $image_path; //Seteo el nombre de la imagen en el objeto
        }

        $user->save();
        
        return redirect()->route('image.index')
                         ->with('mensaje', 'Imagen subida correctamente');
    }

    public function getImage($filename){       
        return Storage::disk('disk_images')->download($filename);
    }

    public function show($id){
        $image = App\Image::findOrFail($id);
        return view('image.detail', compact('image'));
    }
}

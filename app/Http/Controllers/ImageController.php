<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index()
    {
        $dataImagen = App\Image::orderBy('id', 'DESC')
                                ->paginate(5);
        return view('image.index', compact('dataImagen'));
    }

    public function create()
    {
        return view('image.create');
    }

    public function store(Request $request)
    {        
        /* Obtenemos todo el request */
        //return $request->all();                               

        /* Validamos datos */
        $validate = $this->validate($request, [
            'image'       => 'required|mimes:jpg,jpeg,png,gif',
            'description' => 'required|string|max:255'
        ]);        

        /* Guardamos imagen */
        $imagenNueva              = new App\Image;
        $imagenNueva->user_id     = Auth::user()->id; 
        /* Subimos imagen */
        $image = $request->image;      
        if($image){                                                              //Solo si hay imagen
            $image_name = time()."_".$image->getClientOriginalName();            //Poner nombre unico
            \Storage::disk('disk_images')->put($image_name, \File::get($image)); //Guardar en la carpeta storage/app/users
            $imagenNueva->image = $image_name;                                   //Seteo el nombre de la imagen en el objeto
        }
        /* Fin Subimos imagen */
        $imagenNueva->description = $request->description;
        $imagenNueva->save();        
        return redirect()->route('image.index')->with('mensaje', 'Imagen subida correctamente');
    }    

    public function show($id)
    {
        $dataComment = App\Comment::where('image_id', '=', $id)
                                    ->orderBy('id', 'DESC')
                                    ->paginate(20);
        $image = App\Image::findOrFail($id);
        return view('image.show', compact('dataComment', 'image'));
    }
    
    public function getImage($filename)
    {       
        return \Storage::disk('disk_images')->download($filename);
        
        // $file = Storage::disk('disk_images')->get($filename);
        // return $file;
    }
}

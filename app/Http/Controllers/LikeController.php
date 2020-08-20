<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like($image_id){        
        $user_id    = Auth::user()->id;        
        $isset_like = DB::select("SELECT * FROM likes WHERE user_id = $user_id AND image_id = $image_id"); //Verifica si like existe
        // return $isset_like;
        // return response()->json([
        //     'message' => $isset_like
        // ]);        
        
        if($isset_like){
            return back()->with('mensaje', 'Ya le diste like');
        }else{
            $likeNuevo           = new App\Like;
            $likeNuevo->user_id  = $user_id; 
            $likeNuevo->image_id = $image_id;
            $likeNuevo->save();   
            return back()->with('mensaje', 'Te gusta esta imagen!');
        }                        
    }

    public function dislike($image_id){
        $user_id    = Auth::user()->id;        
        $isset_like = DB::select("SELECT * FROM likes WHERE user_id = $user_id AND image_id = $image_id"); //Verifica si like existe       
        
        if($isset_like){
            DB::delete("DELETE FROM likes WHERE user_id = $user_id AND image_id = $image_id");
            return back()->with('mensaje', 'Like eliminado');
        }else{
            return back()->with('mensaje', 'Problema al eliminar like');
        }
        
    }
}

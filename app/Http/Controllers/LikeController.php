<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id)
    {        
        $user_id    = Auth::user()->id;        
        $isset_like = App\Like::where('image_id', '=', $image_id)
                                ->where('user_id', '=', $user_id)
                                ->first(); //LIMIT 1, first si no hay data no trae nada, get trae aunque no tenga data un array vacio [], tambien se pudo recurrir a un count() pero trae la cantidad
        //error_log(json_encode($isset_like));
        
        if($isset_like){            
            return response()->json([
                'message' => 'Ya le diste like'
            ]);   
        }else{
            $likeNuevo           = new App\Like;
            $likeNuevo->user_id  = $user_id; 
            $likeNuevo->image_id = $image_id;
            $likeNuevo->save();   
                        
            $cantidad_likes = App\Like::where('image_id', '=', $image_id)
                                        ->count();
            
            return response()->json([
                'like' => $likeNuevo,
                'message' => 'Te gusta esta imagen',
                'cantidad_likes' => $cantidad_likes
            ]);
        }                        
    }

    public function dislike($image_id)
    {
        $user_id    = Auth::user()->id;        
        $isset_like = App\Like::where('image_id', '=', $image_id)
                                ->where('user_id', '=', $user_id)
                                ->first(); //LIMIT 1, first si no hay data no trae nada, get trae aunque no tenga data un array vacio [], tambien se pudo recurrir a un count() pero trae la cantidad
        //error_log(json_encode($isset_like));
        
        if(!$isset_like){            
            return response()->json([
                'message' => 'Problema al eliminar like'
            ]);
        }else{                                    
            $isset_like->delete();
            $cantidad_likes = App\Like::where('image_id', '=', $image_id)
                                        ->count();
            
            return response()->json([
                'message' => 'Like eliminado',
                'cantidad_likes' => $cantidad_likes
            ]);
        }
        
    }
}

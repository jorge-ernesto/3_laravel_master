<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use Illuminate\Support\Facades\DB;

class PruebasController extends Controller
{
    public function image(Request $request)
    {
        $dataImage  = App\Image::all();
        $dataImage2 = DB::select('select * from images');
        $dataImage3 = DB::table('images')
                        ->get();

        foreach($dataImage as $key=>$image){    
            echo "<h1>{$image->id}         </h1>";
            echo "<p> {$image->user->name} {$image->user->surname}</p>";
            echo "<p> {$image->image_path} </p>";
            echo "<p> {$image->description}</p>";
            echo "<p> {$image->created_at} </p>";
            echo "<p> {$image->updated_at} </p>";

            if(count($image->comments) >= 1):
                foreach($image->comments as $key=>$comment):
                    echo "<h3>{$comment->content}          </h3>";
                    echo "<p> {$comment->created_at}       </p>";
                    echo "<p> {$comment->user->name}       </p>";
                    echo "<p> {$comment->image->image_path}</p>";
                endforeach;
            endif;
            echo "<hr>";
        }
    }    
}

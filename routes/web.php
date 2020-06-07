<?php

use Illuminate\Support\Facades\Route;

use App\Image;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Pruebas */
Route::get('/test', function(){
    /* Images */
    $dataImage  = App\Image::all();
    $dataImage  = App\Image::paginate(10);
    $dataImage2 = DB::select('select * from images');
    $dataImage3 = DB::table('images')
                    ->get();

    foreach($dataImage as $key=>$image):        
        echo "<h3>{$image->id}         </h3>";
        echo "<p> {$image->user->name} </p>";
        echo "<p> {$image->image_path} </p>";
        echo "<p> {$image->description}</p>";
        echo "<p> {$image->created_at} </p>";
        echo "<p> {$image->updated_at} </p>";
        echo "<hr>";
    endforeach;
    /* Fin Images */
});

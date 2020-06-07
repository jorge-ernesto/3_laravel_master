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

/* Ruta por defecto */
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Pruebas */
Route::get('/test', function(){
    /* Images */
    $dataImage  = App\Image::all();
    $dataImage  = App\Image::paginate(10);
    $dataImage2 = DB::select('select * from images');
    $dataImage3 = DB::table('images')
                    ->get();

    foreach($dataImage as $key=>$image):        
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
    endforeach;
    /* Fin Images */
});

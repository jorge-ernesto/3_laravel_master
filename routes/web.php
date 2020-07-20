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
    $auth = \Auth::user();

    if( isset($auth) ){
        return view('home');
    }else{
        return view('auth.login');
    }
});

/* Rutas */
//User
Route::get('/config', 'UserController@config')->name('config.index');
Route::post('/config', 'UserController@update')->name('config.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar'); //Trae imagen

//Image
Route::get('/image', 'ImageController@index')->name('image.index');
Route::get('/image/create', 'ImageController@create')->name('image.create');
Route::post('/image', 'ImageController@store')->name('image.store');
Route::get('/image/view/{filename}', 'ImageController@getImage')->name('image.view'); //Trae imagen

/* Rutas de la autenticación */
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Ruta para pruebas */
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

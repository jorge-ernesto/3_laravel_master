<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

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

//Ruta por defecto
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    $auth = Auth::user();

    if(!empty($auth)){
        //return view('home');
        return redirect('/image');
    }else{
        return view('auth.login');
    }
});

//RUTAS DE LA APLICACION
    //Rutas de prueba
    Route::get("/pruebas/image", "PruebasController@image");    

    //Rutas de usuarios
    Route::get('/config'                , 'UserController@config')  ->name('config.index');
    Route::put('/user/{user}'           , 'UserController@update')  ->name('user.update');
    Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

    //Rutas de imagenes
    Route::get('/image'                , 'ImageController@index')   ->name('image.index');
    Route::get('/image/create'         , 'ImageController@create')  ->name('image.create');
    Route::post('/image'               , 'ImageController@store')   ->name('image.store');
    Route::get('/image/{image}'        , 'ImageController@show')    ->name('image.show');
    Route::get('/image/view/{filename}', 'ImageController@getImage')->name('image.view');

    //Rutas de comentarios
    Route::post('/comment'            , 'CommentController@store')  ->name('comment.store');
    Route::delete('/comment/{comment}', 'CommentController@destroy')->name('comment.destroy');

    //Rutas de likes
    Route::get('/like/like/{image_id}'   , 'LikeController@like')   ->name('like.like');
    Route::get('/like/dislike/{image_id}', 'LikeController@dislike')->name('like.dislike');

    //Rutas de autenticación
    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

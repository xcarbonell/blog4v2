<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Auth;
use App\Post;


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

/*Route::get('/', function () {
    return view('welcome');
});*/


//Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/', [HomeController::class, 'index'])->name('home');

//Route::get('/about', [AboutController::class, 'index']);

Auth::routes();

//  ******  RUTES DELS USUARIS    ******

//vista per editar un post
Route::get('user/{id}/edit', 'UserController@edit')->name('user.edit');

//editar el perfil de l'usuari
Route::put('user/{id}/update', 'UserController@update')->name('user.update');

//veure tots els usuaris per l'admin
Route::get('user/showAll', 'UserController@showAll')->name('user.showAll')->middleware('admin');

//seleccionar l'usuari a esborrar per l'admin
Route::get('user/{id}/destroy', 'UserController@destroy')->name('user.destroy')->middleware('admin');

//vista per crear un usuari per l'admin
Route::get('user/create', 'UserController@create')->name('user.create')->middleware('admin');

//crear un usuari per l'admin
Route::post('user/store', 'UserController@store')->name('user.store')->middleware('admin');

//  ******  RUTES DELS POSTS    ******

//veure els seus posts
Route::get('posts', 'PostController@index')->name('posts');

//veure un post en particular amb els comentaris
Route::get('posts/{id}/show', 'PostController@show')->name('posts.show');

//veure tots els posts
Route::get('posts/showAll', 'PostController@showAll')->name('posts.showAll');

//vista per editar un post
Route::get('posts/{id}/edit', 'PostController@edit')->name('posts.edit');

//editar un post
Route::put('posts/{id}/update', 'PostController@update')->name('posts.update');

//vista per crear un post
Route::get('posts/create', 'PostController@create')->name('posts.create');

//crear un post
Route::post('posts/store', 'PostController@store')->name('posts.store');

//esborrar un post
Route::get('posts/{id}/destroy', 'PostController@destroy')->name('posts.destroy');

/*
Route::get('posts/{post?}', function ($id = null) {
    if ($id == null) {
        return Post::all();
    }
    $post = Post::findOrFail($id);
    return $post;
})->where('post', '[0-9]+');


Route::put('post/{id}', function ($id) {
    //
})->middleware('auth', 'role:admin');

*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return "admin";
    })->name('admin.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

<?php

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
    return redirect('login');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('produit', 'ProduitController');


Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index');
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::resource('/users', 'UsersController');
    Route::resource('/permissions', 'PermissionsController', ['except' => 'destroy']);
    Route::resource('/roles', 'RolesController');
//    Route::resource('/posts', 'PostController');
});


//->middleware('role:superadministrateur|gestionnaire|medecin|infirmier|pharmacien|logistique|caisse|secretaire|qualite')

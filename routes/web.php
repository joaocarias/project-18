<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    /* Empresa */
  Route::get('/empresas', 'EmpresaController@index')->name('empresa');
  Route::get('/empresas/editar/{id}', 'EmpresaController@edit')->name('editar_empresa');
  Route::put('/empresas/update/{id}', 'EmpresaController@update')->name('update_empresa');
});

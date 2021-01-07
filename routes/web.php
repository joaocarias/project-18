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

    /* Tipo Profissional */
  Route::get('/tipos_profissionais', 'TipoProfissionalController@index')->name('tipo_profissional'); 
  Route::get('/tipos_profissionais/novo', 'TipoProfissionalController@create')->name('novo_tipo_profissional');
  Route::get('/tipos_profissionais/editar/{id}', 'TipoProfissionalController@edit')->name('editar_tipo_profissional');
  Route::post('/tipos_profissionais/store', 'TipoProfissionalController@store')->name('cadastrar_tipo_profissional');
  Route::get('/tipos_profissionais/excluir/{id}', 'TipoProfissionalController@destroy')->name('excluir_tipo_profissional');
  Route::put('/tipos_profissionais/update/{id}', 'TipoProfissionalController@update')->name('update_tipo_profissional');
});

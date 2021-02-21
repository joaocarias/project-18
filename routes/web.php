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

  /* Profissionais */
  Route::get('/profissionais', 'ProfissionalController@index')->name('profissionais');
  Route::get('/profissionais/novo', 'ProfissionalController@create')->name('novo_profissional');
  Route::post('/profissionais/store', 'ProfissionalController@store')->name('cadastrar_profissional');
  Route::get('/profissionais/exibir/{id}', 'ProfissionalController@show')->name('exibir_profissional');
  Route::get('/profissionais/editar/{id}', 'ProfissionalController@edit')->name('editar_profissional');
  Route::put('/profissionais/update/{id}', 'ProfissionalController@update')->name('update_profissional');
  Route::get('/profissionais/excluir/{id}', 'ProfissionalController@destroy')->name('excluir_profissional');
  Route::get('/profissionais/resentarsenha/{id}', 'ProfissionalController@resetPassword')->name('resetar_senha_profissional');
  Route::get('/profissionais/criarusuario/{id}', 'ProfissionalController@createUser')->name('criar_usuario_profissional');
  Route::post('/profissionais/inserirregra', 'ProfissionalController@inserirregrauser')->name('inserir_regra_usuario');
  Route::get('/profissionais/removerregrauser', 'ProfissionalController@removerregrauser')->name('remover_regra_user');

  /* User */
  Route::get('/usuarios/atualizarsenha', 'Auth\\UserController@atualizarSenha')->name('atualizar_senha');
  Route::put('/usuarios/updatepassword/{id}', 'Auth\\UserController@updatePassword')->name('update_password');
  Route::get('/usuarios', 'Auth\\UserController@index')->name('usuarios');

  /* Paciente */
  Route::get('/pacientes', 'PacienteController@index')->name('pacientes');
  Route::get('/pacientes/exibir/{id}', 'PacienteController@show')->name('exibir_paciente');
  Route::get('/pacientes/novo', 'PacienteController@create')->name('novo_paciente');
  Route::post('/pacientes/store', 'PacienteController@store')->name('cadastrar_paciente');
  Route::get('/pacientes/excluir/{id}', 'PacienteController@destroy')->name('excluir_paciente');
  Route::get('/pacientes/editar/{id}', 'PacienteController@edit')->name('editar_paciente');
  Route::put('/pacientes/update/{id}', 'PacienteController@update')->name('update_paciente');

  /* Agendas */
  Route::get('/agendas', 'AgendaController@index')->name('agendas');
  Route::get('/agendas/liberar', 'AgendaController@store')->name('liberar_agenda');
  Route::get('/agendas/excluir/{id}', 'AgendaController@destroy')->name('excluir_agenda');
  Route::get('/agendas/agendar/{pacienteId}', 'AgendaController@agendar')->name('agendar_agenda');
  Route::put('/agendas/update/{id}', 'AgendaController@update')->name('update_agenda');
  Route::put('/agendas/desmarcar', 'AgendaController@desmarcar')->name('desmarcar_agenda');

   /* Fornecedor */
   Route::get('/fornecedores', 'FornecedorController@index')->name('fornecedores');
   Route::get('/fornecedores/exibir/{id}', 'FornecedorController@show')->name('exibir_fornecedor');
   Route::get('/fornecedores/novo', 'FornecedorController@create')->name('novo_fornecedor');
   Route::post('/fornecedores/store', 'FornecedorController@store')->name('cadastrar_fornecedor');
   Route::get('/fornecedores/excluir/{id}', 'FornecedorController@destroy')->name('excluir_fornecedor');
   Route::get('/fornecedores/editar/{id}', 'FornecedorController@edit')->name('editar_fornecedor');
   Route::put('/fornecedores/update/{id}', 'FornecedorController@update')->name('update_fornecedor');
   
  /* Produto Fornecedor */
  Route::post('/produtofornecedor/store', 'ProdutoFornecedorController@store')->name('cadastrar_produto_fornecedor');
  Route::put('/produtofornecedor/uptade', 'ProdutoFornecedorController@update')->name('update_produto_fornecedor');

  
});

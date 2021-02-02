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

Auth::routes();



Route::get('/', 'UsuariosController@index');
//Route::get('/home', 'HomeController@index');

Route::any('/dashboard', 'DashboardController@index');

Route::get('usuarios', 'UsuariosController@index');
Route::get('usuarios/novo', 'UsuariosController@novo');
Route::post('usuarios/novo', 'UsuariosController@insert');
Route::get('usuarios/editar/{id}', 'UsuariosController@editar');
Route::post('usuarios/editar', 'UsuariosController@update');
Route::get('usuarios/remove/{id}', 'UsuariosController@remove')->where('id','[0-9]+');


Route::get('cadastros/produtos', 'ProdutosController@index');
Route::get('cadastros/produtos/novo', 'ProdutosController@novo');
Route::post('cadastros/produtos/novo', 'ProdutosController@insert');
Route::get('cadastros/produtos/editar/{id}', 'ProdutosController@editar');
Route::post('cadastros/produtos/editar', 'ProdutosController@update');
Route::get('cadastros/produtos/remove/{id}', 'ProdutosController@remove')->where('id','[0-9]+');


Route::get('cadastros/tipodespesa', 'TipodespesasController@index');
Route::get('cadastros/tipodespesa/novo', 'TipodespesasController@novo');
Route::post('cadastros/tipodespesa/novo', 'TipodespesasController@insert');
Route::get('cadastros/tipodespesa/editar/{id}', 'TipodespesasController@editar')->where('id','[0-9]+');
Route::post('cadastros/tipodespesa/editar', 'TipodespesasController@update');
Route::get('cadastros/tipodespesa/remove/{id}', 'TipodespesasController@remove')->where('id','[0-9]+');


Route::get('cadastros/empresas', 'EmpresasController@index');
Route::get('cadastros/empresas/novo', 'EmpresasController@novo');
Route::post('cadastros/empresas/novo', 'EmpresasController@insert');
Route::get('cadastros/empresas/editar/{id}', 'EmpresasController@editar')->where('id','[0-9]+');
Route::post('cadastros/empresas/editar', 'EmpresasController@update');
Route::get('cadastros/empresas/remove/{id}', 'EmpresasController@remove')->where('id','[0-9]+');


Route::get('cadastros/departamentos', 'DepartamentosController@index');
Route::get('cadastros/departamentos/novo', 'DepartamentosController@novo');
Route::post('cadastros/departamentos/novo', 'DepartamentosController@insert');
Route::get('cadastros/departamentos/editar/{id}', 'DepartamentosController@editar')->where('id','[0-9]+');
Route::post('cadastros/departamentos/editar', 'DepartamentosController@update');
Route::get('cadastros/departamentos/remove/{id}', 'DepartamentosController@remove')->where('id','[0-9]+');


Route::get('cadastros/subdepartamentos', 'SubdepartamentosController@index');
Route::get('cadastros/subdepartamentos/novo', 'SubdepartamentosController@novo');
Route::post('cadastros/subdepartamentos/novo', 'SubdepartamentosController@insert');
Route::get('cadastros/subdepartamentos/editar/{id}', 'SubdepartamentosController@editar')->where('id','[0-9]+');
Route::post('cadastros/subdepartamentos/editar', 'SubdepartamentosController@update');
Route::get('cadastros/subdepartamentos/remove/{id}', 'SubdepartamentosController@remove')->where('id','[0-9]+');

Route::get('cadastros/categorias', 'CategoriasController@index');
Route::get('cadastros/categorias/novo', 'CategoriasController@novo');
Route::post('cadastros/categorias/novo', 'CategoriasController@insert');
Route::get('cadastros/categorias/editar/{id}', 'CategoriasController@editar')->where('id','[0-9]+');
Route::post('cadastros/categorias/editar', 'CategoriasController@update');
Route::get('cadastros/categorias/remove/{id}', 'CategoriasController@remove')->where('id','[0-9]+');



Route::get('loja', 'LojaController@index');
Route::get('/loja/novo', 'LojaController@novo');
Route::post('/loja/novo', 'LojaController@insert');
Route::get('/loja/remove/{id}', 'LojaController@remove')->where('id','[0-9]+');
Route::get('/loja/editar/{id}', 'LojaController@editar')->where('id','[0-9]+');
Route::post('/loja/editar', 'LojaController@update');
Route::post('/loja/saveall', 'LojaController@saveall');


Route::get('/compras', 'OpenController@compras');

Route::get('/galeria/{image}', 'OpenController@getimage');
Route::get('/capa/{image}', 'OpenController@getcapa');
Route::get('/icone/{image}', 'OpenController@geticone');


//Conf API
Route::get('/pics/getbyitem/{id}', 'OpenController@getbyitem')->where('id','[0-9]+');
Route::get('/pics/getbyname/{image}', 'OpenController@getbyname');
Route::get('/pics/getbyid/{image}', 'OpenController@getbyid');

Route::get('/v1/frete/{token}/{cep}', 'ApiController@getfrete');


Route::post('v1/paypal/{id}', 'PayPalController@payWithpaypal')->where('id','[0-9]+');
Route::get('/v1/paypal/status/{id}', 'PayPalController@getPaymentStatus');
Route::any('/v1/paywithpaypal/{id}', 'PayPalController@payWithpaypal')->where('id','[0-9]+');





<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AmostrasController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\OrdemController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\OrcaController;
use App\Http\Controllers\OpcoesController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\DashboardCrontoller;
use App\Http\Controllers\NematoidesController;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExemploMailable;


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

Route::get('/usuario', [UsuarioController::class, 'index']);
Route::get('/login2', [UsuarioController::class, 'paginalogar'])->name('login');
Route::get('/criarconta', [UsuarioController::class, 'criarConta'])->name('criarconta');
Route::get('/', [UsuarioController::class, 'home2'])->name('home2');


Route::post('/meusEventos',[EventoController::class, 'store'])->middleware('auth');
Route::get('/meusEventos', [EventoController::class, 'index'])->middleware('auth')->name('meusEventos');
Route::get('/ListEventos', [EventoController::class, 'listEventos'])->middleware('auth')->name('listEventos');



Route::get('/modelos', [ModeloController::class, 'index'])->middleware('auth')->name('modelos');
Route::get('/remessas', [ModeloController::class, 'indexRemessa'])->middleware('auth')->name('remessas');



Route::get('/amostras', [AmostrasController::class, 'index'])->middleware('auth')->name('listaAmostra');
Route::get('/amostrasCadastro', [AmostrasController::class, 'indexCadastro'])->middleware('auth')->name('amostraCreate');
Route::get('amostras/{id}/cadastro', [AmostrasController::class, 'indexCadastro'])->middleware('auth')->name('amostraCadastro');
Route::post('amostras/cadastro', [AmostrasController::class, 'store'])->middleware('auth')->name('amostraPost');
Route::put('amostras/{id}/cadastro', [AmostrasController::class, 'update'])->middleware('auth')->name('amostraPut');


Route::get('/nematoides', [NematoidesController::class, 'index'])->middleware('auth')->name('namatoides');
Route::get('/nematoidesCadastro', [NematoidesController::class, 'indexCadastro'])->middleware('auth')->name('nemaCreate');
Route::get('nematoides/{id}/cadastro', [NematoidesController::class, 'indexCadastro'])->middleware('auth')->name('nemaCadastro');
Route::post('nematoides/cadastro', [NematoidesController::class, 'store'])->middleware('auth')->name('nemaPost');
Route::put('nematoides/{id}/cadastro', [NematoidesController::class, 'update'])->middleware('auth')->name('nemaPut');



Route::get('/ordem', [OrdemController::class, 'index'])->middleware('auth')->name('ordem');
Route::get('/ordemCadastro', [OrdemController::class, 'indexCadastro'])->middleware('auth')->name('ordemCreate');
Route::get('ordem/{id}/cadastro', [OrdemController::class, 'indexCadastro'])->middleware('auth')->name('ordemCadastro');
Route::post('ordem/cadastro', [OrdemController::class, 'store'])->middleware('auth')->name('ordemPost');
Route::put('ordem/{id}/cadastro', [OrdemController::class, 'update'])->middleware('auth')->name('ordemPut');
Route::post('ordem/import/{id}', [OrdemController::class, 'import'])->middleware('auth')->name('imortAmostras');
Route::get('ordemAmostra/{id}', [OrdemController::class, 'indexCadastroAmostraOrdem'])->middleware('auth')->name('ordemAmostras');

// Pessoas 
Route::get('/pessoa', [PessoaController::class, 'index'])->middleware('auth')->name('pessoa');
Route::get('pessoa/{id}/cadastro', [PessoaController::class, 'indexCadastro'])->middleware('auth')->name('pessoaCadastro');
Route::get('pessoa/cadastro', [PessoaController::class, 'indexCadastro'])->middleware('auth')->name('pessoaCreate');
Route::post('pessoa/cadastro', [PessoaController::class, 'store'])->middleware('auth')->name('pessoaPost');
Route::put('pessoa/{id}/cadastro', [PessoaController::class, 'update'])->middleware('auth')->name('pessoaPut');

// Empresa
Route::get('/empresa', [EmpresasController::class, 'index'])->middleware('auth')->name('empresa');
Route::get('/empresaCadastro', [EmpresasController::class, 'indexCadastro'])->middleware('auth')->name('empresaCreate');
Route::get('empresa/{id}/cadastro', [EmpresasController::class, 'indexCadastro'])->middleware('auth')->name('empresaCadastro');
Route::post('empresa/cadastro', [EmpresasController::class, 'store'])->middleware('auth')->name('empresaPost');
Route::put('empresa/{id}/cadastro', [EmpresasController::class, 'update'])->middleware('auth')->name('empresaPut');
// Opções
Route::get('/opcoes', [OpcoesController::class, 'index'])->middleware('auth')->name('opcoes');

Route::match(['post', 'put'], '/servicoUpdate', [ServicosController::class, 'update'])->middleware('auth')->name('servicoUpdate');
Route::post('/servicoStore', [ServicosController::class, 'store'])->middleware('auth')->name('servicoStore');

Route::get('/servicoP/{nome}', [ServicosController::class,'index'])->middleware('auth')->name('servicoGet');


//dashboard
Route::get('/dasboard', [DashboardCrontoller::class,'index'])->middleware('auth')->name('dashboard');


Route::get('/orcamento', [OrcaController::class, 'index'])->middleware('auth')->name('orca');


Route::get('/testeapi', [UsuarioController::class, 'teste']);




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/testar-smtp', function () {
    try {
        Mail::to('eng.c.jroberto@gmail.com')->send(new ExemploMailable());
        return 'E-mail de teste enviado com sucesso!';
    } catch (\Exception $e) {
        return 'Erro ao enviar e-mail de teste: ' . $e->getMessage();
    }
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImagemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/imagens', [ImagemController::class, 'index']);
Route::get('/imagens/{id}', [ImagemController::class, 'show']);
Route::get('/imagens/protocolo/{protocolo}', [ImagemController::class, 'buscarPorProtocolo']);
Route::get('/imagens/localizacao/{localizacao}', [ImagemController::class, 'buscarPorLocalizacao']);
Route::post('/imagens', [ImagemController::class, 'store']);
Route::post('/imagens/upload-multiplo', [ImagemController::class, 'uploadMultiplo']);
Route::delete('/imagens/{id}', [ImagemController::class, 'destroy']);
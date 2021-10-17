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

Route::resource('/', '\App\Http\Controllers\FutebolController');
Route::prefix('/')->group(function(){
    
	#ROTAS ADM HORUS NATIVO
	#Route::get('\App\Http\Controllers\FutebolController@login');
	Route::get('\App\Http\Controllers\FutebolController@index');

	#GET
		#GRID DO(S) REGISTRO(S)
		Route::get('grid/atletas', ['uses' => '\App\Http\Controllers\AtletaController@grid']);
		Route::get('grid/jogos', ['uses' => '\App\Http\Controllers\JogoController@grid']);
		Route::get('grid/sorteios', ['uses' => '\App\Http\Controllers\FutebolController@grid']);

		#MOSTRAR DETALHE DO REGITRO
		Route::get('dtl/atleta/{id}', ['uses' => '\App\Http\Controllers\AtletaController@show']);
		Route::get('dtl/jogo/{id}', ['uses' => '\App\Http\Controllers\JogoController@show']);
		Route::get('dtlc/atletas/{ids}', ['uses' => '\App\Http\Controllers\AtletaController@showIn']);
		Route::get('dtl/jogo-escalacao/{idJogo}', ['uses' => '\App\Http\Controllers\TimeController@showEscalacao']);
		Route::get('dtl/atletas', ['uses' => '\App\Http\Controllers\AtletaController@showAll']);
		Route::get('dtl/jogos', ['uses' => '\App\Http\Controllers\JogoController@showAll']);

		#EXECUTAR SORTEIO
		Route::get('exec/sorteio/{id_jogo}/{qtde_jogador}/{tipo_sorteio}', ['uses' => '\App\Http\Controllers\FutebolController@executarSorteio']);

	#POST
		#ADD DADO(S)
		Route::post('add/atletas', ['uses' => '\App\Http\Controllers\AtletaController@store']);
		Route::post('add/jogos', ['uses' => '\App\Http\Controllers\JogoController@store']);
		Route::post('add/escalacao', ['uses' => '\App\Http\Controllers\TimeController@store']);

		#ALT DADO(S)
		Route::post('alt/atleta/{id}', ['uses' => '\App\Http\Controllers\AtletaController@update']);
		Route::post('alt/jogo/{id}', ['uses' => '\App\Http\Controllers\JogoController@update']);

	#DELETE
		#RMV DADO(S)
		Route::delete('rmv/atletas/{id}', ['uses' => '\App\Http\Controllers\AtletaController@destroy']);
		Route::delete('rmv/jogos/{id}', ['uses' => '\App\Http\Controllers\JogoController@destroy']);
		Route::delete('rmv/escalacao-jogo/{idJogo}', ['uses' => '\App\Http\Controllers\TimeController@destroy']);

});

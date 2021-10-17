<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jogo;
use App\Atleta;
use App\ApFuncao;

@session_start();
$_SESSION['page'] = "";

class JogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grid()
    {
        $_SESSION['page'] = "jogos";
        $jogos = Jogo::all();
        $atletas = Atleta::all();
        $apFuncao = new ApFuncao();
        return view('contents.grid-jogo', [ 
            'page' => 'jogos',
            'titulo' => 'Jogos',
            'jogos' => $jogos,
            'atletas' => $atletas,
            'apFuncao' => $apFuncao,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jogos = new Jogo();
        $jogos->descricao = $request->input('descricao');
        $jogos->dt_jogo = $request->input('dt_jogo');
        $jogos->status = $request->input('status');
        $jogos->jogadores = $request->input('jogadores');
        $jogos->resultado = $request->input('resultado');
        $jogos->save();
        return "Jogo/Partida Cadastrada!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jogo = Jogo::find($id);
        if(isset($jogo))
            return json_encode($jogo);
        return response('Jogo/Partida não encontrado!', 404);
    }
    /**
     * Display all datas.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $jogos = Jogo::all();
        if(isset($jogos))
            return json_encode($jogos);
        return response('Registro não encontrado!', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jogos = Jogo::find($id);
        if(isset($jogos))
            $jogos->descricao = $request->input('descricao');
            $jogos->dt_jogo = $request->input('dt_jogo');
            $jogos->status = $request->input('status');
            $jogos->jogadores = $request->input('jogadores');
            $jogos->resultado = $request->input('resultado');
            $jogos->save();
            return json_encode($jogos);
        return response('Jogo/Partida não encontrado!', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jogos = Jogo::find($id);
        if(isset($jogos))
            $jogos->delete();
            return response('OK', 200);
        return response('Jogo/Partida não encontrado!', 404);
    }
}

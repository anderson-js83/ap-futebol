<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jogo;
use App\Atleta;
use App\Time;
use App\ApFuncao;

@session_start();
$_SESSION['page'] = "";

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grid()
    {
        $_SESSION['page'] = "times";
        $jogos = Jogo::all();
        $atletas = Atleta::all();
        $apFuncao = new ApFuncao();
        return view('contents.grid-sorteio', [ 
            'page' => 'sorteios',
            'titulo' => 'Sorteios',
            'jogos' => $jogos,
            'atletas' => $atletas,
            'apFuncao' => $apFuncao,
        ]);
    }

    /**
     * Metodo responsavel em listar os times sorteados para o jogo
     */
    public function showEscalacao($idJogo)
    {
        $escalacao = Time::where('id_jogo', $idJogo)->get();
        $arTimes = array();
        foreach ($escalacao as $escalacao) {
            $atletas = Atleta::whereIn('id', (explode(',',$escalacao->jogadores)))->get();
            foreach ($atletas as $atleta) {
                $arTimes[] = ['time'=>$escalacao->time,'nome'=>$atleta->nome, 'sn_goleiro'=> $atleta->sn_goleiro];
            }
        }
        if(isset($arTimes))
            return json_encode($arTimes);
        return response('Escalacao não encontrada!', 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arTimes = explode('|', $request->times);
        $arLetra = ['','A','B','C','D','E','F','G','H','I','J'];
        foreach ($arTimes as $time) {
            if($time){
                $escalacao = explode(':', $time);
                $registros = new Time();
                $registros->id_jogo = $request->input('id_jogo');
                $registros->time = $arLetra[$escalacao[0]];
                $registros->jogadores = $escalacao[1];
                $registros->save();
            }
        }
        return "Participante Cadastrado!";
    }

    /**
     * Metodo para remover a escalacao de um jogo agendado
     */
    public function destroy($idJogo)
    {
        $jogos = Time::where('id_jogo', $idJogo)->delete();
        if(isset($jogos))
            return response('OK', 200);
        return response('Jogo/Partida não encontrado!', 404);
    }
}

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

class FutebolController extends Controller
{
    # Controle para apresentar tela inicial
	public function index()
	{
		$_SESSION['page'] = "home";

		#Jogos/Partidas Agendadas com Atletas Escalados:
		$arTimeEscalado = array();
		$timesEscalados = Time::groupBy('id_jogo')->get();
		foreach ($timesEscalados as $time) {
			$jogo = Jogo::where('id', $time->id_jogo)->get();
			$arTimeEscalado[] = ['dt_jogo'=>$jogo[0]->dt_jogo, 'descricao'=>$jogo[0]->descricao];
		}

        #Jogos Realizados:
        $jogos = Jogo::where('status', 'R')->get();

        #Atletas em Destaque:
        $atletas = Atleta::where('nivel_habilidade', 5)->get();

        #Goleiros Cadastrados:
        $goleiros = Atleta::where('sn_goleiro', 'S')->get();

		return view('contents.index', [
			'timeEscalados' => $arTimeEscalado,
			'jogosRealizado' => $jogos,
			'atletaDestaque' => $atletas,
			'goleiros' => $goleiros
		]);
	}

	/**
	 * Metodo responsavel em renderizar view GRID para os registros
	 */
	public function grid()
    {
        $_SESSION['page'] = "sorteios";
        $jogos = Jogo::where('status','A')->get();
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
     * Metodo responsavel em chamar a execucao do sorteio
     */
    public function executarSorteio($idJogo, $qtdeMaxJogador, $tipoSorteio)
    {
    	#return json_encode(['Teste...', $id_jogo, $qtde_jogador]);
    	return json_encode(ApFuncao::executarSorteio($idJogo, $qtdeMaxJogador, $tipoSorteio));
    	
    	$_SESSION['page'] = "sorteios";
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

}

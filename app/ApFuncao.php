<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jogo;
use App\Atleta;

@session_start();

class ApFuncao
{

    /**
     * Metodo estatico p/ realizar consulta sql customizada
     * @param  $tabela, $idCampo=NULL, $campoFiltro=NULL, $campoRetorno=NULL, $filtroCustom=NULL, $snExibeSql=NULL
     * @return Objeto ARRAY com resultado ou String sql consulta
     */
    public static function executeSql($tabela, $idCampo=NULL, $campoFiltro=NULL, $campoRetorno=NULL, $filtroCustom=NULL, $snExibeSql=NULL)
    {    
        $Filtro = '';
        $campoRetorno = (empty($campoRetorno))?' * ': $campoRetorno;
        
        if(!empty($idCampo) && !empty($campoFiltro)){
            $Filtro = " AND ".$idCampo." = '".$campoFiltro."' ";
        }
        
        if(!empty($filtroCustom)){
            $Filtro = $Filtro.$filtroCustom;
        }
        $sql="SELECT ".$campoRetorno." FROM ". $tabela ." WHERE ". $Filtro;
        
        if($snExibeSql)
        	dd($sql);

        return DB::select($sql);
    }

    /**
     * Metodo estatico p/ validar parametros e realizar o sorteio dos atletas/jogadores
     * @param  $idJogo, $qtdeMaxJogador, $tipoSorteio
     * @return Objeto Json com atributos de status, mensagem e resultado
     */
    public static function executarSorteio($idJogo, $qtdeMaxJogador, $tipoSorteio)
    {
        $jogo = Jogo::where('id',$idJogo)->get();
        if(isset($jogo)){

            #CONDICOES PARA BLOQUEIO DO SORTEIO
            $qtdeGoleiros = Atleta::whereIn('id', (explode(",",$jogo[0]->jogadores)))->where('sn_goleiro', 'S')->count(); # >0 ? true : false
            if($qtdeGoleiros<2)
                return ['status'=>false, 'mensagem'=>'Não possui a quantidade de Goleiros suficientes', 'resultado'=>NULL];

            $qtdeAtletas = Atleta::whereIn('id', (explode(",",$jogo[0]->jogadores)))->count(); # >1 ? true : false
            if($qtdeAtletas<2)
                return ['status'=>false, 'mensagem'=>'Não possui a quantidade de Jogadores suficientes!', 'resultado'=>NULL];

            $qtdeTimes = floor($qtdeAtletas/$qtdeMaxJogador); # >=2 ? true : false
            if($qtdeTimes<2)
                return ['status'=>false, 'mensagem'=>'Não possui a quantidade de Times suficientes para um jogo/partida!', 'resultado'=>NULL];

            if($qtdeTimes>$qtdeGoleiros)
                return ['status'=>false, 'mensagem'=>'Não possui a quantidade de Goleiros suficientes!', 'resultado'=>NULL];

            #Listar atletas/jogadores confirmados
            #Classificacao de goleiros e jogadores por nivel de habilidade
            $Atletas = Atleta::whereIn('id', (explode(",",$jogo[0]->jogadores)))->orderBy('sn_goleiro','desc')->orderBy('nivel_habilidade','desc')->get();
            $arGoleiros = array();
            $arJogadores = array();
            $arJogadoresNH = array();
            $arControle = array();
            foreach ($Atletas as $atleta) {
                if($atleta->sn_goleiro=='S'){
                    $arGoleiros[] = $atleta->id;
                    $arControle['goleiros'][] = $atleta->id;
                    continue;
                }
                $arJogadores[] = $atleta->id;
                $arJogadoresNH[$atleta->nivel_habilidade][] = $atleta->id;
            }

            $cnt = 0;
            $idGoleiro = null;
            $idJogador = null;
            $arTimes = array();
            #Classificacao para garantir cada time tenha um goleiro
            while(true){                
                if(($cnt<$qtdeTimes) && (count($arGoleiros)>0)){
                    $idGoleiro = array_rand($arGoleiros);
                    $arTimes[$cnt][] = $arGoleiros[$idGoleiro];
                    unset($arGoleiros[$idGoleiro]);
                    $cnt++;
                    continue;
                }
                break;
            }

            #Sorteio simples
            if($tipoSorteio==1){

                $cnt = 0;
                while(true){
                    #controle para bloqueio do looping
                    if($cnt>=$qtdeTimes){ break; }
                    #regra para listar e sortear os jogadores para os times
                    if(isset($arTimes[$cnt])){
                        if($qtdeMaxJogador > (count($arTimes[$cnt]))){
                            if(count($arJogadores)){
                                $idJogador = array_rand($arJogadores);
                                $arTimes[$cnt][] = $arJogadores[$idJogador];
                                unset($arJogadores[$idJogador]);
                                continue;
                            }
                        }
                    }
                    $cnt++;
                }

            }
            
            #Sorteio por nivel de habilidade
            if($tipoSorteio==2){

                $arJogadores = $arJogadoresNH;
                $qtdeTimes--;
                $cnt = 0;
                while(true){  
                    if($cnt > $qtdeTimes){ 
                        $cnt=0;
                    }
                    if(count($arJogadores)){
                        #regra para listar e sortear os jogadores para os times
                        if(isset($arTimes[$cnt])){
                            if($qtdeMaxJogador > (count($arTimes[$cnt]))){
                                for($i=5; $i>0; $i--){
                                    if(isset($arJogadores[$i])){
                                        if(count($arJogadores[$i])){
                                            #echo "[". $qtdeMaxJogador .">=". count($arTimes[$cnt]) ."($cnt)]<br/>";
                                            $idJogador = array_rand($arJogadores[$i]);
                                            $arTimes[$cnt][] = $arJogadores[$i][$idJogador];
                                            unset($arJogadores[$i][$idJogador]);
                                            if(!count($arJogadores[$i])){
                                                unset($arJogadores[$i]);
                                            }
                                            break;
                                        }
                                    }
                                }
                                $cnt++;
                                continue;
                            }
                        }
                    }
                    break;
                }
                #Regra para gravar completar o ultimo time caso esteja incompleto
                if(isset($arGoleiros)){
                    if( ($qtdeMaxJogador > (count($arTimes[$qtdeTimes]))) && (count($arGoleiros)) ){
                        $arTimes[$qtdeTimes][] = $arGoleiros;
                    }
                }

            }

            #Bloqueio para garantir que exista dois times com escalacao completa
            if((count($arTimes[0])) != (count($arTimes[1])))
                return ['status'=>false, 'mensagem'=>'Não possui a quantidade de Jogadores suficientes para dois times!', 'resultado'=>NULL];

            #Bloqueio para garantir que exista um goleiro por time
            for($i=0; $i<(count($arTimes)); $i++){
                if(count(Atleta::whereIn('id', $arTimes[$i])->where('sn_goleiro','S')->get())>1)
                    return ['status'=>false, 'mensagem'=>'Não é permitido mais de um goleiro para o time!', 'resultado'=>NULL];
            }

            #Listando nomes do jogaderes para serem apresetado na escalacao
            $arAtletasEscalacao = array();
            for($i=0; $i<=(count($arTimes)); $i++){
                if(isset($arTimes[$i])){
                    if(count($arTimes[$i])){
                        $Atletas = Atleta::whereIn('id', $arTimes[$i])->get();
                        foreach ($Atletas as $atleta) {
                            $arAtletasEscalacao[$i][] = $atleta->nome;
                        }
                    }
                }
            }

            return ['status'=>true, 'mensagem'=>'Sorteio Realizado', 'resultado' => ['goleiro'=>$arGoleiros, 'jogador'=>$arJogadores, 'times'=>$arTimes, 'atletas' => $arAtletasEscalacao]];
            
        }
    }

}

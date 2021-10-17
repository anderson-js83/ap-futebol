@extends('main')
@section('title_app', "Futebol - App ($titulo)")
@section('pg_app', $page)
@section('contents_app')

	<div class="content c2">
        <div class="bloco">

        	<!-- Button trigger modal -->
			<button type="button" class="btn btn-success cp" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
				Add Novo Registro
			</button>

			<table class="table">
				<thead>
					<tr>
						<th scope="col">Id</th>
						<th scope="col">Decrição</th>
						<th scope="col">Data do Jogo</th>
						<th scope="col">Status</th>
						<th scope="col">Jogadores</th>
						<th scope="col">Resultado</th>
					</tr>
					</thead>
					<tbody>
					@foreach($jogos as $jogo)
						<tr id="ln{{ $jogo->id }}">
							<th scope="row">
								{{ $jogo->id }}:
								<button type="button" class="btn btn-danger btn-sm btn_action" id="btnRemover{{ $titulo }}" onClick="acaoRmv({{ $jogo->id }})">
							    	<ion-icon name="close-circle-outline"></ion-icon>
							    </button>
							    <button type="button" class="btn btn-info btn-sm btn_action" id="btnAtualizar{{ $titulo }}" onClick="listaFormAlt{{ $titulo }}({{ $jogo->id }})">
							    	<ion-icon name="create-outline"></ion-icon>
							    </button>
							    <?php $arEscalacao = $apFuncao::executeSql('times', null, null, 'count(id) qtde', " id_jogo in(". $jogo->id .") and deleted_at is null"); ?>
								@if($arEscalacao[0]->qtde>0)
									<button type="button" class="btn btn-warning btn-sm btn_action" onClick="exibirEscalacao({{ $jogo->id }})">
								    	<ion-icon name="timer-outline"></ion-icon>
								    </button>
								@endif
							</th>
							<td>{{ $jogo->descricao }}</td>
							<td>{{ $jogo->dt_jogo }}</td>
							<td>{{ $jogo->status }}</td>
							<td>
								<?php $arJogadores = $apFuncao::executeSql('atletas', null, null, 'count(id) qtde', " id in(". $jogo->jogadores .")"); ?>
								<ion-icon name="walk-outline"></ion-icon><b>o</b> {{ $arJogadores[0]->qtde }}
							</td>
							<td>{{ $jogo->resultado }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<!-- Modal -->
			<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
				<div class="modal-dialog modal-fullscreen">
					<div class="modal-content">
						<div class="modal-header">
						    <h5 class="modal-title h4" id="exampleModalFullscreenLabel">
						    	<ion-icon name="football-outline"></ion-icon> Cadastrar {{ $titulo }}
						    </h5>
						    <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
						</div>
						<div class="modal-body">

							<form>
								<input type="hidden" name="id" value="0">
								<fieldset>
									<legend>Cadastrar e Agendar Jogos/Partidas</legend>
									<div class="container-fluid">
								        <div class="row">
								        	
								        	<div class="col-1 col-sm-1"></div>
								          	<div class="col-4 col-sm-4">
								          		<div class="col-md-12 cp">
													<label class="form-label">Descrição</label>
													<input type="text" class="form-control" name="descricao">
												</div>
								            	<div  class="col-md-12 cp">
													<label class="form-label">Data/Hora da Partida</label>
													<input class="form-control" id="datepicker" name="dt_jogo">
												</div>
												<div class="col-md-12 cp">
													<label class="form-label">Status</label>
													<select class="form-select" name="status">
														<option value="A" selected>(A) Agendado</option>
												    	<option value="R">(R) Realizado</option>
												    	<option value="C">(C) Cancelado</option>
													</select>
												</div>
												<div class="col-md-12 cp">
													<label class="form-label">Resultado</label>
													<input type="text" class="form-control" name="resultado" value="--x--">
												</div>
								          	</div>

								          	<div class="col-7 col-sm-7">
								            	<h4>Confirmar Presença do(s) Atleta(s)</h4>
								            	<div id="chk-atletas">
									            	@foreach($atletas as $atleta)
										            	<div class="form-check">
															<input class="form-check-input" type="checkbox" name="atleta_presente" value="{{ $atleta->id }}">
															<label class="form-check-label">
															   {{ $atleta->nome }}
															</label>
														</div>
													@endforeach
												</div>
								          	</div>

								        </div>
								    </div>
								</fieldset>
							</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" id="btnFecharForm">Fechar</button>
							<button type="button" class="btn btn-success" id="btnSalvar{{ $titulo }}">Salvar</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="escalacaoAgendada"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">
						  		<ion-icon name="football-outline"></ion-icon> {{ $titulo }} - Gerar Times p/ Jogos Agendados e Atletas Confirmados
						  	</h5>
						  <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
						</div>
						<div class="modal-body">

							<form>
								<input type="hidden" name="id_jogo" value="0">
								<fieldset>
									<legend>Informações da Escalação</legend>
									<div class="container-fluid">
								    <div class="row">
								    	<div class="col-2 col-sm-2"></div>
								     	<div class="col-10 col-sm-10">
											<div class="row">
												<div class="col-sm-12">
													<div class="row">
														<div class="col-12 col-sm-12">
															<div id="mostrarEscalacao"></div>
														</div>
													</div>
												</div>
											</div>
								     	</div>
								    </div>
								  </div>
								</fieldset>
							</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" id="btnFecharEscalacao">Fechar</button>
							<button type="button" class="btn btn-warning" id="btnCancelarEscalacao">Cancelar Escalação</button>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>

@endsection
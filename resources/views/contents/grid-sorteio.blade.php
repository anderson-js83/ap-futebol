@extends('main')
@section('title_app', "Futebol - App ($titulo)")
@section('pg_app', $page)
@section('contents_app')

	<div class="content c2">
    <div class="bloco">

			<table class="table">
				<thead>
					<tr>
						<th scope="col">Id</th>
						<th scope="col">Decrição</th>
						<th scope="col">Data do Jogo</th>
						<th scope="col">Jogadores</th>
					</tr>
					</thead>
					<tbody>
					@foreach($jogos as $jogo)
						<tr id="ln{{ $jogo->id }}">
							<th scope="row">
								{{ $jogo->id }}:
								<?php $arEscalacao = $apFuncao::executeSql('times', null, null, 'count(id) qtde', " id_jogo in(". $jogo->id .") and deleted_at is null"); ?>
								@if($arEscalacao[0]->qtde<=0)
								  <button type="button" class="btn btn-info btn-sm btn_action" id="btnAtualizar{{ $titulo }}" onClick="listaFormAlt{{ $titulo }}({{ $jogo->id }})">
								  	<ion-icon name="dice-sharp"></ion-icon>
								  </button>
								@endif
							</th>
							<td>{{ $jogo->descricao }}</td>
							<td>{{ $jogo->dt_jogo }}</td>
							<td>
								<?php $arJogadores = $apFuncao::executeSql('atletas', null, null, 'count(id) qtde', " id in(". $jogo->jogadores .")"); ?>
								<ion-icon name="walk-outline"></ion-icon><b>o</b> {{ $arJogadores[0]->qtde }}
							</td>
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
						  	<ion-icon name="football-outline"></ion-icon> {{ $titulo }} - Gerar Times p/ Jogos Agendados e Atletas Confirmados
						  </h5>
						  <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
						</div>
						<div class="modal-body">

							<form>
								<input type="hidden" name="id_jogo" value="0">
								<fieldset>
									<legend>Informações p/ {{ $titulo }}</legend>
									<div class="container-fluid">
								    <div class="row">

								     	<div class="col-4 col-sm-4">
								     		<div class="col-md-12 cp">
													<label class="form-label small">Descrição:</label>
													<p id="descricao"></p>
												</div>
								      	<div class="col-md-12 cp">
													<label class="form-label small">Data/Hora da Partida:</label>
													<p id="dt_jogo"></p>
												</div>
												<div class="col-md-12 cp">
													<label class="form-label small">Lista do(s) Atleta(s) Confirmados:</label>
									      	<div id="chk-atletas"></div>
												</div>
								     	</div>

								     	<div class="col-8 col-sm-8">
												<div class="row">
													<div class="col-sm-12">
														<h5>Parâmetros/Regras do Sorteio:</h5>
														<div class="row">
															<div class="col-4 col-sm-4">
																<div class="col-md-12 cp">
																	<label class="form-label">Quantidade de Jogadores p/ Time:</label>
																	<select class="form-select" name="qtde_jogador">
																		<option value="1" selected>1</option>
																		<option value="2">2</option>
																	  	<option value="3">3</option>
																	  	<option value="4">4</option>
																	  	<option value="5">5</option>
																	  	<option value="6">6</option>
																	  	<option value="7">7</option>
																	  	<option value="8">8</option>
																	  	<option value="9">9</option>
																	  	<option value="10">10</option>
																	  	<option value="11">11</option>
																	</select>
																</div>
																<div class="col-md-12 cp">
																	<label for="validationCustom03" class="form-label">Tipo de Sorteio:</label>
																	<select class="form-select" name="tipo_sorteio">
																		<option value="1" selected>Simples</option>
																		<option value="2">Por Nível de Habilidade</option>
																	</select>
																</div>
																<div class="col-md-12 cp">
																	<button type="button" class="btn btn-success" id="btnSortearJogadores">
																		<ion-icon name="git-compare-outline"></ion-icon> Sortear Jogadores:
																	</button>
																</div>
															</div>
															<div class="col-8 col-sm-8">
																<input type="hidden" name="times" value=""/>
																<div class="col-md-12 cp">
																	<div id="resultadoSorteioMsg"></div>
																	<div id="resultadoSorteioEscalacao"></div>
																</div>
																<div class="col-md-12 cp confirmar_escalacao" style="display: none;">
																	<button type="button" class="btn btn-primary" id="btnConfirmarEscalacao">
																		Confirmar Escalação?
																	</button>
																</div>
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
							<button type="button" class="btn btn-secondary" id="btnFecharForm">Fechar</button>
						</div>
					</div>
				</div>
			</div>

    </div>
  </div>

@endsection
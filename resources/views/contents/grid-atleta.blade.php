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

        	<!-- Controle para renderizacao dos atributos -->
        	<table class="table">
				<thead>
					<tr>
						<th scope="col">Id</th>
						<th scope="col">Nome</th>
						<th scope="col">E-Mail</th>
						<th scope="col">Goleiro?</th>
						<th scope="col">Nível/Habilidade</th>
					</tr>
					</thead>
					<tbody>
					@foreach($atletas as $atleta)
						<tr id="ln{{ $atleta->id }}">
							<th scope="row">
								{{ $atleta->id }}:
							    <button type="button" class="btn btn-danger btn-sm btn_action" id="btnRemover{{ $titulo }}" onClick="acaoRmv({{ $atleta->id }})">
							    	<ion-icon name="close-circle-outline"></ion-icon>
							    </button>
							    <button type="button" class="btn btn-info btn-sm btn_action" id="btnAtualizar{{ $titulo }}" onClick="listaFormAlt{{ $titulo }}({{ $atleta->id }})">
							    	<ion-icon name="create-outline"></ion-icon>
							    </button>
							</th>
							<td>{{ $atleta->nome }}</td>
							<td>{{ $atleta->email }}</td>
							<td>{{ $atleta->sn_goleiro }}</td>
							<td>{{ $atleta->nivel_habilidade }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div id="resultado"></div>

			<!-- Modal -->
			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel"><ion-icon name="accessibility-outline"></ion-icon> Cadastrar {{ $titulo }}</h5>
						</div>
						<div class="modal-body">
							<form>
								<input type="hidden" name="id" value="0">
								<div  class="col-md-12 cp">
									<label for="validationCustom01" class="form-label">Nome</label>
									<input type="text" class="form-control" id="validationCustom01" required name="nome">
								</div>
								<div  class="col-md-12 cp">
									<label class="form-label">E-mail</label>
									<input type="text" class="form-control" id="validationCustom01" required name="email">
								</div>
								<div  class="col-md-12 cp">
									<label for="validationCustom03" class="form-label">É Goleiro?</label>
									<br />
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom03 inlineRadio1" required name="sn_goleiro" value="S">
										<label class="form-check-label" for="inlineRadio1">Sim</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom03 inlineRadio2" required name="sn_goleiro" value="N">
										<label class="form-check-label" for="inlineRadio2">Não</label>
									</div>
								</div>
								<div  class="col-md-12 cp">
									<label for="validationCustom03" class="form-label">Nivel de Habilidade</label>
									<br />
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom04 inlineRadio1" required name="nivel_habilidade" value="1">
										<label class="form-check-label" for="inlineRadio1">1</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom04 inlineRadio2" required name="nivel_habilidade" value="2">
										<label class="form-check-label" for="inlineRadio2">2</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom04 inlineRadio3" required name="nivel_habilidade" value="3">
										<label class="form-check-label" for="inlineRadio2">3</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom04 inlineRadio4" required name="nivel_habilidade" value="4">
										<label class="form-check-label" for="inlineRadio2">4</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="validationCustom04 inlineRadio5" required name="nivel_habilidade" value="5">
										<label class="form-check-label" for="inlineRadio2">5</label>
									</div>
								</div>
							</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" id="btnFecharForm">Fechar</button>
							<button type="button" class="btn btn-success" id="btnSalvar{{ $titulo }}">Salvar</button>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>

@endsection
@extends('main')
@section('title_app', 'Futebol - App')
@section('pg_app', 'home')
@section('contents_app')

	<div class="content c2">
        <div class="bloco">
        	<h4>Jogos/Partidas Agendadas com Atletas Escalados:</h4>
    		@foreach($timeEscalados as $timeEscalado)
    			<div class="col-md-12 cp">
    				{{ $timeEscalado['descricao'] }}<br/>
    				<ion-icon name="calendar-outline"></ion-icon> {{ $timeEscalado['dt_jogo'] }}</small>
    			</div>
    		@endforeach
        </div>
        <div class="bloco">
        	<h4>Jogos Realizados:</h4>
        	@foreach($jogosRealizado as $jogoRealizado)
    			<div class="col-md-12 cp">
    				{{ $jogoRealizado->descricao }}<br/>
    				<ion-icon name="calendar-outline"></ion-icon> {{ $jogoRealizado->dt_jogo }}</small><br/>
    				{{ $jogoRealizado->resultado }}</small>
    			</div>
    		@endforeach
        </div>
        <div class="bloco">
        	<h4>Atletas em Destaque:</h4>
        	@foreach($atletaDestaque as $atleta)
    			<div class="col-md-12 cp">
    				<ion-icon name="man-outline"></ion-icon> {{ $atleta->nome }} <ion-icon name="star"></ion-icon>
    			</div>
    		@endforeach
		</div>
        <div class="bloco">
        	<h4>Goleiros Cadastrados:</h4>
        	@foreach($goleiros as $goleiro)
    			<div class="col-md-12 cp">
    				<ion-icon name="body-outline"></ion-icon> {{ $goleiro->nome }}
    			</div>
    		@endforeach
        </div>
    </div>

@endsection
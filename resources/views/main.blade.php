<?php
#use App\Hap\ApFuncao;
@session_start();
#dd($apFuncao->setSenhaDeAcesso('provence@horus'));
#$usuario = $apFuncao->getDadosUsuario($_SESSION['id_usuario']);
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title_app')</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport"              content="width=device-width, initial-scale=1.0">
        <meta name="author"                content="Anders JS">
        <meta name="description"           content="Projeto de Teste">
        <meta name="keywords" content="">

        <!-- FONTS GOOGLEAPIS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">

        <!-- LIB JQUERY -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- BOOTSTRAP CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

        <!-- CUSTOM CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    </head>
    <body>

        <div class="main">

            <div class="content c3">
                <div class="bloco">
                    <div class="logomarca">
                        <img src="{{ asset('img/logo.png') }}">
                        <h5>Futebol & Amigos</h5>
                    </div>
                </div>
                <div class="bloco">
                    <ul class="nav">
                        <li class="<?php echo ($_SESSION['page']=='home')?'active':''; ?>"><a href="{{ asset('/') }}"><ion-icon name="planet-outline"></ion-icon> Home</a></li>
                        <li class="<?php echo ($_SESSION['page']=='atletas')?'active':''; ?>"><a href="{{ asset('/grid/atletas') }}"><ion-icon name="accessibility-outline"></ion-icon> Atletas</a></li>
                        <li class="<?php echo ($_SESSION['page']=='jogos')?'active':''; ?>"><a href="{{ asset('/grid/jogos') }}"><ion-icon name="football-outline"></ion-icon> Jogos</a></li>
                        <li class="<?php echo ($_SESSION['page']=='sorteios')?'active':''; ?>"><a href="{{ asset('/grid/sorteios') }}"><ion-icon name="dice-outline"></ion-icon> Sorteio</a></li>
                    </ul>
                </div>
            </div>

            <!-- listagem dinamica de conteudo -->
            @yield('contents_app')

        </div>

        <div class="pg_footer">
            {{ date('Y') }} - by: Anderson JS
        </div>

        <!-- IONICICON -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        <!-- POPPER JS & BOOTSTRAP JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

        <!-- SWEERALERT -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript">

            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: "yyyy-mm-dd"
            });


            // CONFIGURACAO PADRAO CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            /*--[ GRUPO DE FUNCOES/ACOES PARA REGISTROS DE ATLETAS ]--*/
            @if($_SESSION['page']=='atletas')
                
                // Funcao ADD/ALT registro
                $("#btnSalvarAtletas").click(function(){
                    if($("input[name='id']").val()>0){
                        //ALT
                        altAtleta();
                    } else {
                        //ADD
                        addAtleta();
                    }
                });

                // Adicionar registro
                function addAtleta(){
                    atleta = {
                        nome: $("input[name='nome']").val(),
                        email: $("input[name='email']").val(),
                        sn_goleiro: $('input[name=sn_goleiro]:checked').val(),
                        nivel_habilidade: $('input[name=nivel_habilidade]:checked').val()
                    };
                    $.post("{{ asset('add/atletas') }}", atleta, function(){
                        $("input[name='nome'],input[name='email']").val('');
                        $('input[name=sn_goleiro],input[name=nivel_habilidade]').prop('checked', false);
                        Swal.fire('Atleta cadastrado.', '', 'success');
                    });
                }

                // Alterar registro
                function altAtleta(){
                    atleta = {
                            id: $("input[name='id']").val(),
                            nome: $("input[name='nome']").val(),
                            email: $("input[name='email']").val(),
                            sn_goleiro: $('input[name=sn_goleiro]:checked').val(),
                            nivel_habilidade: $('input[name=nivel_habilidade]:checked').val()
                        };
                    $.post("{{ asset('alt/atleta') }}/"+ atleta.id, atleta, function(){
                        Swal.fire('Atleta atualizado.', '', 'success');
                    });
                }

                // Listar e popular o formulario para alerar registro
                function listaFormAltAtletas(id){
                    $.getJSON("{{ asset('dtl/atleta') }}/"+ id, function(data){
                        $("input[name='id']").val(id);
                        $("input[name='nome']").val(data.nome);
                        $("input[name='email']").val(data.email);
                        $('input[name=sn_goleiro][value='+ data.sn_goleiro +']').attr('checked', true);
                        $('input[name=nivel_habilidade][value='+ data.nivel_habilidade +']').attr('checked', true);
                        $("#staticBackdrop").modal('show');
                    });
                }

            @endif
            /*--[ FIM DO GRUPO DE FUNCOES/ACOES PARA REGISTROS DE ATLETAS ]--*/

            /*--[ GRUPO DE FUNCOES/ACOES PARA REGISTROS DE JOGOS ]--*/
            @if($_SESSION['page']=='jogos')
                
                // Funcao ADD/ALT registro
                $("#btnSalvarJogos").click(function(){
                    if($("input[name='id']").val()>0){
                        //ALT
                        altJogo();
                    } else {
                        //ADD
                        addJogo();
                    }
                });

                // Adicionar registro
                function addJogo(){
                    var ids="0";
                    $('input[name=atleta_presente]:checked').each(function(i){
                        ids += ","+ $(this).val();
                    });
                    jogo = {
                        descricao: $("input[name='descricao']").val(),
                        dt_jogo: $("input[name='dt_jogo']").val(),
                        status: $("select[name='status']").val(),
                        jogadores: ids,
                        resultado: $("input[name='resultado']").val()
                    };
                    $.post("{{ asset('add/jogos') }}", jogo, function(){
                        $("input[name='descricao'],input[name='dt_jogo'],select[name='status'],input[name='resultado']").val('');
                        $("input[name='jogadores']").prop('checked', false);
                        Swal.fire('Jogo/Partida cadastrada.', '', 'success');
                    });
                }

                // Alterar registro
                function altJogo(){
                    var ids="0";
                    $('input[name=atleta_presente]:checked').each(function(i){
                        ids += ","+ $(this).val();
                    });
                    jogo = {
                            id: $("input[name='id']").val(),
                            descricao: $("input[name='descricao']").val(),
                            dt_jogo: $("input[name='dt_jogo']").val(),
                            status: $("select[name='status']").val(),
                            jogadores: ids,
                            resultado: $("input[name='resultado']").val()
                        };
                    $.post("{{ asset('alt/jogo') }}/"+ jogo.id, jogo, function(){
                        Swal.fire('Jogo/Partida atualizada.', '', 'success');
                    });
                }

                // Listar e popular o formulario para alerar registro
                function listaFormAltJogos(id){
                    $.getJSON("{{ asset('dtl/jogo') }}/"+ id, function(data){
                        $("input[name='id']").val(id);
                        $("input[name='descricao']").val(data.descricao);
                        $("input[name='dt_jogo']").val(data.dt_jogo);
                        $("select[name='status']").val(data.status);
                        jogadores = data.jogadores;
                        $("input[name='resultado']").val(data.resultado);
                        
                    });
                    $.getJSON("{{ asset('dtl/atletas') }}", function(atletas){
                        ar = jogadores.split(',');
                        cpChk = '';
                        $(atletas).each(function(key, jogador){
                            chk = '';
                            cpChk += '<div class="form-check">';
                                if($.inArray(jogador.id.toString(),ar) !== -1 ){
                                    chk += "checked";
                                }
                            cpChk += '<input class="form-check-input" type="checkbox" name="atleta_presente" value="'+ jogador.id +'" '+ chk +'>';
                            cpChk += '<label class="form-check-label">'+ jogador.nome +'</label></div>';
                        });
                        $('#chk-atletas').html(cpChk);
                    });
                    $("#staticBackdrop").modal('show');
                }

                // Exibe os jogadores escalados para o jogo
                function exibirEscalacao(idJogo){
                    jogadores = null;
                    icon = '';
                    time = 'A';
                    strEscalacao = '';
                    $("input[name='id_jogo']").val(idJogo);
                    $.getJSON("{{ asset('dtl/jogo-escalacao') }}/"+ idJogo, function(data){
                        strEscalacao += '<h4>Time A:</h4>';
                        $(data).each(function(key, jogo){
                            $(jogo).each(function(key, jogador){
                                if(time!=jogador.time){
                                    strEscalacao += '<hr/><h4>Time '+  jogador.time +'</h4>';
                                    time = jogador.time;
                                }
                                strEscalacao += jogador.nome +'<br/>';
                            });
                        });
                        $('#mostrarEscalacao').html(strEscalacao);
                    });
                    $("#escalacaoAgendada").modal('show');
                }

                // Opcao para o cancelamento de uma escalacao de jogadores
                $('#btnCancelarEscalacao').click(function(){
                    if($("input[name='id_jogo']").val()>0){
                        Swal.fire({
                            title: 'Deseja realmente remover essa Escalação?',
                            showCancelButton: true,
                            confirmButtonText: 'Sim',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ asset('rmv/escalacao-jogo') }}/"+ $("input[name='id_jogo']").val(),
                                    type: "delete",
                                    success: function(){
                                        Swal.fire('Escalação removida.', '', 'success');
                                    }
                                });
                            }
                        });
                    }
                });

            @endif
            /*--[ FIM DO GRUPO DE FUNCOES/ACOES PARA REGISTROS DE JOGOS ]--*/

            /*--[ GRUPO DE FUNCOES/ACOES PARA REGISTROS DE SORTEIOS ]--*/
            @if($_SESSION['page']=='sorteios')

                // Listar e popular o formulario para alerar registro
                function listaFormAltSorteios(id){
                    $.getJSON("{{ asset('dtl/jogo') }}/"+ id, function(data){
                        $("input[name='id_jogo']").val(id);
                        $("#descricao").html(data.descricao);
                        $("#dt_jogo").html(data.dt_jogo);
                        jogadores = data.jogadores;
                        $("input[name='resultado']").val(data.resultado);
                        
                    });
                    $.getJSON("{{ asset('dtl/atletas') }}", function(atletas){
                        ar = jogadores.split(',');
                        cpChk = '';
                        $(atletas).each(function(key, jogador){
                            icon = '<ion-icon name="man-outline"></ion-icon>';
                            if(jogador.sn_goleiro=='S'){
                                icon = '<ion-icon name="body-outline"></ion-icon>';
                            }
                            if($.inArray(jogador.id.toString(),ar) !== -1 ){
                                cpChk += '<div class="form-check"><label class="form-check-label">'+ icon +' '+ jogador.nome +'</label></div>';     
                            }
                        });
                        $('#chk-atletas').html(cpChk);
                    });
                    $("#staticBackdrop").modal('show');
                }

                // Executa o sorteio do atletas e exibe gerado para confirmacao
                $("#btnSortearJogadores").click(function(){
                    id_jogo = $("input[name='id_jogo']").val();
                    qtde_jogador = $("select[name='qtde_jogador']").val();
                    tipo_sorteio = $("select[name='tipo_sorteio']").val();
                        
                    $.getJSON("{{ asset('exec/sorteio') }}/"+ id_jogo +"/"+ qtde_jogador +"/"+ tipo_sorteio, function(data){
                        idx = 0;
                        strTimes = '';
                        strEscalacao = '';
                        mensagem = '<div class="alert alert-success" role="success"><ion-icon name="checkmark-circle-outline"></ion-icon> '+ data.mensagem +'</div>';
                        if(data.status==false){
                            $('.confirmar_escalacao').hide(200);                            
                            mensagem = '<div class="alert alert-warning" role="alert"><ion-icon name="alert-circle-outline"></ion-icon> '+ data.mensagem +'</div>';
                        }
                        if(data.status==true){
                            $('.confirmar_escalacao').show(200);

                            $(data.resultado.times).each(function(key, idAtletas){
                                idx = (key+1)
                                strTimes += idx +':'+ idAtletas +'|';
                            });
                            $(data.resultado.atletas).each(function(key, escalacao){
                                idx = (key+1)
                                ar = (escalacao.toString()).split(',');
                                strEscalacao += '<h5>Time '+ idx +':</h5>';
                                $(ar).each(function(key, atleta){ 
                                    strEscalacao += atleta +"<br/>";
                                });
                                strEscalacao += '<hr/>';
                            });
                        }

                        $("input[name='times']").val(strTimes);
                        $('#resultadoSorteioMsg').html(mensagem);
                        $('#resultadoSorteioEscalacao').html(strEscalacao);

                    });
                });

                // Confirmar a escalacao sorteada e registra os participantes
                $("#btnConfirmarEscalacao").click(function(){
                    escalacao = {
                            id_jogo: $("input[name='id_jogo']").val(),
                            times: $("input[name='times']").val()
                        };
                    $.post("{{ asset('add/escalacao') }}",escalacao, function(){
                        Swal.fire({
                            title: 'Escalação registrada.',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.assign("{{ asset('grid/jogos') }}");
                            }
                        });
                    });
                });

            @endif
            /*--[ FIM DO GRUPO DE FUNCOES/ACOES PARA REGISTROS DE SORTEIOS ]--*/

            /*--[ GRUPO DE FUNCOES/ACOES GENERICAS ]--*/
                // Acoes para renderizar e recarregar pagina
                $("#btnFecharForm").click(function(){
                    @if($_SESSION['page']=='atletas')
                        url = "{{ asset('grid/atletas') }}";
                    @endif
                    @if($_SESSION['page']=='jogos')
                        url = "{{ asset('grid/jogos') }}";
                    @endif
                    @if($_SESSION['page']=='sorteios')
                        url = "{{ asset('grid/sorteios') }}";
                    @endif
                    window.location.assign(url);
                });
                $('#btnFecharEscalacao').click(function(){
                    //$("#escalacaoAgendada").modal('hide');
                    window.location.assign("{{ asset('grid/jogos') }}");
                });

                // Acao para remover/deletar registros
                function acaoRmv(id){
                    
                    @if($_SESSION['page']=='atletas')
                        url = "{{ asset('rmv/atletas') }}/"+ id;
                    @endif
                    @if($_SESSION['page']=='jogos')
                        url = "{{ asset('rmv/jogos') }}/"+ id;
                    @endif

                    Swal.fire({
                        title: 'Deseja realmente remover o registro?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        denyButtonText: `Não`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: "delete",
                                context: this,
                                success: function(){
                                    $('#ln'+ id).hide(200);
                                    Swal.fire('Atleta removido.', '', 'success');
                                },
                                error: function(erro){
                                    Swal.fire(erro, '', 'warning');
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire('Nenhuma ação efetuada.', '', 'info');
                        }
                    });
                }
            /*--[ FIM DO GRUPO DE FUNCOES/ACOES GENERICAS ]--*/

        </script>

    </body>
</html>
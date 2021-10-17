<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atleta;

@session_start();
$_SESSION['page'] = "";

class AtletaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grid()
    {
        $_SESSION['page'] = "atletas";
        $atletas = Atleta::all();
        return view('contents.grid-atleta', [ 
            'page' => 'atletas',
            'titulo' => 'Atletas',
            'atletas' => $atletas
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
        $atleta = new Atleta();
        $atleta->nome = $request->input('nome');
        $atleta->email = $request->input('email');
        $atleta->sn_goleiro = $request->input('sn_goleiro');
        $atleta->nivel_habilidade = $request->input('nivel_habilidade');
        $atleta->save();
        return "Atleta Cadastrado!";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $atleta = Atleta::find($id);
        if(isset($atleta))
            return json_encode($atleta);
        return response('Atleta não encontrado!', 404);
    }

    /**
     * Metodo customizado para listar registros aplicando condicao de filtro SQL com IN
     */
    public function showIn($ids)
    {
        $atleta = Atleta::whereIn('id',(explode(',',$ids)))->get();
        if(isset($atleta))
            return json_encode($atleta);
        return response('Atleta não encontrado!', 404);
    }

    /**
     * Display all datas.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $atletas = Atleta::all();
        if(isset($atletas))
            return json_encode($atletas);
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
        $atleta = Atleta::find($id);
        if(isset($atleta))
            $atleta->nome = $request->input('nome');
            $atleta->email = $request->input('email');
            $atleta->sn_goleiro = $request->input('sn_goleiro');
            $atleta->nivel_habilidade = $request->input('nivel_habilidade');
            $atleta->save();
            return json_encode($atleta);
        return response('Atleta não encontrado!', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $atleta = Atleta::find($id);
        if(isset($atleta))
            $atleta->delete();
            return response('OK', 200);
        return response('Atleta não encontrado!', 404);
    }
}

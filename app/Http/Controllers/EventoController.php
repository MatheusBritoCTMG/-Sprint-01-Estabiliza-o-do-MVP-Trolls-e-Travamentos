<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pergunta;
use App\Http\Requests\StorePerguntaRequest;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * TICKET #002 (BUG LEGADO DE PERFORMANCE):
     * Refatorado para filtrar pelo evento, ordenar pelas mais recentes e paginar de 10 em 10.
     *
     * TICKET #004 (Performance & Carregamento Ansioso):
     * Utiliza with('user') (Eager Loading) para evitar o problema de N+1 queries
     * que ocorreria ao acessar $pergunta->user->name dentro do loop na view.
     *
     * TICKET #006 (Moderação / Status Público):
     * Filtra apenas perguntas com is_public = true, escondendo do público
     * as perguntas ainda pendentes de moderação pelo organizador.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        $perguntas = Pergunta::with('user')
            ->where('evento_id', $evento->id)
            ->where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

    /**
     * TICKET #001 (BUG LEGADO DE SEGURANÇA):
     * Salva a pergunta usando a requisição sem validações rigorosas.
     */
    public function storePergunta(StorePerguntaRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'user_id'   => auth()->id(),
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
        ]);

        return redirect()->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada com sucesso!');
    }
}

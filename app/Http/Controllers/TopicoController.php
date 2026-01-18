<?php

namespace App\Http\Controllers;

use App\Models\Topico;
use Illuminate\Http\Request;

class TopicoController extends Controller
{
    public function index()
    {
        $topicos = Topico::withCount('questoes')->orderBy('nome')->get();

        return view('topicos.index', compact('topicos'));
    }

    public function create()
    {
        return view('topicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:topicos,nome',
            'descricao' => 'nullable|string',
        ]);

        Topico::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('topicos.index')
            ->with('success', 'Tópico criado com sucesso!');
    }
}

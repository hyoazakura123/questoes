<?php

namespace App\Http\Controllers;

use App\Models\Questao;
use App\Models\Alternativa;
use App\Models\Topico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestaoController extends Controller
{
    /**
     * Exibe o formulário de criação da questão
     */
    public function index()
    {
        $topicos = Topico::orderBy('nome')->get();

        return view('questoes.create', compact('topicos'));
    }

    /**
     * Persiste a questão e suas alternativas
     */
    public function store(Request $request)
    {
        $request->validate([
            'enunciado' => 'required|string',
            'topico_id' => 'required|exists:topicos,id',
            'comentario' => 'nullable|string',
            'alternativas' => 'required|array|min:2',
            'alternativas.*.texto' => 'required|string',
            'correta' => 'required|integer',
        ]);

        DB::transaction(function () use ($request) {

            $questao = Questao::create([
                'enunciado' => $request->enunciado,
                'topico_id' => $request->topico_id,
                'comentario' => $request->comentario,
            ]);

            foreach ($request->alternativas as $index => $alt) {
                Alternativa::create([
                    'questao_id' => $questao->id,
                    'texto' => $alt['texto'],
                    'correta' => ((int) $request->correta === (int) $index),
                    'comentario' => $alt['comentario'] ?? null,
                ]);
            }
        });

        return redirect('/')
            ->with('success', 'Questão cadastrada com sucesso.');
    }
}

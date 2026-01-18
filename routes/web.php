<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestaoController;
use App\Http\Controllers\TopicoController;

// Página inicial - seleção de tópicos
Route::get('/', [TopicoController::class, 'index'])->name('home');

// Tópicos
Route::get('/topicos', [TopicoController::class, 'index'])->name('topicos.index');
Route::get('/topicos/criar', [TopicoController::class, 'create'])->name('topicos.create');
Route::post('/topicos', [TopicoController::class, 'store'])->name('topicos.store');

// Questões
Route::get('/questoes/criar', [QuestaoController::class, 'create'])->name('questoes.create');
Route::post('/questoes', [QuestaoController::class, 'store'])->name('questoes.store');
Route::get('/questoes/topico/{topico}', [QuestaoController::class, 'porTopico'])->name('questoes.topico');
Route::post('/questoes/{questao}/responder', [QuestaoController::class, 'responder'])->name('questoes.responder');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestaoController;

Route::get('/', [QuestaoController::class, 'index'])->name('questoes.index');
Route::post('/questoes', [QuestaoController::class, 'store'])->name('questoes.store');

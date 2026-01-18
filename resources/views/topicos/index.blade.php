@extends('layouts.app')

@section('title', 'Selecione um Tópico')

@section('content')
<div class="page-header text-center">
    <h1><i class="bi bi-collection me-3"></i>Escolha um Tópico</h1>
    <p>Selecione um tópico para começar a responder questões</p>
</div>

@if($topicos->isEmpty())
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-folder2-open" style="font-size: 5rem; color: rgba(255,255,255,0.2);"></i>
        </div>
        <h3 class="text-white-50">Nenhum tópico cadastrado</h3>
        <p class="text-white-50 mb-4">Comece criando seu primeiro tópico</p>
        <a href="{{ route('topicos.create') }}" class="btn btn-gradient-primary">
            <i class="bi bi-plus-circle me-2"></i>Criar Tópico
        </a>
    </div>
@else
    <div class="row g-4">
        @foreach($topicos as $topico)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('questoes.topico', $topico) }}" class="text-decoration-none">
                    <div class="card topic-card h-100">
                        <div class="card-body p-4">
                            <div class="topic-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <h4 class="card-title text-white mb-2">{{ $topico->nome }}</h4>
                            @if($topico->descricao)
                                <p class="text-white-50 small mb-3">{{ Str::limit($topico->descricao, 80) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="badge-count">
                                    <i class="bi bi-question-circle me-1"></i>
                                    {{ $topico->questoes_count }} {{ $topico->questoes_count == 1 ? 'questão' : 'questões' }}
                                </span>
                                <i class="bi bi-arrow-right-circle text-white-50" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('topicos.create') }}" class="text-decoration-none">
                <div class="card h-100" style="border-style: dashed; border-width: 2px;">
                    <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="topic-icon" style="background: rgba(255,255,255,0.1);">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <h5 class="text-white-50">Adicionar Tópico</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif
@endsection

@extends('layouts.app')

@section('title', 'Criar Tópico')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="page-header text-center">
            <h1><i class="bi bi-folder-plus me-3"></i>Novo Tópico</h1>
            <p>Crie um tópico para organizar suas questões</p>
        </div>

        <div class="card">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('topicos.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nome" class="form-label">
                            <i class="bi bi-tag me-1"></i>Nome do Tópico
                        </label>
                        <input type="text"
                               class="form-control @error('nome') is-invalid @enderror"
                               id="nome"
                               name="nome"
                               value="{{ old('nome') }}"
                               placeholder="Ex: Matemática, História, Programação..."
                               required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descricao" class="form-label">
                            <i class="bi bi-text-paragraph me-1"></i>Descrição (opcional)
                        </label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror"
                                  id="descricao"
                                  name="descricao"
                                  rows="3"
                                  placeholder="Descreva brevemente o conteúdo deste tópico...">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-success">
                            <i class="bi bi-check-lg me-2"></i>Criar Tópico
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-2"></i>Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

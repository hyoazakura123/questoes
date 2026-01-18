@extends('layouts.app')

@section('title', 'Criar Questão')

@push('styles')
<style>
    .alternative-card {
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .alternative-card:hover {
        border-color: rgba(102, 126, 234, 0.3);
        background: rgba(255, 255, 255, 0.05);
    }

    .alternative-card.selected {
        border-color: #38ef7d;
        background: rgba(56, 239, 125, 0.1);
    }

    .alternative-letter {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .correct-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .alternative-card.selected .correct-indicator {
        opacity: 1;
    }

    .form-check-input[type="radio"] {
        width: 24px;
        height: 24px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #38ef7d;
        border-color: #38ef7d;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="page-header text-center">
            <h1><i class="bi bi-plus-circle me-3"></i>Nova Questão</h1>
            <p>Crie uma questão de múltipla escolha para seus estudos</p>
        </div>

        <div class="card">
            <div class="card-body p-4 p-lg-5">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Ops! Verifique os erros:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($topicos->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-folder2-open" style="font-size: 4rem; color: rgba(255,255,255,0.2);"></i>
                        <h4 class="text-white-50 mt-3">Nenhum tópico cadastrado</h4>
                        <p class="text-white-50">Você precisa criar um tópico antes de adicionar questões</p>
                        <a href="{{ route('topicos.create') }}" class="btn btn-gradient-primary mt-2">
                            <i class="bi bi-folder-plus me-2"></i>Criar Tópico
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('questoes.store') }}">
                        @csrf

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bi bi-folder me-1"></i>Tópico
                                </label>
                                <select name="topico_id" class="form-select" required>
                                    <option value="">Selecione um tópico...</option>
                                    @foreach($topicos as $topico)
                                        <option value="{{ $topico->id }}" {{ old('topico_id') == $topico->id ? 'selected' : '' }}>
                                            {{ $topico->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-chat-left-text me-1"></i>Enunciado da Questão
                            </label>
                            <textarea
                                name="enunciado"
                                rows="4"
                                class="form-control"
                                placeholder="Digite o enunciado da questão aqui..."
                                required
                            >{{ old('enunciado') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-info-circle me-1"></i>Comentário / Explicação (opcional)
                            </label>
                            <textarea
                                name="comentario"
                                rows="3"
                                class="form-control"
                                placeholder="Adicione uma explicação que será exibida após o aluno responder..."
                            >{{ old('comentario') }}</textarea>
                        </div>

                        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

                        <div class="mb-4">
                            <h5 class="text-white mb-3">
                                <i class="bi bi-list-check me-2"></i>Alternativas
                                <small class="text-white-50 fw-normal">(Selecione a correta)</small>
                            </h5>

                            @php $letras = ['A', 'B', 'C', 'D']; @endphp

                            @for($i = 0; $i < 4; $i++)
                                <div class="alternative-card" id="alt-card-{{ $i }}">
                                    <div class="correct-indicator">
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-lg me-1"></i>Correta
                                        </span>
                                    </div>

                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <div class="alternative-letter">{{ $letras[$i] }}</div>
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="correta"
                                                value="{{ $i }}"
                                                id="correta-{{ $i }}"
                                                {{ old('correta') == $i ? 'checked' : '' }}
                                                required
                                                onchange="updateSelectedCard({{ $i }})"
                                            >
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="mb-3">
                                                <input
                                                    type="text"
                                                    name="alternativas[{{ $i }}][texto]"
                                                    class="form-control"
                                                    placeholder="Texto da alternativa {{ $letras[$i] }}"
                                                    value="{{ old("alternativas.$i.texto") }}"
                                                    required
                                                >
                                            </div>
                                            <div>
                                                <input
                                                    type="text"
                                                    name="alternativas[{{ $i }}][comentario]"
                                                    class="form-control"
                                                    placeholder="Comentário para esta alternativa (opcional)"
                                                    value="{{ old("alternativas.$i.comentario") }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-light me-md-2">
                                <i class="bi bi-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-gradient-success">
                                <i class="bi bi-check-lg me-2"></i>Salvar Questão
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateSelectedCard(index) {
        document.querySelectorAll('.alternative-card').forEach((card, i) => {
            if (i === index) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });
    }

    // Inicializa o estado ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const checked = document.querySelector('input[name="correta"]:checked');
        if (checked) {
            updateSelectedCard(parseInt(checked.value));
        }
    });
</script>
@endpush

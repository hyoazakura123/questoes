@extends('layouts.app')

@section('title', 'Quiz - ' . $topico->nome)

@push('styles')
<style>
    .question-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .question-number {
        position: absolute;
        top: 0;
        left: 0;
        background: var(--gradient-primary);
        padding: 0.5rem 1.5rem;
        border-radius: 0 0 16px 0;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .question-text {
        font-size: 1.2rem;
        line-height: 1.7;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
        color: #fff;
    }

    .alternative-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        width: 100%;
        padding: 1rem 1.5rem;
        margin-bottom: 0.75rem;
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        color: #fff;
        text-align: left;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .alternative-btn:hover:not(:disabled) {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(102, 126, 234, 0.5);
        transform: translateX(5px);
    }

    .alternative-btn:disabled {
        cursor: not-allowed;
    }

    .alternative-btn .letter {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .alternative-btn .text {
        flex-grow: 1;
        font-size: 1rem;
    }

    .alternative-btn .result-icon {
        font-size: 1.5rem;
        display: none;
    }

    .alternative-btn.correct {
        background: rgba(56, 239, 125, 0.15);
        border-color: #38ef7d;
    }

    .alternative-btn.correct .letter {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .alternative-btn.correct .result-icon {
        display: block;
        color: #38ef7d;
    }

    .alternative-btn.wrong {
        background: rgba(244, 92, 67, 0.15);
        border-color: #f45c43;
    }

    .alternative-btn.wrong .letter {
        background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    }

    .alternative-btn.wrong .result-icon {
        display: block;
        color: #f45c43;
    }

    .feedback-box {
        display: none;
        margin-top: 1.5rem;
        padding: 1.5rem;
        border-radius: 16px;
        animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .feedback-box.success {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.2) 0%, rgba(56, 239, 125, 0.2) 100%);
        border: 1px solid rgba(56, 239, 125, 0.3);
    }

    .feedback-box.error {
        background: linear-gradient(135deg, rgba(235, 51, 73, 0.2) 0%, rgba(244, 92, 67, 0.2) 100%);
        border: 1px solid rgba(244, 92, 67, 0.3);
    }

    .feedback-box .icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .feedback-box.success .icon { color: #38ef7d; }
    .feedback-box.error .icon { color: #f45c43; }

    .commentary-box {
        margin-top: 1rem;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }

    .commentary-box .label {
        font-weight: 600;
        color: #667eea;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .progress-container {
        margin-bottom: 2rem;
    }

    .progress {
        height: 10px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .progress-bar {
        background: var(--gradient-success);
        transition: width 0.5s ease;
    }

    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }

    .stats-card .number {
        font-size: 2.5rem;
        font-weight: 700;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-card.success .number {
        background: var(--gradient-success);
        -webkit-background-clip: text;
        background-clip: text;
    }

    .stats-card.error .number {
        background: var(--gradient-danger);
        -webkit-background-clip: text;
        background-clip: text;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: rgba(255, 255, 255, 0.1);
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1><i class="bi bi-journal-check me-3"></i>{{ $topico->nome }}</h1>
            <p>{{ $topico->descricao ?? 'Responda as questões e teste seus conhecimentos' }}</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-light">
            <i class="bi bi-arrow-left me-2"></i>Voltar aos Tópicos
        </a>
    </div>
</div>

@if($questoes->isEmpty())
    <div class="card">
        <div class="card-body empty-state">
            <i class="bi bi-question-circle"></i>
            <h3 class="text-white-50">Nenhuma questão neste tópico</h3>
            <p class="text-white-50 mb-4">Adicione questões para começar a praticar</p>
            <a href="{{ route('questoes.create') }}" class="btn btn-gradient-primary">
                <i class="bi bi-plus-circle me-2"></i>Criar Questão
            </a>
        </div>
    </div>
@else
    <div class="progress-container">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-white-50">Progresso</span>
            <span class="text-white" id="progress-text">0 de {{ $questoes->count() }} respondidas</span>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%" id="progress-bar"></div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="number" id="total-count">{{ $questoes->count() }}</div>
                <div class="text-white-50">Total de Questões</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card success">
                <div class="number" id="correct-count">0</div>
                <div class="text-white-50">Acertos</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card error">
                <div class="number" id="wrong-count">0</div>
                <div class="text-white-50">Erros</div>
            </div>
        </div>
    </div>

    @php $letras = ['A', 'B', 'C', 'D']; @endphp

    @foreach($questoes as $index => $questao)
        <div class="question-card" id="question-{{ $questao->id }}">
            <div class="question-number">Questão {{ $index + 1 }}</div>

            <div class="question-text">{{ $questao->enunciado }}</div>

            <div class="alternatives">
                @foreach($questao->alternativas as $altIndex => $alternativa)
                    <button type="button"
                            class="alternative-btn"
                            data-questao-id="{{ $questao->id }}"
                            data-alternativa-id="{{ $alternativa->id }}"
                            onclick="responder(this, {{ $questao->id }}, {{ $alternativa->id }})">
                        <span class="letter">{{ $letras[$altIndex] ?? ($altIndex + 1) }}</span>
                        <span class="text">{{ $alternativa->texto }}</span>
                        <span class="result-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="feedback-box" id="feedback-{{ $questao->id }}">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">
                        <i class="bi" id="feedback-icon-{{ $questao->id }}"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" id="feedback-title-{{ $questao->id }}"></h5>
                        <p class="mb-0 text-white-50" id="feedback-message-{{ $questao->id }}"></p>
                    </div>
                </div>
                <div class="commentary-box" id="commentary-{{ $questao->id }}" style="display: none;">
                    <div class="label"><i class="bi bi-lightbulb me-1"></i>Explicação</div>
                    <div id="commentary-text-{{ $questao->id }}"></div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="text-center mt-4">
        <button class="btn btn-gradient-primary btn-lg" onclick="scrollToTop()">
            <i class="bi bi-arrow-up me-2"></i>Voltar ao Topo
        </button>
    </div>
@endif
@endsection

@push('scripts')
<script>
    let answered = 0;
    let correct = 0;
    let wrong = 0;
    const total = {{ $questoes->count() }};

    function responder(button, questaoId, alternativaId) {
        const questionCard = document.getElementById(`question-${questaoId}`);
        const buttons = questionCard.querySelectorAll('.alternative-btn');

        // Desabilita todos os botões desta questão
        buttons.forEach(btn => btn.disabled = true);

        // Faz a requisição AJAX
        fetch(`/questoes/${questaoId}/responder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ alternativa_id: alternativaId })
        })
        .then(response => response.json())
        .then(data => {
            const feedbackBox = document.getElementById(`feedback-${questaoId}`);
            const feedbackIcon = document.getElementById(`feedback-icon-${questaoId}`);
            const feedbackTitle = document.getElementById(`feedback-title-${questaoId}`);
            const feedbackMessage = document.getElementById(`feedback-message-${questaoId}`);

            // Marca a alternativa clicada
            if (data.acertou) {
                button.classList.add('correct');
                button.querySelector('.result-icon i').className = 'bi bi-check-circle-fill';
                feedbackBox.classList.add('success');
                feedbackIcon.className = 'bi bi-emoji-smile-fill';
                feedbackTitle.textContent = 'Parabéns! Você acertou!';
                feedbackMessage.textContent = 'Continue assim, você está mandando bem!';
                correct++;
                document.getElementById('correct-count').textContent = correct;
            } else {
                button.classList.add('wrong');
                button.querySelector('.result-icon i').className = 'bi bi-x-circle-fill';
                feedbackBox.classList.add('error');
                feedbackIcon.className = 'bi bi-emoji-frown-fill';
                feedbackTitle.textContent = 'Ops! Resposta incorreta';
                feedbackMessage.textContent = 'Não desanime, continue estudando!';
                wrong++;
                document.getElementById('wrong-count').textContent = wrong;

                // Marca a alternativa correta
                buttons.forEach(btn => {
                    if (btn.dataset.alternativaId == data.alternativa_correta_id) {
                        btn.classList.add('correct');
                        btn.querySelector('.result-icon i').className = 'bi bi-check-circle-fill';
                    }
                });
            }

            // Mostra o comentário se existir
            if (data.comentario) {
                const commentaryBox = document.getElementById(`commentary-${questaoId}`);
                const commentaryText = document.getElementById(`commentary-text-${questaoId}`);
                commentaryText.textContent = data.comentario;
                commentaryBox.style.display = 'block';
            }

            feedbackBox.style.display = 'block';

            // Atualiza progresso
            answered++;
            updateProgress();
        })
        .catch(error => {
            console.error('Erro:', error);
            buttons.forEach(btn => btn.disabled = false);
            alert('Erro ao enviar resposta. Tente novamente.');
        });
    }

    function updateProgress() {
        const percentage = (answered / total) * 100;
        document.getElementById('progress-bar').style.width = percentage + '%';
        document.getElementById('progress-text').textContent = `${answered} de ${total} respondidas`;
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endpush

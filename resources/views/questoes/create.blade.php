<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Painel de Criação de Questões</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-secondary">
                <div class="card-header bg-black border-secondary">
                    <h4 class="mb-0">Cadastro de Questão</h4>
                </div>

                <div class="card-body">

                    {{-- SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ERRORS --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $erro)
                                    <li>{{ $erro }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('questoes.store') }}">
                        @csrf

                        {{-- TÓPICO --}}
                        <div class="mb-3">
                            <label class="form-label">Tópico</label>
                            <select name="topico_id" class="form-select" required>
                                <option value="">Selecione</option>
                                @foreach($topicos as $topico)
                                    <option value="{{ $topico->id }}" {{ old('topico_id') == $topico->id ? 'selected' : '' }}>
                                        {{ $topico->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ENUNCIADO --}}
                        <div class="mb-3">
                            <label class="form-label">Enunciado</label>
                            <textarea
                                name="enunciado"
                                rows="4"
                                class="form-control"
                                required
                            >{{ old('enunciado') }}</textarea>
                        </div>

                        {{-- COMENTÁRIO --}}
                        <div class="mb-4">
                            <label class="form-label">Comentário da Questão</label>
                            <textarea
                                name="comentario"
                                rows="3"
                                class="form-control"
                            >{{ old('comentario') }}</textarea>
                        </div>

                        <hr class="border-secondary">

                        {{-- ALTERNATIVAS --}}
                        <h5 class="mb-3">Alternativas</h5>

                        @for($i = 0; $i < 4; $i++)
                            <div class="row g-2 align-items-center mb-2">
                                <div class="col-auto">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="correta"
                                        value="{{ $i }}"
                                        {{ old('correta') == $i ? 'checked' : '' }}
                                        required
                                    >
                                </div>

                                <div class="col">
                                    <input
                                        type="text"
                                        name="alternativas[{{ $i }}][texto]"
                                        class="form-control"
                                        placeholder="Texto da alternativa"
                                        value="{{ old("alternativas.$i.texto") }}"
                                        required
                                    >
                                </div>

                                <div class="col">
                                    <input
                                        type="text"
                                        name="alternativas[{{ $i }}][comentario]"
                                        class="form-control"
                                        placeholder="Comentário (opcional)"
                                        value="{{ old("alternativas.$i.comentario") }}"
                                    >
                                </div>
                            </div>
                        @endfor

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Salvar Questão
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <p class="text-center text-secondary mt-3 small">
                Painel interno • Cadastro de questões
            </p>

        </div>
    </div>

</div>

</body>
</html>

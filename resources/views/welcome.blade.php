<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Questão</title>
</head>
<body>

<h1>Cadastro de Questão</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('questoes.store') }}">
    @csrf

    <div>
        <label>Tópico</label>
        <select name="topico_id" required>
            <option value="">Selecione</option>
            @foreach($topicos as $topico)
                <option value="{{ $topico->id }}">{{ $topico->nome }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Enunciado</label>
        <textarea name="enunciado" required></textarea>
    </div>

    <div>
        <label>Comentário da questão</label>
        <textarea name="comentario"></textarea>
    </div>

    <hr>

    <h3>Alternativas</h3>

    @for($i = 0; $i < 4; $i++)
        <div>
            <input type="radio" name="correta" value="{{ $i }}" required>
            <input type="text" name="alternativas[{{ $i }}][texto]" placeholder="Texto da alternativa" required>
            <input type="text" name="alternativas[{{ $i }}][comentario]" placeholder="Comentário (opcional)">
        </div>
    @endfor

    <hr>

    <button type="submit">Salvar Questão</button>
</form>

</body>
</html>

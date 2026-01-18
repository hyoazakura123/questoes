<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Questões')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-danger: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.3) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
        }

        .btn-gradient-primary {
            background: var(--gradient-primary);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-gradient-success {
            background: var(--gradient-success);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-gradient-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.4);
            color: white;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
        }

        .topic-card {
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .topic-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .topic-card:hover::before {
            opacity: 1;
        }

        .topic-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .badge-count {
            background: var(--gradient-primary);
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
        }

        .alert {
            border-radius: 16px;
            border: none;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.2) 0%, rgba(56, 239, 125, 0.2) 100%);
            border: 1px solid rgba(56, 239, 125, 0.3);
            color: #38ef7d;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(235, 51, 73, 0.2) 0%, rgba(244, 92, 67, 0.2) 100%);
            border: 1px solid rgba(244, 92, 67, 0.3);
            color: #f45c43;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.7) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            animation: float 20s infinite ease-in-out;
        }

        .shape:nth-child(1) { width: 400px; height: 400px; top: -200px; right: -100px; }
        .shape:nth-child(2) { width: 300px; height: 300px; bottom: -150px; left: -100px; animation-delay: -5s; }
        .shape:nth-child(3) { width: 200px; height: 200px; top: 50%; left: 50%; animation-delay: -10s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(20px, -20px) rotate(5deg); }
            50% { transform: translate(-20px, 20px) rotate(-5deg); }
            75% { transform: translate(-20px, -20px) rotate(5deg); }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>QuizMaster
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('topicos.create') }}">
                            <i class="bi bi-folder-plus me-1"></i>Novo Tópico
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('questoes.create') }}">
                            <i class="bi bi-plus-circle me-1"></i>Nova Questão
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

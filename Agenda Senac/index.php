<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senac Reservas // Interface Gênesis</title>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome (Ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Seu CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Cursor customizado -->
    <div class="cursor"></div>

    <!-- Bolhas de Fundo em SVG -->
    <div class="blob-container">
        <svg viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
            <path id="blob1" d="M826.5,583Q753,666,667,737.5Q581,809,494.5,850Q408,891,326,846.5Q244,802,168,740Q92,678,74.5,589Q57,500,81,417.5Q105,335,152.5,267.5Q200,200,285.5,153.5Q371,107,460.5,91.5Q550,76,630.5,123.5Q711,171,780,235.5Q849,300,865.5,400Q882,500,826.5,583Z" />
            <path id="blob2" d="M834.5,588.5Q771,677,677,735Q583,793,491.5,833Q400,873,316,833.5Q232,794,153.5,733Q75,672,85,586Q95,500,94,411.5Q93,323,150,265Q207,207,294,166.5Q381,126,470.5,115Q560,104,642,148.5Q724,193,786.5,260Q849,327,865.5,413.5Q882,500,834.5,588.5Z" />
        </svg>
    </div>

    <header id="main-header">
        <nav class="container">
            <a href="#" class="logo">Senac <strong>Reservas</strong></a>
            <a href="app/index.php" class="btn" data-tilt data-tilt-max="8" data-tilt-speed="400" data-tilt-perspective="1000">Acessar Plataforma</a>
        </nav>
    </header>

    <main class="container">
        <section id="hero">
            <div class="hero-content">
                <div class="title-line">
                    <h1>A gestão de espaços,</h1>
                </div>
                <div class="title-line">
                    <h1>reinventada.</h1>
                </div>
                <p>Agende, gerencie e colabore com uma fluidez sem precedentes. Bem-vindo ao futuro da organização no Senac.</p>
                <!-- **** ALTERAÇÕES **** - data-tilt removido e span adicionado -->
                <a href="../app/registro.php" class="btn btn-primary">
                    <span>Começar Agora</span>
                </a>
            </div>
        </section>

        <section id="features">
            <div class="features-grid">
                <div class="glass-card" data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-perspective="1000">
                    <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
                    <h3>Agenda Inteligente</h3>
                    <p>Visualize a disponibilidade em uma interface limpa que parece flutuar sobre o tempo.</p>
                </div>
                <div class="glass-card" data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-perspective="1000">
                    <div class="card-icon"><i class="fas fa-bolt"></i></div>
                    <h3>Fluxo Instantâneo</h3>
                    <p>Solicitações e aprovações em um sistema desenhado para ser tão rápido quanto seu pensamento.</p>
                </div>
                <div class="glass-card" data-tilt data-tilt-max="5" data-tilt-speed="400" data-tilt-perspective="1000">
                    <div class="card-icon"><i class="fas fa-layer-group"></i></div>
                    <h3>Controle Centralizado</h3>
                    <p>Tudo o que importa, desde perfis de usuário até históricos de reserva, em um painel coeso.</p>
                </div>
            </div>
        </section>
    </main>

    <footer id="main-footer">
        <p>&copy; 2025 Senac Reservas. Uma Nova Era na Gestão de Espaços.</p>
    </footer>

    <!-- Frameworks (via CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.3/vanilla-tilt.min.js"></script>
    
    <!-- Seu JavaScript -->
    <script src="script.js"></script>

</body>
</html>
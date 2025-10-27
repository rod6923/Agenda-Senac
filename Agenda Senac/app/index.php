<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login // Senac Reservas</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/app-style.css">
    
    <style>
        .auth-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            /* **** CORREÇÃO CRÍTICA **** - Garante que o painel fique na frente */
            position: relative;
            z-index: 2;
        }
        .auth-header {
            position: absolute;
            top: 20px;
            left: 40px;
            z-index: 5;
        }
        .auth-panel {
            width: 100%;
            max-width: 400px;
            text-align: center;
            /* Corrigido para corresponder à animação */
            opacity: 0;
            transform: translateY(30px);
        }
        .auth-switch {
            margin-top: 20px;
            font-size: 0.9rem;
            color: rgba(0,0,0,0.6);
        }
        .auth-switch a { font-weight: 500; }
        .auth-panel button.btn-primary { width: 100%; }
    </style>
</head>
<body>
    <div class="cursor"></div>
    <div class="blob-container">
        <svg viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
            <path id="blob1" d="M826.5,583Q753,666,667,737.5Q581,809,494.5,850Q408,891,326,846.5Q244,802,168,740Q92,678,74.5,589Q57,500,81,417.5Q105,335,152.5,267.5Q200,200,285.5,153.5Q371,107,460.5,91.5Q550,76,630.5,123.5Q711,171,780,235.5Q849,300,865.5,400Q882,500,826.5,583Z" />
            <path id="blob2" d="M834.5,588.5Q771,677,677,735Q583,793,491.5,833Q400,873,316,833.5Q232,794,153.5,733Q75,672,85,586Q95,500,94,411.5Q93,323,150,265Q207,207,294,166.5Q381,126,470.5,115Q560,104,642,148.5Q724,193,786.5,260Q849,327,865.5,413.5Q882,500,834.5,588.5Z" />
        </svg>
    </div>

    <header class="auth-header">
        <a href="../index.php" class="logo">Senac <strong>Reservas</strong></a>
    </header>

    <div class="auth-wrapper">
        <div class="glass-panel auth-panel" data-tilt data-tilt-max="1">
            <h2>Acessar Plataforma</h2>
            <form action="processa_login.php" method="post" style="text-align: left;">
                <div class="glass-form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="glass-form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            <p class="auth-switch">Não tem uma conta? <a href="registro.php">Cadastre-se</a></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.3/vanilla-tilt.min.js"></script>
    <script>
        gsap.to("#blob1", { duration: 15, repeat: -1, yoyo: true, ease: "sine.inOut", x: "-=200", y: "+=150", rotation: 90, transformOrigin: "50% 50%" });
        gsap.to("#blob2", { duration: 12, repeat: -1, yoyo: true, ease: "sine.inOut", x: "+=150", y: "-=200", rotation: -90, transformOrigin: "50% 50%" });

        const cursor = document.querySelector('.cursor');
        const interactiveElements = document.querySelectorAll('a, button, .btn, .glass-panel');
        window.addEventListener('mousemove', (e) => {
            gsap.to(cursor, { duration: 0.3, x: e.clientX, y: e.clientY, ease: 'power3.out' });
        });
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('cursor-grow'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('cursor-grow'));
        });

        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), { max: 1, speed: 400, glare: true, "max-glare": 0.5 });

        // Animação de entrada do painel de login
        gsap.to('.auth-panel', {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: 'power3.out',
            delay: 0.2
        });
    </script>
</body>
</html>
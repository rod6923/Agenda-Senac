<?php 
// O header já inicia a sessão, conecta ao DB e busca a foto
include 'includes/header.php'; 
?>

<title>Solicitar Reserva - Senac Reservas</title>

<h1 class="page-title">Solicitar Reserva de Auditório</h1>

<div class="glass-panel" >
    <form action="processa_reserva.php" method="post">
        <div class="glass-form-group">
            <label>Título do Evento:</label>
            <input type="text" name="titulo" required>
        </div>
        <div class="glass-form-group">
            <label>Descrição:</label>
            <textarea name="descricao" rows="4"></textarea>
        </div>
        
        <!-- **** NOVO SELETOR DE URGÊNCIA **** -->
        <div class="glass-form-group">
            <label>Nível de Urgência:</label>
            <div class="urgency-selector">
                <div class="urgency-option">
                    <input type="radio" id="urgencia-baixa" name="urgencia" value="Baixa">
                    <label for="urgencia-baixa" title="Baixa"></label>
                    <span>Baixa</span>
                </div>
                <div class="urgency-option">
                    <input type="radio" id="urgencia-media" name="urgencia" value="Media">
                    <label for="urgencia-media" title="Média"></label>
                    <span>Média</span>
                </div>
                <div class="urgency-option">
                    <input type="radio" id="urgencia-alta" name="urgencia" value="Alta">
                    <label for="urgencia-alta" title="Alta"></label>
                    <span>Alta</span>
                </div>
            </div>
        </div>
        
        <div class="glass-form-group">
            <label>Data do Evento:</label>
            <input type="date" name="data_evento" required>
        </div>
        <div class="form-group-inline">
            <div class="glass-form-group">
                <label>Hora de Início:</label>
                <select name="hora_inicio" required>
                    <?php for ($h = 7; $h <= 21; $h++): ?>
                        <option value="<?php echo sprintf('%02d', $h); ?>"><?php echo sprintf('%02d:00', $h); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="glass-form-group">
                <label>Hora de Fim:</label>
                <select name="hora_fim" required>
                    <?php for ($h = 8; $h <= 22; $h++): ?>
                        <option value="<?php echo sprintf('%02d', $h); ?>"><?php echo sprintf('%02d:00', $h); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Solicitação</button>
    </form>
</div>

<?php 
if (file_exists('includes/footer.php')) {
    include 'includes/footer.php';
}
?>

<!-- Frameworks e Scripts de Interatividade -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.3/vanilla-tilt.min.js"></script>

<script>
    // --- SCRIPTS GLOBAIS DA APLICAÇÃO ---
    gsap.to("#blob1", { duration: 15, repeat: -1, yoyo: true, ease: "sine.inOut", x: "-=200", y: "+=150", rotation: 90, transformOrigin: "50% 50%" });
    gsap.to("#blob2", { duration: 12, repeat: -1, yoyo: true, ease: "sine.inOut", x: "+=150", y: "-=200", rotation: -90, transformOrigin: "50% 50%" });

    const cursor = document.querySelector('.cursor');
    const interactiveElements = document.querySelectorAll('a, button, .btn, .glass-panel, .occupied, .profile-pic-upload-wrapper, .urgency-option label');

    window.addEventListener('mousemove', (e) => {
        gsap.to(cursor, { duration: 0.3, x: e.clientX, y: e.clientY, ease: 'power3.out' });
    });

    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', () => cursor.classList.add('cursor-grow'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('cursor-grow'));
    });

    VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
        max: 3,
        speed: 400,
        glare: true,
        "max-glare": 0.5
    });
</script>

</body>
</html>
</main>

    <!-- Frameworks (via CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.3/vanilla-tilt.min.js"></script>

    <script>
        // Registra o plugin ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        // --- 1. Animação das bolhas ---
        gsap.to("#blob1", { duration: 15, repeat: -1, yoyo: true, ease: "sine.inOut", x: "-=200", y: "+=150", rotation: 90, transformOrigin: "50% 50%" });
        gsap.to("#blob2", { duration: 12, repeat: -1, yoyo: true, ease: "sine.inOut", x: "+=150", y: "-=200", rotation: -90, transformOrigin: "50% 50%" });

        // --- 2. Lógica do cursor personalizado ---
        const cursor = document.querySelector('.cursor');
        const interactiveElements = document.querySelectorAll('a, button, .btn, .glass-panel, .occupied, .profile-pic-upload-wrapper');
        window.addEventListener('mousemove', (e) => {
            gsap.to(cursor, { duration: 0.3, x: e.clientX, y: e.clientY, ease: 'power3.out' });
        });
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('cursor-grow'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('cursor-grow'));
        });

        // --- 3. Inicialização do Vanilla-Tilt ---
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 3, 
            speed: 400, 
            glare: true, 
            "max-glare": 0.5
        });

        // --- 4. ANIMAÇÕES DE ENTRADA CORRIGIDAS ---
        
        // Anima o título da página PARA o estado final
        gsap.to('.page-title', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out',
            delay: 0.2
        });
        
        // Anima cada painel de vidro PARA o estado final quando ele entra na tela
        gsap.utils.toArray('.glass-panel').forEach(panel => {
            gsap.to(panel, {
                scrollTrigger: {
                    trigger: panel,
                    start: "top 90%",
                    toggleActions: "play none none none"
                },
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out'
            });
        });
    </script>
</body>
</html>
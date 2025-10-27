document.addEventListener('DOMContentLoaded', () => {

    gsap.registerPlugin(ScrollTrigger);

    // --- 1. LÓGICA DO CURSOR CUSTOMIZADO ---
    const cursor = document.querySelector('.cursor');
    const interactiveElements = document.querySelectorAll('a, button, .btn, .glass-card');

    window.addEventListener('mousemove', (e) => {
        gsap.to(cursor, { duration: 0.3, x: e.clientX, y: e.clientY, ease: 'power3.out' });
    });

    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', () => cursor.classList.add('cursor-grow'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('cursor-grow'));
    });

    // --- 2. ANIMAÇÃO DAS BOLHAS (BLOBS) ---
    gsap.to("#blob1", { duration: 15, repeat: -1, yoyo: true, ease: "sine.inOut", x: "-=200", y: "+=150", rotation: 90, transformOrigin: "50% 50%" });
    gsap.to("#blob2", { duration: 12, repeat: -1, yoyo: true, ease: "sine.inOut", x: "+=150", y: "-=200", rotation: -90, transformOrigin: "50% 50%" });

    // --- 3. ANIMAÇÕES DE ENTRADA DA PÁGINA ---
    const tl = gsap.timeline({ defaults: { ease: "power4.out" } });

    tl.from('.title-line h1', { y: 120, duration: 1.2, stagger: 0.1 })
      .to('.hero-content p', { y: 0, opacity: 1, duration: 1 }, "-=1.0")
      .to('.hero-content .btn-primary', { y: 0, opacity: 1, duration: 1 }, "-=0.8");

    gsap.utils.toArray('.glass-card').forEach(card => {
        gsap.to(card, {
            scrollTrigger: { trigger: card, start: "top 85%", toggleActions: "play none none none" },
            opacity: 1, y: 0, duration: 1, ease: "power4.out"
        });
    });

    // --- 4. INICIALIZAÇÃO DO VANILLA-TILT.JS ---
    // Agora inicializa apenas nos elementos que ainda têm o atributo data-tilt
    VanillaTilt.init(document.querySelectorAll("[data-tilt]"), { glare: true, "max-glare": 0.2 });

    // --- 5. LÓGICA DO BOTÃO MAGNÉTICO ---
    const magneticButton = document.querySelector('.hero-content .btn');
    const buttonText = magneticButton.querySelector('span');

    magneticButton.addEventListener('mousemove', (e) => {
        const rect = magneticButton.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;

        // Anima o botão para seguir o cursor
        gsap.to(magneticButton, {
            x: x * 0.4,
            y: y * 0.4,
            duration: 0.6,
            ease: 'power3.out'
        });

        // Anima o texto para um efeito parallax sutil
        gsap.to(buttonText, {
            x: x * 0.4,
            y: y * 0.4,
            duration: 0.7,
            ease: 'power3.out'
        });
    });

    magneticButton.addEventListener('mouseleave', () => {
        // Anima o botão e o texto de volta à posição original com um efeito elástico
        gsap.to([magneticButton, buttonText], {
            x: 0,
            y: 0,
            duration: 1,
            ease: 'elastic.out(1, 0.3)'
        });
    });
});
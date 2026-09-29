// Dark mode toggle
const themeToggle = document.getElementById('theme-toggle');
const html = document.documentElement;

// Load saved theme or default to dark
const saved = localStorage.getItem('theme') || 'dark';
html.classList.toggle('dark', saved === 'dark');
updateToggleIcon(saved);

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const isDark = html.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateToggleIcon(isDark ? 'dark' : 'light');
    });
}

function updateToggleIcon(mode) {
    const sunIcon  = document.getElementById('icon-sun');
    const moonIcon = document.getElementById('icon-moon');
    if (!sunIcon || !moonIcon) return;
    sunIcon.classList.toggle('hidden', mode === 'dark');
    moonIcon.classList.toggle('hidden', mode === 'light');
}

// Mobile menu
const menuBtn  = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

// Scroll reveal
const revealEls = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window) {
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.1 });
    revealEls.forEach(el => obs.observe(el));
} else {
    revealEls.forEach(el => el.classList.add('visible'));
}

// Skill bars
const bars = document.querySelectorAll('.skill-bar-fill[data-width]');
if ('IntersectionObserver' in window) {
    const barObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                setTimeout(() => { e.target.style.width = e.target.dataset.width + '%'; }, 200);
                barObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.3 });
    bars.forEach(b => { b.style.width = '0%'; barObs.observe(b); });
}

// Typed hero text
const typedEl = document.getElementById('typed-text');
if (typedEl) {
    const phrases = [
        'Front-End Developer',
        'Graphic Designer',
        'Information Systems Student',
        'UI Enthusiast',
    ];
    let pi = 0, ci = 0, deleting = false;
    const type = () => {
        const cur = phrases[pi];
        typedEl.textContent = deleting ? cur.slice(0, --ci) : cur.slice(0, ++ci);
        if (!deleting && ci === cur.length) { setTimeout(() => { deleting = true; type(); }, 1800); return; }
        if (deleting && ci === 0) { deleting = false; pi = (pi + 1) % phrases.length; }
        setTimeout(type, deleting ? 45 : 80);
    };
    setTimeout(type, 800);
}

// Counter animation
document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    const duration = 1500;
    const start = performance.now();
    const update = (now) => {
        const p = Math.min((now - start) / duration, 1);
        el.textContent = Math.round(p * target);
        if (p < 1) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
});

// Navbar scroll effect
const header = document.getElementById('main-header');
if (header) {
    window.addEventListener('scroll', () => {
        header.classList.toggle('bg-dark-900/95', window.scrollY > 20);
        header.classList.toggle('backdrop-blur-xl', window.scrollY > 20);
        header.classList.toggle('border-b', window.scrollY > 20);
        header.classList.toggle('border-white/5', window.scrollY > 20);
    }, { passive: true });
}

// Back to top
const btt = document.getElementById('back-to-top');
if (btt) {
    window.addEventListener('scroll', () => {
        btt.classList.toggle('opacity-0', window.scrollY < 400);
        btt.classList.toggle('pointer-events-none', window.scrollY < 400);
    }, { passive: true });
    btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

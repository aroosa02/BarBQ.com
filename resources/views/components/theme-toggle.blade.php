<button id="themeToggle" class="btn btn-outline-secondary btn-sm" aria-label="Toggle theme">
    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
</button>

<script>
    (function () {
        const btn = document.getElementById('themeToggle');
        const icon = document.getElementById('themeIcon');

        function syncIcon() {
            const t = document.documentElement.getAttribute('data-bs-theme');
            icon.className = t === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        }

        syncIcon();

        btn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('barbq-theme', next);
            syncIcon();
        });
    })();
</script>
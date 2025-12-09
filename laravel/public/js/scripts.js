// Minimal UI logic: mobile nav, demo auth handling (uses localStorage for demo)

document.addEventListener('DOMContentLoaded', function () {
    initNavToggle();
    renderAuthState();
});

function initNavToggle() {
    const toggle = document.querySelector('.nav-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    if (!toggle || !mobileNav) return;
    toggle.addEventListener('click', () => {
        mobileNav.style.display = mobileNav.style.display === 'block' ? 'none' : 'block';
    });
    document.addEventListener('click', (e) => {
        if (!mobileNav.contains(e.target) && !toggle.contains(e.target)) {
            mobileNav.style.display = 'none';
        }
    });
}

function renderAuthState() {
    const raw = localStorage.getItem('bsa_user');
    const container = document.querySelector('.header-auth-target');
    if (!container) return;
    if (raw) {
        const user = JSON.parse(raw);
        container.innerHTML = `
            <div style="position:relative;">
                <div class="user-avatar" id="header-user">
                    <img src="${user.avatar}" alt="${user.name}">
                    <span class="text-secondary">${user.name}</span>
                </div>
                <div class="user-menu" id="user-menu" style="display:none; position:absolute; right:0; top:48px; background:#0b0b0b; border:1px solid #222; padding:10px; border-radius:6px; min-width:150px;">
                    <a href="/profile" style="display:block; padding:8px 0; color:var(--color-text-primary);">Профиль</a>
                    <a href="#" id="logout-link" style="display:block; padding:8px 0; color:var(--color-text-secondary);">Выйти</a>
                </div>
            </div>
        `;
        const headerUser = document.getElementById('header-user');
        const userMenu = document.getElementById('user-menu');
        headerUser?.addEventListener('click', (ev) => {
            ev.stopPropagation();
            userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', () => {
            if (userMenu) userMenu.style.display = 'none';
        });
        document.getElementById('logout-link')?.addEventListener('click', (ev) => {
            ev.preventDefault();
            localStorage.removeItem('bsa_user');
            renderAuthState();
            fetch('/auth/logout', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }).catch(()=>{});
        });
    } else {
        container.innerHTML = `
            <a class="btn ghost" href="/login">Войти</a>
            <a class="btn primary" href="/register">Регистрация</a>
        `;
    }
}

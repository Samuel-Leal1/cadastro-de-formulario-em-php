<?php
require_once __DIR__ . '/auth.php';
requireLogin();
?>
<nav class="navbar">
    <div class="navbar-brand">
        &#128100; Cadastro de Funcionários
    </div>
    <div class="navbar-links">
        <a href="dashboard.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">Início</a>
        <a href="listagem.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'listagem.php' ? 'active' : '' ?>">Listagem</a>
    </div>
    <div class="navbar-user">
        <div class="user-dropdown" id="userDropdown">
            <span>Olá, <?= htmlspecialchars(getAdminName()) ?></span>
            <span class="dropdown-arrow">&#9660;</span>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="logout.php">Sair</a>
            </div>
        </div>
    </div>
</nav>

<script>
    const dropdown = document.getElementById('userDropdown');
    const menu = document.getElementById('dropdownMenu');
    let hideTimer;

    dropdown.addEventListener('mouseenter', () => {
        clearTimeout(hideTimer);
        menu.style.display = 'block';
    });

    dropdown.addEventListener('mouseleave', () => {
        hideTimer = setTimeout(() => {
            menu.style.display = 'none';
        }, 300);
    });

    menu.addEventListener('mouseenter', () => {
        clearTimeout(hideTimer);
    });

    menu.addEventListener('mouseleave', () => {
        hideTimer = setTimeout(() => {
            menu.style.display = 'none';
        }, 300);
    });
</script>

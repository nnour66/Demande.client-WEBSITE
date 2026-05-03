<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NnourArena</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js" defer></script>
    <script src="/assets/js/form-message.js" defer></script>
    <script src="/assets/js/profile-menu.js" defer></script>
</head>
<body data-theme="dark">

    <header class="site-header">
        <nav class="main-nav" aria-label="Navigation principale">
            <a href="/index.php" class="site-brand" aria-label="Retour à l'accueil GameArena">
                <img
                    src="/assets/img/logo-tournoi.svg"
                    alt="Logo GameArena"
                    class="site-logo"
                >
            </a>

            <ul class="nav-actions">
                <?php if (isset($_SESSION['username'])) : ?>
                    <li class="nav-item profile-menu-item">
                        <button class="profile-trigger" id="profileToggle" type="button" aria-expanded="false">
                            <span class="profile-avatar">
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            </span>

                            <span class="profile-meta">
                                <span class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <span class="profile-subtext">Connecté</span>
                            </span>

                            <span class="profile-caret">▾</span>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="profile-dropdown-header">
                                <span class="profile-dropdown-avatar">
                                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                                </span>

                                <div class="profile-dropdown-info">
                                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                                    <span><?php echo htmlspecialchars($_SESSION['email'] ?? 'Utilisateur'); ?></span>
                                </div>
                            </div>

                            <div class="profile-dropdown-links">
                                <a href="/profil.php">Mon profil</a>
                                <a href="/edit-profil.php">Modifier mes informations</a>
                                <?php if ($_SESSION['username'] === 'admin') : ?>
                                    <a href="/admin.php">Panel Admin</a>
                                <?php endif; ?>
                                <a href="/logout.php" class="danger-link">Déconnexion</a>
                            </div>
                        </div>
                    </li>
                <?php else : ?>
    <li class="nav-item">
        <a href="login.php" class="login-btn" aria-label="Se connecter">
            <span class="profile-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4 20c2-4 6-5 8-5s6 1 8 5"></path>
                </svg>
            </span>
        </a>
    </li>
<?php endif; ?>

                <li class="nav-item">
                    <button class="theme-btn" id="themeToggle" type="button" aria-label="Changer le thème">
                        <span class="theme-icon theme-icon-moon" id="themeIconMoon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"></path>
                            </svg>
                        </span>

                        <span class="theme-icon theme-icon-sun" id="themeIconSun">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2"></path>
                                <path d="M12 20v2"></path>
                                <path d="M4.93 4.93l1.41 1.41"></path>
                                <path d="M17.66 17.66l1.41 1.41"></path>
                                <path d="M2 12h2"></path>
                                <path d="M20 12h2"></path>
                                <path d="M4.93 19.07l1.41-1.41"></path>
                                <path d="M17.66 6.34l1.41-1.41"></path>
                            </svg>
                        </span>
                    </button>
                </li>
            </ul>
        </nav>

        <section class="hero-banner" aria-label="Présentation du site">
            <p class="hero-kicker" data-i18n="heroKicker">Tournois gaming • compétitions • e-sport</p>
            <h1 class="hero-title">NnourArena</h1>
        </section>
    </header>
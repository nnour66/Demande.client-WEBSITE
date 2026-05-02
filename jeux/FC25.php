<?php
include '../includes/header.php';
?>

<main class="home-main">

    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">FC 25</h1>
            <p class="tournament-subtitle">La simulation de football la plus populaire au monde</p>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                La série FIFA, devenue EA Sports FC en 2023, existe depuis 1993. Après 30 ans
                de partenariat avec la FIFA, EA Sports décide de voler de ses propres ailes et
                lance EA Sports FC 24 puis FC 25. La licence change mais l'expérience reste
                la même : des milliers de joueurs réels, les plus grands championnats du monde
                et un mode Ultimate Team devenu un phénomène à part entière dans le monde
                de l'e-sport.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                FC 25 est un jeu de simulation football en 1v1. Chaque joueur contrôle
                une équipe de 11 joueurs et tente de marquer plus de buts que son adversaire
                en 2 mi-temps de 6 minutes (temps de jeu accéléré). Le nouveau système
                FC IQ introduit une intelligence tactique avancée pour chaque joueur sur le terrain.
            </p>
            <ul class="tournament-tips">
                <li>Maîtrisez les nouvelles mécaniques de dribble et de tir</li>
                <li>Construisez une équipe équilibrée avec une bonne chimie</li>
                <li>Adaptez votre tactique selon l'adversaire</li>
                <li>Profitez des phases arrêtées : corners et coups francs</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li>
                    <span class="rule-number">01</span>
                    <span class="rule-text">Format 1v1, chaque joueur choisit sa propre équipe</span>
                </li>
                <li>
                    <span class="rule-number">02</span>
                    <span class="rule-text">Matchs en 2 manches — en cas d'égalité, tirs au but</span>
                </li>
                <li>
                    <span class="rule-number">03</span>
                    <span class="rule-text">Difficulté : Légendaire, temps de jeu 6 minutes par mi-temps</span>
                </li>
                <li>
                    <span class="rule-number">04</span>
                    <span class="rule-text">Aucune équipe nationale, clubs uniquement</span>
                </li>
                <li>
                    <span class="rule-number">05</span>
                    <span class="rule-text">Tout glitch ou exploitation de bug entraîne une disqualification</span>
                </li>
            </ul>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Prizes & Récompenses</h2>
            <div class="prizes-grid">
                <div class="prize-card prize-card--gold">
                    <span class="prize-place">1er</span>
                    <span class="prize-trophy">🥇</span>
                    <span class="prize-reward">500 €</span>
                    <span class="prize-label">+ Trophée GameArena</span>
                </div>
                <div class="prize-card prize-card--silver">
                    <span class="prize-place">2ème</span>
                    <span class="prize-trophy">🥈</span>
                    <span class="prize-reward">200 €</span>
                    <span class="prize-label">+ Médaille GameArena</span>
                </div>
                <div class="prize-card prize-card--bronze">
                    <span class="prize-place">3ème</span>
                    <span class="prize-trophy">🥉</span>
                    <span class="prize-reward">100 €</span>
                    <span class="prize-label">+ Médaille GameArena</span>
                </div>
            </div>
        </div>
    </section>

    <section class="tournament-cta">
        <div class="tournament-section-inner">
            <h2 class="tournament-cta-title">Prêt à participer ?</h2>
            <p class="tournament-cta-text">Inscrivez-vous dès maintenant et affrontez les meilleurs joueurs.</p>
            <a href="../register.php" class="tournament-cta-btn">S'inscrire au tournoi</a>
        </div>
    </section>

</main>

<?php
include '../includes/footer.php';
?>
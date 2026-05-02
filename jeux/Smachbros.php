<?php
include '../includes/header.php';
?>

<main class="home-main">

    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">Super Smash Bros</h1>
            <p class="tournament-subtitle">Le jeu de combat le plus iconique de Nintendo</p>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                Super Smash Bros est créé par Masahiro Sakurai et lancé en 1999 sur Nintendo 64.
                Contrairement aux jeux de combat classiques, l'objectif n'est pas de vider
                une barre de vie mais d'éjecter les adversaires hors de l'arène. Super Smash Bros
                Ultimate, sorti en 2018 sur Switch, rassemble plus de 80 personnages issus
                de nombreuses franchises et est considéré comme le crossover ultime du jeu vidéo.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Chaque joueur choisit un personnage parmi plus de 80 disponibles et affronte
                ses adversaires sur des arènes variées. Plus votre pourcentage de dégâts est élevé,
                plus vous êtes projeté loin lors d'un coup. L'objectif est d'envoyer vos
                adversaires hors des limites de la scène pour leur faire perdre des vies.
            </p>
            <ul class="tournament-tips">
                <li>Maîtrisez un ou deux personnages plutôt que de tout essayer</li>
                <li>Apprenez à edgeguard pour empêcher les retours adverses</li>
                <li>Le shield et le parry sont essentiels en défense</li>
                <li>Gérez votre pourcentage : jouez plus prudemment à haut %</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li>
                    <span class="rule-number">01</span>
                    <span class="rule-text">Format 1v1, 3 stocks, 8 minutes par match</span>
                </li>
                <li>
                    <span class="rule-number">02</span>
                    <span class="rule-text">Stages légaux uniquement : Battlefield, Final Destination, Smashville, Town & City, Pokémon Stadium 2</span>
                </li>
                <li>
                    <span class="rule-number">03</span>
                    <span class="rule-text">Objets désactivés — compétition pure</span>
                </li>
                <li>
                    <span class="rule-number">04</span>
                    <span class="rule-text">Le perdant choisit le stage suivant parmi les stages légaux</span>
                </li>
                <li>
                    <span class="rule-number">05</span>
                    <span class="rule-text">Tout stalling intentionnel entraîne un avertissement puis disqualification</span>
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
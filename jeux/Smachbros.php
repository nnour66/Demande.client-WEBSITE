<?php
include '../includes/header.php';
?>

<main class="home-main">

    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">Super Smash Bros</h1>
            <p class="tournament-subtitle">Le jeu de combat iconique de Nintendo</p>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                Créé par Masahiro Sakurai, Smash Bros révolutionne le jeu de combat
                avec un système basé sur l’éjection des adversaires.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Augmentez le pourcentage de dégâts de vos adversaires pour les éjecter
                hors de l’arène.
            </p>
            <ul class="tournament-tips">
                <li>Maîtrisez votre personnage</li>
                <li>Utilisez le shield et le parry</li>
                <li>Apprenez les combos</li>
                <li>Edgeguard efficacement</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li><span class="rule-number">01</span><span class="rule-text">1v1, 3 stocks</span></li>
                <li><span class="rule-number">02</span><span class="rule-text">8 minutes</span></li>
                <li><span class="rule-number">03</span><span class="rule-text">Stages légaux uniquement</span></li>
                <li><span class="rule-number">04</span><span class="rule-text">Objets désactivés</span></li>
                <li><span class="rule-number">05</span><span class="rule-text">Pas de stalling</span></li>
            </ul>
        </div>
    </section>

    <section class="tournament-cta">
        <div class="tournament-section-inner">

            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="../team.php" class="tournament-cta-btn">Créer ou rejoindre une équipe</a>
            <?php else : ?>
                <a href="../login.php" class="tournament-cta-btn">Se connecter pour s'inscrire</a>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php include '../includes/footer.php'; ?>
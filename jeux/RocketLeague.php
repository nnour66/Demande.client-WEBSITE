<?php
include '../includes/header.php';
?>

<main class="home-main">

    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">Rocket League</h1>
            <p class="tournament-subtitle">Du football avec des voitures propulsées par des fusées</p>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                Rocket League est développé par Psyonix et sorti en 2015.
                Le jeu devient rapidement un succès e-sport et passe en free-to-play en 2020.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Deux équipes s'affrontent pour marquer des buts avec des voitures.
                Les matchs durent 5 minutes avec prolongation si nécessaire.
            </p>
            <ul class="tournament-tips">
                <li>Gérez votre boost</li>
                <li>Respectez les rotations</li>
                <li>Travaillez les aériennes</li>
                <li>Anticipez les actions</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li><span class="rule-number">01</span><span class="rule-text">Format 3v3</span></li>
                <li><span class="rule-number">02</span><span class="rule-text">Best-of-3</span></li>
                <li><span class="rule-number">03</span><span class="rule-text">5 minutes par match</span></li>
                <li><span class="rule-number">04</span><span class="rule-text">Aucune modification autorisée</span></li>
                <li><span class="rule-number">05</span><span class="rule-text">Présence 10 min avant</span></li>
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
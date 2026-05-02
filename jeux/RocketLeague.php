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
                Rocket League est développé par Psyonix et lancé en 2015. Le concept est simple :
                du football avec des voitures capables de voler. Le jeu devient rapidement
                un phénomène e-sport mondial. En 2019, Epic Games rachète Psyonix et rend
                le jeu free-to-play en 2020, faisant exploser sa communauté à plusieurs
                dizaines de millions de joueurs actifs.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Deux équipes de 1 à 3 joueurs s'affrontent pour marquer des buts avec
                une énorme balle en utilisant leurs voitures. Le boost est la ressource
                clé du jeu : il permet d'accélérer, de sauter plus haut et d'effectuer
                des frappes aériennes spectaculaires. Les matchs durent 5 minutes.
            </p>
            <ul class="tournament-tips">
                <li>Gérez votre boost en permanence, ramassez les pads au sol</li>
                <li>La rotation en équipe est fondamentale — ne soyez jamais deux au même endroit</li>
                <li>Apprenez les frappes aériennes pour surprendre l'adversaire</li>
                <li>Défendez intelligemment : anticipez plutôt que réagir</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li>
                    <span class="rule-number">01</span>
                    <span class="rule-text">Format 3v3, équipes de 3 joueurs</span>
                </li>
                <li>
                    <span class="rule-number">02</span>
                    <span class="rule-text">Matchs en best-of-3, finale en best-of-5</span>
                </li>
                <li>
                    <span class="rule-number">03</span>
                    <span class="rule-text">Temps de jeu : 5 minutes, prolongations en cas d'égalité</span>
                </li>
                <li>
                    <span class="rule-number">04</span>
                    <span class="rule-text">Aucun plug-in ou modification du client de jeu autorisé</span>
                </li>
                <li>
                    <span class="rule-number">05</span>
                    <span class="rule-text">Les équipes doivent être en salle 10 minutes avant le match</span>
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
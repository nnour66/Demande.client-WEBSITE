<?php
include '../includes/header.php';
?>

<main class="home-main">

    <!-- ===== HERO DU JEU ===== -->
    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">Counter-Strike 2</h1>
            <p class="tournament-subtitle">Le FPS tactique le plus compétitif au monde</p>
        </div>
    </section>

    <!-- ===== HISTOIRE ===== -->
    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                Counter-Strike est né en 1999 comme un mod de Half-Life créé par Minh Le et Jess Cliffe.
                Valve rachète le projet en 2000 et publie plusieurs versions jusqu'à CS:GO en 2012,
                qui devient l'un des jeux PC les plus joués au monde. En 2023, Valve lance
                Counter-Strike 2, une refonte complète sous le moteur Source 2, apportant
                des graphismes améliorés, une physique des fumigènes entièrement repensée
                et une expérience de jeu optimisée.
            </p>
        </div>
    </section>

    <!-- ===== COMMENT JOUER ===== -->
    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                CS2 oppose deux équipes de 5 joueurs : les Terroristes (T) et les
                Counter-Terroristes (CT). Les T doivent poser une bombe sur un site
                désigné ou éliminer tous les CT. Les CT doivent désamorcer la bombe
                ou éliminer tous les T. Chaque manche dure maximum 1 minute 55.
                Une partie se joue en 24 manches, la première équipe à en remporter
                13 gagne.
            </p>
            <ul class="tournament-tips">
                <li>Gérez votre économie pour acheter armes et équipements</li>
                <li>Communiquez avec votre équipe via le chat vocal</li>
                <li>Apprenez les spots et les angles de chaque carte</li>
                <li>Maîtrisez le recul de chaque arme</li>
            </ul>
        </div>
    </section>

    <!-- ===== RÈGLES DU TOURNOI ===== -->
    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li>
                    <span class="rule-number">01</span>
                    <span class="rule-text">Équipes de 5 joueurs + 1 remplaçant maximum</span>
                </li>
                <li>
                    <span class="rule-number">02</span>
                    <span class="rule-text">Format double élimination — pas de seconde chance après deux défaites</span>
                </li>
                <li>
                    <span class="rule-number">03</span>
                    <span class="rule-text">Maps jouées : Mirage, Inferno, Dust2, Nuke, Ancient</span>
                </li>
                <li>
                    <span class="rule-number">04</span>
                    <span class="rule-text">Aucun cheat, aucun bug exploit — disqualification immédiate</span>
                </li>
                <li>
                    <span class="rule-number">05</span>
                    <span class="rule-text">Les équipes doivent être connectées 15 minutes avant le match</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- ===== PRIZES ===== -->
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

    <!-- ===== CTA INSCRIPTION ===== -->
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
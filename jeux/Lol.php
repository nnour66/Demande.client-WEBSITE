<?php
include '../includes/header.php';
?>

<main class="home-main">

    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">League of Legends</h1>
            <p class="tournament-subtitle">Le MOBA le plus joué au monde depuis plus de 10 ans</p>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                League of Legends est développé par Riot Games et lancé en 2009. Inspiré du
                mod Warcraft III "Defense of the Ancients", il popularise le genre MOBA à
                l'échelle mondiale. Aujourd’hui, LoL est un pilier de l’e-sport avec des
                compétitions internationales suivies par des millions de spectateurs.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Deux équipes de 5 joueurs s'affrontent pour détruire le Nexus adverse.
                Chaque joueur incarne un champion avec un rôle spécifique : Top, Jungle,
                Mid, ADC ou Support.
            </p>
            <ul class="tournament-tips">
                <li>Maîtrisez quelques champions clés</li>
                <li>Contrôlez la vision avec les wards</li>
                <li>Jouez les objectifs : Dragon, Baron</li>
                <li>Coordonnez les teamfights</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li><span class="rule-number">01</span><span class="rule-text">Équipes de 5 joueurs</span></li>
                <li><span class="rule-number">02</span><span class="rule-text">Format Best-of-3</span></li>
                <li><span class="rule-number">03</span><span class="rule-text">Draft obligatoire (ban/pick)</span></li>
                <li><span class="rule-number">04</span><span class="rule-text">Serveur EUW</span></li>
                <li><span class="rule-number">05</span><span class="rule-text">Comportement toxique = disqualification</span></li>
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
                </div>
                <div class="prize-card prize-card--silver">
                    <span class="prize-place">2ème</span>
                    <span class="prize-trophy">🥈</span>
                    <span class="prize-reward">200 €</span>
                </div>
                <div class="prize-card prize-card--bronze">
                    <span class="prize-place">3ème</span>
                    <span class="prize-trophy">🥉</span>
                    <span class="prize-reward">100 €</span>
                </div>
            </div>
        </div>
    </section>

    <section class="tournament-cta">
        <div class="tournament-section-inner">
            <h2 class="tournament-cta-title">Prêt à participer ?</h2>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="../team.php" class="tournament-cta-btn">Créer ou rejoindre une équipe</a>
            <?php else : ?>
                <a href="../login.php" class="tournament-cta-btn">Se connecter pour s'inscrire</a>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php include '../includes/footer.php'; ?>
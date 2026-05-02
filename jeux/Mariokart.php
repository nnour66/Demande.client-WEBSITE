<?php
include '../includes/header.php';
?>

<main class="home-main">

    <section class="tournament-hero">
        <div class="tournament-hero-inner">
            <span class="intro-tag">Tournoi</span>
            <h1 class="tournament-title">Mario Kart</h1>
            <p class="tournament-subtitle">La course la plus chaotique et fun de l'histoire du jeu vidéo</p>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Histoire du jeu</h2>
            <p class="tournament-text">
                Super Mario Kart est lancé en 1992 sur Super Nintendo par Nintendo.
                La franchise devient rapidement l'une des plus emblématiques de Nintendo
                avec des dizaines de millions de copies vendues. Mario Kart 8 Deluxe,
                sorti sur Switch en 2017, reste à ce jour le jeu le plus vendu de la console
                avec plus de 60 millions d'exemplaires écoulés dans le monde.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Mario Kart est un jeu de course où 12 pilotes s'affrontent sur des circuits
                colorés et variés. Des objets apparaissent en course pour attaquer les adversaires
                ou se défendre. La position en course détermine la puissance des objets reçus :
                plus vous êtes loin derrière, plus vos objets sont puissants.
            </p>
            <ul class="tournament-tips">
                <li>Dérapez pour accumuler du boost dans les virages</li>
                <li>Utilisez les champignons sur les raccourcis hors-piste</li>
                <li>Conservez vos objets défensifs face aux concurrents proches</li>
                <li>Mémorisez les positions des objets sur chaque circuit</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li>
                    <span class="rule-number">01</span>
                    <span class="rule-text">Format Grand Prix — 4 courses par manche, points cumulés</span>
                </li>
                <li>
                    <span class="rule-number">02</span>
                    <span class="rule-text">150cc obligatoire, objets activés</span>
                </li>
                <li>
                    <span class="rule-number">03</span>
                    <span class="rule-text">Les circuits sont tirés au sort avant chaque Grand Prix</span>
                </li>
                <li>
                    <span class="rule-number">04</span>
                    <span class="rule-text">Chaque joueur utilise sa propre manette</span>
                </li>
                <li>
                    <span class="rule-number">05</span>
                    <span class="rule-text">En cas d'égalité de points, une course décisive est jouée</span>
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
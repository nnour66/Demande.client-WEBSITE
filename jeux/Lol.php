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
                l'échelle mondiale. Avec plus de 150 champions jouables et des millions de
                parties quotidiennes, LoL est devenu le pilier de l'e-sport mondial avec
                son Championnat du Monde diffusé dans des stades entiers chaque année.
            </p>
        </div>
    </section>

    <section class="tournament-section tournament-section--alt">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Comment jouer</h2>
            <p class="tournament-text">
                Deux équipes de 5 joueurs s'affrontent sur la carte Faille de l'Invocateur.
                L'objectif est de détruire le Nexus adverse. Chaque joueur choisit un champion
                avec des capacités uniques et occupe un rôle précis : Top, Jungle, Mid, ADC
                ou Support. La partie dure en moyenne 30 à 40 minutes.
            </p>
            <ul class="tournament-tips">
                <li>Maîtrisez un ou deux champions avant d'en explorer d'autres</li>
                <li>La vision (wards) est essentielle pour contrôler la carte</li>
                <li>Coordonnez les objectifs : Dragon, Baron Nashor</li>
                <li>Communiquez avec votre équipe pour organiser les teamfights</li>
            </ul>
        </div>
    </section>

    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Règles du tournoi</h2>
            <ul class="tournament-rules">
                <li>
                    <span class="rule-number">01</span>
                    <span class="rule-text">Équipes de 5 joueurs, format best-of-3 en phases de groupes</span>
                </li>
                <li>
                    <span class="rule-number">02</span>
                    <span class="rule-text">Phase de draft : ban/pick de champions obligatoire</span>
                </li>
                <li>
                    <span class="rule-number">03</span>
                    <span class="rule-text">Serveur EUW uniquement, ping maximum toléré : 80ms</span>
                </li>
                <li>
                    <span class="rule-number">04</span>
                    <span class="rule-text">Tout comportement toxique entraîne une disqualification immédiate</span>
                </li>
                <li>
                    <span class="rule-number">05</span>
                    <span class="rule-text">En cas de déconnexion dans les 5 premières minutes, remake autorisé</span>
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
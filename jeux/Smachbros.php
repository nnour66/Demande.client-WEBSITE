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
    <!-- ===== PLACES RESTANTES ===== -->
    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Disponibilité</h2>

            <?php
            require_once '../includes/db.php';
            $stmtT = $pdo->prepare("SELECT id, places FROM tournaments WHERE game = 'SmashBros' LIMIT 1");
            $stmtT->execute();
            $tournoi = $stmtT->fetch(PDO::FETCH_ASSOC);

            $stmtCount = $pdo->prepare("SELECT COUNT(*) as nb FROM teams WHERE tournament_id = ?");
            $stmtCount->execute([$tournoi['id']]);
            $nb_equipes      = $stmtCount->fetch(PDO::FETCH_ASSOC)['nb'];
            $places_restantes = $tournoi['places'] - $nb_equipes;
            $pct             = $tournoi['places'] > 0 ? round(($nb_equipes / $tournoi['places']) * 100) : 0;

            if ($pct >= 90)     $bar_class = 'full';
            elseif ($pct >= 60) $bar_class = 'warn';
            else                $bar_class = '';
            ?>

            <div class="availability-block">
                <div class="availability-numbers">
                    <div class="availability-stat">
                        <span class="availability-value"><?= $places_restantes ?></span>
                        <span class="availability-label">Places restantes</span>
                    </div>
                    <div class="availability-sep"></div>
                    <div class="availability-stat">
                        <span class="availability-value"><?= $nb_equipes ?></span>
                        <span class="availability-label">Équipes inscrites</span>
                    </div>
                    <div class="availability-sep"></div>
                    <div class="availability-stat">
                        <span class="availability-value"><?= $tournoi['places'] ?></span>
                        <span class="availability-label">Places totales</span>
                    </div>
                </div>

                <div class="availability-bar-wrap">
                    <div class="availability-bar">
                        <div class="availability-bar-fill <?= $bar_class ?>" style="width: <?= $pct ?>%"></div>
                    </div>
                    <span class="availability-bar-label"><?= $pct ?>% rempli</span>
                </div>

                <?php if ($places_restantes <= 0) : ?>
                    <p class="availability-status availability-status--full">Tournoi complet</p>
                <?php elseif ($pct >= 75) : ?>
                    <p class="availability-status availability-status--warn">⚠ Plus que <?= $places_restantes ?> place<?= $places_restantes > 1 ? 's' : '' ?> disponible<?= $places_restantes > 1 ? 's' : '' ?> !</p>
                <?php else : ?>
                    <p class="availability-status availability-status--open">✓ Inscriptions ouvertes</p>
                <?php endif; ?>
            </div>
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
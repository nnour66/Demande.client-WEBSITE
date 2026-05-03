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
    <!-- ===== PLACES RESTANTES ===== -->
    <section class="tournament-section">
        <div class="tournament-section-inner">
            <h2 class="tournament-section-title">Disponibilité</h2>

            <?php
            require_once '../includes/db.php';
            $stmtT = $pdo->prepare("SELECT id, places FROM tournaments WHERE game = 'RocketLeague' LIMIT 1");
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
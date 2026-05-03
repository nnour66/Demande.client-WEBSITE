<?php
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM tournaments");
$tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nb_tournois = count($tournaments);
$total_places = array_sum(array_column($tournaments, 'places'));

include 'includes/header.php';
?>

<div class="header-transition"></div>

<main class="home-main">

    <section class="home-intro" aria-labelledby="home-intro-title">
        <div class="intro-left">
            <p class="intro-tag" data-i18n="introTag">Tournoi e-sport</p>
            <h2 id="home-intro-title" class="intro-title">
                <span data-i18n="introTitle">Les Jeux</span>
            </h2>
            <p class="intro-text" data-i18n="introText">
                Prêt à prouver que tu es le boss du campus ? NnourArena rassemble les meilleurs jeux du moment pour des affrontements mémorables entre potes ou en solo. Du tryhard intense en équipe sur Rocket League et LoL, jusqu'aux fous rires (et crises de nerfs) sur Mario Kart et Smash Bros, il y en a pour tous les profils. Consulte les formats, vérifie les places restantes et sécurise ton inscription avant qu'il ne soit trop tard. Que le meilleur gagne !
            </p>
        </div>
    </section>

    <section class="games-showcase" id="jeux" aria-labelledby="games-title">
        <header class="section-head">
            <div class="section-head-left">
                <p class="section-tag" data-i18n="sectionTitle">Sélection principale</p>
                <h2 id="games-title" class="section-title" data-i18n="sectionTag">Jeux du tournoi</h2>
            </div>
        </header>

        <ul class="games-list">
            <?php foreach ($tournaments as $tournament):
                $places_total = (int) $tournament['places'];
                $places_prises = isset($tournament['places_prises']) ? (int) $tournament['places_prises'] : 0;
                $pct = $places_total > 0 ? round(($places_prises / $places_total) * 100) : 0;

                if ($pct >= 90) {
                    $bar_class = 'full';
                } elseif ($pct >= 60) {
                    $bar_class = 'warn';
                } else {
                    $bar_class = '';
                }

                $title = trim($tournament['title']);
                $game_link = '#';
                $title_i18n = '';

                if (stripos($title, 'LoL') === 0) {
                    $game_link = 'jeux/Lol.php';
                    $title_i18n = 'game1Title';
                } elseif (stripos($title, 'Mario Kart') === 0) {
                    $game_link = 'jeux/Mariokart.php';
                    $title_i18n = 'game2Title';
                } elseif (stripos($title, 'CS2') === 0) {
                    $game_link = 'jeux/CS2.php';
                    $title_i18n = 'game6Title';
                } elseif (stripos($title, 'Smash Bros') === 0) {
                    $game_link = 'jeux/Smachbros.php';
                    $title_i18n = 'game3Title';
                } elseif (stripos($title, 'FC 25') === 0) {
                    $game_link = 'jeux/FC25.php';
                    $title_i18n = 'game4Title';
                } elseif (stripos($title, 'Rocket League') === 0) {
                    $game_link = 'jeux/RocketLeague.php';
                    $title_i18n = 'game5Title';
                }
            ?>
                <li class="games-item">
                    <!-- ON ENGLOBE LA CARTE ICI -->
                    <a href="<?= htmlspecialchars($game_link) ?>" class="tournament-card-link">
                        <article class="game-card">

                            <figure class="game-media">
                                <img
                                    src="<?= htmlspecialchars($tournament['image']) ?>"
                                    alt="<?= htmlspecialchars($tournament['title']) ?>"
                                    class="game-image"
                                >
                            </figure>

                            <span class="game-date-badge" aria-label="Date du tournoi">
                                <?= htmlspecialchars($tournament['date']) ?>
                            </span>

                            <header class="game-card-header">
                                <p class="game-category" data-i18n="gameCategory">Tournoi</p>

                                <?php if ($title_i18n !== ''): ?>
                                    <h3 class="game-title" data-i18n="<?= htmlspecialchars($title_i18n) ?>">
                                        <?= htmlspecialchars($tournament['title']) ?>
                                    </h3>
                                <?php else: ?>
                                    <h3 class="game-title">
                                        <?= htmlspecialchars($tournament['title']) ?>
                                    </h3>
                                <?php endif; ?>
                            </header>

                            <p class="game-description">
                                <span class="game-places-number"><?= $places_total ?></span>
                                <span data-i18n="gameSlots">places disponibles</span>
                            </p>

                            <div class="game-card-sep"></div>

                            <div class="game-card-footer">
                                <!-- ANCIEN BOUTON <a> TRANSFORMÉ EN <span> -->
                                <span class="game-link" data-i18n="gameLink">
                                    Voir le tournoi
                                </span>

                                <div class="game-progress" aria-label="Places restantes">
                                    <div class="game-progress-bar">
                                        <div class="game-progress-fill <?= htmlspecialchars($bar_class) ?>" style="width: <?= $pct ?>%"></div>
                                    </div>
                                    <span class="game-progress-txt"><?= $places_total ?> pl.</span>
                                </div>
                            </div>

                        </article>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

</main>

<?php require_once 'includes/footer.php'; ?>
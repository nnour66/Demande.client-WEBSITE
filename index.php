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
            <p class="intro-tag">Tournoi e-sport</p>
            <h2 id="home-intro-title" class="intro-title">Les <span class="intro-title-accent">Jeux</span></h2>
            <p class="intro-text">
                Découvre les jeux disponibles sur GameArena, accède aux espaces de tournoi,
                consulte les formats de compétition et prépare-toi à entrer dans l'arène.
            </p>
        </div>
    </section>

    <section class="games-showcase" aria-labelledby="games-title">
        <header class="section-head">
            <div class="section-head-left">
                <p class="section-tag">Sélection principale</p>
                <h2 id="games-title" class="section-title">Jeux du tournoi</h2>
            </div>
            <div class="section-live" aria-label="Tournois en cours">
                <span class="live-dot" aria-hidden="true"></span>
                En cours
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

                if (stripos($title, 'LoL') === 0) {
                    $game_link = 'jeux/Lol.php';
                } elseif (stripos($title, 'Mario Kart') === 0) {
                    $game_link = 'jeux/Mariokart.php';
                } elseif (stripos($title, 'CS2') === 0) {
                    $game_link = 'jeux/CS2.php';
                } elseif (stripos($title, 'Smash Bros') === 0) {
                    $game_link = 'jeux/Smachbros.php';
                } elseif (stripos($title, 'FC 25') === 0) {
                    $game_link = 'jeux/FC25.php';
                } elseif (stripos($title, 'Rocket League') === 0) {
                    $game_link = 'jeux/RocketLeague.php';
                }
            ?>
                <li class="games-item">
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
                            <p class="game-category">Tournoi</p>
                            <h3 class="game-title"><?= htmlspecialchars($tournament['title']) ?></h3>
                        </header>

                        <p class="game-description">
                            <?= $places_total ?> places disponibles
                        </p>

                        <div class="game-card-sep"></div>

                        <div class="game-card-footer">
                            <a href="<?= htmlspecialchars($game_link) ?>" class="game-link">
                                Voir le tournoi →
                            </a>

                            <div class="game-progress" aria-label="Places restantes">
                                <div class="game-progress-bar">
                                    <div class="game-progress-fill <?= htmlspecialchars($bar_class) ?>" style="width: <?= $pct ?>%"></div>
                                </div>
                                <span class="game-progress-txt"><?= $places_total ?> pl.</span>
                            </div>
                        </div>

                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

</main>

<?php require_once 'includes/footer.php'; ?>    
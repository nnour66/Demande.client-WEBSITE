<?php
include '../includes/header.php';
require_once '../includes/db.php';

$success_msg = '';
$error_msg   = '';

// Récupérer l'id du tournoi Mario Kart
$stmtT = $pdo->prepare("SELECT id, places FROM tournaments WHERE game = 'MarioKart' LIMIT 1");
$stmtT->execute();
$tournoi = $stmtT->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscription_solo'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    $user_id       = $_SESSION['user_id'];
    $tournament_id = $tournoi['id'];

    // Vérifier si déjà inscrit
    $stmtCheck = $pdo->prepare("SELECT id FROM solo_registrations WHERE user_id = ? AND tournament_id = ?");
    $stmtCheck->execute([$user_id, $tournament_id]);

    if ($stmtCheck->fetch()) {
        $error_msg = "Tu es déjà inscrit à ce tournoi.";
    } else {
        // Vérifier les places restantes
        $stmtCount = $pdo->prepare("SELECT COUNT(*) as nb FROM solo_registrations WHERE tournament_id = ?");
        $stmtCount->execute([$tournament_id]);
        $nb = $stmtCount->fetch(PDO::FETCH_ASSOC)['nb'];

        if ($nb >= $tournoi['places']) {
            $error_msg = "Désolé, le tournoi est complet.";
        } else {
            $insert = $pdo->prepare("INSERT INTO solo_registrations (tournament_id, user_id) VALUES (?, ?)");
            $insert->execute([$tournament_id, $user_id]);
            $success_msg = "Ton inscription au tournoi Mario Kart est confirmée !";
        }
    }
}

// Places restantes
$stmtCount = $pdo->prepare("SELECT COUNT(*) as nb FROM solo_registrations WHERE tournament_id = ?");
$stmtCount->execute([$tournoi['id']]);
$inscrits        = $stmtCount->fetch(PDO::FETCH_ASSOC)['nb'];
$places_restantes = $tournoi['places'] - $inscrits;
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

    <!-- ===== CTA INSCRIPTION ===== -->
    <section class="tournament-cta">
        <div class="tournament-section-inner">
            <h2 class="tournament-cta-title">Prêt à participer ?</h2>
            
            <p class="tournament-cta-text">
                Inscrivez-vous dès maintenant et affrontez les meilleurs joueurs.<br>
                Places restantes : <strong><?= $places_restantes ?> / <?= $tournoi['places'] ?></strong>
            </p>

            <?php if (!empty($success_msg)) : ?>
                <div class="team-message success" style="max-width: 500px; margin: 0 auto 24px; color: #2ecc71; background: rgba(46, 204, 113, 0.2); padding: 15px; border-radius: 8px;">
                    ✓ <?= $success_msg ?>
                </div>
            <?php elseif (!empty($error_msg)) : ?>
                <div class="team-message error" style="max-width: 500px; margin: 0 auto 24px; color: #e74c3c; background: rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 8px;">
                    <?= $error_msg ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <?php if (empty($success_msg) && $places_restantes > 0) : ?>
                    <form method="POST" action="">
                        <button type="submit" name="inscription_solo" class="tournament-cta-btn" style="border: none; cursor: pointer;">
                            S'inscrire au tournoi
                        </button>
                    </form>
                <?php elseif ($places_restantes <= 0) : ?>
                    <p class="tournament-cta-text">Le tournoi est complet.</p>
                <?php endif; ?>
            <?php else : ?>
                <a href="../login.php" class="tournament-cta-btn">Se connecter pour s'inscrire</a>
            <?php endif; ?>

        </div>
    </section>

        </div>
    </section>

</main>

<?php include '../includes/footer.php'; ?>
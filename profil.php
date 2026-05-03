<?php
include 'includes/header.php';
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les infos de l'utilisateur
$stmtUser = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Récupérer les inscriptions solo
$stmtSolo = $pdo->prepare("
    SELECT t.title, t.date, t.game, 'solo' as type, sr.id as registration_id
    FROM solo_registrations sr
    JOIN tournaments t ON sr.tournament_id = t.id
    WHERE sr.user_id = ?
    ORDER BY t.date ASC
");
$stmtSolo->execute([$user_id]);
$soloTournaments = $stmtSolo->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les inscriptions en équipe
$stmtTeam = $pdo->prepare("
    SELECT t.title, t.date, t.game, 'team' as type,
           te.name as team_name,
           te.invite_code,
           te.captain_id,
           tm.id as registration_id,
           tm.team_id
    FROM team_members tm
    JOIN teams te ON tm.team_id = te.id
    JOIN tournaments t ON te.tournament_id = t.id
    WHERE tm.user_id = ?
    ORDER BY t.date ASC
");
$stmtTeam->execute([$user_id]);
$teamTournaments = $stmtTeam->fetchAll(PDO::FETCH_ASSOC);

// Traitement désinscription solo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unregister_solo'])) {
    $registration_id = (int)$_POST['registration_id'];
    $stmt = $pdo->prepare("DELETE FROM solo_registrations WHERE id = ? AND user_id = ?");
    $stmt->execute([$registration_id, $user_id]);
    header("Location: /profile.php");
    exit();
}

// Traitement désinscription équipe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unregister_team'])) {
    $team_id = (int)$_POST['team_id'];

    // Vérifier si capitaine
    $stmtCap = $pdo->prepare("SELECT captain_id FROM teams WHERE id = ?");
    $stmtCap->execute([$team_id]);
    $team = $stmtCap->fetch(PDO::FETCH_ASSOC);

    if ($team['captain_id'] == $user_id) {
        // Capitaine : supprimer toute l'équipe
        $pdo->prepare("DELETE FROM team_members WHERE team_id = ?")->execute([$team_id]);
        $pdo->prepare("DELETE FROM teams WHERE id = ?")->execute([$team_id]);
    } else {
        // Simple membre : juste se retirer
        $pdo->prepare("DELETE FROM team_members WHERE team_id = ? AND user_id = ?")->execute([$team_id, $user_id]);
    }

    header("Location: /profile.php");
    exit();
}
?>

<main class="home-main">

    <section class="home-intro login-intro">
        <span class="intro-tag">Mon espace</span>
        <h1 class="intro-title">Mon profil</h1>
        <p class="intro-text">Retrouvez vos informations et vos inscriptions aux tournois.</p>
    </section>

    <!-- ===== INFOS UTILISATEUR ===== -->
    <section class="profile-card-section">
        <div class="profile-card">
            <div class="profile-card-avatar">
                <?= strtoupper(substr($user['username'], 0, 1)) ?>
            </div>
            <div class="profile-card-info">
                <h2 class="profile-card-name"><?= htmlspecialchars($user['username']) ?></h2>
                <p class="profile-card-email"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <a href="/edit-profil.php" class="profile-card-edit">Modifier mes informations</a>
        </div>
    </section>

    <!-- ===== TOURNOIS ===== -->
    <section class="profile-tournaments-section">
        <h2 class="profile-section-title">Mes tournois</h2>

        <?php if (empty($soloTournaments) && empty($teamTournaments)) : ?>
            <div class="profile-empty">
                <p>Tu n'es inscrit à aucun tournoi pour le moment.</p>
                <a href="/index.php" class="tournament-cta-btn">Voir les tournois</a>
            </div>
        <?php else : ?>
            <div class="profile-tournaments-grid">

                <?php foreach ($soloTournaments as $t) : ?>
                    <div class="profile-tournament-card">
                        <div class="profile-tournament-top">
                            <span class="profile-tournament-badge solo">Solo</span>
                            <span class="profile-tournament-date"><?= date('d/m/Y', strtotime($t['date'])) ?></span>
                        </div>
                        <h3 class="profile-tournament-title"><?= htmlspecialchars($t['title']) ?></h3>
                        <p class="profile-tournament-status">✓ Inscrit</p>
                        <form method="POST" class="profile-unregister-form" onsubmit="return confirm('Se désinscrire de ce tournoi ?')">
                            <input type="hidden" name="registration_id" value="<?= $t['registration_id'] ?>">
                            <button type="submit" name="unregister_solo" class="profile-unregister-btn">Se désinscrire</button>
                        </form>
                    </div>
                <?php endforeach; ?>

                <?php foreach ($teamTournaments as $t) : ?>
                    <div class="profile-tournament-card">
                        <div class="profile-tournament-top">
                            <span class="profile-tournament-badge team">Équipe</span>
                            <span class="profile-tournament-date"><?= date('d/m/Y', strtotime($t['date'])) ?></span>
                        </div>
                        <h3 class="profile-tournament-title"><?= htmlspecialchars($t['title']) ?></h3>
                        <p class="profile-tournament-team">
                            <?= htmlspecialchars($t['team_name']) ?>
                            <?php if ($t['captain_id'] == $user_id) : ?>
                                <span class="profile-captain-badge">Capitaine</span>
                            <?php endif; ?>
                        </p>
                        <?php if ($t['captain_id'] == $user_id) : ?>
                            <p class="profile-invite-code">
                                Code : <span><?= $t['invite_code'] ?></span>
                            </p>
                        <?php endif; ?>
                        <p class="profile-tournament-status">✓ Inscrit</p>
                        <form method="POST" class="profile-unregister-form" onsubmit="return confirm('<?= $t['captain_id'] == $user_id ? 'Tu es capitaine, cela supprimera toute l\'équipe. Continuer ?' : 'Se désinscrire de cette équipe ?' ?>')">
                            <input type="hidden" name="team_id" value="<?= $t['team_id'] ?>">
                            <button type="submit" name="unregister_team" class="profile-unregister-btn">
                                <?= $t['captain_id'] == $user_id ? 'Dissoudre l\'équipe' : 'Quitter l\'équipe' ?>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header("Location: /index.php");
    exit();
}

$success_msg = '';
$error_msg   = '';

// ── Supprimer un utilisateur ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $target_id = (int)$_POST['user_id'];

    if ($target_id === (int)$_SESSION['user_id']) {
        $error_msg = "Tu ne peux pas supprimer le compte admin.";
    } else {
        $pdo->prepare("DELETE FROM solo_registrations WHERE user_id = ?")->execute([$target_id]);

        $stmtCap = $pdo->prepare("SELECT id FROM teams WHERE captain_id = ?");
        $stmtCap->execute([$target_id]);
        $captainTeams = $stmtCap->fetchAll(PDO::FETCH_ASSOC);
        foreach ($captainTeams as $team) {
            $pdo->prepare("DELETE FROM team_members WHERE team_id = ?")->execute([$team['id']]);
            $pdo->prepare("DELETE FROM teams WHERE id = ?")->execute([$team['id']]);
        }

        $pdo->prepare("DELETE FROM team_members WHERE user_id = ?")->execute([$target_id]);
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$target_id]);

        $success_msg = "Utilisateur supprimé avec succès.";
    }
}

// ── Supprimer une équipe complète ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_team'])) {
    $team_id = (int)$_POST['team_id'];
    $pdo->prepare("DELETE FROM team_members WHERE team_id = ?")->execute([$team_id]);
    $pdo->prepare("DELETE FROM teams WHERE id = ?")->execute([$team_id]);
    $success_msg = "Équipe supprimée avec succès.";
}

// ── Supprimer un membre d'une équipe ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_member'])) {
    $team_id = (int)$_POST['team_id'];
    $user_id = (int)$_POST['member_user_id'];

    // Vérifier que ce n'est pas le capitaine
    $stmtCap = $pdo->prepare("SELECT captain_id FROM teams WHERE id = ?");
    $stmtCap->execute([$team_id]);
    $team = $stmtCap->fetch(PDO::FETCH_ASSOC);

    if ($team['captain_id'] == $user_id) {
        $error_msg = "Tu ne peux pas supprimer le capitaine. Supprime l'équipe entière.";
    } else {
        $pdo->prepare("DELETE FROM team_members WHERE team_id = ? AND user_id = ?")->execute([$team_id, $user_id]);
        $success_msg = "Membre retiré de l'équipe.";
    }
}

// ── Ouvrir / Fermer un tournoi ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_tournament'])) {
    $tournament_id  = (int)$_POST['tournament_id'];
    $current_status = $_POST['current_status'];
    $new_status     = $current_status === 'open' ? 'closed' : 'open';
    $pdo->prepare("UPDATE tournaments SET status = ? WHERE id = ?")->execute([$new_status, $tournament_id]);
    $success_msg = "Statut du tournoi mis à jour.";
}

// ── Supprimer une inscription solo ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_solo_reg'])) {
    $reg_id = (int)$_POST['reg_id'];
    $pdo->prepare("DELETE FROM solo_registrations WHERE id = ?")->execute([$reg_id]);
    $success_msg = "Inscription supprimée.";
}

// ── Récupérer les données ──
$users = $pdo->query("SELECT id, username, email FROM users WHERE username != 'admin' ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

$tournaments = $pdo->query("SELECT * FROM tournaments ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);

$soloRegs = $pdo->query("
    SELECT sr.id, u.username, t.title, t.game, sr.registered_at
    FROM solo_registrations sr
    JOIN users u ON sr.user_id = u.id
    JOIN tournaments t ON sr.tournament_id = t.id
    ORDER BY sr.registered_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

$teams = $pdo->query("
    SELECT te.id, te.name, te.invite_code, te.max_size,
           t.title as tournament_title,
           u.username as captain_name,
           te.captain_id
    FROM teams te
    JOIN tournaments t ON te.tournament_id = t.id
    JOIN users u ON te.captain_id = u.id
    ORDER BY te.id ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les membres pour chaque équipe
$teamMembers = [];
foreach ($teams as $team) {
    $stmtM = $pdo->prepare("
        SELECT u.id, u.username, te.captain_id
        FROM team_members tm
        JOIN users u ON tm.user_id = u.id
        JOIN teams te ON tm.team_id = te.id
        WHERE tm.team_id = ?
    ");
    $stmtM->execute([$team['id']]);
    $teamMembers[$team['id']] = $stmtM->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
?>

<main class="home-main">

    <section class="home-intro login-intro">
        <span class="intro-tag">Administration</span>
        <h1 class="intro-title">Panel Admin</h1>
        <p class="intro-text">Gestion des utilisateurs, tournois et inscriptions.</p>
    </section>

    <?php if (!empty($success_msg)) : ?>
        <div class="team-message success" style="margin-bottom: 32px;"><?= $success_msg ?></div>
    <?php elseif (!empty($error_msg)) : ?>
        <div class="team-message error" style="margin-bottom: 32px;"><?= $error_msg ?></div>
    <?php endif; ?>

    <!-- ===== TOURNOIS ===== -->
    <section class="admin-section">
        <h2 class="admin-section-title">Tournois</h2>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Places</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tournaments as $t) : ?>
                        <?php
                            if ($t['type'] === 'solo') {
                                $stmtC = $pdo->prepare("SELECT COUNT(*) as nb FROM solo_registrations WHERE tournament_id = ?");
                            } else {
                                $stmtC = $pdo->prepare("SELECT COUNT(*) as nb FROM teams WHERE tournament_id = ?");
                            }
                            $stmtC->execute([$t['id']]);
                            $nb = $stmtC->fetch(PDO::FETCH_ASSOC)['nb'];
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($t['title']) ?></td>
                            <td>
                                <span class="admin-badge <?= $t['type'] ?>">
                                    <?= $t['type'] === 'solo' ? 'Solo' : 'Équipe' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($t['date'])) ?></td>
                            <td><?= $nb ?> / <?= $t['places'] ?></td>
                            <td>
                                <span class="admin-badge <?= $t['status'] ?>">
                                    <?= $t['status'] === 'open' ? 'Ouvert' : 'Fermé' ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="tournament_id" value="<?= $t['id'] ?>">
                                    <input type="hidden" name="current_status" value="<?= $t['status'] ?>">
                                    <button type="submit" name="toggle_tournament" class="admin-btn <?= $t['status'] === 'open' ? 'admin-btn--danger' : 'admin-btn--success' ?>">
                                        <?= $t['status'] === 'open' ? 'Fermer' : 'Ouvrir' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ===== UTILISATEURS ===== -->
    <section class="admin-section">
        <h2 class="admin-section-title">Utilisateurs</h2>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u) : ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Supprimer <?= htmlspecialchars($u['username']) ?> ?')">
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                    <button type="submit" name="delete_user" class="admin-btn admin-btn--danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ===== INSCRIPTIONS SOLO ===== -->
    <section class="admin-section">
        <h2 class="admin-section-title">Inscriptions solo</h2>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Joueur</th>
                        <th>Tournoi</th>
                        <th>Date d'inscription</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($soloRegs)) : ?>
                        <tr><td colspan="4" class="admin-empty">Aucune inscription solo.</td></tr>
                    <?php else : ?>
                        <?php foreach ($soloRegs as $r) : ?>
                            <tr>
                                <td><?= htmlspecialchars($r['username']) ?></td>
                                <td><?= htmlspecialchars($r['title']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($r['registered_at'])) ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Supprimer cette inscription ?')">
                                        <input type="hidden" name="reg_id" value="<?= $r['id'] ?>">
                                        <button type="submit" name="delete_solo_reg" class="admin-btn admin-btn--danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ===== ÉQUIPES ===== -->
    <section class="admin-section">
        <h2 class="admin-section-title">Équipes</h2>

        <?php if (empty($teams)) : ?>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <tbody>
                        <tr><td class="admin-empty">Aucune équipe créée.</td></tr>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <?php foreach ($teams as $team) : ?>
                <div class="admin-team-block">
                    <div class="admin-team-header">
                        <div class="admin-team-info">
                            <h3 class="admin-team-name"><?= htmlspecialchars($team['name']) ?></h3>
                            <span class="admin-team-meta"><?= htmlspecialchars($team['tournament_title']) ?></span>
                            <span class="admin-team-meta">Capitaine : <strong><?= htmlspecialchars($team['captain_name']) ?></strong></span>
                            <span class="admin-team-meta">Code : <span class="admin-code"><?= $team['invite_code'] ?></span></span>
                            <span class="admin-team-meta"><?= count($teamMembers[$team['id']]) ?> / <?= $team['max_size'] ?> membres</span>
                        </div>
                        <form method="POST" onsubmit="return confirm('Supprimer l\'équipe <?= htmlspecialchars($team['name']) ?> et tous ses membres ?')">
                            <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                            <button type="submit" name="delete_team" class="admin-btn admin-btn--danger">Supprimer l'équipe</button>
                        </form>
                    </div>

                    <!-- Membres de l'équipe -->
                    <?php if (!empty($teamMembers[$team['id']])) : ?>
                        <table class="admin-table admin-team-members-table">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>Rôle</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teamMembers[$team['id']] as $member) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($member['username']) ?></td>
                                        <td>
                                            <?php if ($member['id'] == $team['captain_id']) : ?>
                                                <span class="profile-captain-badge">Capitaine</span>
                                            <?php else : ?>
                                                <span style="color: var(--text-muted); font-size: 0.85rem;">Membre</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($member['id'] != $team['captain_id']) : ?>
                                                <form method="POST" onsubmit="return confirm('Retirer <?= htmlspecialchars($member['username']) ?> de l\'équipe ?')">
                                                    <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                                                    <input type="hidden" name="member_user_id" value="<?= $member['id'] ?>">
                                                    <button type="submit" name="delete_member" class="admin-btn admin-btn--danger">Retirer</button>
                                                </form>
                                            <?php else : ?>
                                                <span style="color: var(--text-muted); font-size: 0.8rem;">—</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
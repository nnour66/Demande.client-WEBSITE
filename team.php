<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$user_id     = $_SESSION['user_id'];
$success_msg = '';
$error_msg   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        /* ── CRÉER UNE ÉQUIPE ── */
        if ($action === 'create_team') {
            $tournament_id = (int)($_POST['tournament_id'] ?? 0);
            $team_name     = trim($_POST['team_name'] ?? '');

            if (empty($tournament_id) || empty($team_name)) {
                $error_msg = "Merci de remplir tous les champs pour créer l'équipe.";
            } else {
                $stmtCheck = $pdo->prepare("
                    SELECT tm.id FROM team_members tm
                    JOIN teams t ON tm.team_id = t.id
                    WHERE tm.user_id = ? AND t.tournament_id = ?
                ");
                $stmtCheck->execute([$user_id, $tournament_id]);

                if ($stmtCheck->fetch()) {
                    $error_msg = "Tu es déjà inscrit à ce tournoi avec une équipe !";
                } else {
                    $stmtName = $pdo->prepare("SELECT id FROM teams WHERE name = ? AND tournament_id = ?");
                    $stmtName->execute([$team_name, $tournament_id]);

                    if ($stmtName->fetch()) {
                        $error_msg = "Ce nom d'équipe est déjà pris pour ce tournoi.";
                    } else {
                        $stmtTournoi = $pdo->prepare("SELECT team_size, title FROM tournaments WHERE id = ?");
                        $stmtTournoi->execute([$tournament_id]);
                        $tournoi = $stmtTournoi->fetch(PDO::FETCH_ASSOC);

                        if ($tournoi) {
                            $invite_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                            $max_size    = $tournoi['team_size'];

                            $pdo->beginTransaction();

                            $insertTeam = $pdo->prepare("INSERT INTO teams (tournament_id, name, captain_id, invite_code, max_size) VALUES (?, ?, ?, ?, ?)");
                            $insertTeam->execute([$tournament_id, $team_name, $user_id, $invite_code, $max_size]);
                            $team_id = $pdo->lastInsertId();

                            $insertMember = $pdo->prepare("INSERT INTO team_members (team_id, user_id) VALUES (?, ?)");
                            $insertMember->execute([$team_id, $user_id]);

                            $pdo->commit();

                            $success_msg = "success_create|" . htmlspecialchars($team_name) . "|" . $invite_code;
                        } else {
                            $error_msg = "Tournoi introuvable.";
                        }
                    }
                }
            }

        /* ── REJOINDRE UNE ÉQUIPE ── */
        } elseif ($action === 'join_team') {
            $invite_code = strtoupper(trim($_POST['invite_code'] ?? ''));

            if (empty($invite_code)) {
                $error_msg = "Merci de renseigner le code d'invitation.";
            } else {
                $stmtTeam = $pdo->prepare("SELECT id, tournament_id, name, max_size FROM teams WHERE invite_code = ?");
                $stmtTeam->execute([$invite_code]);
                $team = $stmtTeam->fetch(PDO::FETCH_ASSOC);

                if ($team) {
                    $team_id       = $team['id'];
                    $tournament_id = $team['tournament_id'];

                    $stmtCheck = $pdo->prepare("
                        SELECT tm.id FROM team_members tm
                        JOIN teams t ON tm.team_id = t.id
                        WHERE tm.user_id = ? AND t.tournament_id = ?
                    ");
                    $stmtCheck->execute([$user_id, $tournament_id]);

                    if ($stmtCheck->fetch()) {
                        $error_msg = "Tu participes déjà à ce tournoi dans une autre équipe !";
                    } else {
                        $stmtCount = $pdo->prepare("SELECT COUNT(*) as nb FROM team_members WHERE team_id = ?");
                        $stmtCount->execute([$team_id]);
                        $nb = $stmtCount->fetch(PDO::FETCH_ASSOC)['nb'];

                        if ($nb < $team['max_size']) {
                            $insertMember = $pdo->prepare("INSERT INTO team_members (team_id, user_id) VALUES (?, ?)");
                            $insertMember->execute([$team_id, $user_id]);
                            $success_msg = "success_join|" . htmlspecialchars($team['name']);
                        } else {
                            $error_msg = "L'équipe " . htmlspecialchars($team['name']) . " est déjà complète.";
                        }
                    }
                } else {
                    $error_msg = "Code d'invitation invalide ou expiré.";
                }
            }
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $error_msg = "Une erreur est survenue : " . $e->getMessage();
    }
}

$stmtTournaments = $pdo->query("SELECT id, title FROM tournaments WHERE type = 'team' AND status = 'open'");
$teamTournaments = $stmtTournaments->fetchAll(PDO::FETCH_ASSOC);

// Parse success message
if (str_starts_with($success_msg, 'success_create|')) {
    $parts               = explode('|', $success_msg);
    $success_create_name = $parts[1];
    $success_create_code = $parts[2];
    $success_msg         = 'create';
} elseif (str_starts_with($success_msg, 'success_join|')) {
    $parts            = explode('|', $success_msg);
    $success_join_name = $parts[1];
    $success_msg       = 'join';
}
?>

<?php include 'includes/header.php'; ?>

<main class="home-main">

    <section class="home-intro login-intro">
        <span class="intro-tag">Espace équipe</span>
        <h1 class="intro-title">Gérer son équipe</h1>
        <p class="intro-text">Crée une nouvelle équipe pour un tournoi ou rejoins tes coéquipiers avec leur code d'invitation.</p>
    </section>

    <!-- Messages globaux -->
    <?php if ($success_msg === 'create') : ?>
        <div class="team-message success">
            Ton équipe <strong><?= $success_create_name ?></strong> est créée !<br>
            Donne ce code à tes coéquipiers :<br>
            <span class="invite-code-display"><?= $success_create_code ?></span>
        </div>
    <?php elseif ($success_msg === 'join') : ?>
        <div class="team-message success">
            Félicitations ! Tu as rejoint l'équipe <strong><?= $success_join_name ?></strong>.
        </div>
    <?php elseif (!empty($error_msg)) : ?>
        <div class="team-message error"><?= $error_msg ?></div>
    <?php endif; ?>

    <section class="team-section">

        <!-- CRÉER UNE ÉQUIPE -->
        <form method="POST" class="login-form" style="flex: 1; min-width: 300px; max-width: 420px; margin: 0;">
            <p class="team-form-title">Créer une équipe</p>
            <p class="team-form-subtitle">Tu seras automatiquement désigné capitaine.</p>

            <input type="hidden" name="action" value="create_team">

            <p class="login-field">
                <label for="tournament_id">Choisir le tournoi</label>
                <select id="tournament_id" name="tournament_id" required>
                        <option value="" disabled selected hidden>Sélectionne un tournoi...</option>                    <?php foreach ($teamTournaments as $t) : ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p class="login-field">
                <label for="team_name">Nom de l'équipe</label>
                <input type="text" id="team_name" name="team_name" placeholder="Ex : Les Invincibles" required>
            </p>

            <p class="login-actions">
                <button type="submit">Créer mon équipe</button>
            </p>
        </form>

        <!-- SÉPARATEUR -->
        <div class="team-divider"></div>

        <!-- REJOINDRE UNE ÉQUIPE -->
        <form method="POST" class="login-form" style="flex: 1; min-width: 300px; max-width: 420px; margin: 0;">
            <p class="team-form-title">Rejoindre une équipe</p>
            <p class="team-form-subtitle">Demande le code d'invitation de 8 caractères à ton capitaine.</p>

            <input type="hidden" name="action" value="join_team">

            <p class="login-field">
                <label for="invite_code">Code d'invitation</label>
                <input type="text" id="invite_code" name="invite_code" placeholder="Ex : A9B4X7K2" required maxlength="8" style="text-transform: uppercase; letter-spacing: 3px; font-weight: 700;">
            </p>

            <p class="login-actions">
                <button type="submit" class="btn-outline">Rejoindre l'équipe</button>
            </p>
        </form>

    </section>

</main>

<?php include 'includes/footer.php'; ?>
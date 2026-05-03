<?php
include 'includes/header.php';
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

$user_id     = $_SESSION['user_id'];
$success_msg = '';
$error_msg   = '';

$stmtUser = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username'] ?? '');
    $new_email    = trim($_POST['email'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($new_username) || empty($new_email)) {
        $error_msg = "Le nom d'utilisateur et l'email sont obligatoires.";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Adresse email invalide.";
    } elseif (strlen($new_email) > 100) {
        $error_msg = "L'adresse email ne peut pas dépasser 100 caractères.";
    } else {
        // Vérifier unicité username/email (sauf pour soi-même)
        $stmtCheck = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmtCheck->execute([$new_username, $new_email, $user_id]);

        if ($stmtCheck->fetch()) {
            $error_msg = "Ce nom d'utilisateur ou cet email est déjà utilisé.";
        } else {
            if (!empty($new_password)) {
                if ($new_password !== $confirm_password) {
                    $error_msg = "Les mots de passe ne correspondent pas.";
                } else {
                    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
                    $stmt->execute([$new_username, $new_email, $hashedPassword, $user_id]);
                }
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                $stmt->execute([$new_username, $new_email, $user_id]);
            }

            if (empty($error_msg)) {
                $_SESSION['username'] = $new_username;
                $_SESSION['email']    = $new_email;
                $user['username']     = $new_username;
                $user['email']        = $new_email;
                $success_msg          = "Profil mis à jour avec succès.";
            }
        }
    }
}
?>

<main class="home-main">

    <section class="home-intro login-intro">
        <span class="intro-tag">Mon espace</span>
        <h1 class="intro-title">Modifier mon profil</h1>
        <p class="intro-text">Mettez à jour vos informations personnelles.</p>
    </section>

    <section class="login-section">
        <form method="POST" class="login-form register-form">

            <div id="editMessageContainer">
                <?php if (!empty($success_msg)) : ?>
                    <div class="form-message success">
                        <span class="form-message-icon">✓</span>
                        <span class="form-message-text"><?= $success_msg ?></span>
                    </div>
                <?php elseif (!empty($error_msg)) : ?>
                    <div class="form-message error">
                        <span class="form-message-icon">!</span>
                        <span class="form-message-text"><?= $error_msg ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <p class="login-field">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </p>

            <p class="login-field">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" maxlength="100" required>
            </p>

            <p class="login-field">
                <label for="new_password">Nouveau mot de passe <span class="label-optional">(laisser vide pour ne pas changer)</span></label>
                <span class="input-password-wrap">
                    <input type="password" id="new_password" name="new_password">
                    <button type="button" class="password-toggle" aria-label="Afficher le mot de passe" data-target="new_password">
                        <svg class="eye-icon eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-icon eye-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </span>
            </p>

            <p class="login-field">
                <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                <span class="input-password-wrap">
                    <input type="password" id="confirm_password" name="confirm_password">
                    <button type="button" class="password-toggle" aria-label="Afficher le mot de passe" data-target="confirm_password">
                        <svg class="eye-icon eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-icon eye-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </span>
            </p>

            <p class="login-actions">
                <button type="submit">Enregistrer les modifications</button>
            </p>

            <p class="login-links">
                <a href="/profil.php">← Retour au profil</a>
            </p>

        </form>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
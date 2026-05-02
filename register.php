<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

    $username         = trim($_POST['username'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Adresse email invalide.']);
        exit();
    }

    if (strlen($email) > 100) {
        echo json_encode(['status' => 'error', 'message' => "L'adresse email ne peut pas dépasser 100 caractères."]);
        exit();
    }

    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Les mots de passe ne correspondent pas.']);
        exit();
    }

    $zxcvbn_score = intval($_POST['zxcvbn_score'] ?? -1);
    if ($zxcvbn_score < 3) {
        echo json_encode(['status' => 'error', 'message' => 'Mot de passe trop faible. Score minimum requis : 3/4.']);
        exit();
    }

    $check = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
    $check->execute([':username' => $username, ':email' => $email]);

    if ($check->fetch()) {
        echo json_encode(['status' => 'error', 'message' => "Nom d'utilisateur ou email déjà utilisé."]);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $insert->execute([':username' => $username, ':email' => $email, ':password' => $hashedPassword]);

    echo json_encode([
        'status'   => 'success',
        'message'  => 'Compte créé avec succès.',
        'redirect' => 'login.php'
    ]);
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>


<script src="/assets/js/zxcvbn.js"></script>

<main class="home-main">
    <section class="home-intro login-intro">
        <span class="intro-tag">Espace joueur</span>
        <h1 class="intro-title">Créer un compte</h1>
        <p class="intro-text">Créez votre compte pour rejoindre la plateforme.</p>
    </section>

    <section class="login-section">
        <form id="registerForm" method="POST" class="login-form register-form" novalidate>
            <div id="registerMessageContainer"></div>

            <p class="login-field">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </p>

            <p class="login-field">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" maxlength="100" required>
            </p>

            <p class="login-field">
                <label for="password">Mot de passe</label>
                <span class="input-password-wrap">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="password-toggle" aria-label="Afficher le mot de passe" data-target="password">
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
                <ul class="password-criteria" id="passwordCriteria">
                    <li class="criteria-item" id="criteria-length">✗ Au moins 8 caractères</li>
                    <li class="criteria-item" id="criteria-upper">✗ Une majuscule</li>
                    <li class="criteria-item" id="criteria-number">✗ Un chiffre</li>
                    <li class="criteria-item" id="criteria-special">✗ Un caractère spécial</li>
                    <li class="criteria-item" id="criteria-score">✗ Score zxcvbn minimum : 3/4</li>
                </ul>
            </p>

            <p class="login-field">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <span class="input-password-wrap">
                    <input type="password" id="confirm_password" name="confirm_password" required>
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

            <input type="hidden" id="zxcvbn_score" name="zxcvbn_score" value="0">

            <p class="login-actions">
                <button type="submit" id="registerSubmitBtn">Créer mon compte</button>
            </p>

            <p class="login-links">
                Déjà inscrit ? <a href="login.php">Se connecter</a>
            </p>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
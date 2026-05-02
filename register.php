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

    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Les mots de passe ne correspondent pas.']);
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
                <input type="email" id="email" name="email" required>
            </p>

            <p class="login-field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </p>

            <p class="login-field">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </p>

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
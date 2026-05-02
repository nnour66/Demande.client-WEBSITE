<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email']    = $user['email'];

        echo json_encode(['status' => 'success', 'message' => 'Connexion réussie.', 'redirect' => 'index.php']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email ou mot de passe incorrect.']);
    }

    exit();
}
?>

<?php include 'includes/header.php'; ?>

<main class="home-main">
    <section class="home-intro login-intro">
        <span class="intro-tag">Espace joueur</span>
        <h1 class="intro-title">Connexion</h1>
        <p class="intro-text">Connectez-vous à votre espace personnel.</p>
    </section>

    <section class="login-section">
        <form id="loginForm" method="POST" class="login-form" novalidate>
            <div id="loginMessageContainer"></div>

            <p class="login-field">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" required>
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
            </p>

            <p class="login-actions">
                <button type="submit" id="loginSubmitBtn">Se connecter</button>
            </p>

            <p class="login-links">
                Pas encore inscrit ? <a href="register.php">Créer un compte</a>
            </p>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
<?php
session_start();
require_once 'includes/db.php';

$message = '';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $check = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $check->execute([
                ':username' => $username,
                ':email' => $email
            ]);

            $existingUser = $check->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                $message = "Nom d'utilisateur ou email déjà utilisé.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insert = $pdo->prepare("
                    INSERT INTO users (username, email, password)
                    VALUES (:username, :email, :password)
                ");

                $insert->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashedPassword
                ]);

                $message = "Compte créé avec succès.";
            }
        } else {
            $message = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
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
        <form action="register.php" method="POST" class="login-form register-form">
            <?php if (!empty($message)) : ?>
                <p class="form-message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

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
                <button type="submit" name="register">Créer mon compte</button>
            </p>

            <p class="login-links">
                Déjà inscrit ? <a href="login.php">Se connecter</a>
            </p>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
document.addEventListener("DOMContentLoaded", () => {

    /* ===== UTILITAIRE COMMUN ===== */
    function renderMessage(container, message, type = "error") {
        container.innerHTML = `
            <div class="form-message ${type}">
                <span class="form-message-icon">${type === "success" ? "✓" : "!"}</span>
                <span class="form-message-text">${message}</span>
                <button type="button" class="form-message-close" aria-label="Fermer">&times;</button>
            </div>
        `;

        const closeBtn   = container.querySelector(".form-message-close");
        const messageBox = container.querySelector(".form-message");

        if (closeBtn && messageBox) {
            closeBtn.addEventListener("click", () => {
                messageBox.classList.add("is-hiding");
                setTimeout(() => { container.innerHTML = ""; }, 300);
            });
        }
    }

    /* ===== LOGIN ===== */
    const loginForm      = document.getElementById("loginForm");
    const loginContainer = document.getElementById("loginMessageContainer");
    const loginBtn       = document.getElementById("loginSubmitBtn");

    if (loginForm && loginContainer && loginBtn) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            loginContainer.innerHTML = "";

            const email    = loginForm.email.value.trim();
            const password = loginForm.password.value;

            if (!email || !password) {
                renderMessage(loginContainer, "Veuillez remplir tous les champs.", "error");
                return;
            }

            loginBtn.disabled    = true;
            loginBtn.textContent = "Connexion...";

            try {
                const response = await fetch("login.php", {
                    method: "POST",
                    body: new FormData(loginForm),
                    cache: "no-store",
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });

                const data = await response.json();
                renderMessage(loginContainer, data.message, data.status);

                if (data.status === "success" && data.redirect) {
                    setTimeout(() => { window.location.href = data.redirect; }, 1200);
                }
            } catch {
                renderMessage(loginContainer, "Une erreur est survenue. Réessayez.", "error");
            } finally {
                loginBtn.disabled    = false;
                loginBtn.textContent = "Se connecter";
            }
        });
    }

    /* ===== REGISTER ===== */
    const registerForm      = document.getElementById("registerForm");
    const registerContainer = document.getElementById("registerMessageContainer");
    const registerBtn       = document.getElementById("registerSubmitBtn");

    if (registerForm && registerContainer && registerBtn) {
        registerForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            registerContainer.innerHTML = "";

            const username        = registerForm.username.value.trim();
            const email           = registerForm.email.value.trim();
            const password        = registerForm.password.value;
            const confirmPassword = registerForm.confirm_password.value;

            if (!username || !email || !password || !confirmPassword) {
                renderMessage(registerContainer, "Veuillez remplir tous les champs.", "error");
                return;
            }

            if (password !== confirmPassword) {
                renderMessage(registerContainer, "Les mots de passe ne correspondent pas.", "error");
                return;
            }

            registerBtn.disabled    = true;
            registerBtn.textContent = "Création...";

            try {
                const response = await fetch("register.php", {
                    method: "POST",
                    body: new FormData(registerForm),
                    cache: "no-store",
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });

                const data = await response.json();
                renderMessage(registerContainer, data.message, data.status);

                if (data.status === "success" && data.redirect) {
                    setTimeout(() => { window.location.href = data.redirect; }, 1200);
                }
            } catch {
                renderMessage(registerContainer, "Une erreur est survenue. Réessayez.", "error");
            } finally {
                registerBtn.disabled    = false;
                registerBtn.textContent = "Créer mon compte";
            }
        });
    }

});
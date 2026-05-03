document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       UTILITAIRE COMMUN
    ===================================================== */
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


    /* =====================================================
       TOGGLE AFFICHER / MASQUER MOT DE PASSE
    ===================================================== */
    document.querySelectorAll(".password-toggle").forEach((btn) => {
        btn.addEventListener("click", () => {
            const input   = document.getElementById(btn.dataset.target);
            const eyeShow = btn.querySelector(".eye-show");
            const eyeHide = btn.querySelector(".eye-hide");

            if (input.type === "password") {
                input.type            = "text";
                eyeShow.style.display = "none";
                eyeHide.style.display = "block";
                btn.setAttribute("aria-label", "Masquer le mot de passe");
            } else {
                input.type            = "password";
                eyeShow.style.display = "block";
                eyeHide.style.display = "none";
                btn.setAttribute("aria-label", "Afficher le mot de passe");
            }
        });
    });

    /* =====================================================
                            LOGIN
    ===================================================== */
    const loginForm      = document.getElementById("loginForm");
    const loginContainer = document.getElementById("loginMessageContainer");
    const loginBtn       = document.getElementById("loginSubmitBtn");

    if (loginForm && loginContainer && loginBtn) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            loginContainer.innerHTML = "";

            const identifier = loginForm.identifier.value.trim();
            const password   = loginForm.password.value;

            if (!identifier || !password) {
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

    

    /* =====================================================
       REGISTER
    ===================================================== */
    const registerForm      = document.getElementById("registerForm");
    const registerContainer = document.getElementById("registerMessageContainer");
    const registerBtn       = document.getElementById("registerSubmitBtn");
    const passwordInput     = document.getElementById("password");
    const zxcvbnScoreInput  = document.getElementById("zxcvbn_score");
    const passwordCriteria  = document.getElementById("passwordCriteria");

    const criteriaLength  = document.getElementById("criteria-length");
    const criteriaUpper   = document.getElementById("criteria-upper");
    const criteriaNumber  = document.getElementById("criteria-number");
    const criteriaSpecial = document.getElementById("criteria-special");
    const criteriaScore   = document.getElementById("criteria-score");

    /* ── Critères en temps réel ── */
    if (passwordInput && passwordCriteria && zxcvbnScoreInput) {
        passwordInput.addEventListener("input", () => {
            const val = passwordInput.value;

            if (!val) {
                passwordCriteria.style.display = "none";
                zxcvbnScoreInput.value         = "0";
                return;
            }

            passwordCriteria.style.display = "flex";

            const hasLength  = val.length >= 8;
            const hasUpper   = /[A-Z]/.test(val);
            const hasNumber  = /[0-9]/.test(val);
            const hasSpecial = /[^A-Za-z0-9]/.test(val);

            const result   = zxcvbn(val);
            const score    = result.score;
            const hasScore = score >= 3;

            zxcvbnScoreInput.value = score;

            function update(el, valid, okText, koText) {
                el.textContent = valid ? `✓ ${okText}` : `✗ ${koText}`;
                el.classList.toggle("valid", valid);
            }

            update(criteriaLength,  hasLength,  "Au moins 8 caractères",    "Au moins 8 caractères");
            update(criteriaUpper,   hasUpper,   "Une majuscule",             "Une majuscule");
            update(criteriaNumber,  hasNumber,  "Un chiffre",                "Un chiffre");
            update(criteriaSpecial, hasSpecial, "Un caractère spécial",      "Un caractère spécial");
            update(criteriaScore,   hasScore,   `Score zxcvbn : ${score}/4`, `Score zxcvbn : ${score}/4 (minimum 3)`);
        });
    }

    /* ── Soumission ── */
    if (registerForm && registerContainer && registerBtn) {
        registerForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            registerContainer.innerHTML = "";

            const username        = registerForm.username.value.trim();
            const email           = registerForm.email.value.trim();
            const password        = registerForm.password.value;
            const confirmPassword = registerForm.confirm_password.value;
            const score           = parseInt(zxcvbnScoreInput.value, 10);

            if (!username || !email || !password || !confirmPassword) {
                renderMessage(registerContainer, "Veuillez remplir tous les champs.", "error");
                return;
            }

            if (email.length > 100) {
                renderMessage(registerContainer, "L'adresse email ne peut pas dépasser 100 caractères.", "error");
                return;
            }

            if (score < 3) {
                renderMessage(registerContainer, "Mot de passe trop faible. Score minimum requis : 3/4.", "error");
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
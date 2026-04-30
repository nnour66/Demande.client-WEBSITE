document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const messageContainer = document.getElementById("loginMessageContainer");
    const submitBtn = document.getElementById("loginSubmitBtn");

    if (!form || !messageContainer || !submitBtn) return;

    function renderMessage(message, type = "error") {
        messageContainer.innerHTML = `
            <div class="form-message ${type}">
                <span class="form-message-icon">${type === "success" ? "✓" : "!"}</span>
                <span class="form-message-text">${message}</span>
                <button type="button" class="form-message-close" aria-label="Fermer">&times;</button>
            </div>
        `;

        const closeBtn = messageContainer.querySelector(".form-message-close");
        const messageBox = messageContainer.querySelector(".form-message");

        if (closeBtn && messageBox) {
            closeBtn.addEventListener("click", () => {
                messageBox.classList.add("is-hiding");
                setTimeout(() => {
                    messageContainer.innerHTML = "";
                }, 300);
            });
        }
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        messageContainer.innerHTML = "";

        const email = form.email.value.trim();
        const password = form.password.value;

        if (!email || !password) {
            renderMessage("Veuillez remplir tous les champs.", "error");
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = "Connexion...";

        try {
            const formData = new FormData(form);

            const response = await fetch("login.php", {
                method: "POST",
                body: formData,
                cache: "no-store",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const data = await response.json();

            renderMessage(data.message, data.status);

            if (data.status === "success" && data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1200);
            }
        } catch (error) {
            renderMessage("Une erreur est survenue. Réessayez.", "error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = "Se connecter";
        }
    });
});

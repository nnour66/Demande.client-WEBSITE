document.addEventListener("DOMContentLoaded", () => {
    const themeToggle = document.getElementById("themeToggle");
    const body = document.body;

    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "light" || savedTheme === "dark") {
        body.setAttribute("data-theme", savedTheme);
    } else {
        body.setAttribute("data-theme", "dark");
    }

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const currentTheme = body.getAttribute("data-theme");
            const newTheme = currentTheme === "light" ? "dark" : "light";

            body.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
        });
    }
});
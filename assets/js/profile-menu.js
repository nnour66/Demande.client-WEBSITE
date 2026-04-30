document.addEventListener("DOMContentLoaded", () => {
    const profileToggle = document.getElementById("profileToggle");
    const profileDropdown = document.getElementById("profileDropdown");
    const profileItem = document.querySelector(".profile-menu-item");

    if (!profileToggle || !profileDropdown || !profileItem) return;

    profileToggle.addEventListener("click", () => {
        const isOpen = profileItem.classList.toggle("open");
        profileToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    document.addEventListener("click", (event) => {
        if (!profileItem.contains(event.target)) {
            profileItem.classList.remove("open");
            profileToggle.setAttribute("aria-expanded", "false");
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            profileItem.classList.remove("open");
            profileToggle.setAttribute("aria-expanded", "false");
        }
    });
});
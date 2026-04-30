document.addEventListener("DOMContentLoaded", () => {
    const langToggle = document.getElementById("langToggle");
    const langFlag = document.getElementById("langFlag");
    const langLabel = document.getElementById("langLabel");

    const translations = {
        fr: {
            heroKicker: "Tournois gaming • compétitions • e-sport",
            introTag: "Tournoi e-sport",
            introTitle: "Les Jeux",
            introText: "Découvre les jeux disponibles sur GameArena, accède aux espaces de tournoi, consulte les formats de compétition et prépare-toi à entrer dans l'arène.",
            sectionTitle: "Sélection principale",
            sectionTag: "Jeux du tournoi",
            gameCategory: "Tournoi",
            gameSlots: "places disponibles",
            game1Title: "LoL : La Faille de l'Exam",
            game2Title: "Mario Kart : GP du CROUS",
            game3Title: "Smash Bros : Baston Générale",
            game4Title: "FC 25 : Tournoi Inter-Promo",
            game5Title: "Rocket League : Fly & Cry",
            game6Title: "CS2 : Tournoi Campus",
            gameLink: "Voir le tournoi",
            footerNav: "Navigation",
            navHome: "Accueil",
            navGames: "Les jeux",
            navLogin: "Se connecter",
            footerContact: "Contact",
            footerProject: "Université — Projet e-sport",
            footerSocials: "Réseaux",
            footerRights: "Projet universitaire. Tous droits réservés.",
            legalNotice: "Mentions légales",
            privacyPolicy: "Politique de confidentialité"
        },
        en: {
            heroKicker: "Gaming tournaments • competitions • esports",
            introTag: "Esports tournament",
            introTitle: "Games",
            introText: "Discover the games available on GameArena, access the tournament spaces, explore the competition formats, and get ready to enter the arena.",
            sectionTitle: "Main selection",
            sectionTag: "Tournament games",
            gameCategory: "Tournament",
            gameSlots: "available slots",
            game1Title: "LoL: The Exam Rift",
            game2Title: "Mario Kart: CROUS Grand Prix",
            game3Title: "Smash Bros: General Brawl",
            game4Title: "FC 25: Inter-Class Tournament",
            game5Title: "Rocket League: Fly & Cry",
            game6Title: "CS2: Campus Tournament",
            gameLink: "View tournament",
            footerNav: "Navigation",
            navHome: "Home",
            navGames: "Games",
            navLogin: "Log in",
            footerContact: "Contact",
            footerProject: "University — Esports project",
            footerSocials: "Socials",
            footerRights: "University project. All rights reserved.",
            legalNotice: "Legal notice",
            privacyPolicy: "Privacy policy"
        }
    };

    let currentLang = localStorage.getItem("language") || "fr";

    function updateLangButton(lang) {
    if (!langFlag || !langLabel) return;

    if (lang === "fr") {
        langFlag.src = "/assets/img/fr.svg";
        langLabel.textContent = "FR";
    } else {
        langFlag.src = "/assets/img/gb.svg";
        langLabel.textContent = "EN";
    }
}

    function applyLanguage(lang) {
        document.querySelectorAll("[data-i18n]").forEach((element) => {
            const key = element.getAttribute("data-i18n");
            if (translations[lang] && translations[lang][key]) {
                element.textContent = translations[lang][key];
            }
        });

        document.documentElement.lang = lang;
        updateLangButton(lang);
        localStorage.setItem("language", lang);
    }

    if (langToggle) {
        langToggle.addEventListener("click", () => {
            langToggle.classList.add("switching");

            setTimeout(() => {
                currentLang = currentLang === "fr" ? "en" : "fr";
                applyLanguage(currentLang);
            }, 120);

            setTimeout(() => {
                langToggle.classList.remove("switching");
            }, 240);
        });
    }

    applyLanguage(currentLang);
});
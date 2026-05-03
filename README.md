# 🎮 Projet Tournoi Gaming – Documentation

## 📌 Présation du projet

Ce projet est une application web permettant de gérer un **tournoi de jeux vidéo**.
Les utilisateurs יכולים s’inscrire, se connecter, gérer leur profil et interagir avec différentes pages liées aux jeux et aux équipes.

L’application propose également un espace administrateur pour gérer certains aspects du site.

---

## 🗂️ Structure du projet

Voici l’organisation globale du projet :

```
.
├── admin.php
├── assets
│   ├── css
│   │   └── style.css
│   ├── img
│   │   ├── cs2.webp
│   │   ├── fc25.webp
│   │   ├── fr.svg
│   │   ├── gb.svg
│   │   ├── logo-tournoi.svg
│   │   ├── lol_cover.webp
│   │   ├── mario_kart.webp
│   │   ├── rocket_league.webp
│   │   └── ssbu.webp
│   └── js
│       ├── form-message.js
│       ├── profile-menu.js
│       └── theme.js
├── database
│   ├── database.sqlite
│   └── init_db.php
├── edit-profil.php
├── includes
│   ├── db.php
│   ├── footer.php
│   └── header.php
├── index.php
├── jeux
│   ├── CS2.php
│   ├── FC25.php
│   ├── Lol.php
│   ├── Mariokart.php
│   ├── RocketLeague.php
│   └── Smachbros.php
├── login.php
├── logout.php
├── profil.php
├── register.php
└── team.php
```

---

## 📁 Détail des dossiers

### 🎨 `assets/`

Contient toutes les ressources statiques :

* **css/**

  * `style.css` : feuille de style principale du site

* **js/**

  * `form-message.js` : gestion des messages des formulaires
  * `profile-menu.js` : interactions du menu profil
  * `theme.js` : gestion du thème (ex : dark/light mode)

* **img/**

  * Images des jeux (CS2, LoL, Rocket League, etc.)
  * Drapeaux (FR, GB)
  * Logo du tournoi

---

### 🗄️ `database/`

Gestion de la base de données :

* `database.sqlite` : base de données SQLite
* `init_db.php` : script d’initialisation de la base

---

### 🔧 `includes/`

Fichiers réutilisables :

* `db.php` : connexion à la base de données
* `header.php` : en-tête du site
* `footer.php` : pied de page

---

### 🎮 `jeux/`

Pages dédiées à chaque jeu :

* `CS2.php`
* `FC25.php`
* `Lol.php`
* `Mariokart.php`
* `RocketLeague.php`
* `Smachbros.php`

Chaque fichier représente une page spécifique avec les informations ou interactions liées au jeu.

---

## 📄 Pages principales

* `index.php` : page d’accueil
* `login.php` : connexion utilisateur
* `register.php` : inscription
* `logout.php` : déconnexion
* `profil.php` : profil utilisateur
* `edit-profil.php` : modification du profil
* `team.php` : gestion ou affichage des équipes
* `admin.php` : interface administrateur

---

## ⚙️ Fonctionnalités principales

* ✅ Inscription et connexion des utilisateurs
* ✅ Gestion de profil (consultation et modification)
* ✅ Navigation entre différents jeux
* ✅ Interface dynamique avec JavaScript
* ✅ Gestion du thème (clair/sombre)
* ✅ Base de données SQLite simple et efficace
* ✅ Structure modulaire avec includes

---

## 🛠️ Technologies utilisées

* **PHP** : logique serveur
* **SQLite** : base de données
* **HTML / CSS** : structure et design
* **JavaScript** : interactions dynamiques

---

## 🚀 Lancement du projet

1. Cloner le projet
2. Initialiser la base de données avec :

   ```
   database/init_db.php
   ```
3. Accéder au projet via :

   ```
   http://localhost/
   ```

---

## 📌 Remarques

* Le projet est structuré de manière modulaire pour faciliter la maintenance
* L’utilisation de SQLite permet une mise en place rapide sans configuration complexe
* Les fichiers `includes` évitent la duplication de code

---


## 👤 Auteur

Projet réalisé dans le cadre d’un apprentissage du développement web.

---

🧑‍💻 Conclusion

Ce projet pose une excellente base pour une application web complète :

* structure propre
* logique claire
* potentiel d’évolution énorme

👉 Il peut servir de tremplin vers :

* un projet pro
* un portfolio
* ou une vraie plateforme gaming

---


💡 *N’hésite pas à améliorer ce projet et à ajouter tes propres fonctionnalités !*


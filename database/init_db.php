<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO('sqlite:database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("DROP TABLE IF EXISTS tournaments");
    $pdo->exec("DROP TABLE IF EXISTS users");

    $pdo->exec("
        CREATE TABLE tournaments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            date TEXT NOT NULL,
            places INTEGER NOT NULL,
            image TEXT NOT NULL
        );
    ");

    $pdo->exec("
        CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL
        );
    ");

    $pdo->exec("
        INSERT INTO tournaments (title, date, places, image) VALUES
        ('LoL : La Faille de l''Exam', '2026-03-14', 8, 'assets/img/lol_cover.webp'),
        ('Mario Kart : GP du CROUS', '2026-03-20', 32, 'assets/img/mario_kart.webp'),
        ('CS2 : Rush B', '2026-04-02', 16, 'assets/img/cs2.webp'),
        ('Smash Bros : Baston Générale', '2026-04-10', 64, 'assets/img/ssbu.webp'),
        ('FC 25 : Tournoi Inter-Promo', '2026-04-18', 20, 'assets/img/fc25.webp'),
        ('Rocket League : Fly & Cry', '2026-05-25', 12, 'assets/img/rocket_league.webp');
    ");

    echo "Base réinitialisée avec succès.";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
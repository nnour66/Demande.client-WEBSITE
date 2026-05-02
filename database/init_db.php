<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $dbPath = __DIR__ . '/database.sqlite';

    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Active les clés étrangères sur SQLite
    $pdo->exec("PRAGMA foreign_keys = ON");

    $pdo->exec("DROP TABLE IF EXISTS team_members");
    $pdo->exec("DROP TABLE IF EXISTS solo_registrations");
    $pdo->exec("DROP TABLE IF EXISTS teams");
    $pdo->exec("DROP TABLE IF EXISTS tournaments");
    $pdo->exec("DROP TABLE IF EXISTS users");

    $pdo->exec("
        CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL
        );
    ");

    $pdo->exec("
        CREATE TABLE tournaments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            game TEXT NOT NULL,
            type TEXT NOT NULL CHECK(type IN ('solo', 'team')),
            team_size INTEGER NOT NULL DEFAULT 1,
            date TEXT NOT NULL,
            places INTEGER NOT NULL,
            image TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT 'open' CHECK(status IN ('open', 'closed'))
        );
    ");

    $pdo->exec("
        CREATE TABLE teams (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tournament_id INTEGER NOT NULL,
            name TEXT NOT NULL,
            captain_id INTEGER NOT NULL,
            invite_code TEXT NOT NULL UNIQUE,
            max_size INTEGER NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (tournament_id) REFERENCES tournaments(id),
            FOREIGN KEY (captain_id) REFERENCES users(id)
        );
    ");

    $pdo->exec("
        CREATE TABLE team_members (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            team_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (team_id) REFERENCES teams(id),
            FOREIGN KEY (user_id) REFERENCES users(id),
            UNIQUE (user_id, team_id)
        );
    ");

    $pdo->exec("
        CREATE TABLE solo_registrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tournament_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (tournament_id) REFERENCES tournaments(id),
            FOREIGN KEY (user_id) REFERENCES users(id),
            UNIQUE (user_id, tournament_id)
        );
    ");

    $pdo->exec("
        INSERT INTO tournaments (title, game, type, team_size, date, places, image) VALUES
        ('LoL : La Faille de l''Exam',       'LoL',          'team', 5, '2026-03-14', 8,  'assets/img/lol_cover.webp'),
        ('Mario Kart : GP du CROUS',          'MarioKart',    'solo', 1, '2026-03-20', 32, 'assets/img/mario_kart.webp'),
        ('CS2 : Rush B',                      'CS2',          'team', 5, '2026-04-02', 16, 'assets/img/cs2.webp'),
        ('Smash Bros : Baston Générale',      'SmashBros',    'team', 2, '2026-04-10', 64, 'assets/img/ssbu.webp'),
        ('FC 25 : Tournoi Inter-Promo',       'FC25',         'solo', 1, '2026-04-18', 20, 'assets/img/fc25.webp'),
        ('Rocket League : Fly & Cry',         'RocketLeague', 'team', 3, '2026-05-25', 12, 'assets/img/rocket_league.webp');
    ");

    echo "Base réinitialisée avec succès.";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
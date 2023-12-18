-- Création de la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS HarmoniHub;
USE HarmoniHub;

-- Création de la table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    artist_name VARCHAR(50) NOT NULL UNIQUE DEFAULT 'Unknown',
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des musiques
CREATE TABLE IF NOT EXISTS musics (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    featuring VARCHAR(50),
    file_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Création de la table des genres
CREATE TABLE IF NOT EXISTS genres (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insertion des genres
INSERT IGNORE INTO `genres` (`name`) VALUES ('Rap');
INSERT IGNORE INTO `genres` (`name`) VALUES ('R&B');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Techno');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Acoustic');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Electro');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Metal');

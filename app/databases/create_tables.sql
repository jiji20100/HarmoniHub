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
    role INT(11) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des genres
CREATE TABLE IF NOT EXISTS genres (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);
-- Création de la table des roles
CREATE TABLE IF NOT EXISTS roles (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);


-- Création de la table des musiques
CREATE TABLE IF NOT EXISTS musics (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    title VARCHAR(100) NOT NULL,
    artist VARCHAR(100) NOT NULL,
    genre INT(11) UNSIGNED NOT NULL,
    featuring VARCHAR(50),
    file_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    note INT(11) UNSIGNED,
    private BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (genre) REFERENCES genres(id) ON DELETE CASCADE
);

-- Création de la table des playlists
CREATE TABLE IF NOT EXISTS playlists (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL DEFAULT 'My playlist',
    user_id INT(11) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS links_playlist_music (
    playlist_id INT(11) UNSIGNED,
    music_id INT(11) UNSIGNED,
    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (music_id) REFERENCES musics(id) ON DELETE CASCADE
);

-- Création de la table des favoris
CREATE TABLE IF NOT EXISTS favorites (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    music_id INT(11) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (music_id) REFERENCES musics(id) ON DELETE CASCADE
);

-- Création de la table des notes
CREATE TABLE IF NOT EXISTS notes (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    music_id INT(11) UNSIGNED,
    note INT(11) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (music_id) REFERENCES musics(id) ON DELETE CASCADE
);

-- Création de la table des commentaires
CREATE TABLE IF NOT EXISTS comments (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    music_id INT(11) UNSIGNED,
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (music_id) REFERENCES musics(id) ON DELETE CASCADE
);

-- Création de la table des messages
CREATE TABLE IF NOT EXISTS messages (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    music_id INT(11) UNSIGNED,
    message TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (music_id) REFERENCES musics(id) ON DELETE CASCADE
);
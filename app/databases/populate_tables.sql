USE HarmoniHub;


-- Insertion des genres
INSERT IGNORE INTO `genres` (`name`) VALUES ('Rap');
INSERT IGNORE INTO `genres` (`name`) VALUES ('R&B');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Techno');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Acoustic');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Electro');
INSERT IGNORE INTO `genres` (`name`) VALUES ('Metal');

-- Insertion des utilisateurs
INSERT INTO users (surname, name, artist_name, email, password)
VALUES ('Doe', 'John', 'JohnDoe', 'john.doe@example.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Smith', 'Jane', 'JaneSmith', 'jane.smith@example.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Johnson', 'Michael', 'Unknown', 'michael.johnson@example.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Samuel', 'Deliens', 'DeliensSamuel', 'Samuel.deliens@gmail.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Jihad', 'Rifi', 'RifiJihad', 'Jihad.rifi@gmail.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO');
       ('Nicolas', 'Natanek', 'NicoEpita', 'nicolas.natanek@gmail.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO');


-- Insertion des musiques
INSERT INTO musics (user_id, title, artist, genre, featuring, file_path, note)
VALUES  (1, 'My song', 'JohnDoe', 1, NULL, '../files/1/My song.mp3', 5),
        (1, 'My second song', 'JohnDoe', 1, 'JaneSmith', '../files/1/My second song.mp3', 4),
        (2, 'My song', 'JaneSmith', 2, NULL, '../files/2/My song.mp3', 3),
        (2, 'My second song', 'JaneSmith', 3, '../JohnDoe', 'files/2/My second song.mp3', 2),
        (3, 'My song', 'Unknown', 2, NULL, '../files/3/My song.mp3', 1),
        (3, 'My second song', 'Unknown', 5, 'JohnDoe', '../files/3/My second song.mp3', 0),
        (4, 'My song', 'DeliensSamuel', 6, NULL, '../files/4/My song.mp3', 0),
        (4, 'My second song', 'DeliensSamuel', 5, 'JohnDoe', '../files/4/My second song.mp3', 0),
        (5, 'My song', 'RifiJihad', 2, NULL, '../files/5/My song.mp3', 0),
        (5, 'My second song', 'RifiJihad', 6, 'JohnDoe', '../files/5/My second song.mp3', 0);


-- Insertion des notes
INSERT INTO notes (user_id, music_id, note)
VALUES  (1, 1, 5),
        (1, 2, 4),
        (2, 3, 3),
        (2, 4, 2),
        (3, 5, 1),
        (3, 6, 0),
        (4, 7, 0),
        (4, 8, 0),
        (5, 9, 0),
        (5, 10, 0);

-- Insertion des commentaires
INSERT INTO comments (user_id, music_id, comment)
VALUES  (1, 1, 'This is a comment'),
        (1, 2, 'This is another comment'),
        (2, 3, 'This is a comment'),
        (2, 4, 'This is another comment'),
        (3, 5, 'This is a comment'),
        (3, 6, 'This is another comment'),
        (4, 7, 'This is a comment'),
        (4, 8, 'This is another comment'),
        (5, 9, 'This is a comment'),
        (5, 10, 'This is another comment');


-- insertion des playlists
INSERT INTO playlists (user_id, name)
VALUES  (1, 'Library'),
        (2, 'Library'),
        (3, 'Library'),
        (4, 'Library'),
        (5, 'Library');

-- insertion des liens musiques - playlists
-- every user has 1 playlist with all his musics
INSERT INTO links_playlist_music (playlist_id, music_id)
VALUES  (1, 1),
        (1, 2),
        (2, 3),
        (2, 4),
        (3, 5),
        (3, 6),
        (4, 7),
        (4, 8),
        (5, 9),
        (5, 10);

-- Insertion des rôles

INSERT IGNORE INTO `roles` (`name`) VALUES ('admin');
INSERT IGNORE INTO `roles` (`name`) VALUES ('user');
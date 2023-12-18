USE HarmoniHub;

-- Insertion des utilisateurs
INSERT INTO users (surname, name, artist_name, email, password)
VALUES ('Doe', 'John', 'JohnDoe', 'john.doe@example.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Smith', 'Jane', 'JaneSmith', 'jane.smith@example.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Johnson', 'Michael', 'Unknown', 'michael.johnson@example.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO'),
       ('Samuel', 'Deliens', 'DeliensSamuel', 'Samuel.deliens@gmail.com', '$2y$12$Kt4LZgiDAZHR7fZSLygIqOjkOFgfrkWD0dIeEu/pmlqXWFM0ppvBO');


-- Insertion des musiques
INSERT INTO musics (user_id, title, artist, genre, featuring, file_path, note)
VALUES  (1, 'My song', 'JohnDoe', 'Rap', NULL, 'musics/JohnDoe/My song.mp3', 5),
        (1, 'My second song', 'JohnDoe', 'Rap', 'JaneSmith', 'musics/JohnDoe/My second song.mp3', 4),
        (2, 'My song', 'JaneSmith', 'Rap', NULL, 'musics/JaneSmith/My song.mp3', 3),
        (2, 'My second song', 'JaneSmith', 'Rap', 'JohnDoe', 'musics/JaneSmith/My second song.mp3', 2),
        (3, 'My song', 'Unknown', 'Rap', NULL, 'musics/Unknown/My song.mp3', 1),
        (3, 'My second song', 'Unknown', 'Rap', 'JohnDoe', 'musics/Unknown/My second song.mp3', 0),
        (4, 'My song', 'DeliensSamuel', 'Rap', NULL, 'musics/DeliensSamuel/My song.mp3', 0),
        (4, 'My second song', 'DeliensSamuel', 'Rap', 'JohnDoe', 'musics/DeliensSamuel/My second song.mp3', 0);


-- Insertion des notes
INSERT INTO notes (user_id, music_id, note)
VALUES  (1, 1, 5),
        (1, 2, 4),
        (2, 3, 3),
        (2, 4, 2),
        (3, 5, 1),
        (3, 6, 0),
        (4, 7, 0),
        (4, 8, 0);

-- Insertion des commentaires
INSERT INTO comments (user_id, music_id, comment)
VALUES  (1, 1, 'This is a comment'),
        (1, 2, 'This is another comment'),
        (2, 3, 'This is a comment'),
        (2, 4, 'This is another comment'),
        (3, 5, 'This is a comment'),
        (3, 6, 'This is another comment'),
        (4, 7, 'This is a comment'),
        (4, 8, 'This is another comment');
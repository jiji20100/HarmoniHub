# Projet d'architecture WEB - HarmoniHub

Le projet n'est dorénavant plus sous laravel mais sous php natif il faudra faire avec malheureusement.

<h2>Avant de lancer votre projet</h2>

- Dupliquez le fichier config/config.example et renommez le en config.php. Modifiez le en y ajoutant vos variables comem indiqué dans le projet.

- Installer composer sur votre machine si ce n'est pas déjà fait.

- Modifier le fichier apache2.conf dans /etc/apache2/ en y modifiant la ligne suivante, pensez à redémarrer apache2 après:
```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
```

- Modifier le document root dans le fichier 000-default.conf dans /etc/apache2/sites-available/ en y mettant le chemin vers le dossier public du projet.

- Afin de pouvoir utiliser le projet, il vous faudra mettre à jour les dépendances du projet (vendor):
```
composer dumpautoload
```

- Clonez le projet dans le /var/www/html/ de votre machine pour le faire tourner.
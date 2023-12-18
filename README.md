# Projet d'architecture WEB - HarmoniHub

Le projet n'est dorénavant plus sous laravel mais sous php natif il faudra faire avec malheureusement.

- Clonez le projet dans le /var/www/html/ de votre machine.

<h2>Avant de lancer votre projet</h2>


- Ajoutez votre base de donnée phpmyadmin dans votre dossier public/. Ouvrez votre base de donnée via https://votredomaine/phpmyadmin. Importez le fichier databases/create_tables.sql dans le menu "Importer" de phpmyadmin.


- Dupliquez le fichier config/config.example et le fichier config/config.ini.example, renommez les en config.php et config.ini et modifiez les en y ajoutant vos variables de base de données comme indiqué dans le projet. (Le nom de la base de donnée est HarmonyHub, c'est celle que vous venez d'importer).

- Installer composer sur votre machine si ce n'est pas déjà fait.

- Modifier le fichier apache2.conf dans /etc/apache2/ en y modifiant la ligne suivante, pensez à redémarrer apache2 après:
```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
```


- si vous avez une erreur 500 apres le changement du fichier apache2.conf, il faut faire la commande :
```
sudo a2enmod rewrite
```

- faut pas oublier de restart le server Apache :

 ```
sudo systemctl restart apache2
```
   
- Modifier le document root dans les fichiers <b>000-default.conf</b> et <b>default-ssl.conf</b> dans /etc/apache2/sites-available/ en y mettant le chemin vers le dossier public du projet.

- Afin de pouvoir utiliser le projet, il vous faudra mettre à jour les dépendances du projet (vendor):
```
composer dumpautoload
```

- Finalement, il vous faudra mettre tous les droits des fichiers du projet en RWE pour que le projet fonctionne correctement :
```
sudo chmod -R 777 .
```

<h2> Comment utiliser votre projet et mettreen place un espace de travail </h2>

Pour ajouter une route. Par example, imaginons que vous souhaitez travailler sur la page "favoris". Pour y accéder, il faut mettre en place une route.
Pour mettre en place une route il faut : 

Créer un controller pour votre page favoris dans le dossier app/Controllers/
Créer une méthode index qui redirigera vers votre page : 
```
public function index(): Renderer
    {
        return Renderer::make('favoris');
    }
```
- Créer une view "favoris.php" dans app/Views/

- Ajouter une route dans app/App.php dans la fonction initRoutes :
```
$this->router
    ->set('/', ['Controllers\FavorisController', 'index'])
    ->middleware('Source\Session', 'redirectIfNotConnected');
```
Mettez à jour le lien de redirection dans votre page pour rediriger vers "/favoris".
Mettez les fonctions à exécuter dans le middleware ("redirectIfNotConnected" redirigera si non connecté)


Règles de codage (Afin de faciliter la lecture du code et de faciliter l'avancement du projet):
- Pensez à bien séparer la vue, le controller et ne doit pas avoir d'html ou de SQL et le modèle doit avoir le minimum de php et html possible. 

- Toutes les requêtes SQL doivent être dans le modèle. 
- Pensez à bien séparer les fonctions dans les modèles propres à chaque table de la base de donnée.

- Vous pouvez passer des variables à la vue en faisant: 
```
return Renderer::make('favoris', ['variable' => $variable]);
```

- La BDD ne doit pas être utilisé directement, il faut passer par les modèles.
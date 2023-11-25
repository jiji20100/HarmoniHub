# Projet d'architecture WEB - HarmoniHub

<h1>Comment installer le projet sur <b>votre machine<b> ?</h1>

<h2>Installer Composer :</h2>

Considérons que vous avez suivis le cours et que PHP, MySQL et APACHE sont biens installés. Le projet utilisera le framework Laravel.
Laravel utilise Composer pour la gestion des dépendances. Si tu n'as pas encore installé Composer, tu peux le faire en suivant les instructions sur <a href="getcomposer.org">getcomposer.org.</a>

Une fois l'installation terminée, assurez-vous que celui-ci est bien installé avec la commande : `composer --version`

<h2>Cloner le projet depuis le dépôt :</h2>

Cloner le projet. Utilisez l'url SSH : `git clone git@github.com:jiji20100/HarmoniHub.git`
Si vous rencontrez des soucis de clonage, vérifiez vos droits avec chown et modifiez les si necessaire avec chmod. Vous pouvez aussi simplement tout faire en `sudo su`.

<h2>Installer les dépendances Laravel :</h2>

Dans le répertoire racine de votre projet Laravel, ouvrez une invite de commande et exécutez la commande suivante pour installer les dépendances du projet à l'aide de Composer : `composer install`

<h2>Configurer l'environnement :</h2>

Dupliquez le fichier .env.example et renommez le en .env. Mettre à jour chaque variable en fonction de votre appli.
Exécutez la commande suivante pour générer une clé d'application unique pour votre projet Laravel : `php artisan key:generate`

<h2> Migrer la base de donnée :</h2>

Ajouter votre dossier phpmyadmin utilisé en cours dans le dossier public/ et éxécutez les migrations pour créer les tables de base de données associées à votre application : `php artisan migrate`

<h2>Testez votre application :</h2>

Ouvrez votre navigateur et accédez à l'url de votre machine (ou à l'URL que vous avez configurée dans le fichier .env) pour tester votre application Laravel.

Ces étapes devraient vous permettre de faire tourner votre projet Laravel. Assurez-vous de suivre la documentation officielle de Laravel pour plus d'informations sur le développement et le déploiement d'applications Laravel : <a href="https://laravel.com/docs/10.x">Documentation Laravel.</a>

<h1>Gestion des erreurs</h1>

Vous risquez de rencontrer des erreurs de permissions. Si c'est le cas, à vous de vérifier vos droits sur le projet. Si laravel a besoin d'accéder à un dossier en particulier mais qu'il en a pas les permissions, n'hésiter pas à le passer en chmod 777.

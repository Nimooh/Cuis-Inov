# SAE 3.01 - Développement d’une application

## Auteurs

-   Brice Burlot `burl0005`
-   Ruben Dunesme `dune0004`
-   Steven Morlet `morl0027`
-   Antoine Terrier `terr0031`
-   Gabriel Valente `vale0068`

## Installation

Installation de Symfony : https://symfony.com/download

Installation de Node.js : https://nodejs.org

Ce projet utilise [Composer](https://getcomposer.org/) afin de gérer les dépendances PHP.

Installation des dépendances : `composer install` puis `npm install`

## Configuration

Il est nécessaire de créer un fichier `.env.local` basé sur le modèle `.env`.

Ce dernier doit contenir la variable `DATABASE_URL` afin de se connecter à une base de données. Voir [ici](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url) pour plus d'informations.

## Utilisation

Lancement du serveur Web : `composer start`

Lancement du serveur Web qui permet de mettre à jour les assets à chaque modification sans recharger la page : `composer start:assets`

Génération de la base de données et des données factices : `composer db`

Compilation des assets pour la production : `npm run build`

Compilation des assets pour le développement : `npm run dev`

Compilation des assets en temps réel à chaque modification : `npm run watch`

## Normes du code

Ce projet utilise [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) afin de respecter les recommandations [Symfony](https://symfony.com/doc/current/contributing/code/standards.html).

Détection des éventuelles erreurs de style de code : `composer test:cs`

Correction des éventuelles erreurs de style de code : `composer fix:cs`

## Tests

Ce projet utilise [Codeception](https://codeception.com/) afin de réaliser des tests automatisés.

Génération de la base de données de test et exécution des tests unitaires : `composer test:codeception`

Tests du style de code et unitaires : `composer test`

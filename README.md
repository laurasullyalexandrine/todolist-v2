# ToDoList

Vous êtes sur la nouvelle version de l'application ToDoList par ToDo & Co.
Développé en utilisant le framework Symfony version 6.4 (LTS) et PHP 8.2

## DESCRIPTION DU PROJET

ToDoList est une application de gestion de tâches conçue pour aider ses utilisateurs et les équipes à organiser, prioriser et suivre leurs activiés quotidiennes.
Les utilisateurs peuvent créer, modifier et supprimer des tâches en fonction de leurs besoins et priorités.
Le projet intègre des fonctionnalités de sécurité robustes pour garantir la confidentialité des données des utilisateurs et protéger l'accès aux informations sensibles.

## PRÉREQUIS

- PHP 8.2.4
- MySQL ou Mariadb
- Composer version 2.3.10
- Symfony CLI 5.6
- Symfony 6.4.2

## INSTALLATION DE LA BASE DE DONNEES

1. Clôner le projet depuis mon compte gitHub sur votre disque dur.
2. Ouvrez le projet dans votre éditeur de texte.
3. Installer les dépendances Composer.```composer install```
4. Noter que le dossier vendor est généré automatiquement par composer.
5. Créer un copie du fichier .env et le renommer .env.local
6. Renseigner les informations de connexion à la base de données, de votre SGBDR depuis le fichier .env.local
   - ex : `DATABASE_URL="mysql://votre-identifiant:votre-mot-de-passe@127.0.0.1.3306/nom-de-la-bd-todolist?serverVersion=mariadb-10.4"`
7. Créer la base de données : `symfony console doctrine:database:create`
8. Jouer la dernière migration : `symfony console doctrine:migrations:migrate`
9. Charger les fixtures : `symfony console doctrine:fixtures:load`

## INSTALLATION  DE LA BASE DE DONNEES DE TEST

1. Créer la base de données de test : `symfony console --env=test doctrine:database:create`
2. Jouer la dernière migration de test : `symfony console --env=test doctrine:migrations:migrate`
3. Charger les fixtures de test : `symfony console --env=test doctrine:fixtures:load`

## DOCUMENTATION À UTILISER

[Documentation Symfony](https://symfony.com/doc/current/index.html)

[Documentation PHP](https://www.php.net/docs.php)

[Documentation Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/2.16/index.html)

[Documentation Twig](https://twig.symfony.com/doc/)

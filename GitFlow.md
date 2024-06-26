# Guide de Contribution *GitFlow pour l'Application ToDoList

![schema du modèle GitFlow](/public/img/git-flow-diagram.jpg)

## INTRODUCTION

Ce guide vous fournira des instructions détaillées sur la manière de contribuer efficacement au projet ToDolist, en utilisant le modèle de développement GitFlow.
GitFlow est un modèle de développement qui utilise Git comme système de contrôle de version.
Le modèle GitFlow repose sur deux branches principales : ``main`` et ``develop``.
La branche ``develop`` est utilisée pour intégrer les différentes fonctionnalités développées par l'équipe.

## PRÉREQUIS

- Un compte GitHub
- Git installé sur votre système
- Connaissance de base de Git
- Lire le fichier README

## CLONAGE DU REPOSITORY

Suivre les instructions présentes dans le fichier README.

## CREATION D'UNE FEATURE BRANCH

Avant de commencer à travailler sur une nouvelle fonctionnalité, créez une nouvelle branche de fonctionnalité à partir de la branche ``develop`` en utilisant la convention de nommage suivante : ``git checkout -b feature/nom_de_la_fonctionnalite develop``

## TRAVAIL SUR LA FONCTIONNALITE

Développez la nouvelle fonctionnalité en respectant les bonnes pratiques de codage et en suivant les conventions de style du projet.

## COMMIT ET PUSH DES MODIFICATIONS

Une fois que vous avez terminé de travailler sur la fonctionnalité, effectuez les commits de vos modifications sur votre branche feature :

``git add .``

``git commit -m "Description concise des modifications"``

``git push origin feature/nom_de_la_fonctionnalite``

## TESTS

Avant de soumettre votre travail, assurez-vous que toutes les nouvelles fonctionnalités sont testées de manière appropriée. Les tests unitaires, les tests fonctionnels et les tests d'intégration doivent être inclus selon les besoins.

## SOUMISSION DE LA DEMANDE DE TIRAGE (Pull Request)

Une fois le développement terminé et les tests réussis, sur GitHub ouvrez une demande de tirage (pull request) vers la branche ``develop``. Décrivez clairement les changements apportés et mentionnez la tâche associée. Les demandes de tirage doivent être examinées par un développeur senior avant d'être fusionnées.

## INTEGRATION

Une fois que la demande de tirage a été approuvée et que tous les problèmes identifiés ont été résolus, elle peut être fusionnée dans la branche ``develop``.

## INFORMATIONS COMPLEMENTAIRES IMPORTANTES

Seulement et seulement si une série de fonctionnalités est prête à être publiée en tant que nouvelle version, une branche de ``release`` en utilisant la convention de nommage ``git checkout -b release/0.1.0`` est créée à partir de la branche ``develop``.
Les tests de validation sont effectués sur cette branche de ``release`` pour s'assurer que toutes les fonctionnalités incluses fonctionnent correctement et qu'aucun bogue critique n'est présent.

Une fois que la branche de ``release`` est considérée comme prête, elle est fusionnée dans la branche ``main``

``git checkout main``

``git merge release/0.1.0``

Cela marque la fin du cycle de développement pour cette version et met à jour la branche ``main`` avec les dernières fonctionnalités stables.

Une branche ``hotfix`` est une branche de maintenance qui peut être créée à partir de la branche ``main`` afin de corriger des bogues minimes détectés sur la production.

Une fois la branche ``hotfix``  terminée, elle est mergée dans ``develop`` et dans ``main``.

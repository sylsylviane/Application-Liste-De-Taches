# Application Liste de tâches

## Description
Ce projet a été réalisé comme une démonstration guidée dans le cadre du cours **Cadriciel Web** et met en pratique des concepts essentiels de développement avec le framework Laravel. Les élèves ont suivi et reproduit ces étapes en temps réel pour mieux comprendre les principes et les pratiques enseignés.

Ce cours Laravel axé sur la création d'une application de liste de tâches avec accès à la connexion et gestion des privilèges offre une expérience d'apprentissage pratique aux futurs développeurs Laravel. En couvrant les opérations d'authentification, d'autorisation et CRUD, les étudiants peuvent acquérir des compétences précieuses pour développer des applications Web sécurisées et riches en fonctionnalités à l'aide de Laravel.

> Référence: https://good4college.com/online-course/laravel-building-a-to-do-list-application/fr

L'application permet :
- La gestion d'une liste de tâches.
- L'accès utilisateur avec connexion et gestion des privilèges.

---

## Technologies utilisées
- **Laravel** : Framework PHP pour le développement backend.
- **Blade** : Système de templates Laravel pour la génération de vues dynamiques.
- **Bootstrap** : Librairie CSS pour la conception d'interfaces responsives et modernes.
- **MySQL** : Base de données relationnelle pour le stockage des données.

---

## Fonctionnalités principales
- Authentification et gestion des utilisateurs.
- Gestion des privilèges et rôles.
- Ajout, modification et suppression de tâches.
- Interface utilisateur stylisée grâce à Bootstrap.

---

## Installation et configuration
1. Clonez le dépôt :
    ```bash
    git clone <url-du-repo>
    cd <nom-du-projet>
    ```
    ```
    composer install
    cp .env.example .env
    php artisan key:generate
    ```
    Configurez votre base de données dans le fichier .env.

    ```bash
    php artisan migrate
    php artisan serve
    ```
### Auteur

Réalisé par Sylviane Paré, dans le cadre du cours Cadriciel Web.

# Guide de l'application School

## 1. Présentation

Cette application est une plateforme de gestion scolaire développée avec Laravel 12. Elle permet de gérer les informations administratives et pédagogiques d'un établissement : élèves, professeurs, matières, classes, inscriptions, notes, bulletins, présences et décisions scolaires.

L'application distingue deux profils :

- Directeur : accès complet et gestion globale 
- Secrétaire : accès fonctionnel aux opérations administratives et scolaires

## 2. Stack technique

- PHP 8.2
- Laravel 12
- MySQL (configuration par défaut dans `.env`)
- Blade + Tailwind CSS
- Vite pour le front-end

## 3. Prérequis

Avant de lancer le projet, vérifie que tu as installé :

- PHP 8.2+
- Composer
- Node.js + npm
- MySQL/MariaDB
- Git

## 4. Installation

### Étape 1 : copier les variables d'environnement

```bash
cp .env.example .env
```

### Étape 2 : configurer la base de données

Dans le fichier `.env`, mets les informations de connexion MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school
DB_USERNAME=root
DB_PASSWORD=
```

Crée ensuite la base de données MySQL correspondante si elle n'existe pas.

### Étape 3 : installer les dépendances

```bash
composer install
npm install
```

### Étape 4 : générer la clé d'application

```bash
php artisan key:generate
```

### Étape 5 : lancer les migrations

```bash
php artisan migrate
```

Optionnellement, tu peux utiliser la commande de préparation fournie par le projet :

```bash
composer run setup
```

## 5. Lancer l'application

Pour démarrer l'application en mode développement :

```bash
composer run dev
```

Cette commande lance simultanément :

- le serveur Laravel
- la file d'attente
- la vue des logs
- Vite pour le front-end

Tu peux aussi démarrer séparément :

```bash
php artisan serve
npm run dev
```

L'application est ensuite accessible à l'adresse :

```text
http://localhost:8000
```

## 6. Authentification et rôles

La route de base redirige vers la page de connexion :

```text
/
```

### Connexion

- URL : `/login`
- Les comptes sont gérés par Laravel Breeze

### Rôles disponibles

Le modèle `User` contient un champ `role` avec deux valeurs :

- `director`
- `secretary`

Les middlewares vérifient ces rôles :

- `/director/*` → réservé au directeur
- `/secretary/*` → réservé au secrétaire

## 7. Structure de l'application

Les modules principaux sont regroupés par rôles dans les routes :

### Espace directeur

```text
/director
```

Modules :

- années scolaires
- matières
- programmes de classes
- affectations des professeurs
- périodes
- inscriptions
- notes
- bulletins
- classes
- niveaux
- cycles
- décisions scolaires
- professeurs
- élèves
- présences

### Espace secrétaire

```text
/secretary
```

Le secretariat reprend pratiquement les mêmes modules de gestion scolaire, avec un accès adapté selon les responsabilités.

## 8. Flux de travail recommandé

Voici un usage typique pour une gestion complète d'une année scolaire :

1. Créer une année scolaire
2. Définir les cycles et niveaux
3. Créer les classes
4. Ajouter les matières et les programmes
5. Gérer les professeurs et leurs affectations
6. Inscrire les élèves
7. Suivre les présences
8. Saisir les notes
9. Générer les bulletins
10. Valider les résultats

## 9. Modules clés

### 9.1 Élèves

Permet de gérer :

- les élèves
- leurs informations personnelles
- leurs inscriptions
- leur suivi académique

### 9.2 Professeurs

Permet de gérer :

- les professeurs
- leurs matières
- leurs affectations par classe / période

### 9.3 Notes et bulletins

Le système permet de :

- saisir des notes
- associer les notes à des périodes
- générer des bulletins
- valider les résultats
- exporter les bulletins en PDF

### 9.4 Présences

Le module de présence permet :

- de créer une journée de présence
- d'enregistrer les absences
- d'afficher les données de suivi

## 10. Points d'entrée principaux

Quelques routes utiles :

```text
/dashboard
/login
/director/Dashboard
/secretary/Dashboard
/director/eleves
/director/professeurs
/director/notes
/director/bulletins
/director/presences
```

## 11. Bonnes pratiques

- Toujours créer ou modifier les données via les écrans de gestion plutôt que directement en base
- Vérifier les permissions selon le rôle connecté
- Faire les migrations après chaque modification du schéma
- Relancer les assets front-end pendant le développement si le CSS ne s'affiche pas

## 12. Dépannage

### Problème : `.env` non configuré

```bash
cp .env.example .env
php artisan key:generate
```

### Problème : erreur de base de données

```bash
php artisan migrate
```

### Problème : styles ou scripts non chargés

```bash
npm install
npm run dev
```

### Problème : accès refusé (403)

Vérifie que le compte connecté a bien le bon rôle :

- `director` pour l'espace directeur
- `secretary` pour l'espace secrétaire

## 13. À retenir

Cette application est conçue pour la gestion administrative d'un établissement scolaire. Son cœur est un système CRUD complet basé sur Laravel, avec une séparation claire des rôles directeur / secrétaire et des modules académiques et administratifs.

Si tu veux, je peux aussi te faire un second guide plus orienté :

- guide utilisateur simple pour les professeurs / secrétaires
- guide administrateur système
- guide technique de développement du projet
- guide de prise en main rapide pour les nouveaux développeurs

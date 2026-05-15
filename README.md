# Application de Gestion des Emplois du Temps

Application web développée dans le cadre d’un projet académique au sein du Pôle Digital & Intelligence Artificielle (DIA).

L’objectif principal du projet est de centraliser et automatiser la gestion des emplois du temps afin de faciliter l’organisation des séances, des groupes, des salles et des formateurs.

---

## Fonctionnalités

- Authentification sécurisée
- Gestion des séances
- Gestion des groupes
- Gestion des salles
- Gestion des formateurs
- Tableau de bord administrateur
- Consultation des emplois du temps
- Détection automatique des conflits de planification

---

## Technologies utilisées

- Laravel 12
- PHP 8.3
- MySQL 8
- Blade
- Bootstrap 5
- Laravel Breeze

---

## Architecture du projet

Le projet suit l’architecture MVC (Model - View - Controller) proposée par Laravel.

---

## Règles de gestion

- Aucun conflit entre les groupes, salles et formateurs
- Maximum de 4 séances par jour
- Gestion hebdomadaire des emplois du temps

---

## Captures d’écran

### Tableau de bord administrateur
Ajoutez ici une capture d’écran

### Gestion des séances
Ajoutez ici une capture d’écran

### Gestion des formateurs
Ajoutez ici une capture d’écran

---

## Documentation

📄 Rapport complet du projet :  
[Voir la documentation] https://drive.google.com/file/d/1wVLWjtVcK5rwaZyQVIOSy1zNgPKHXMVo/view?usp=sharing

---

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/votre-compte/nom-du-repository.git
````

### 2. Accéder au dossier

```bash
cd nom-du-repository
```

### 3. Installer les dépendances

```bash
composer install
```

### 4. Configurer le fichier .env

```bash
cp .env.example .env
```

Configurer ensuite :

* nom de la base de données
* utilisateur MySQL
* mot de passe

---

### 5. Générer la clé de l’application

```bash
php artisan key:generate
```

### 6. Exécuter les migrations

```bash
php artisan migrate
```

### 7. Lancer le serveur

```bash
php artisan serve
```

---

## Auteur

TARIQ Salma
Développeuse Full-Stack

---

## Remerciements

Merci à notre formatrice pour son accompagnement et ses conseils durant la réalisation de ce projet.

```
```

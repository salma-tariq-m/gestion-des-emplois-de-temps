# 📅 Application de Gestion des Emplois du Temps

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)

Application web développée dans le cadre d’un projet académique au sein du **Pôle Digital & Intelligence Artificielle (DIA)** de la **CMC Rabat**.

L’objectif principal est de centraliser, automatiser et moderniser la planification des emplois du temps afin d'éliminer les processus papier/Excel et d'optimiser la gestion des ressources.

---

## 🚀 Fonctionnalités Principales

### 🔐 Authentification & Rôles
- **Espace Administrateur :** Gestion globale des ressources, planification et modification des séances, suivi du tableau de bord.
- **Espace Formateur :** Consultation du planning personnel et mise à jour du profil.
- **Espace Stagiaire :** Consultation dynamique de l'emploi du temps du groupe.

### 🛠️ Gestion des Ressources & Algorithme
- **Gestion complète (CRUD) :** Séances, Groupes, Salles et Formateurs.
- **Détection automatique des conflits :** Algorithme empêchant la double-réservation d'une salle, d'un formateur ou d'un groupe sur le même créneau.
- **Contraintes métiers :** Limitation stricte à un maximum de 4 séances par jour.

---

## 📐 Architecture & Technologies

- **Architecture :** MVC (Model-View-Controller) natif de Laravel.
- **Backend :** Laravel 12 & PHP 8.3
- **Base de données :** MySQL 8
- **Frontend :** Blade Templates & Bootstrap 5
- **Sécurité & Auth :** Laravel Breeze

---

## 📜 Règles de Gestion Implémentées

- ❌ **Zéro Conflit :** Vérification systématique de la disponibilité (Groupe, Salle, Formateur) avant validation d'un créneau.
- 🕒 **Charge Journalière :** Maximum 4 séances par jour et par groupe.
- 📅 **Vue Hebdomadaire :** Organisation et affichage fluide par semaine.

---

## 📂 Documentation & Démo

| Type de ressource | Lien d'accès |
| :--- | :--- |
| 📄 **Rapport de Projet (PDF)** | [Consulter le rapport complet](https://drive.google.com/file/d/1hq9-GEhOedEcxKkR4XL4ul2OHkxDmLp_/view?usp=sharing) |
| 🎥 **Vidéo de Démonstration** | [Voir le Record du Projet](https://drive.google.com/file/d/10-EwbBSyZXOfvQf7uel3n-_aGiB0l6zs/view?usp=sharing) |

---

## 💻 Installation et Configuration

Suivez ces étapes pour installer et lancer le projet localement :

### 1. Cloner le dépôt et accéder au dossier
```bash
git clone [https://github.com/salma-tariq-m/gestion-des-emplois-de-temps.git](https://github.com/salma-tariq-m/gestion-des-emplois-de-temps.git)
cd gestion-des-emplois-de-temps
2. Installer les dépendances PHP
Bash
composer install
3. Configurer le fichier d'environnement
Bash
cp .env.example .env
Ouvrez ensuite le fichier .env fraîchement créé pour y configurer les accès à votre base de données locale :

مقتطف الرمز
DB_DATABASE=nom_de_votre_base_de_donnees
DB_USERNAME=votre_utilisateur_mysql
DB_PASSWORD=votre_mot_de_passe
4. Initialiser l'application
Bash
# Générer la clé unique de l'application
php artisan key:generate

# Exécuter les migrations pour créer les tables
php artisan migrate
5. Lancer le serveur de développement
Bash
php artisan serve
L'application sera alors accessible sur : http://127.0.0.1:8000

👩‍💻 Auteur
TARIQ Salma

Développeuse Full-Stack

E-Music - Gestion d'École de Musique

E-Music est une application web complète de gestion administrative, pédagogique et logistique destinée aux écoles de musique. Développée avec Symfony 7 et PHP 8.2, elle centralise les interactions entre l'administration, les professeurs et les élèves.

Fonctionnalités Principales

Pédagogie & Scolarité

Gestion des Élèves & Responsables : Suivi des dossiers, coordonnées et liens familiaux.

Gestion des Professeurs : Profils, spécialités instrumentales et assignation aux cours.

Planning des Cours :

Gestion des créneaux horaires, salles et jours.

Planning Global interactif pour l'administration.

Espaces dédiés pour les élèves (Mes Cours) et les professeurs (Mon Emploi du temps).

Inscriptions : Gestion du processus d'inscription aux différents cours.

Parc Instrumental & Logistique

Inventaire : Gestion détaillée des Instruments (Marque, Type, Numéro de série, Date d'achat, Prix) et des Accessoires.

Locations (Contrats de Prêt) :

Création et suivi des contrats de prêt aux élèves.

Gestion des états de départ et de retour.

Alertes de disponibilité (Disponible / En prêt).

Maintenance : Suivi des Interventions (réparations, entretien) sur le matériel.

Finance & Administration

Gestion des Paiements : Suivi des règlements des familles.

Gestion par Tranches : Système de tarification basé sur le quotient familial ou tranches de revenus.

Tableaux de Bord : Dashboards spécifiques pour Admin, Gestionnaire, Professeur et Élève.

Stack Technique

Framework Backend : Symfony 7.3.4

Langage : PHP 8.2.18

Base de Données : MariaDB

Frontend : Twig, Stimulus, Symfony UX Turbo, Bootstrap.

Développement : Maker Bundle, Web Profiler, PHPUnit.

Installation

Prérequis techniques :

PHP >= 8.2

Composer

Serveur SQL  MariaDB

Symfony CLI (recommandé)

1. Cloner le projet

git clone(https://github.com/ZakinaA/25darkwolf.git
cd 25darkwolf


2. Installer les dépendances

composer install


3. Base de données

Gestion de la migration :

php bin/console make:migration
php bin/console doctrine:migrations:migrate   

4.Controlleurs

Créer un controlleur complet :

php bin/console make:crud

5. Lancer le serveur

symfony server:start
# ou via Wamp/Xampp en pointant sur /public


Gestion des Rôles & Sécurité

L'application utilise un système de sécurité hiérarchique robuste (security.yaml).

Rôle

Description

Accès

ROLE_ADMIN

Administrateur système

Accès total (Hérite de tous les rôles).

ROLE_GESTIONNAIRE

Personnel administratif

Gestion pédagogique, financière et logistique.

ROLE_PROF

Enseignant

Accès à ses cours, liste de ses élèves, planning personnel.

ROLE_ELEVE

Étudiant

Accès en lecture seule à ses cours, location d'instruments.

Structure de la Base de Données (Entités Principales)

Utilisateurs : Admin, Gestionnaire, Professeur, Eleve.

Matériel : Instrument, Accessoire, TypeInstrument, Marque, ContratPret, Intervention.

Scolaire : Cours, Inscription, Jour, Tranche.

Finance : Paiement.

Créez votre branche de fonctionnalité (git branch nom_branche).

Se positionner sur votre branche de fonctionnalité (git checkout nom_branche).

Committez vos changements (git add -A & git commit -m 'message').

Pushez vers la branche (git push origin nom_branche).

Ouvrez une Pull Request.

Auteurs

Antonin / Valentin / Maxime - Développement complet

Projet réalisé dans le cadre d'un développement académique.

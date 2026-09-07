# SoutenanceManager — Gestion des soutenances

Application web Laravel pour organiser les soutenances de projets de fin d'études :
dépôt des rapports par les étudiants, remarques et validation par les professeurs,
planification des soutenances et composition des jurys par l'administration, notation
par le jury et consultation des notes. Projet réalisé à l'EMSI Marrakech (2025).

## Trois espaces

| Espace | Ce qu'il permet |
|---|---|
| **Administrateur** | Gérer les étudiants et les professeurs, assigner encadrant et rapporteur, valider ou rejeter les rapports, planifier les soutenances et constituer les jurys, suivre les notes |
| **Professeur** | Voir les étudiants qu'il encadre ou évalue, télécharger leurs documents, laisser des remarques, valider les rapports, noter les soutenances où il siège |
| **Étudiant** | Créer son compte, déposer son dossier de stage et son rapport (PDF), traiter les remarques reçues, consulter la date, la salle, le jury et la note de sa soutenance |

Chaque espace a son propre middleware (`admin`, `professor`, `etudiant.auth`) et la
connexion se fait depuis un formulaire unique (`/login`) avec choix du profil.
La note finale d'une soutenance est calculée automatiquement (moyenne du jury) dès que
tous les membres ont noté.

## Modèle de données

`etudiants` (avec encadrant et rapporteur), `professeurs`, `soutenances`, `jury_membres`
(pivot avec rôle, note et commentaire), `documents`, `remarques`, plus les tables de
référence du schéma UML (filières, promos, groupes, entreprises, statuts, attestations…).

## Installation

Prérequis : PHP 8.2+, Composer, Node.js.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite      # SQLite par défaut, aucun serveur à installer
php artisan migrate --seed          # crée les tables et un jeu de données de démo
php artisan serve
```

Ouvrir http://127.0.0.1:8000 puis « Se connecter ».

### Comptes de démonstration

| Profil | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@soutenance.ma` | `admin123` (modifiable dans `.env` : `ADMIN_EMAIL` / `ADMIN_PASSWORD`) |
| Professeur (rapporteur) | `m.alami@univ.ma` | `password` |
| Professeur (encadrante) | `f.zahra@univ.ma` | `password` |
| Étudiant | `ahmed.benali@etu.ma` | `password` |

Pour utiliser MySQL à la place de SQLite, renseigner `DB_CONNECTION=mysql` et les
variables `DB_*` dans `.env`.

## Tests

```bash
php artisan test
```

Le test `SoutenanceFlowTest` couvre le parcours complet : inscription et connexion des
trois profils, dépôt d'un rapport, remarque et validation par le professeur, planification
d'une soutenance avec jury, notation par chaque membre et calcul de la note finale,
ainsi que les contrôles d'accès (un professeur ne voit que ses étudiants, seul le jury note).

## Technologies

Laravel 12 · PHP 8 · SQLite / MySQL · Blade · CSS · JavaScript · PHPUnit

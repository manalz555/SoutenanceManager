# SoutenanceManager — Gestion des soutenances

Application web Laravel pour organiser les soutenances de projets de fin d'études :
planification des soutenances, composition des jurys, dépôt des rapports par les étudiants
et consultation des remarques et des notes. Projet réalisé à l'EMSI Marrakech (2025).

## Trois espaces

| Espace | Ce qu'il permet |
|---|---|
| **Administrateur** | Gérer les étudiants, les professeurs, créer et planifier les soutenances, affecter les jurys |
| **Professeur** | Consulter les étudiants qu'il encadre ou évalue, lire leurs documents, laisser des remarques |
| **Étudiant** | Inscription, tableau de bord, dépôt du rapport, consultation de sa soutenance et des remarques |

Chaque espace a sa propre authentification et son propre middleware.

## Modèle de données

Étudiants, professeurs, responsables, filières, promos, groupes, entreprises, soutenances,
rapports, documents, remarques, attestations et statuts (17 modèles Eloquent).

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# configurer la base de données dans .env, puis :
php artisan migrate --seed
npm run dev
php artisan serve
```

## Technologies

Laravel 12 · PHP 8 · MySQL · Blade · Tailwind CSS · Vite

<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\etudiants;
use App\Models\professeurs;
use App\Models\Remarque;
use App\Models\soutenances;
use Illuminate\Database\Seeder;

/**
 * Jeu de données de démonstration.
 * Tous les comptes ont le mot de passe « password ».
 * Administrateur : voir ADMIN_EMAIL / ADMIN_PASSWORD dans .env (admin@soutenance.ma / admin123 par défaut).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $zahra = professeurs::create(['nom_prof' => 'Zahra', 'prenom_prof' => 'Fatima', 'role_prof' => 'encadrant', 'email_prof' => 'f.zahra@univ.ma', 'password_prof' => 'password']);
        $alami = professeurs::create(['nom_prof' => 'Alami', 'prenom_prof' => 'Mohammed', 'role_prof' => 'rapporteur', 'email_prof' => 'm.alami@univ.ma', 'password_prof' => 'password']);
        $idrissi = professeurs::create(['nom_prof' => 'Idrissi', 'prenom_prof' => 'Youssef', 'role_prof' => 'examinateur', 'email_prof' => 'y.idrissi@univ.ma', 'password_prof' => 'password']);
        $benjelloun = professeurs::create(['nom_prof' => 'Benjelloun', 'prenom_prof' => 'Ahmed', 'role_prof' => 'president', 'email_prof' => 'a.benjelloun@univ.ma', 'password_prof' => 'password']);

        $ahmed = etudiants::create([
            'nom' => 'Benali', 'prenom' => 'Ahmed', 'email' => 'ahmed.benali@etu.ma', 'password' => 'password',
            'date_naissance' => '2003-04-12', 'matricule' => 'E2025-001', 'filiere' => 'Informatique',
            'annee_universitaire' => '2024-2025', 'encadrant_id' => $zahra->id, 'rapporteur_id' => $alami->id,
        ]);
        $fatima = etudiants::create([
            'nom' => 'Alami', 'prenom' => 'Fatima', 'email' => 'fatima.alami@etu.ma', 'password' => 'password',
            'date_naissance' => '2002-11-03', 'matricule' => 'E2025-002', 'filiere' => 'Génie Logiciel',
            'annee_universitaire' => '2024-2025', 'encadrant_id' => $zahra->id, 'rapporteur_id' => $idrissi->id,
        ]);
        $youssef = etudiants::create([
            'nom' => 'Idrissi', 'prenom' => 'Youssef', 'email' => 'youssef.idrissi@etu.ma', 'password' => 'password',
            'date_naissance' => '2003-01-25', 'matricule' => 'E2025-003', 'filiere' => 'Réseaux',
            'annee_universitaire' => '2024-2025', 'encadrant_id' => $benjelloun->id, 'rapporteur_id' => $alami->id,
        ]);
        etudiants::create([
            'nom' => 'Tazi', 'prenom' => 'Mohammed', 'email' => 'mohammed.tazi@etu.ma', 'password' => 'password',
            'date_naissance' => '2003-07-08', 'matricule' => 'E2025-004', 'filiere' => 'Informatique',
            'annee_universitaire' => '2024-2025',
        ]);

        // Documents (les fichiers ne sont pas créés : seules les fiches existent en démo)
        $rapportAhmed = Document::create([
            'etudiant_id' => $ahmed->id, 'type' => 'rapport', 'titre' => 'Application Web de Gestion des Stocks',
            'chemin_fichier' => 'documents/demo/rapport-ahmed.pdf', 'nom_fichier_original' => 'rapport_final.pdf',
            'extension' => 'pdf', 'taille_mo' => 2.4, 'statut' => 'soumis', 'date_soumission' => now()->subDays(6),
        ]);
        Document::create([
            'etudiant_id' => $ahmed->id, 'type' => 'dossier_stage', 'titre' => 'Stage — TechCorp Maroc',
            'chemin_fichier' => 'documents/demo/dossier-ahmed.pdf', 'nom_fichier_original' => 'dossier_stage.pdf',
            'extension' => 'pdf', 'taille_mo' => 0.8, 'statut' => 'valide', 'date_soumission' => now()->subDays(40),
        ]);
        $rapportFatima = Document::create([
            'etudiant_id' => $fatima->id, 'type' => 'rapport', 'titre' => 'Système de Recommandation E-commerce',
            'chemin_fichier' => 'documents/demo/rapport-fatima.pdf', 'nom_fichier_original' => 'rapport.pdf',
            'extension' => 'pdf', 'taille_mo' => 3.1, 'statut' => 'valide', 'date_soumission' => now()->subDays(12),
        ]);
        Document::create([
            'etudiant_id' => $youssef->id, 'type' => 'rapport', 'titre' => 'Plateforme E-learning',
            'chemin_fichier' => 'documents/demo/rapport-youssef.pdf', 'nom_fichier_original' => 'rapport_v1.pdf',
            'extension' => 'pdf', 'taille_mo' => 1.9, 'statut' => 'soumis', 'date_soumission' => now()->subDays(2),
        ]);

        // Remarques
        Remarque::create(['etudiant_id' => $ahmed->id, 'professeur_id' => $alami->id, 'document_id' => $rapportAhmed->id,
            'sujet' => 'Références bibliographiques',
            'contenu' => "Excellent travail sur la partie technique. Merci d'ajouter des références récentes (2023-2024) dans l'état de l'art, pages 15 à 20."]);
        Remarque::create(['etudiant_id' => $ahmed->id, 'professeur_id' => $alami->id, 'document_id' => $rapportAhmed->id,
            'sujet' => 'Chapitre 4 — Résultats',
            'contenu' => 'La méthodologie est claire. Détaillez davantage les résultats et ajoutez des graphiques comparatifs.']);
        Remarque::create(['etudiant_id' => $ahmed->id, 'professeur_id' => $zahra->id, 'document_id' => $rapportAhmed->id,
            'sujet' => 'Diagrammes UML', 'statut' => 'traitee', 'date_resolution' => now()->subDays(3),
            'contenu' => 'Corrigez le diagramme de classes en page 35 : la relation User / Role est mal représentée.']);
        Remarque::create(['etudiant_id' => $fatima->id, 'professeur_id' => $idrissi->id, 'document_id' => $rapportFatima->id,
            'sujet' => 'Introduction', 'statut' => 'traitee', 'date_resolution' => now()->subDays(8),
            'contenu' => 'Introduction claire et bien structurée. Bonne présentation de la problématique.']);

        // Soutenances + jurys
        $soutAhmed = soutenances::create(['etudiant_id' => $ahmed->id, 'Date_Sout' => now()->addDays(10)->setTime(10, 0), 'Salle_Sout' => 'B102']);
        $soutAhmed->juryMembers()->attach([
            $benjelloun->id => ['role' => 'president'],
            $zahra->id      => ['role' => 'encadrant'],
            $alami->id      => ['role' => 'rapporteur'],
            $idrissi->id    => ['role' => 'examinateur'],
        ]);

        // Soutenance passée : deux membres ont déjà noté, le rapporteur pas encore.
        // (Toutes les lignes portent les mêmes colonnes : SQLite exige des VALUES homogènes.)
        $soutFatima = soutenances::create(['etudiant_id' => $fatima->id, 'Date_Sout' => now()->subDays(5)->setTime(14, 0), 'Salle_Sout' => 'B103']);
        $soutFatima->juryMembers()->attach([
            $benjelloun->id => ['role' => 'president', 'note' => 16.5, 'commentaire' => 'Très bonne présentation.'],
            $zahra->id      => ['role' => 'encadrant', 'note' => 17, 'commentaire' => null],
            $idrissi->id    => ['role' => 'rapporteur', 'note' => null, 'commentaire' => null],
        ]);

        $soutYoussef = soutenances::create(['etudiant_id' => $youssef->id, 'Date_Sout' => now()->addDays(14)->setTime(9, 0), 'Salle_Sout' => 'A201']);
        $soutYoussef->juryMembers()->attach([
            $zahra->id      => ['role' => 'president'],
            $benjelloun->id => ['role' => 'encadrant'],
            $alami->id      => ['role' => 'rapporteur'],
        ]);
    }
}

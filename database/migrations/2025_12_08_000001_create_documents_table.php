<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
            // dossier_stage | rapport
            $table->string('type')->default('rapport');
            $table->string('titre');
            $table->string('chemin_fichier');
            $table->string('nom_fichier_original');
            $table->string('extension', 10);
            $table->decimal('taille_mo', 8, 2)->default(0);
            // soumis | valide | rejete
            $table->string('statut')->default('soumis');
            $table->text('commentaire')->nullable();
            $table->boolean('est_version_corrigee')->default(false);
            $table->dateTime('date_soumission')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

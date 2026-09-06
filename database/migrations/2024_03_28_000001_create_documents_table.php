<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->enum('type', ['rapport', 'fichier_stage', 'autre']);
            $table->string('titre');
            $table->string('chemin_fichier');
            $table->string('nom_fichier_original');
            $table->string('extension');
            $table->float('taille_mo', 8, 2);
            $table->enum('statut', ['soumis', 'en_attente', 'approuve', 'rejete'])->default('soumis');
            $table->text('commentaire')->nullable();
            $table->boolean('est_version_corrigee')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};

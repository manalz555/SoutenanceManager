<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('matricule')->nullable()->unique();
            $table->string('filiere')->nullable();
            $table->string('annee_universitaire')->nullable();
            $table->string('telephone')->nullable();
            $table->foreignId('encadrant_id')->nullable()->constrained('professeurs')->nullOnDelete();
            $table->foreignId('rapporteur_id')->nullable()->constrained('professeurs')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};

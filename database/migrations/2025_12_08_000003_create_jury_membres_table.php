<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jury_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soutenance_id')->constrained('soutenances')->cascadeOnDelete();
            $table->foreignId('professeur_id')->constrained('professeurs')->cascadeOnDelete();
            // president | encadrant | rapporteur | examinateur
            $table->string('role')->nullable();
            $table->decimal('note', 4, 2)->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->unique(['soutenance_id', 'professeur_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jury_membres');
    }
};

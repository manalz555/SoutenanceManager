<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jury_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('defense_id')->constrained('defenses')->onDelete('cascade');
            $table->foreignId('professeur_id')->constrained('professeurs')->onDelete('cascade');
            $table->enum('role', ['president', 'examinateur', 'rapporteur', 'encadrant']);
            $table->float('note', 3, 2)->nullable();
            $table->text('commentaires')->nullable();
            $table->timestamps();
            
            // Ensure a professor can't be assigned twice to the same defense
            $table->unique(['defense_id', 'professeur_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('jury_membres');
    }
};

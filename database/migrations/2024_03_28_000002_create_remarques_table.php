<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('remarques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('professeur_id')->constrained('professeurs')->onDelete('cascade');
            $table->text('contenu');
            $table->enum('statut', ['nouvelle', 'en_cours', 'resolue'])->default('nouvelle');
            $table->date('date_remarque');
            $table->date('date_resolution')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remarques');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('defenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->dateTime('date_heure');
            $table->string('salle');
            $table->text('sujet');
            $table->enum('type', ['pfe', 'stage_ete']);
            $table->enum('statut', ['planifiee', 'terminee', 'annulee', 'reportee'])->default('planifiee');
            $table->text('notes')->nullable();
            $table->float('note_finale', 3, 2)->nullable();
            $table->string('mention')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('defenses');
    }
};

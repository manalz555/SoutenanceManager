<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_prof');
            $table->string('prenom_prof');
            // encadrant | rapporteur | examinateur | president
            $table->string('role_prof')->default('encadrant');
            $table->string('email_prof')->unique();
            $table->string('password_prof');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professeurs');
    }
};

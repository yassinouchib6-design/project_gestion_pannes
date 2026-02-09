<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pannes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipement_id')->constrained('equipements')->cascadeOnDelete();

            // ✅ كان عندك غلط: utilisateurs -> خاصها users
            $table->foreignId('utilisateur_id')->constrained('users')->cascadeOnDelete();

            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_panne')->nullable();
            $table->string('contact')->nullable();

            $table->enum('priorite', ['low','medium','high'])->default('medium');
            $table->string('type_panne')->nullable();

            $table->enum('statut', ['nouvelle','en_cours','resolue'])->default('nouvelle');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pannes');
    }
};
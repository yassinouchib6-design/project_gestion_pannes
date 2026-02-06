<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pannes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('equipement_id')->constrained('equipements')->cascadeOnDelete();
    $table->foreignId('utilisateur_id')->constrained('utilisateurs')->cascadeOnDelete();

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pannes');
    }
};

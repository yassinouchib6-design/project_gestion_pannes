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
        Schema::create('interventions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('panne_id')->constrained('pannes')->cascadeOnDelete();
    $table->foreignId('technicien_id')->constrained('techniciens')->cascadeOnDelete();
    $table->foreignId('solution_id')->nullable()->constrained('solutions')->nullOnDelete();

    $table->dateTime('date_debut')->nullable();
    $table->dateTime('date_fin')->nullable();
    $table->text('rapport_intervention')->nullable();

    $table->enum('statut', ['planifiee','en_cours','terminee'])->default('planifiee');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};

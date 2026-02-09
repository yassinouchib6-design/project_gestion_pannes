<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('panne_id')->constrained('pannes')->cascadeOnDelete();

            // ✅ technicien_id كيربط مع techniciens
            $table->foreignId('technicien_id')->nullable()->constrained('techniciens')->nullOnDelete();

            $table->foreignId('solution_id')->nullable()->constrained('solutions')->nullOnDelete();

            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->text('rapport_intervention')->nullable();

            $table->enum('statut', ['planifiee','en_cours','terminee'])->default('planifiee');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
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
        Schema::create('affectation_equipements', function (Blueprint $table) {
    $table->id();
    $table->foreignId('equipement_id')->constrained('equipements')->cascadeOnDelete();
    $table->foreignId('utilisateur_id')->constrained('utilisateurs')->cascadeOnDelete();
    $table->date('date_affectation');
    $table->date('date_fin')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectation_equipements');
    }
};

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
       Schema::create('utilisateurs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('structure_id')->constrained('structures')->cascadeOnDelete();

    // optional link to auth user
    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

    $table->string('nom');
    $table->string('prenom');
    $table->string('num_bureau')->nullable();
    $table->string('contact')->nullable();
    $table->string('email')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};

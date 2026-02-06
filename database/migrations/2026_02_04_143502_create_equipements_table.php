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
       Schema::create('equipements', function (Blueprint $table) {
    $table->id();
    $table->string('serie_equipement')->unique();
    $table->string('type_equipement');
    $table->string('marque_equipement')->nullable();
    $table->string('modele_equipement')->nullable();
    $table->date('date_acquisition')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipements');
    }
};

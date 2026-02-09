<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pannes', function (Blueprint $table) {
            // حذف FK القديم
            $table->dropForeign(['utilisateur_id']);

            // ربط صحيح مع users
            $table->foreign('utilisateur_id')
                ->references('id')->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pannes', function (Blueprint $table) {
            $table->dropForeign(['utilisateur_id']);

            // رجّعها كيف كانت (إلا كنت داير table utilisateurs فعلاً)
            $table->foreign('utilisateur_id')
                ->references('id')->on('utilisateurs')
                ->cascadeOnDelete();
        });
    }
};
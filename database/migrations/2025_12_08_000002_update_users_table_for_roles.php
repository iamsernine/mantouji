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
        Schema::table('users', function (Blueprint $table) {
            // Modifier la colonne role pour supporter: 0=client, 1=cooperative_user, 2=admin
            $table->foreignId('cooperative_id')->nullable()->after('role')->constrained('cooperatives')->onDelete('cascade');
            $table->boolean('is_active')->default(true)->after('cooperative_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cooperative_id']);
            $table->dropColumn(['cooperative_id', 'is_active']);
        });
    }
};

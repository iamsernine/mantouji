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
        Schema::table('products', function (Blueprint $table) {
            // Supprimer les anciennes colonnes
            $table->dropColumn(['reviews', 'reviews_number']);
            
            // Ajouter les nouvelles colonnes
            $table->text('short_description')->nullable()->after('name');
            $table->longText('long_description')->nullable()->after('short_description');
            $table->decimal('price', 10, 2)->nullable()->after('long_description');
            $table->foreignId('sector_id')->nullable()->after('price')->constrained('sectors')->onDelete('set null');
            $table->foreignId('cooperative_id')->nullable()->after('sector_id')->constrained('cooperatives')->onDelete('cascade');
            $table->boolean('is_active')->default(true)->after('cooperative_id');
            
            // Modifier user_id pour être nullable (car on utilise maintenant cooperative_id)
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->dropForeign(['cooperative_id']);
            $table->dropColumn(['short_description', 'long_description', 'price', 'sector_id', 'cooperative_id', 'is_active']);
            
            $table->integer('reviews')->default(1);
            $table->string('reviews_number')->default(1);
        });
    }
};

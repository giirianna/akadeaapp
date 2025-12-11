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
        Schema::table('subjects', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['teacher_id']);
            
            // Make teacher_id nullable
            $table->foreignId('teacher_id')->nullable()->change();
            $table->string('teacher_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable(false)->change();
            $table->string('teacher_name')->nullable(false)->change();
            
            // Re-add the foreign key constraint
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }
};

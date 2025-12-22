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
        Schema::table('exam_submissions', function (Blueprint $table) {
            $table->decimal('total_score', 5, 2)->nullable()->after('answers');
            $table->json('essay_scores')->nullable()->after('total_score');
            $table->boolean('is_scored')->default(false)->after('essay_scores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_submissions', function (Blueprint $table) {
            $table->dropColumn(['total_score', 'essay_scores', 'is_scored']);
        });
    }
};

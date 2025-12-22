<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the old major column if it exists
            if (Schema::hasColumn('students', 'major')) {
                $table->dropColumn('major');
            }

            // Add major_id foreign key column
            if (!Schema::hasColumn('students', 'major_id')) {
                $table->foreignId('major_id')->nullable()->after('class')->constrained('majors')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'major_id')) {
                $table->dropForeign(['major_id']);
                $table->dropColumn('major_id');
            }

            // Restore the old major column
            if (!Schema::hasColumn('students', 'major')) {
                $table->string('major')->nullable();
            }
        });
    }
};

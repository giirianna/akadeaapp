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
        Schema::table('subjects', function (Blueprint $table) {
            // Drop the old 'major' column
            if (Schema::hasColumn('subjects', 'major')) {
                $table->dropColumn('major');
            }
            // Add the new foreign key
            $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Reverse: drop foreign key and add back the old column
            if (Schema::hasColumn('subjects', 'major_id')) {
                $table->dropConstrainedForeignId('major_id');
            }
            $table->string('major')->nullable();
        });
    }
};

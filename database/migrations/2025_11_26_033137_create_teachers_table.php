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
    if (!Schema::hasTable('teachers')) {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('teacher_number')->unique();
            $table->string('teacher_role');
            $table->string('full_name');
            $table->string('religion')->nullable();
            $table->string('gender');
            $table->string('blood_type')->nullable();

            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('highest_education')->nullable();
            $table->unsignedInteger('years_of_experience')->default(0);
            $table->string('teacher_photo')->nullable();

            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};

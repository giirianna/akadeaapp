<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('teacher_number')->unique();
            $table->string('teacher_role')->nullable();
            $table->string('full_name');
            $table->string('religion')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('blood_type')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('highest_education')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
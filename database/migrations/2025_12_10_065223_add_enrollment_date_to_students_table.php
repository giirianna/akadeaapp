<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Ganti nama kolom
            $table->renameColumn('enrollment_month', 'enrollment_date');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('enrollment_date', 'enrollment_month');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('questions', function (Blueprint $table) {
        if (!Schema::hasColumn('questions', 'description')) {
            $table->text('description')->nullable();
        }
        if (!Schema::hasColumn('questions', 'required')) {
            $table->boolean('required')->default(true);
        }
        if (!Schema::hasColumn('questions', 'image')) {
            $table->string('image')->nullable();
        }
        if (!Schema::hasColumn('questions', 'scale_min')) {
            $table->integer('scale_min')->nullable();
        }
        if (!Schema::hasColumn('questions', 'scale_max')) {
            $table->integer('scale_max')->nullable();
        }
        if (!Schema::hasColumn('questions', 'rows')) {
            $table->json('rows')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            //
        });
    }
};

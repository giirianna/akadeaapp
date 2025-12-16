<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('student_name');
            $table->string('class');
            $table->string('major')->nullable();
            $table->string('month'); 
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['belum_lunas', 'lunas', 'sebagian'])->default('belum_lunas');
            $table->string('payment_method')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spp_payments');
    }
}
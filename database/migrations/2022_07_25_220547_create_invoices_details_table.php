<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Id_invoices');
            $table->string('invoices_number',50);
            $table->foreign('Id_invoices')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('product' ,50);
            $table->string('section' ,50);
            $table->string('status' ,50);
            $table->integer('value_status');
            $table->date('Payment_date')->nullable();
            $table->string('notes')->nullable();
            $table->text('user',300);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_details');
    }
};

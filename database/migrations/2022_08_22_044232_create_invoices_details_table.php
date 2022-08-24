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
            $table->unsignedBigInteger('id_Invoice')->nullable();
            $table->string('invoice_number', 50)->nullable();
            $table->foreign('id_Invoice')->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->string('product', 50)->nullable();
            $table->string('Section', 999)->nullable();
            $table->string('Status', 50)->nullable();
            $table->integer('Value_Status')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->text('note')->nullable();
            $table->string('user',300)->nullable();
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

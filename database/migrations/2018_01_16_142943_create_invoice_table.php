<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price')->nullable();
            $table->string('currency')->nullable();
            $table->integer('orderId')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('notification_url')->nullable();
            $table->string('paymentCode')->nullable();
            $table->string('buyer')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('cryptoDue')->unsigned()->nullable();
            $table->bigInteger('cryptoPaid')->unsigned()->nullable();

            $table->integer('invoiceTime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}

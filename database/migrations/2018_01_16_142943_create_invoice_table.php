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
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->integer('orderId')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('store_id')->unsigned()->index()->nullable();

            $table->float('price')->nullable();
            $table->string('payment_address');
            $table->string('currency')->nullable();
            $table->string('cryptocurrency')->nullable();
            $table->string('description')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('notification_url')->nullable();
            $table->string('paymentCode')->nullable();
            $table->string('buyer')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('cryptoDue')->unsigned()->nullable();
            $table->bigInteger('cryptoPaid')->unsigned()->nullable();
            $table->integer('invoiceTime')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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

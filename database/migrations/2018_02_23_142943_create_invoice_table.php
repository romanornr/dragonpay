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
            $table->unsignedBigInteger('orderId');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('store_id')->unsigned()->index()->nullable();
            $table->integer('cryptocurrency_id')->unsigned()->index()->nullable();
            $table->integer('masterwallet_id')->unsigned()->index();
            $table->unsignedBigInteger('key_path');

            $table->float('price')->nullable();
            $table->bigInteger('cryptoDue')->unsigned();
            $table->bigInteger('cryptoPaid')->unsigned()->nullable();
            $table->string('payment_address')->unique();
            $table->string('currency');
            $table->string('description')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('notification_url')->nullable();
            $table->string('paymentCode')->nullable();
            $table->string('buyer')->nullable();
            $table->string('status')->default('new');
            $table->integer('invoiceTime')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies')->onDelete('cascade');
           // $table->foreign('masterwallet_id')->references('id')->on('masterwallets');
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
        Schema::dropIfExists('invoice');
    }
}

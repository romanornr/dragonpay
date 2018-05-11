<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterwalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masterwallets', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->integer('cryptocurrency_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('store_id')->unsigned()->index();

            $table->string('master_public_key');
            $table->string('address_type');
            $table->string('script_type');
            $table->unsignedTinyInteger('min_confirmations');
            $table->timestamps();

            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masterwallets');
    }
}

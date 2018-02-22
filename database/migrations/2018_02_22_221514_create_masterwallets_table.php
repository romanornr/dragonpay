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
            $table->increments('id');
            $table->integer('cryptocurrency_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('master_public_key');
            $table->string('address_type');
            $table->string('script_type');
            $table->timestamps();

            $table->integer('cryptocurrency_id')->index();
            $table->integer('user_id')->index();
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

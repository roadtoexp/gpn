<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_id');
            $table->string('type_id');
            $table->bigInteger('number');
            $table->boolean('active');
            $table->float('balance')->nullable();
            $table->dateTime('last_usage')->nullable();
            $table->text('description');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('card_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
